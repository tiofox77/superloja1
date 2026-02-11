<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function products(Request $request): JsonResponse
    {
        $query = Product::query()
            ->select('id', 'name', 'sku', 'barcode', 'price', 'sale_price', 'stock_quantity', 'manage_stock', 'is_active', 'featured_image', 'category_id', 'brand_id')
            ->with(['category:id,name', 'brand:id,name'])
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->boolean('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        $query->orderBy('name');

        $perPage = min((int) $request->input('per_page', 50), 200);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function productByBarcode(string $barcode): JsonResponse
    {
        $product = Product::select('id', 'name', 'sku', 'barcode', 'price', 'sale_price', 'stock_quantity', 'manage_stock', 'is_active', 'featured_image', 'category_id', 'brand_id')
            ->with(['category:id,name', 'brand:id,name'])
            ->where('barcode', $barcode)
            ->where('is_active', true)
            ->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produto não encontrado para o código de barras.'], 404);
        }

        return response()->json(['success' => true, 'data' => $product]);
    }

    public function categories(): JsonResponse
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->select('id', 'name')
            ->get();

        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function sale(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|string|in:cash,card,transfer,mbway,multicaixa',
            'amount_received' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validate stock
        $errors = [];
        foreach ($validated['items'] as $idx => $item) {
            $product = Product::find($item['product_id']);
            if (!$product || !$product->is_active) {
                $errors[] = "Item #{$idx}: Produto não encontrado ou inativo.";
                continue;
            }
            if ($product->manage_stock && $product->stock_quantity < $item['quantity']) {
                $errors[] = "Item #{$idx} ({$product->name}): Estoque insuficiente. Disponível: {$product->stock_quantity}";
            }
        }

        if (!empty($errors)) {
            return response()->json(['success' => false, 'message' => 'Erro de validação de estoque.', 'errors' => $errors], 422);
        }

        // Calculate totals
        $subtotal = collect($validated['items'])->sum(fn($i) => $i['unit_price'] * $i['quantity']);
        $discountPercentage = $validated['discount_percentage'] ?? 0;
        $discountAmount = $validated['discount_amount'] ?? (($subtotal * $discountPercentage) / 100);
        $subtotalAfterDiscount = $subtotal - $discountAmount;
        $taxRate = $validated['tax_rate'] ?? 0;
        $taxAmount = ($subtotalAfterDiscount * $taxRate) / 100;
        $totalAmount = $subtotalAfterDiscount + $taxAmount;
        $amountReceived = $validated['amount_received'] ?? $totalAmount;
        $changeAmount = max(0, $amountReceived - $totalAmount);

        // Create customer if email provided
        $customer = null;
        if (!empty($validated['customer_email'])) {
            $customer = User::firstOrCreate(
                ['email' => $validated['customer_email']],
                [
                    'name' => $validated['customer_name'] ?? 'Cliente POS',
                    'phone' => $validated['customer_phone'] ?? null,
                    'password' => bcrypt(Str::random(12)),
                    'role' => 'customer',
                ]
            );
        }

        // Create order
        $order = Order::create([
            'user_id' => $customer?->id,
            'order_number' => 'POS-' . date('Ymd') . '-' . str_pad((string) (Order::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT),
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => $validated['payment_method'],
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'amount_received' => $amountReceived,
            'change_amount' => $changeAmount,
            'customer_name' => $validated['customer_name'] ?? 'Cliente POS',
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_phone' => $validated['customer_phone'] ?? null,
            'notes' => $validated['notes'] ?? 'Venda POS via API',
            'is_pos_sale' => true,
            'billing_address' => [],
            'shipping_address' => [],
        ]);

        // Create order items and update stock
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['unit_price'] * $item['quantity'],
                'product_details' => [
                    'category' => $product->category->name ?? null,
                    'brand' => $product->brand->name ?? null,
                ],
            ]);

            if ($product->manage_stock) {
                $product->decrement('stock_quantity', $item['quantity']);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Venda processada com sucesso.',
            'data' => [
                'order' => $order->load('items'),
                'totals' => [
                    'subtotal' => round($subtotal, 2),
                    'discount' => round($discountAmount, 2),
                    'tax' => round($taxAmount, 2),
                    'total' => round($totalAmount, 2),
                    'amount_received' => round($amountReceived, 2),
                    'change' => round($changeAmount, 2),
                ],
            ],
        ], 201);
    }

    public function sales(Request $request): JsonResponse
    {
        $query = Order::where('is_pos_sale', true)
            ->with('items')
            ->orderBy('created_at', 'desc');

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $sales = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $sales->items(),
            'meta' => [
                'current_page' => $sales->currentPage(),
                'last_page' => $sales->lastPage(),
                'per_page' => $sales->perPage(),
                'total' => $sales->total(),
            ],
        ]);
    }

    public function saleShow(int $id): JsonResponse
    {
        $sale = Order::where('is_pos_sale', true)->with('items')->find($id);

        if (!$sale) {
            return response()->json(['success' => false, 'message' => 'Venda POS não encontrada.'], 404);
        }

        return response()->json(['success' => true, 'data' => $sale]);
    }
}
