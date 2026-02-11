<?php

namespace App\Livewire\Admin\Pos;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

#[Layout('components.admin.layouts.app')]
#[Title('POS - Ponto de Venda')]
class PosSystem extends Component
{
    use WithPagination;

    // Cart items
    public $cart = [];
    public $cartTotal = 0;
    public $cartSubtotal = 0;
    public $cartTax = 0;
    public $cartDiscount = 0;
    public $cartItemCount = 0;

    // Search and filters
    public $search = '';
    public $categoryFilter = '';
    public $brandFilter = '';
    public $showOnlyInStock = false;

    // Customer info
    public $customerName = '';
    public $customerEmail = '';
    public $customerPhone = '';

    // Payment
    public $paymentMethod = 'cash';
    public $amountReceived = 0;
    public $change = 0;
    public $discountPercentage = 0;
    public $notes = '';

    // UI states
    public $showPaymentModal = false;
    public $showCustomerModal = false;
    public $showCartDetails = true;

    // Configuration
    public $taxRate = 14; // 14% IVA em Angola
    public $enableBarcode = true;

    protected $listeners = ['productScanned' => 'addProductByBarcode'];

    public function mount()
    {
        $this->resetCart();
    }

    #[Computed]
    public function categories()
    {
        return Cache::remember('pos_categories', 3600, function () {
            return Category::where('is_active', true)
                ->orderBy('name')
                ->select('id', 'name')
                ->get();
        });
    }

    #[Computed]
    public function brands()
    {
        return Cache::remember('pos_brands', 3600, function () {
            return Brand::where('is_active', true)
                ->orderBy('name')
                ->select('id', 'name')
                ->get();
        });
    }

    public function render()
    {
        $products = Product::query()
            ->select('id', 'name', 'sku', 'barcode', 'price', 'sale_price', 'stock_quantity', 'manage_stock', 'is_active', 'featured_image', 'category_id', 'brand_id')
            ->with(['category:id,name', 'brand:id,name'])
            ->where('is_active', true)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%')
                      ->orWhere('barcode', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, fn($query) => $query->where('category_id', $this->categoryFilter))
            ->when($this->brandFilter, fn($query) => $query->where('brand_id', $this->brandFilter))
            ->when($this->showOnlyInStock, fn($query) => $query->where('stock_quantity', '>', 0))
            ->orderBy('name')
            ->paginate(200);

        return view('livewire.admin.pos.pos-system', [
            'products' => $products,
        ]);
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);
        
