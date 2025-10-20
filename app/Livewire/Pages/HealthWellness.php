<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HealthWellness extends Component
{
    use WithPagination;

    public $healthCategory;
    public $subcategories;
    public $selectedCategory = '';
    public $selectedBrand = '';
    public $sortBy = 'name';
    public $perPage = 12;
    
    // Modal properties
    public $showModal = false;
    public $selectedProduct = null;
    public $selectedVariants = [];
    public $currentImages = [];
    public $mainImageIndex = 0;

    protected $queryString = [
        'selectedCategory' => ['except' => '', 'as' => 'category'],
        'selectedBrand' => ['except' => '', 'as' => 'brand'],
        'sortBy' => ['except' => 'name', 'as' => 'sort']
    ];

    public function mount()
    {
        // Buscar categoria principal "Saúde e Bem-estar"
        $this->healthCategory = Category::where('name', 'Saúde e Bem-estar')
            ->where('is_active', true)
            ->first();

        // Buscar subcategorias com contagem de produtos
        if ($this->healthCategory) {
            $this->subcategories = Category::where('parent_id', $this->healthCategory->id)
                ->where('is_active', true)
                ->withCount(['products' => function($query) {
                    $query->where('is_active', true);
                }])
                ->orderBy('name')
                ->get();
        } else {
            $this->subcategories = collect();
        }
        
        // Se vier com categoria específica na URL
        if (request()->has('category')) {
            $this->selectedCategory = request()->get('category');
        }
    }

    public function updatingSelectedCategory(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedBrand(): void
    {
        $this->resetPage();
    }

    public function updatingSortBy(): void
    {
        $this->resetPage();
    }

    public function addToCart(int $productId): void
    {
        try {
            $product = Product::findOrFail($productId);
            
            // Dispatch para o componente ShoppingCart
            $this->dispatch('add-to-cart', $productId);
            
            // Dispatch global para atualizar o carrinho do header
            $this->dispatch('cart-item-added', [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'sale_price' => $product->sale_price,
                'quantity' => 1,
                'image_url' => $product->featured_image,
                'sku' => $product->sku
            ]);
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Produto adicionado ao carrinho!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao adicionar produto ao carrinho'
            ]);
        }
    }

    public function viewProduct(int $productId): void
    {
        $this->selectedProduct = Product::with(['category', 'brand', 'variants'])->findOrFail($productId);
        $this->loadProductImages();
        $this->showModal = true;
    }
    
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedProduct = null;
        $this->selectedVariants = [];
        $this->currentImages = [];
        $this->mainImageIndex = 0;
    }

    public function selectVariant(string $variantName, int $variantId): void
    {
        $this->selectedVariants[$variantName] = $variantId;
        
        // Se for uma cor, atualizar as imagens
        if ($variantName === 'Cor') {
            $this->loadVariantImages($variantId);
        }
    }

    public function loadProductImages(): void
    {
        if (!$this->selectedProduct) {
            return;
        }

        // Começar com a imagem featured
        $this->currentImages = [];
        if ($this->selectedProduct->featured_image) {
            $this->currentImages[] = $this->selectedProduct->featured_image;
        }

        // Adicionar outras imagens da galeria
        if ($this->selectedProduct->images) {
            $images = json_decode($this->selectedProduct->images, true);
            if (is_array($images)) {
                foreach ($images as $image) {
                    if (!in_array($image, $this->currentImages)) {
                        $this->currentImages[] = $image;
                    }
                }
            }
        }

        $this->mainImageIndex = 0;
    }

    public function loadVariantImages(int $variantId): void
    {
        if (!$this->selectedProduct || !$this->selectedProduct->variant_images) {
            return;
        }

        $variant = $this->selectedProduct->variants->where('id', $variantId)->first();
        if (!$variant) {
            return;
        }

        $variantImages = json_decode($this->selectedProduct->variant_images, true);
        if (is_array($variantImages) && isset($variantImages[$variant->value])) {
            $this->currentImages = $variantImages[$variant->value];
            $this->mainImageIndex = 0;
        }
    }

    public function setMainImage(int $index): void
    {
        if ($index >= 0 && $index < count($this->currentImages)) {
            $this->mainImageIndex = $index;
        }
    }

    public function getFinalPriceProperty(): float
    {
        if (!$this->selectedProduct) {
            return 0;
        }

        $basePrice = $this->selectedProduct->sale_price ?? $this->selectedProduct->price;
        $adjustment = 0;

        // Calcular ajustes de preço das variantes selecionadas
        foreach ($this->selectedVariants as $variantName => $variantId) {
            $variant = $this->selectedProduct->variants->where('id', $variantId)->first();
            if ($variant) {
                $adjustment += $variant->price_adjustment;
            }
        }

        return $basePrice + $adjustment;
    }

    public function toggleWishlist(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $wishlist = session()->get('wishlist', []);
        
        if (in_array($productId, $wishlist)) {
            // Remover da lista
            $wishlist = array_diff($wishlist, [$productId]);
            session()->put('wishlist', $wishlist);
            
            $this->dispatch('wishlist-item-removed', ['id' => $productId]);
            
            $this->dispatch('showAlert', [
                'type' => 'info',
                'message' => 'Produto removido da lista de desejos'
            ]);
        } else {
            // Adicionar à lista
            $wishlist[] = $productId;
            session()->put('wishlist', $wishlist);
            
            $this->dispatch('wishlist-item-added', [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'image' => $product->featured_image,
                'category' => $product->category->name ?? null
            ]);
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Produto adicionado à lista de desejos!'
            ]);
        }
    }

    public function isInWishlist(int $productId): bool
    {
        $wishlist = session()->get('wishlist', []);
        return in_array($productId, $wishlist);
    }

    public function getHealthProductsProperty()
    {
        if (!$this->healthCategory) {
            return collect();
        }

        // IDs das categorias de saúde (categoria principal + subcategorias)
        $healthCategoryIds = [$this->healthCategory->id];
        $healthSubcategoryIds = Category::where('parent_id', $this->healthCategory->id)->pluck('id')->toArray();
        $healthCategoryIds = array_merge($healthCategoryIds, $healthSubcategoryIds);

        $query = Product::with(['category', 'brand', 'variants'])
            ->where('is_active', true)
            ->whereIn('category_id', $healthCategoryIds);

        // Apply filters
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedBrand) {
            $query->where('brand_id', $this->selectedBrand);
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'price-low':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'name':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        return $query->paginate($this->perPage);
    }

    public function getHealthBrandsProperty()
    {
        if (!$this->healthCategory) {
            return collect();
        }

        // IDs das categorias de saúde
        $healthCategoryIds = [$this->healthCategory->id];
        $healthSubcategoryIds = Category::where('parent_id', $this->healthCategory->id)->pluck('id')->toArray();
        $healthCategoryIds = array_merge($healthCategoryIds, $healthSubcategoryIds);

        // Buscar apenas marcas que têm produtos de saúde
        return Brand::whereHas('products', function($query) use ($healthCategoryIds) {
            $query->where('is_active', true)
                  ->whereIn('category_id', $healthCategoryIds);
        })->where('is_active', true)->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.pages.health-wellness', [
            'products' => $this->healthProducts,
            'subcategories' => $this->subcategories,
            'brands' => $this->healthBrands,
            'showModal' => $this->showModal,
            'selectedProduct' => $this->selectedProduct
        ])->layout('layouts.app')
          ->title('Saúde e Bem-estar - SuperLoja Angola');
    }
}
