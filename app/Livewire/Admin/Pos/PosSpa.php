<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Pos;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Cache;

#[Layout('components.admin.layouts.app')]
#[Title('PDV')]
class PosSpa extends Component
{
    use WithPagination;
    public string $search = '';
    public ?int $categoryId = null;
    public array $cart = [];
    
    // Customer
    public string $customerName = '';
    public string $customerPhone = '';
    
    // Payment
    public string $paymentMethod = 'cash';
    public float $amountPaid = 0;
    public float $discount = 0;
    
    public function addToCart(int $productId): void
    {
        $product = Product::find($productId);
        if (!$product) return;
        
        $key = "product_{$productId}";
        
        if (isset($this->cart[$key])) {
            if ($this->cart[$key]['quantity'] < $product->stock_quantity) {
                $this->cart[$key]['quantity']++;
            } else {
                $this->dispatch('toast', ['type' => 'warning', 'message' => 'Estoque insuficiente!']);
                return;
            }
        } else {
            $this->cart[$key] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->featured_image,
                'stock' => $product->stock_quantity,
            ];
        }
    }
    
    public function updateQuantity(string $key, int $quantity): void
    {
        if (isset($this->cart[$key])) {
            if ($quantity <= 0) {
                unset($this->cart[$key]);
            } elseif ($quantity <= ($this->cart[$key]['stock'] ?? 999)) {
                $this->cart[$key]['quantity'] = $quantity;
            }
        }
    }
    
    public function removeFromCart(string $key): void
    {
        unset($this->cart[$key]);
    }
    
    public function clearCart(): void
    {
        $this->cart = [];
        $this->customerName = '';
        $this->customerPhone = '';
        $this->discount = 0;
        $this->amountPaid = 0;
    }
    
    public function getSubtotalProperty(): float
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }
    
    public function getTotalProperty(): float
    {
        return max(0, $this->subtotal - $this->discount);
    }
    
    public function getChangeProperty(): float
    {
        return max(0, $this->amountPaid - $this->total);
    }
    
    public function completeSale(): void
    {
        if (empty($this->cart)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Carrinho vazio!']);
            return;
        }
        
        // Create order
        $order = Order::create([
            'order_number' => 'POS-' . strtoupper(uniqid()),
            'customer_name' => $this->customerName ?: 'Cliente PDV',
            'customer_phone' => $this->customerPhone,
            'subtotal' => $this->subtotal,
            'discount_amount' => $this->discount,
            'total_amount' => $this->total,
            'amount_received' => $this->amountPaid,
            'change_amount' => $this->change,
            'payment_method' => $this->paymentMethod,
            'status' => 'delivered',
            'payment_status' => 'paid',
            'is_pos_sale' => true,
            'notes' => "Venda PDV",
            'billing_address' => [],
            'shipping_address' => [],
        ]);
        
        // Create order items
        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
            
            // Update stock
            Product::find($item['id'])?->decrement('stock_quantity', $item['quantity']);
        }
        
        $this->dispatch('toast', ['type' => 'success', 'message' => "Venda concluída! Pedido #{$order->order_number}"]);
        $this->clearCart();
    }
    
    public function render()
    {
        $products = Product::query()
            ->select('id', 'name', 'sku', 'price', 'sale_price', 'stock_quantity', 'manage_stock', 'is_active', 'featured_image', 'category_id')
            ->with(['category:id,name'])
            ->where('is_active', true)
            ->when($this->search, fn($q) => $q->where(function($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('sku', 'like', "%{$this->search}%")
                      ->orWhere('barcode', 'like', "%{$this->search}%");
            }))
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->orderBy('name')
            ->paginate(200);
        
        $categories = Cache::remember('pos_categories', 3600, function () {
            return Category::where('is_active', true)
                ->orderBy('name')
                ->select('id', 'name')
                ->get();
        });
        
        return view('livewire.admin.pos.index-spa', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
