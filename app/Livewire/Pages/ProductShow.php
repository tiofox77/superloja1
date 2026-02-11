<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Title;

class ProductShow extends Component
{
    public $productId;
    public $product;

    public function mount($id)
    {
        $this->productId = $id;
        $this->product = Product::with(['category', 'brand'])->findOrFail($id);
    }

    public function getTitle()
    {
        return $this->product->name . ' - SuperLoja';
    }

    public function render()
    {
        return view('livewire.pages.product-show')
            ->layout('layouts.app')
            ->title($this->getTitle());
    }
}
