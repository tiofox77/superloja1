<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wishlist as WishlistModel;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Component
{
    use WithPagination;

    public function removeFromWishlist($productId)
    {
        $user = Auth::user();
        
        WishlistModel::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Produto removido da lista de desejos!'
        ]);

        // Reset pagination if necessary
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        
        if (!$product || !$product->is_active || $product->stock_quantity <= 0) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Produto não disponível!'
            ]);
            return;
        }

        // Get current cart from session
        $cart = session()->get('cart', []);
        
        // If product already exists in cart, increase quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            // Add product to cart
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->main_image,
                'sku' => $product->sku,
                'quantity' => 1
            ];
        }

        // Save cart to session
        session()->put('cart', $cart);

        // Dispatch event to update cart header
        $this->dispatch('cartUpdated');

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => "{$product->name} adicionado ao carrinho!"
        ]);
    }

    public function clearWishlist()
    {
        $user = Auth::user();
        
        WishlistModel::where('user_id', $user->id)->delete();

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Lista de desejos limpa com sucesso!'
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        
        $wishlistItems = WishlistModel::where('user_id', $user->id)
            ->with(['product' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Filter out products that are null (inactive products)
        $wishlistItems->getCollection()->transform(function($item) {
            return $item->product ? $item : null;
        })->filter();

        return view('livewire.user.wishlist', compact('wishlistItems'))
            ->layout('layouts.app')
            ->title('Lista de Desejos - SuperLoja');
    }
}
