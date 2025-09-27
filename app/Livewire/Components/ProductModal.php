<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Product;

class ProductModal extends Component
{
    public bool $isOpen = false;
    public ?Product $product = null;

    protected $listeners = [
        'open-product-modal' => 'openModal'
    ];

    public function openModal($productId): void
    {
        $this->product = Product::with(['category', 'brand', 'variants'])
            ->find($productId);
            
        if ($this->product) {
            $this->isOpen = true;
        } else {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'Produto não encontrado!'
            ]);
        }
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->product = null;
    }

    public function addToCart(): void
    {
        if ($this->product) {
            $this->dispatch('add-to-cart', productId: $this->product->id);
            $this->dispatch('show-notification', [
                'type' => 'success',
                'message' => 'Produto adicionado ao carrinho!'
            ]);
            $this->closeModal();
        }
    }

    public function addToWishlist(): void
    {
        if ($this->product) {
            $this->dispatch('show-notification', [
                'type' => 'success',
                'message' => 'Produto adicionado aos favoritos!'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.components.product-modal');
    }
}
