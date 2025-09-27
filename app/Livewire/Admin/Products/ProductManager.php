<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariant;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showModal = false;
    public $editMode = false;
    public $productId = null;

    // Form fields
    public $name = '';
    public $description = '';
    public $price = '';
    public $sale_price = '';
    public $stock_quantity = '';
    public $sku = '';
    public $category_id = '';
    public $brand_id = '';
    public $is_active = true;
    public $is_featured = false;
    public $weight = '';
    public $length = '';
    public $width = '';
    public $height = '';
    public $image = null;
    public $gallery = [];

    // Filters
    public $search = '';
    public $filterCategory = '';
    public $filterBrand = '';
    public $filterStatus = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // View mode
    public $viewMode = 'table';
    
    // Variantes
    public $variants = [];
    
    // Selection and pagination
    public $selectedProducts = [];
    public $perPage = 10;
    public $selectAll = false;
    public $filterCondition = '';

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:10|max:2000',
        'price' => 'required|numeric|min:0.01',
        'sale_price' => 'nullable|numeric|min:0|lt:price',
        'stock_quantity' => 'required|integer|min:0',
        'sku' => 'required|string|min:3|max:100|unique:products,sku',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'nullable|exists:brands,id',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'weight' => 'nullable|numeric|min:0',
        'length' => 'nullable|numeric|min:0',
        'width' => 'nullable|numeric|min:0',
        'height' => 'nullable|numeric|min:0',
        'image' => 'nullable|image|max:2048',
        'gallery.*' => 'nullable|image|max:2048',
        'variants.*.name' => 'nullable|string|max:255',
        'variants.*.value' => 'nullable|string|max:255',
        'variants.*.price_adjustment' => 'nullable|numeric',
        'variants.*.stock_quantity' => 'nullable|integer|min:0',
        'variants.*.sku_suffix' => 'nullable|string|max:50',
        'variants.*.images.*' => 'nullable|image|max:2048',
    ];

    protected $queryString = ['search', 'filterCategory', 'filterBrand', 'filterStatus', 'sortBy', 'sortDirection'];

    public function mount(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function render()
    {
        $products = Product::with(['category', 'brand'])
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%')
                                                    ->orWhere('sku', 'like', '%' . $this->search . '%'))
            ->when($this->filterCategory, fn($query) => $query->where('category_id', $this->filterCategory))
            ->when($this->filterBrand, fn($query) => $query->where('brand_id', $this->filterBrand))
            ->when($this->filterStatus !== '', fn($query) => $query->where('is_active', $this->filterStatus))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'featured' => Product::where('is_featured', true)->count(),
            'low_stock' => Product::where('stock_quantity', '<=', 10)->count(),
        ];

        // Atualizar estado do checkbox "selecionar todos" após renderizar
        $this->updateSelectAllState();

        return view('livewire.admin.products.product-manager', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerir Produtos',
            'pageTitle' => 'Produtos'
        ]);
    }

    public function openModal($productId = null): void
    {
        $this->resetFields();
        $this->resetValidation();

        if ($productId) {
            $this->editMode = true;
            $this->productId = $productId;
            $this->loadProduct($productId);
        } else {
            $this->editMode = false;
            $this->productId = null;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetFields();
        $this->resetValidation();
        
        // Dispatch event para limpar previews JavaScript
        $this->dispatch('modalClosed');
    }

    public function saveProduct(): void
    {        
        try {
            // Validação personalizada para SKU
            $rules = $this->rules;
            if ($this->editMode && $this->productId) {
                $rules['sku'] = 'required|string|min:3|max:100|unique:products,sku,' . $this->productId;
            }
            
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erros de validação: ' . implode(', ', $errors)
            ]);
            return;
        }

        try {
            $productData = [
                'name' => $this->name,
                'slug' => \Str::slug($this->name),
                'description' => $this->description ?: '',
                'price' => (float)$this->price,
                'sale_price' => $this->sale_price ? (float)$this->sale_price : null,
                'stock_quantity' => (int)($this->stock_quantity ?: 0),
                'sku' => $this->sku,
                'category_id' => (int)$this->category_id,
                'brand_id' => $this->brand_id ? (int)$this->brand_id : null,
                'is_active' => (bool)$this->is_active,
                'is_featured' => (bool)$this->is_featured,
                'weight' => $this->weight ? (float)$this->weight : null,
                'length' => $this->length ? (float)$this->length : null,
                'width' => $this->width ? (float)$this->width : null,
                'height' => $this->height ? (float)$this->height : null,
            ];

            if ($this->editMode) {
                $product = Product::findOrFail($this->productId);
                $product->update($productData);
                $message = 'Produto atualizado com sucesso!';
            } else {
                $product = Product::create($productData);
                $message = 'Produto criado com sucesso!';
            }

            // Handle image upload com validação rigorosa
            $this->handleImageUpload($product);
            
            // Salvar variantes
            $this->saveVariants($product);

            $this->closeModal();
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro ao salvar produto: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao salvar produto. Tente novamente.'
            ]);
        }
    }

    // Método removido - estava interferindo com uploads do Livewire

    private function handleImageUpload($product): void
    {
        \Log::info('HandleImageUpload called', [
            'product_id' => $product->id,
            'has_image' => !empty($this->image),
            'image_type' => $this->image ? gettype($this->image) : null,
            'image_class' => $this->image ? get_class($this->image) : null,
        ]);
        
        // Upload da imagem principal
        if ($this->image && is_object($this->image) && $this->image->isValid()) {
            \Log::info('Processing main image', [
                'name' => $this->image->getClientOriginalName(),
                'size' => $this->image->getSize(),
                'mime' => $this->image->getMimeType(),
            ]);
            
            try {
                $imagePath = $this->image->store('products', 'public');
                if ($imagePath) {
                    $product->update(['featured_image' => $imagePath]);
                    \Log::info('Main image uploaded successfully', ['path' => $imagePath]);
                }
            } catch (\Exception $e) {
                \Log::error('Erro no upload da imagem principal: ' . $e->getMessage());
            }
        } else {
            \Log::info('No main image or invalid', [
                'has_image' => !empty($this->image),
                'is_object' => $this->image ? is_object($this->image) : false,
                'is_valid' => $this->image && is_object($this->image) ? $this->image->isValid() : false,
            ]);
        }

        // Upload da galeria
        if (!empty($this->gallery) && is_array($this->gallery)) {
            $galleryPaths = [];
            foreach ($this->gallery as $galleryImage) {
                if ($galleryImage && is_object($galleryImage) && $galleryImage->isValid()) {
                    try {
                        $galleryPath = $galleryImage->store('products/gallery', 'public');
                        if ($galleryPath) {
                            $galleryPaths[] = $galleryPath;
                        }
                    } catch (\Exception $e) {
                        \Log::error('Erro no upload da galeria: ' . $e->getMessage());
                    }
                }
            }
            
            if (!empty($galleryPaths)) {
                // No modo de edição, fazer merge com imagens existentes
                $existingImages = [];
                if ($this->editMode && $product->images) {
                    if (is_array($product->images)) {
                        $existingImages = $product->images;
                    } elseif (is_string($product->images)) {
                        $decoded = json_decode($product->images, true);
                        $existingImages = is_array($decoded) ? $decoded : [];
                    }
                }
                
                $allImages = array_merge($existingImages, $galleryPaths);
                $product->update(['images' => $allImages]);
            }
        }
    }

    public function deleteProduct($productId): void
    {
        try {
            $product = Product::findOrFail($productId);
            $product->delete();

            $this->dispatch('productDeleted', $productId);
            session()->flash('success', 'Produto eliminado com sucesso!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao eliminar produto: ' . $e->getMessage());
        }
    }

    public function toggleStatus($productId): void
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update(['is_active' => !$product->is_active]);

            $this->dispatch('productStatusToggled', $productId);
            session()->flash('success', 'Status do produto alterado!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }

    public function toggleFeatured($productId): void
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update(['is_featured' => !$product->is_featured]);

            session()->flash('success', 'Produto ' . ($product->is_featured ? 'destacado' : 'removido dos destaques') . '!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao alterar destaque: ' . $e->getMessage());
        }
    }

    private function loadProduct($productId): void
    {
        $product = Product::findOrFail($productId);

        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->price = $product->price;
        $this->sale_price = $product->sale_price;
        $this->stock_quantity = $product->stock_quantity;
        $this->sku = $product->sku;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->weight = $product->weight;
        $this->length = $product->length;
        $this->width = $product->width;
        $this->height = $product->height;
        
        // Carregar imagens da galeria existentes (não são uploads do Livewire)
        // Estas são apenas para visualização no modo de edição
        $this->gallery = []; // Reset gallery para uploads
        
        // Carregar variantes existentes
        $this->loadProductVariants($productId);
    }

    private function resetFields(): void
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->sale_price = '';
        $this->stock_quantity = '';
        $this->sku = '';
        $this->category_id = '';
        $this->brand_id = '';
        $this->is_active = true;
        $this->is_featured = false;
        $this->weight = '';
        $this->length = '';
        $this->width = '';
        $this->height = '';
        
        // Reset file uploads safely
        $this->image = null;
        $this->gallery = [];
        $this->variants = [];
        
        // Clear validation errors
        $this->resetValidation();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatingFilterCategory(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatingFilterBrand(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function addVariant(): void
    {
        $this->variants[] = [
            'name' => '',
            'value' => '',
            'price_adjustment' => 0,
            'stock_quantity' => 0,
            'sku_suffix' => '',
            'images' => [],
            'is_active' => true
        ];
    }

    public function removeVariant($index): void
    {
        if (isset($this->variants[$index])) {
            $variant = $this->variants[$index];
            
            // Se for uma variante existente (tem ID), remover do banco de dados
            if (isset($variant['id']) && $variant['id']) {
                try {
                    $dbVariant = ProductVariant::find($variant['id']);
                    if ($dbVariant) {
                        // Remover imagens físicas se existirem
                        if ($dbVariant->images && is_array($dbVariant->images)) {
                            foreach ($dbVariant->images as $imagePath) {
                                if (Storage::disk('public')->exists($imagePath)) {
                                    Storage::disk('public')->delete($imagePath);
                                }
                            }
                        }
                        
                        $variantName = $dbVariant->name . ' - ' . $dbVariant->value;
                        $dbVariant->delete();
                        
                        $this->dispatch('showAlert', [
                            'type' => 'success',
                            'message' => "Variante '{$variantName}' removida com sucesso!"
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Erro ao remover variante do banco: ' . $e->getMessage());
                    $this->dispatch('showAlert', [
                        'type' => 'error',
                        'message' => 'Erro ao remover variante do banco de dados.'
                    ]);
                    return;
                }
            } else {
                // Variante nova (apenas local), mostrar notificação simples
                $variantName = ($variant['name'] ?? 'Nova') . ' - ' . ($variant['value'] ?? 'Valor');
                $this->dispatch('showAlert', [
                    'type' => 'info',
                    'message' => "Variante '{$variantName}' removida da lista."
                ]);
            }
            
            // Remover do array local
            unset($this->variants[$index]);
            $this->variants = array_values($this->variants);
        }
    }

    public function updatedSelectedProducts(): void
    {
        // Verificar se todos os produtos visíveis estão selecionados
        $currentPageProductIds = $this->getProducts()->paginate(15)->pluck('id')->toArray();
        
        if (empty($this->selectedProducts)) {
            $this->selectAll = false;
        } else {
            // Verificar se todos os produtos da página atual estão selecionados
            $selectedInCurrentPage = array_intersect($currentPageProductIds, $this->selectedProducts);
            $this->selectAll = count($selectedInCurrentPage) === count($currentPageProductIds);
        }
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectAllProducts();
        } else {
            $this->deselectAllProducts();
        }
    }

    public function updatedFilterCondition(): void
    {
        $this->resetPage();
    }

    public function getProducts()
    {
        return Product::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->filterCategory, fn($query) => $query->where('category_id', $this->filterCategory))
            ->when($this->filterBrand, fn($query) => $query->where('brand_id', $this->filterBrand))
            ->when($this->filterStatus, function($query) {
                if ($this->filterStatus === 'active') {
                    $query->where('is_active', true);
                } elseif ($this->filterStatus === 'inactive') {
                    $query->where('is_active', false);
                } elseif ($this->filterStatus === 'featured') {
                    $query->where('is_featured', true);
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection);
    }

    public function selectAllProducts(): void
    {
        // Selecionar apenas produtos da página atual
        $currentPageProductIds = $this->getProducts()->paginate(15)->pluck('id')->toArray();
        
        // Manter produtos já selecionados de outras páginas e adicionar os da página atual
        $this->selectedProducts = array_unique(array_merge($this->selectedProducts, $currentPageProductIds));
    }

    public function deselectAllProducts(): void
    {
        // Desmarcar apenas produtos da página atual
        $currentPageProductIds = $this->getProducts()->paginate(15)->pluck('id')->toArray();
        $this->selectedProducts = array_diff($this->selectedProducts, $currentPageProductIds);
    }

    public function updateSelectAllState(): void
    {
        // Verificar se todos os produtos da página atual estão selecionados
        $currentPageProductIds = $this->getProducts()->paginate(15)->pluck('id')->toArray();
        
        if (empty($currentPageProductIds)) {
            $this->selectAll = false;
        } else {
            $selectedInCurrentPage = array_intersect($currentPageProductIds, $this->selectedProducts);
            $this->selectAll = count($selectedInCurrentPage) === count($currentPageProductIds);
        }
    }

    // Real-time validation
    public function updatedName(): void
    {
        $this->validateOnly('name');
    }

    public function updatedSku(): void
    {
        $this->validateOnly('sku');
    }

    public function updatedPrice(): void
    {
        $this->validateOnly('price');
    }

    public function updatedSalePrice(): void
    {
        $this->validateOnly('sale_price');
    }

    public function updatedStockQuantity(): void
    {
        $this->validateOnly('stock_quantity');
    }

    public function updatedCategoryId(): void
    {
        $this->validateOnly('category_id');
    }

    public function updatedBrandId(): void
    {
        $this->validateOnly('brand_id');
    }

    public function updatedImage(): void
    {
        $this->validateOnly('image');
    }

    public function updatedGallery(): void
    {
        $this->validateOnly('gallery.*');
    }


    // Debug method to test if Livewire is working
    public function testMethod(): void
    {
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Teste de conectividade Livewire funcionando!'
        ]);
    }

    // Método sem uploads para teste
    public function saveProductWithoutUploads(): void
    {
        // Validação básica sem uploads
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
        ];

        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Preencha os campos obrigatórios corretamente.'
            ]);
            return;
        }

        try {
            $productData = [
                'name' => $this->name,
                'slug' => \Str::slug($this->name),
                'description' => $this->description ?: '',
                'price' => (float)$this->price,
                'sale_price' => $this->sale_price ? (float)$this->sale_price : null,
                'stock_quantity' => (int)($this->stock_quantity ?: 0),
                'sku' => $this->sku,
                'category_id' => (int)$this->category_id,
                'brand_id' => $this->brand_id ? (int)$this->brand_id : null,
                'is_active' => (bool)$this->is_active,
                'is_featured' => (bool)$this->is_featured,
                'weight' => $this->weight ? (float)$this->weight : null,
                'length' => $this->length ? (float)$this->length : null,
                'width' => $this->width ? (float)$this->width : null,
                'height' => $this->height ? (float)$this->height : null,
            ];

            if ($this->editMode) {
                $product = Product::findOrFail($this->productId);
                $product->update($productData);
                $message = 'Produto atualizado com sucesso!';
            } else {
                $product = Product::create($productData);
                $message = 'Produto criado com sucesso!';
            }
            
            $this->closeModal();
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro ao salvar produto: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage()
            ]);
        }
    }

    // Método alternativo com uploads mais seguro
    public function saveProductAlternative(): void
    {
        // Reset uploads problemáticos
        $this->image = null;
        $this->gallery = [];
        
        // Usa o método sem uploads
        $this->saveProductWithoutUploads();
    }

    public function removeImage(): void
    {
        $this->image = null;
        $this->resetValidation('image');
    }

    public function removeGalleryImage($index): void
    {
        if (is_array($this->gallery) && isset($this->gallery[$index])) {
            unset($this->gallery[$index]);
            $this->gallery = array_values($this->gallery); // Reindex array
        }
        $this->resetValidation('gallery.*');
    }

    public function removeExistingImage($productId, $imageIndex): void
    {
        try {
            $product = Product::findOrFail($productId);
            $images = [];
            
            if ($product->images) {
                if (is_array($product->images)) {
                    $images = $product->images;
                } elseif (is_string($product->images)) {
                    $decoded = json_decode($product->images, true);
                    $images = is_array($decoded) ? $decoded : [];
                }
            }
            
            if (isset($images[$imageIndex])) {
                // Remover o arquivo físico se existir
                if (Storage::disk('public')->exists($images[$imageIndex])) {
                    Storage::disk('public')->delete($images[$imageIndex]);
                }
                
                // Remover do array
                unset($images[$imageIndex]);
                $images = array_values($images); // Reindex
                
                // Atualizar o produto
                $product->update(['images' => $images]);
                
                $this->dispatch('showAlert', [
                    'type' => 'success',
                    'message' => 'Imagem removida com sucesso!'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao remover imagem: ' . $e->getMessage()
            ]);
        }
    }

    public function removeVariantImage($variantIndex, $imageIndex): void
    {
        if (isset($this->variants[$variantIndex]['images'][$imageIndex])) {
            unset($this->variants[$variantIndex]['images'][$imageIndex]);
            $this->variants[$variantIndex]['images'] = array_values($this->variants[$variantIndex]['images']);
        }
    }

    public function loadProductVariants($productId): void
    {
        $variants = ProductVariant::where('product_id', $productId)->get();
        
        $this->variants = $variants->map(function ($variant) {
            // Processar imagens existentes
            $existingImages = [];
            if ($variant->images) {
                if (is_array($variant->images)) {
                    $existingImages = $variant->images;
                } elseif (is_string($variant->images)) {
                    $decoded = json_decode($variant->images, true);
                    $existingImages = is_array($decoded) ? $decoded : [];
                }
            }
            
            return [
                'id' => $variant->id,
                'name' => $variant->name,
                'value' => $variant->value,
                'price_adjustment' => $variant->price_adjustment,
                'stock_quantity' => $variant->stock_quantity,
                'sku_suffix' => $variant->sku_suffix,
                'images' => [], // Para novos uploads
                'is_active' => $variant->is_active,
                'existing_images' => $existingImages // Imagens já salvas
            ];
        })->toArray();
    }

    private function saveVariants($product): void
    {
        if (!empty($this->variants)) {
            foreach ($this->variants as $variantData) {
                $variantImages = [];
                
                // Upload das imagens da variante se existirem
                if (!empty($variantData['images']) && is_array($variantData['images'])) {
                    foreach ($variantData['images'] as $image) {
                        if ($image && is_object($image) && $image->isValid()) {
                            try {
                                $imagePath = $image->store('products/variants', 'public');
                                if ($imagePath) {
                                    $variantImages[] = $imagePath;
                                }
                            } catch (\Exception $e) {
                                \Log::error('Erro no upload da imagem da variante: ' . $e->getMessage());
                            }
                        }
                    }
                }
                
                // Merge com imagens existentes se for edição
                $existingImages = $variantData['existing_images'] ?? [];
                $allImages = array_merge($existingImages, $variantImages);
                
                $variantDbData = [
                    'product_id' => $product->id,
                    'name' => $variantData['name'],
                    'value' => $variantData['value'],
                    'price_adjustment' => (float)($variantData['price_adjustment'] ?? 0),
                    'stock_quantity' => (int)($variantData['stock_quantity'] ?? 0),
                    'sku_suffix' => $variantData['sku_suffix'] ?? '',
                    'images' => $allImages,
                    'is_active' => $variantData['is_active'] ?? true
                ];
                
                if (isset($variantData['id']) && $variantData['id']) {
                    // Atualizar variante existente
                    ProductVariant::where('id', $variantData['id'])->update($variantDbData);
                } else {
                    // Criar nova variante
                    ProductVariant::create($variantDbData);
                }
            }
        }
    }

    public function bulkAction($action): void
    {
        if (empty($this->selectedProducts)) {
            $this->dispatch('showAlert', [
                'type' => 'warning',
                'message' => 'Selecione pelo menos um produto para executar a ação.'
            ]);
            return;
        }

        try {
            $count = 0;
            switch ($action) {
                case 'activate':
                    $count = Product::whereIn('id', $this->selectedProducts)->update(['is_active' => true]);
                    $message = "{$count} produto(s) ativado(s) com sucesso!";
                    break;
                    
                case 'deactivate':
                    $count = Product::whereIn('id', $this->selectedProducts)->update(['is_active' => false]);
                    $message = "{$count} produto(s) desativado(s) com sucesso!";
                    break;
                    
                case 'feature':
                    $count = Product::whereIn('id', $this->selectedProducts)->update(['is_featured' => true]);
                    $message = "{$count} produto(s) destacado(s) com sucesso!";
                    break;
                    
                case 'unfeature':
                    $count = Product::whereIn('id', $this->selectedProducts)->update(['is_featured' => false]);
                    $message = "{$count} produto(s) removido(s) dos destaques!";
                    break;
                    
                case 'delete':
                    $count = Product::whereIn('id', $this->selectedProducts)->delete();
                    $message = "{$count} produto(s) removido(s) com sucesso!";
                    break;
                    
                default:
                    throw new \Exception('Ação não reconhecida.');
            }

            $this->selectedProducts = [];
            $this->selectAll = false;
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro na ação em lote: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao executar a ação: ' . $e->getMessage()
            ]);
        }
    }

    public function exportProducts(): void
    {
        $filters = [
            'search' => $this->search,
            'category' => $this->filterCategory,
            'brand' => $this->filterBrand,
            'status' => $this->filterStatus
        ];
        
        // Se há produtos selecionados, incluir apenas esses
        if (!empty($this->selectedProducts)) {
            $filters['selected_ids'] = implode(',', $this->selectedProducts);
        }
        
        $url = route('admin.products.export-pdf') . '?' . http_build_query($filters);
        
        $this->dispatch('openUrl', ['url' => $url]);
        
        $message = !empty($this->selectedProducts) 
            ? 'Gerando PDF com ' . count($this->selectedProducts) . ' produto(s) selecionado(s)...'
            : 'Gerando PDF com todos os produtos filtrados...';
            
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    public function exportProductsExcel(): void
    {
        $filters = [
            'search' => $this->search,
            'category' => $this->filterCategory,
            'brand' => $this->filterBrand,
            'status' => $this->filterStatus
        ];
        
        // Se há produtos selecionados, incluir apenas esses
        if (!empty($this->selectedProducts)) {
            $filters['selected_ids'] = implode(',', $this->selectedProducts);
        }
        
        $url = route('admin.products.export-csv') . '?' . http_build_query($filters);
        
        $this->dispatch('openUrl', ['url' => $url]);
        
        $message = !empty($this->selectedProducts) 
            ? 'Gerando CSV com ' . count($this->selectedProducts) . ' produto(s) selecionado(s)...'
            : 'Gerando CSV com todos os produtos filtrados...';
            
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $message
        ]);
    }
    
}
