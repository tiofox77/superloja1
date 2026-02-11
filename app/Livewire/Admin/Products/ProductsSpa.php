<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;

#[Layout('components.admin.layouts.app')]
#[Title('Produtos')]
class ProductsSpa extends Component
{
    use WithPagination;
    use WithFileUploads;
    
    #[Url]
    public string $search = '';
    
    #[Url]
    public string $category = '';
    
    #[Url]
    public string $brand = '';
    
    #[Url]
    public string $status = '';
    
    #[Url]
    public string $sortBy = 'created_at';
    
    #[Url]
    public string $sortDir = 'desc';
    
    public int $perPage = 12;
    public string $viewMode = 'grid';
    public array $selected = [];
    public bool $selectAll = false;

    public bool $showModal = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $description = '';
    public string $short_description = '';
    public string $sku = '';
    public string $barcode = '';
    public string $price = '';
    public string $sale_price = '';
    public string $cost_price = '';
    public string $stock_quantity = '0';
    public string $low_stock_threshold = '10';
    public bool $manage_stock = true;
    public string $stock_status = 'in_stock';
    public string $parent_category_id = '';
    public string $category_id = '';
    public string $brand_id = '';
    public bool $is_active = true;
    public bool $is_featured = false;
    public string $condition = 'new';
    public string $condition_notes = '';
    public string $weight = '';
    public string $length = '';
    public string $width = '';
    public string $height = '';

    public ?string $currentFeaturedImage = null;
    public array $currentImages = [];

    public $featuredImageUpload;
    public array $galleryUploads = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'brand' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function mount(): void
    {
        // Always show listing first
        // Modals are opened via wire:click buttons
    }
    
