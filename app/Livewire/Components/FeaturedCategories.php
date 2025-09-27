<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Category;

class FeaturedCategories extends Component
{
    public $categories;

    public function mount(): void
    {
        $this->categories = Category::with(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->withCount(['products as products_count' => function ($query) {
                $query->where('is_active', true);
            }])
            ->take(8)
            ->get();
    }

    public function render()
    {
        return view('livewire.components.featured-categories');
    }
}
