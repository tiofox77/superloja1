<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Product;

class WishlistHeader extends Component
{
    public array $wishlistItems = [];
    public bool $isOpen = false;

    protected $listeners = [
        'wishlist-item-added' => 'addItem',
        'wishlist-item-removed' => 'removeItem',
        'wishlist-updated' => 'refreshWishlist'
    ];

    public function mount(): void
    {
        $this->loadWishlistFromSession();
    }

    public function addItem(array $productData): void
    {
        $productId = $productData['id'];
        
        // Verificar se produto já está na wishlist
        if (!$this->isInWishlist($productId)) {
            $this->wishlistItems[] = [
                'id' => $productData['id'],
                'name' => $productData['name'],
                'price' => $productData['price'],
                'sale_price' => $productData['sale_price'] ?? null,
                'image' => $productData['image'] ?? null,
                'category' => $productData['category'] ?? null
            ];
            
            $this->saveWishlistToSession();
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => $productData['name'] . ' adicionado à lista de desejos!'
            ]);
        }
    }

    public function removeItem(int $productId): void
    {
        $removedItem = null;
        foreach ($this->wishlistItems as $index => $item) {
            if ($item['id'] === $productId) {
                $removedItem = $item;
                unset($this->wishlistItems[$index]);
                break;
            }
        }
        
        $this->wishlistItems = array_values($this->wishlistItems);
        $this->saveWishlistToSession();
        
        if ($removedItem) {
            $this->dispatch('show-toast', [
                'type' => 'info',
                'message' => $removedItem['name'] . ' removido da lista de desejos'
            ]);
        }
    }

    public function removeItemById(int $productId): void
    {
        $this->removeItem($productId);
        
        // Dispatch para outros componentes saberem que o item foi removido
        $this->dispatch('wishlist-item-removed', ['id' => $productId]);
    }

    public function clearWishlist(): void
    {
        $this->wishlistItems = [];
        $this->saveWishlistToSession();
        
        $this->dispatch('show-toast', [
            'type' => 'info',
            'message' => 'Lista de desejos limpa'
        ]);
    }

    public function toggleWishlist(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function moveToCart(int $productId): void
    {
        $item = collect($this->wishlistItems)->firstWhere('id', $productId);
        
        if ($item) {
            // Remover da wishlist
            $this->removeItem($productId);
            
            // Dispatch para adicionar ao carrinho
            $this->dispatch('cart-item-added', [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['sale_price'] ?? $item['price'],
                'quantity' => 1,
                'image_url' => $item['image'],
                'sku' => null
            ]);
            
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => $item['name'] . ' movido para o carrinho!'
            ]);
        }
    }

    public function refreshWishlist(): void
    {
        $this->loadWishlistFromSession();
    }

    public function isInWishlist(int $productId): bool
    {
        return collect($this->wishlistItems)->contains('id', $productId);
    }

    private function loadWishlistFromSession(): void
    {
        $wishlistIds = session()->get('wishlist', []);
        $this->wishlistItems = [];
        
        if (!empty($wishlistIds)) {
            $products = Product::whereIn('id', $wishlistIds)->get();
            
            foreach ($products as $product) {
                $this->wishlistItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $product->featured_image,
                    'category' => $product->category->name ?? null
                ];
            }
        }
    }

    private function saveWishlistToSession(): void
    {
        $wishlistIds = collect($this->wishlistItems)->pluck('id')->toArray();
        session()->put('wishlist', $wishlistIds);
    }

    public function getItemCountProperty(): int
    {
        return count($this->wishlistItems);
    }

    public function render()
    {
        return view('livewire.components.wishlist-header');
    }
}