    #[Computed]
    public function subcategories()
    {
        if (empty($this->parent_category_id)) {
            return collect([]);
        }
        
        return Category::where('parent_id', $this->parent_category_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
    
    public function updatedParentCategoryId($value): void
    {
        // Limpar erro de validação quando categoria for selecionada
        if (!empty($value)) {
            $this->resetValidation('parent_category_id');
        }
    }
    
    public function updatedCategoryId($value): void
    {
        // Limpar erro de validação quando subcategoria for selecionada
        if (!empty($value)) {
            $this->resetValidation('category_id');
        }
    }

    protected function rules(): array
    {
        $skuRule = 'nullable|string|max:255|unique:products,sku';
        if ($this->editingId) {
            $skuRule = 'nullable|string|max:255|unique:products,sku,' . $this->editingId;
        }

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'sku' => $skuRule,
            'barcode' => 'nullable|string|max:255',

            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',

            'stock_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'manage_stock' => 'boolean',
            'stock_status' => 'required|in:in_stock,out_of_stock,on_backorder',

            'parent_category_id' => 'required|exists:categories,id',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',

            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'condition' => 'required|in:new,used,refurbished',
            'condition_notes' => 'nullable|string',

            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',

            'featuredImageUpload' => 'nullable|image|max:2048',
            'galleryUploads.*' => 'nullable|image|max:2048',
        ];
    }
    
    protected function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            
            'sku.unique' => 'Este SKU/Código já está em uso.',
            
            'price.required' => 'O preço de venda é obrigatório.',
            'price.numeric' => 'O preço deve ser um número válido.',
            'price.min' => 'O preço deve ser maior ou igual a zero.',
            
            'sale_price.numeric' => 'O preço promocional deve ser um número válido.',
            'sale_price.lt' => 'O preço promocional deve ser menor que o preço normal.',
            
            'cost_price.numeric' => 'O preço de custo deve ser um número válido.',
            
            'stock_quantity.required' => 'A quantidade em estoque é obrigatória.',
            'stock_quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'stock_quantity.min' => 'A quantidade não pode ser negativa.',
            
            'parent_category_id.required' => 'Por favor, selecione uma categoria principal.',
            'parent_category_id.exists' => 'A categoria selecionada não é válida.',
            
            'category_id.exists' => 'A subcategoria selecionada não é válida.',
            
            'brand_id.exists' => 'A marca selecionada não é válida.',
            
            'condition.required' => 'A condição do produto é obrigatória.',
            'condition.in' => 'A condição selecionada não é válida.',
            
            'featuredImageUpload.image' => 'O arquivo deve ser uma imagem.',
            'featuredImageUpload.max' => 'A imagem não pode ser maior que 2MB.',
            
            'galleryUploads.*.image' => 'Todos os arquivos da galeria devem ser imagens.',
            'galleryUploads.*.max' => 'As imagens da galeria não podem ser maiores que 2MB.',
        ];
    }
    
    protected function validationAttributes(): array
    {
        return [
            'name' => 'nome do produto',
            'description' => 'descrição',
            'short_description' => 'descrição curta',
            'sku' => 'SKU/Código',
            'barcode' => 'código de barras',
            'price' => 'preço de venda',
            'sale_price' => 'preço promocional',
            'cost_price' => 'preço de custo',
            'stock_quantity' => 'quantidade em estoque',
            'low_stock_threshold' => 'limite de estoque baixo',
            'parent_category_id' => 'categoria principal',
            'category_id' => 'subcategoria',
            'brand_id' => 'marca',
            'condition' => 'condição',
            'weight' => 'peso',
            'length' => 'comprimento',
            'width' => 'largura',
            'height' => 'altura',
            'featuredImageUpload' => 'imagem principal',
            'galleryUploads' => 'galeria de imagens',
        ];
    }


    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal(int $productId): void
    {
        $product = Product::find($productId);
        if (!$product) {
            return;
        }

        $this->resetForm();
        $this->editingId = $product->id;

        $this->name = $product->name ?? '';
        $this->description = $product->description ?? '';
        $this->short_description = $product->short_description ?? '';
        $this->sku = $product->sku ?? '';
        $this->barcode = $product->barcode ?? '';
        $this->price = $product->price !== null ? (string) $product->price : '';
        $this->sale_price = $product->sale_price !== null ? (string) $product->sale_price : '';
        $this->cost_price = $product->cost_price !== null ? (string) $product->cost_price : '';
        $this->stock_quantity = (string) ($product->stock_quantity ?? 0);
        $this->low_stock_threshold = (string) ($product->low_stock_threshold ?? 10);
        $this->manage_stock = (bool) ($product->manage_stock ?? true);
        $this->stock_status = $product->stock_status ?? 'in_stock';
        // Se o produto tem categoria, verificar se ela tem pai
        if ($product->category_id) {
            $category = Category::find($product->category_id);
            if ($category) {
                if ($category->parent_id) {
                    // É uma subcategoria
                    $this->parent_category_id = (string) $category->parent_id;
                    $this->category_id = (string) $category->id;
                } else {
                    // É categoria raiz
                    $this->parent_category_id = (string) $category->id;
                    $this->category_id = '';
                }
            }
        } else {
            $this->parent_category_id = '';
            $this->category_id = '';
        }
        $this->brand_id = $product->brand_id ? (string) $product->brand_id : '';
        $this->is_active = (bool) ($product->is_active ?? true);
        $this->is_featured = (bool) ($product->is_featured ?? false);
        $this->condition = $product->condition ?? 'new';
        $this->condition_notes = $product->condition_notes ?? '';
        $this->weight = $product->weight !== null ? (string) $product->weight : '';
        $this->length = $product->length !== null ? (string) $product->length : '';
        $this->width = $product->width !== null ? (string) $product->width : '';
        $this->height = $product->height !== null ? (string) $product->height : '';

        $this->currentFeaturedImage = $product->featured_image;
        $this->currentImages = $product->images ?? [];

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();

        if (request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit')) {
            $this->redirect(route('admin.products.index'), navigate: true);
        }
    }

    public function saveProduct(): void
    {
        // Debug: verificar valor recebido
        \Log::info('Salvando produto com parent_category_id: ' . $this->parent_category_id);
        
        // Gerar SKU automático se não fornecido
        if (empty($this->sku)) {
            $this->sku = 'PROD-' . strtoupper(uniqid());
        }
        
        // Validar antes de processar
        $this->validate();
        
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'short_description' => $this->nullIfEmpty($this->short_description),
            'sku' => $this->sku,
            'barcode' => $this->nullIfEmpty($this->barcode),
            'price' => $this->price,
            'sale_price' => $this->nullIfEmpty($this->sale_price),
            'cost_price' => $this->nullIfEmpty($this->cost_price),
            'stock_quantity' => (int) $this->stock_quantity,
            'low_stock_threshold' => (int) $this->low_stock_threshold,
            'manage_stock' => $this->manage_stock,
            'stock_status' => $this->stock_status,
            'category_id' => !empty($this->category_id) ? (int) $this->category_id : (int) $this->parent_category_id,
            'brand_id' => $this->brand_id !== '' ? (int) $this->brand_id : null,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'condition' => $this->condition,
            'condition_notes' => $this->nullIfEmpty($this->condition_notes),
            'weight' => $this->nullIfEmpty($this->weight),
            'length' => $this->nullIfEmpty($this->length),
            'width' => $this->nullIfEmpty($this->width),
            'height' => $this->nullIfEmpty($this->height),
        ];

        $product = $this->editingId ? Product::find($this->editingId) : new Product();
        if (!$product) {
            return;
        }

        if ($this->editingId) {
            $product->update($data);
        } else {
            $product = Product::create($data);
        }

        if ($this->featuredImageUpload) {
            $path = $this->featuredImageUpload->store('products', 'public');
            $product->update(['featured_image' => $path]);
        }

        if (!empty($this->galleryUploads)) {
            $existing = $product->images ?? [];
            $stored = [];
            foreach ($this->galleryUploads as $upload) {
                if ($upload) {
                    $stored[] = $upload->store('products', 'public');
                }
            }

            $product->update([
                'images' => array_values(array_filter(array_merge($existing, $stored))),
            ]);
        }

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => $this->editingId ? 'Produto atualizado com sucesso!' : 'Produto criado com sucesso!',
        ]);

        $this->closeModal();
    }

    protected function resetForm(): void
    {
        $this->resetValidation();

        $this->editingId = null;
        $this->name = '';
        $this->description = '';
        $this->short_description = '';
        $this->sku = '';
        $this->barcode = '';
        $this->price = '';
        $this->sale_price = '';
        $this->cost_price = '';
        $this->stock_quantity = '0';
        $this->low_stock_threshold = '10';
        $this->manage_stock = true;
        $this->stock_status = 'in_stock';
        $this->parent_category_id = '';
        $this->category_id = '';
        $this->brand_id = '';
        $this->is_active = true;
        $this->is_featured = false;
        $this->condition = 'new';
        $this->condition_notes = '';
        $this->weight = '';
        $this->length = '';
        $this->width = '';
        $this->height = '';
        $this->currentFeaturedImage = null;
        $this->currentImages = [];
        $this->featuredImageUpload = null;
        $this->galleryUploads = [];
    }

    protected function nullIfEmpty(?string $value): mixed
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);
        return $trimmed === '' ? null : $trimmed;
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function updatingCategory(): void
    {
        $this->resetPage();
    }
    
    public function updatingBrand(): void
    {
        $this->resetPage();
    }
    
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    
    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }
    
    public function toggleSelectAll(): void
    {
        if ($this->selectAll) {
            $this->selected = $this->getProductsQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }
    
    public function deleteSelected(): void
    {
        if (count($this->selected) > 0) {
            $deletedCount = count($this->selected);
            Product::whereIn('id', $this->selected)->delete();
            $this->selected = [];
            $this->selectAll = false;
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => $deletedCount . ' produtos excluídos com sucesso!',
            ]);
        }
    }
    
    public function toggleStatus(int $productId): void
    {
        $product = Product::find($productId);
        if ($product) {
            $product->update(['is_active' => !$product->is_active]);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Status atualizado!',
            ]);
        }
    }
    
    public function deleteProduct(int $productId): void
    {
        $product = Product::find($productId);
        if ($product) {
            $product->delete();
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Produto excluído com sucesso!',
            ]);
        }
    }
    
    public function clearFilters(): void
    {
        $this->reset(['search', 'category', 'brand', 'status']);
        $this->resetPage();
    }
    
    public function testToast(): void
    {
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Toast está funcionando!',
        ]);
    }
    
    protected function getProductsQuery()
    {
        return Product::query()
            ->with(['category', 'brand'])
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            ->when($this->brand, fn($q) => $q->where('brand_id', $this->brand))
            ->when($this->status !== '', fn($q) => $q->where('is_active', $this->status === 'active'))
            ->orderBy($this->sortBy, $this->sortDir);
    }
    
    public function render()
    {
        $products = $this->getProductsQuery()->paginate($this->perPage);
        
        return view('livewire.admin.products.index-spa', [
            'products' => $products,
            'categories' => Category::whereNull('parent_id')->where('is_active', true)->distinct()->orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'lowStockProducts' => Product::where('stock_quantity', '<=', 10)->count(),
        ]);
    }
}
