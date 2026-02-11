<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Auction;
use Livewire\Attributes\Title;

#[Title('SuperLoja - A melhor loja de eletrônicos de Angola')]
class HomePage extends Component
{
    public function render()
    {
        $stats = [
            'products' => Product::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
            'brands' => Brand::where('is_active', true)->count(),
            'auctions' => Auction::where('status', 'active')
                ->where('end_time', '>', now())
                ->count(),
        ];

        return view('livewire.pages.home', compact('stats'))
            ->layout('layouts.app');
    }
}
