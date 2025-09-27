<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistButton extends Component
{
    public $productId;
    public $isInWishlist = false;
    public $size = 'md'; // sm, md, lg
    public $style = 'button'; // button, icon

    public function mount($productId, $size = 'md', $style = 'button')
    {
        $this->productId = $productId;
        $this->size = $size;
        $this->style = $style;
        
        if (Auth::check()) {
            $this->checkWishlistStatus();
        }
    }

    public function checkWishlistStatus()
    {
        $this->isInWishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $this->productId)
            ->exists();
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            $this->dispatch('showAlert', [
                'type' => 'warning',
                'message' => 'Você precisa fazer login para adicionar produtos à lista de desejos!'
            ]);
            return;
        }

        $product = Product::find($this->productId);
        
        if (!$product || !$product->is_active) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Produto não encontrado ou inativo!'
            ]);
            return;
        }

        if ($this->isInWishlist) {
            // Remove from wishlist
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->productId)
                ->delete();

            $this->isInWishlist = false;

            $this->dispatch('showAlert', [
                'type' => 'info',
                'message' => 'Produto removido da lista de desejos!'
            ]);
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $this->productId,
            ]);

            $this->isInWishlist = true;

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Produto adicionado à lista de desejos! ❤️'
            ]);
        }

        // Dispatch event to update wishlist header if exists
        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        return view('livewire.components.wishlist-button');
    }
}
