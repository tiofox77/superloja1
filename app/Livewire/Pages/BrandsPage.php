<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Brand;
use Livewire\Attributes\Title;

#[Title('Marcas - SuperLoja')]
class BrandsPage extends Component
{
    public function render()
    {
        $brands = Brand::with(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->withCount(['products as products_count' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();
        
        return view('livewire.pages.brands', compact('brands'))
            ->layout('layouts.app');
    }
}
