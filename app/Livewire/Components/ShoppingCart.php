<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Product;

class ShoppingCart extends Component
{
    public bool $isOpen = false;
    public array $items = [];

    protected $listeners = [
        'add-to-cart' => 'addItem',
        'cart-updated' => '$refresh',
        'toggle-cart' => 'toggleCart'
    ];

    public function mount(): void
    {
        $this->loadCartFromSession();
    }

    public function toggleCart(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function addItem(int $productId, int $quantity = 1): void
    {
        try {
            $product = Product::findOrFail($productId);
            
            // Verificar se produto já está no carrinho
            $existingIndex = null;
            foreach ($this->items as $index => $item) {
                if ($item['id'] == $productId) {
                    $existingIndex = $index;
                    break;
                }
            }
            
            if ($existingIndex !== null) {
                // Atualizar quantidade se já existe
                $this->items[$existingIndex]['quantity'] += $quantity;
            } else {
                // Adicionar novo item
                $this->items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->sale_price ?? $product->price,
                    'original_price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->featured_image,
                    'sku' => $product->sku
                ];
            }
            
            $this->saveCartToSession();
            $this->dispatch('cart-updated');
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => $product->name . ' adicionado ao carrinho!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Erro ao adicionar produto ao carrinho'
            ]);
        }
    }

    public function removeItem(int $itemId): void
    {
        $removedItem = null;
        foreach ($this->items as $index => $item) {
            if ($item['id'] === $itemId) {
                $removedItem = $item;
                unset($this->items[$index]);
                break;
            }
        }
        
        $this->items = array_values($this->items); // Re-index array
        $this->saveCartToSession();
        $this->dispatch('cart-updated');
        
        if ($removedItem) {
            $this->dispatch('show-toast', [
                'type' => 'info',
                'message' => $removedItem['name'] . ' removido do carrinho'
            ]);
        }
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        foreach ($this->items as &$item) {
            if ($item['id'] === $itemId) {
                $item['quantity'] = max(1, $quantity);
                break;
            }
        }
        $this->saveCartToSession();
        $this->dispatch('cart-updated');
    }

    public function clearCart(): void
    {
        $this->items = [];
        $this->saveCartToSession();
        $this->dispatch('cart-updated');
        $this->dispatch('show-toast', [
            'type' => 'info',
            'message' => 'Carrinho limpo'
        ]);
    }

    private function loadCartFromSession(): void
    {
        $this->items = session()->get('cart.items', []);
    }

    private function saveCartToSession(): void
    {
        session()->put('cart.items', $this->items);
    }

    public function getItemCountProperty(): int
    {
        return array_sum(array_column($this->items, 'quantity'));
    }

    public function getTotalProperty(): float
    {
        return array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->items));
    }

    public function render()
    {
        return view('livewire.components.shopping-cart');
    }
}