        if (!$product || !$product->is_active) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Produto não encontrado ou inativo.'
            ]);
            return;
        }

        if ($product->manage_stock && $product->stock_quantity < $quantity) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Estoque insuficiente. Disponível: ' . $product->stock_quantity
            ]);
            return;
        }

        $price = $product->sale_price ?? $product->price;
        $cartItemId = 'item_' . $productId;

        if (isset($this->cart[$cartItemId])) {
            $newQuantity = $this->cart[$cartItemId]['quantity'] + $quantity;
            
            if ($product->manage_stock && $product->stock_quantity < $newQuantity) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Estoque insuficiente. Disponível: ' . $product->stock_quantity
                ]);
                return;
            }
            
            $this->cart[$cartItemId]['quantity'] = $newQuantity;
            $this->cart[$cartItemId]['total'] = $price * $newQuantity;
        } else {
            $this->cart[$cartItemId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $price,
                'quantity' => $quantity,
                'total' => $price * $quantity,
                'image' => $product->featured_image_url,
            ];
        }

        $this->calculateTotals();
        
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $product->name . ' adicionado ao carrinho!'
        ]);
    }

    public function removeFromCart($cartItemId)
    {
        unset($this->cart[$cartItemId]);
        $this->calculateTotals();
        
        $this->dispatch('showAlert', [
            'type' => 'info',
            'message' => 'Item removido do carrinho.'
        ]);
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($cartItemId);
            return;
        }

        if (!isset($this->cart[$cartItemId])) {
            return;
        }

        $product = Product::select('id', 'manage_stock', 'stock_quantity')
            ->find($this->cart[$cartItemId]['product_id']);
        
        if ($product && $product->manage_stock && $product->stock_quantity < $quantity) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Estoque insuficiente. Disponível: ' . $product->stock_quantity
            ]);
            return;
        }

        $this->cart[$cartItemId]['quantity'] = (int)$quantity;
        $this->cart[$cartItemId]['total'] = $this->cart[$cartItemId]['price'] * $quantity;
        
        $this->calculateTotals();
    }

    public function applyDiscount()
    {
        if ($this->discountPercentage < 0 || $this->discountPercentage > 100) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Desconto deve estar entre 0% e 100%.'
            ]);
            return;
        }

        $this->calculateTotals();
        
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Desconto de ' . $this->discountPercentage . '% aplicado!'
        ]);
    }

    public function calculateChange()
    {
        $this->change = max(0, $this->amountReceived - $this->cartTotal);
    }

    private function calculateTotals()
    {
        $this->cartSubtotal = collect($this->cart)->sum('total');
        $this->cartDiscount = ($this->cartSubtotal * $this->discountPercentage) / 100;
        $subtotalAfterDiscount = $this->cartSubtotal - $this->cartDiscount;
        $this->cartTax = ($subtotalAfterDiscount * $this->taxRate) / 100;
        $this->cartTotal = $subtotalAfterDiscount + $this->cartTax;
        $this->cartItemCount = collect($this->cart)->sum('quantity');
        
        $this->calculateChange();
    }

    public function openPaymentModal()
    {
        if (empty($this->cart)) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Carrinho está vazio.'
            ]);
            return;
        }

        $this->amountReceived = $this->cartTotal;
        $this->calculateChange();
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
    }

    public function processSale()
    {
        if (empty($this->cart)) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Carrinho está vazio.'
            ]);
            return;
        }

        if ($this->paymentMethod === 'cash' && $this->amountReceived < $this->cartTotal) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Valor recebido insuficiente.'
            ]);
            return;
        }

        try {
            // Create customer if provided
            $customer = null;
            if ($this->customerEmail) {
                $customer = User::firstOrCreate([
                    'email' => $this->customerEmail
                ], [
                    'name' => $this->customerName ?: 'Cliente POS',
                    'phone' => $this->customerPhone,
                    'password' => bcrypt(Str::random(12)),
                    'role' => 'customer',
                ]);
            }

            // Create order
            $order = Order::create([
                'user_id' => $customer ? $customer->id : null,
                'order_number' => 'POS-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
                'status' => 'completed',
                'payment_status' => 'paid',
                'payment_method' => $this->paymentMethod,
                'subtotal' => $this->cartSubtotal,
                'tax_amount' => $this->cartTax,
                'discount_amount' => $this->cartDiscount,
                'total_amount' => $this->cartTotal,
                'notes' => $this->notes,
                'customer_name' => $this->customerName ?: 'Cliente POS',
                'customer_email' => $this->customerEmail,
                'customer_phone' => $this->customerPhone,
                'amount_received' => $this->amountReceived,
                'change_amount' => $this->change,
                'is_pos_sale' => true,
                'billing_address' => [],
                'shipping_address' => [],
            ]);

            // Create order items and update stock quantities
            foreach ($this->cart as $item) {
                $product = Product::find($item['product_id']);
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['total'],
                    'product_details' => [
                        'category' => $product->category->name ?? null,
                        'brand' => $product->brand->name ?? null,
                        'image' => $product->featured_image_url,
                    ],
                ]);
                
                // Update stock if managed
                if ($product->manage_stock) {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            $this->resetCart();
            $this->resetCustomer();
            $this->resetPayment();
            $this->closePaymentModal();

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Venda processada com sucesso! Pedido: ' . $order->order_number
            ]);

            // Emit event for receipt printing
            $this->dispatch('printReceipt', ['orderId' => $order->id]);

        } catch (\Exception $e) {
            \Log::error('Erro ao processar venda POS: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao processar venda: ' . $e->getMessage()
            ]);
        }
    }

    public function addProductByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)
            ->where('is_active', true)
            ->first();

        if ($product) {
            $this->addToCart($product->id);
        } else {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Produto não encontrado para o código: ' . $barcode
            ]);
        }
    }

    public function clearCart()
    {
        $this->resetCart();
        $this->dispatch('showAlert', [
            'type' => 'info',
            'message' => 'Carrinho limpo.'
        ]);
    }

    private function resetCart()
    {
        $this->cart = [];
        $this->cartTotal = 0;
        $this->cartSubtotal = 0;
        $this->cartTax = 0;
        $this->cartDiscount = 0;
        $this->cartItemCount = 0;
        $this->discountPercentage = 0;
    }

    private function resetCustomer()
    {
        $this->customerName = '';
        $this->customerEmail = '';
        $this->customerPhone = '';
    }

    private function resetPayment()
    {
        $this->paymentMethod = 'cash';
        $this->amountReceived = 0;
        $this->change = 0;
        $this->notes = '';
    }

    public function toggleCartDetails()
    {
        $this->showCartDetails = !$this->showCartDetails;
    }
}
