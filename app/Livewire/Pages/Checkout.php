<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class Checkout extends Component
{
    use WithFileUploads;

    public array $cartItems = [];
    public float $subtotal = 0;
    public float $tax = 0;
    public float $total = 0;
    
    // Customer info
    public string $delivery_name = '';
    public string $delivery_phone = '';
    public string $delivery_address = '';
    public string $delivery_city = '';
    public string $delivery_notes = '';
    
    // Payment
    public string $payment_method = 'bank_transfer';
    public $payment_proof;
    
    protected $rules = [
        'delivery_name' => 'required|string|min:3',
        'delivery_phone' => 'required|string|min:9',
        'delivery_address' => 'required|string|min:10',
        'delivery_city' => 'required|string|min:3',
        'payment_method' => 'required|in:bank_transfer,cash_on_delivery,multicaixa,bank_deposit',
        'payment_proof' => 'nullable|image|max:10240' // 10MB max
    ];

    public function updatedPaymentMethod()
    {
        // Reset payment proof when changing method
        $this->payment_proof = null;
    }

    public function mount()
    {
        // Verificar se há itens de checkout na sessão
        $this->cartItems = session('checkout.items', []);
        
        if (empty($this->cartItems)) {
            session()->flash('error', 'Nenhum item no carrinho');
            $this->redirect(route('home'));
            return;
        }
        
        $this->calculateTotals();
        
        // Pré-preencher dados do usuário se logado
        if (auth()->check()) {
            $user = auth()->user();
            $this->delivery_name = $user->name ?? '';
            $this->delivery_phone = $user->phone ?? '';
        }
    }

    public function calculateTotals()
    {
        $this->subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->cartItems));
        $this->tax = $this->subtotal * 0.1; // 10% tax
        $this->total = $this->subtotal + $this->tax;
    }

    public function updateQuantity($itemId, $quantity)
    {
        foreach ($this->cartItems as &$item) {
            if ($item['id'] == $itemId) {
                $item['quantity'] = max(1, $quantity);
                break;
            }
        }
        
        $this->calculateTotals();
        session()->put('checkout.items', $this->cartItems);
    }

    public function removeItem($itemId)
    {
        $this->cartItems = array_values(array_filter($this->cartItems, fn($item) => $item['id'] != $itemId));
        
        if (empty($this->cartItems)) {
            session()->forget(['checkout.items', 'checkout.total']);
            $this->dispatch('showAlert', ['type' => 'info', 'message' => 'Carrinho vazio']);
            $this->redirect(route('home'));
            return;
        }
        
        $this->calculateTotals();
        session()->put('checkout.items', $this->cartItems);
        $this->dispatch('showAlert', ['type' => 'info', 'message' => 'Item removido']);
    }

    public function placeOrder()
    {
        // Debug: verificar dados antes da validação
        \Log::info('Tentando finalizar pedido:', [
            'delivery_name' => $this->delivery_name,
            'delivery_phone' => $this->delivery_phone,
            'delivery_address' => $this->delivery_address,
            'delivery_city' => $this->delivery_city,
            'payment_method' => $this->payment_method,
            'cart_items_count' => count($this->cartItems)
        ]);
        
        $this->validate();
        
        try {
            // Validar comprovativo se necessário
            if (in_array($this->payment_method, ['bank_deposit', 'bank_transfer']) && !$this->payment_proof) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'É obrigatório anexar o comprovativo de pagamento para este método.'
                ]);
                return;
            }

            // Upload do comprovativo se fornecido
            $paymentProofPath = null;
            if ($this->payment_proof) {
                $paymentProofPath = $this->payment_proof->store('payment-proofs', 'public');
            }

            // Preparar endereços para JSON
            $shippingAddress = [
                'name' => $this->delivery_name,
                'phone' => $this->delivery_phone,
                'address' => $this->delivery_address,
                'city' => $this->delivery_city,
                'notes' => $this->delivery_notes
            ];
            
            $billingAddress = $shippingAddress; // Usar o mesmo endereço para faturação
            
            // Criar pedido
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
                'status' => 'pending',
                'subtotal' => $this->subtotal,
                'tax_amount' => $this->tax,
                'total_amount' => $this->total,
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'payment_method' => $this->payment_method,
                'payment_status' => $this->payment_method === 'cash_on_delivery' ? 'pending' : 'pending',
                'payment_proof' => $paymentProofPath,
                'notes' => $this->delivery_notes,
            ]);

            // Criar itens do pedido
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'] ?? '',
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);

                // Atualizar estoque
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock_quantity', $item['quantity']);
                }
            }

            // Limpar sessões
            session()->forget(['checkout.items', 'checkout.total']);
            session()->forget('cart.items'); // Limpar carrinho também

            $this->dispatch('showAlert', [
                'type' => 'success', 
                'message' => 'Pedido realizado com sucesso! Número: ' . $order->order_number
            ]);

            // Temporário: redirecionar para home até criar página de orders
            $this->redirect(route('home'), navigate: true);

        } catch (\Exception $e) {
            \Log::error('Erro ao processar pedido:', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'user_id' => auth()->id(),
                'cart_items' => $this->cartItems
            ]);
            
            $this->dispatch('showAlert', [
                'type' => 'error', 
                'message' => 'Erro ao processar pedido: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pages.checkout')
            ->layout('layouts.app')
            ->title('Finalizar Compra - SuperLoja');
    }
}
