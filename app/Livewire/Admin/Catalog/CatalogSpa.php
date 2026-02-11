<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Catalog;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('components.admin.layouts.app')]
#[Title('Gerador de Catálogo')]
class CatalogSpa extends Component
{
    public string $title = 'Catálogo de Produtos';
    public string $subtitle = 'SuperLoja - As Melhores Ofertas';
    public ?int $categoryId = null;
    public string $priceRange = '';
    public bool $onlyActive = true;
    public bool $onlyWithStock = false;
    public bool $showPrices = true;
    public bool $showDescription = true;
    public string $layout = 'grid'; // grid, list, compact
    public int $productsPerPage = 12;
    public array $selectedProducts = [];
    public bool $selectAll = false;
    
    public function updatedSelectAll(): void
    {
        if ($this->selectAll) {
            $this->selectedProducts = $this->getProductsQuery()->pluck('id')->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }
    
    public function toggleProduct(int $productId): void
    {
        if (in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            $this->selectedProducts[] = $productId;
        }
    }
    
    protected function getProductsQuery()
    {
        return Product::query()
            ->with(['category', 'brand'])
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->when($this->onlyActive, fn($q) => $q->where('is_active', true))
            ->when($this->onlyWithStock, fn($q) => $q->where('stock', '>', 0))
            ->when($this->priceRange, function($q) {
                [$min, $max] = explode('-', $this->priceRange);
                return $q->whereBetween('price', [(float)$min, (float)$max]);
            })
            ->orderBy('name');
    }
    
    public function generatePdf()
    {
        $products = !empty($this->selectedProducts) 
            ? Product::whereIn('id', $this->selectedProducts)->with(['category', 'brand'])->get()
            : $this->getProductsQuery()->get();
        
        if ($products->isEmpty()) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Nenhum produto selecionado!']);
            return;
        }
        
        $pdf = Pdf::loadView('exports.catalog-pdf', [
            'products' => $products,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'showPrices' => $this->showPrices,
            'showDescription' => $this->showDescription,
            'layout' => $this->layout,
        ]);
        
        return response()->streamDownload(
            fn() => print($pdf->output()),
            'catalogo-' . now()->format('Y-m-d') . '.pdf'
        );
    }
    
    public function render()
    {
        $products = $this->getProductsQuery()->paginate($this->productsPerPage);
        $categories = Category::orderBy('name')->get();
        
        return view('livewire.admin.catalog.index-spa', [
            'products' => $products,
            'categories' => $categories,
            'totalSelected' => count($this->selectedProducts),
        ]);
    }
}
