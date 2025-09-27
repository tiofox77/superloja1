<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Product;

class CartHeader extends Component
{
    public array $cartItems = [];
    public bool $isOpen = false;

    protected $listeners = [
        'cart-item-added' => 'addItem',
        'cart-updated' => 'refreshCart',
        'cart-cleared' => 'clearCart'
    ];

    public function mount(): void
    {
        $this->loadCartFromSession();
    }

    public function addItem(array $productData): void
    {
        $productId = $productData['id'];
        $quantity = $productData['quantity'] ?? 1;

        // Verificar se produto já está no carrinho
        $existingIndex = null;
        foreach ($this->cartItems as $index => $item) {
            if ($item['id'] == $productId) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== null) {
            // Atualizar quantidade se já existe
            $this->cartItems[$existingIndex]['quantity'] += $quantity;
        } else {
            // Adicionar novo item
            $this->cartItems[] = [
                'id' => $productData['id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'quantity' => $quantity,
                'image' => $productData['image_url'],
                'sku' => $productData['sku']
            ];
        }

        $this->saveCartToSession();
        
        // Dispatch notification
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => $productData['name'] . ' adicionado ao carrinho!'
        ]);
    }

    public function removeItem(int $itemId): void
    {
        $removedItem = null;
        foreach ($this->cartItems as $index => $item) {
            if ($item['id'] === $itemId) {
                $removedItem = $item;
                unset($this->cartItems[$index]);
                break;
            }
        }
        
        $this->cartItems = array_values($this->cartItems);
        $this->saveCartToSession();
        
        if ($removedItem) {
            $this->dispatch('show-toast', [
                'type' => 'info',
                'message' => $removedItem['name'] . ' removido do carrinho'
            ]);
        }
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        foreach ($this->cartItems as &$item) {
            if ($item['id'] === $itemId) {
                $item['quantity'] = max(1, $quantity);
                break;
            }
        }
        $this->saveCartToSession();
    }

    public function increaseQuantity(int $itemId): void
    {
        $this->updateQuantity($itemId, $this->getItemQuantity($itemId) + 1);
    }

    public function decreaseQuantity(int $itemId): void
    {
        $currentQuantity = $this->getItemQuantity($itemId);
        if ($currentQuantity > 1) {
            $this->updateQuantity($itemId, $currentQuantity - 1);
        }
    }

    public function clearCart(): void
    {
        $this->cartItems = [];
        $this->saveCartToSession();
        $this->dispatch('show-toast', [
            'type' => 'info',
            'message' => 'Carrinho limpo'
        ]);
    }

    public function toggleCart(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function refreshCart(): void
    {
        $this->loadCartFromSession();
    }

    public function checkout(): void
    {
        // Verificar se há itens no carrinho
        if (empty($this->cartItems)) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Seu carrinho está vazio!'
            ]);
            return;
        }

        // Verificar se usuário está logado
        if (!auth()->check()) {
            $this->dispatch('show-toast', [
                'type' => 'warning',
                'message' => 'Faça login para finalizar a compra'
            ]);
            // Redirecionar para login
            $this->redirect(route('login'));
            return;
        }

        // Salvar dados do carrinho para checkout
        session()->put('checkout.items', $this->cartItems);
        session()->put('checkout.total', $this->total);
        
        // Fechar o dropdown do carrinho
        $this->isOpen = false;
        
        // Redirecionar para página de checkout
        $this->redirect(route('checkout'));
    }

    private function getItemQuantity(int $itemId): int
    {
        foreach ($this->cartItems as $item) {
            if ($item['id'] === $itemId) {
                return $item['quantity'];
            }
        }
        return 0;
    }

    private function loadCartFromSession(): void
    {
        $this->cartItems = session()->get('cart.items', []);
    }

    private function saveCartToSession(): void
    {
        session()->put('cart.items', $this->cartItems);
    }

    public function getItemCountProperty(): int
    {
        return array_sum(array_column($this->cartItems, 'quantity'));
    }

    public function getTotalProperty(): float
    {
        return array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->cartItems));
    }

    public function render()
    {
        return view('livewire.components.cart-header');
    }
}
