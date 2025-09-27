<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Product;

class FeaturedProductsMini extends Component
{
    public $products;

    public function mount(): void
    {
        $this->products = Product::with(['category', 'brand'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.components.featured-products-mini');
    }
}
