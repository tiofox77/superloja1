<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryManager extends Component
{
    use WithFileUploads, WithPagination;

    // Modal state
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $isEditMode = false;
    
    // Form fields
    public $categoryId;
    public string $name = '';
    public string $description = '';
    public $parentId = null;
    public string $icon = '';
    public string $color = '#6366f1';
    public int $sortOrder = 0;
    public bool $isActive = true;
    public $image;
    public string $currentImage = '';
    public bool $removeImage = false;
    
    // Search and filters
    public string $search = '';
    public string $filter = '';
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';
    
    // Delete modal
    public $categoryToDelete;
    public string $categoryNameToDelete = '';
    public int $productCount = 0;
    public int $childrenCount = 0;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'parentId' => 'nullable|exists:categories,id',
        'icon' => 'nullable|string|max:10',
        'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
        'sortOrder' => 'required|integer|min:0',
        'isActive' => 'boolean',
        'image' => 'nullable|image|max:2048', // 2MB Max
    ];

    protected array $messages = [
        'name.required' => 'O nome da categoria é obrigatório.',
        'name.max' => 'O nome deve ter no máximo 255 caracteres.',
        'color.regex' => 'Cor deve estar no formato hexadecimal (#RRGGBB).',
        'image.image' => 'O arquivo deve ser uma imagem.',
        'image.max' => 'A imagem deve ter no máximo 2MB.',
    ];

    public function render()
    {
        // Buscar categorias hierarquicamente
        $query = Category::query()
            ->when($this->search, fn($query) => $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            }))
            ->when($this->filter === 'active', fn($query) => $query->where('is_active', true))
            ->when($this->filter === 'inactive', fn($query) => $query->where('is_active', false))
            ->when($this->filter === 'parent', fn($query) => $query->whereNull('parent_id'))
            ->when($this->filter === 'child', fn($query) => $query->whereNotNull('parent_id'))
            ->with(['parent', 'children'])
            ->withCount(['products', 'children']);

        // Ordenação hierárquica: pais primeiro, depois filhos agrupados por pai
        if ($this->filter !== 'child') {
            $query->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
                  ->orderBy('parent_id', 'asc')
                  ->orderBy($this->sortBy, $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        $categories = $query->paginate(15);

        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $stats = [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'main' => Category::whereNull('parent_id')->count(),
            'sub' => Category::whereNotNull('parent_id')->count(),
        ];

        return view('livewire.admin.categories.category-manager', [
            'categories' => $categories,
            'parentCategories' => $parentCategories,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerir Categorias',
            'pageTitle' => 'Categorias'
        ]);
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->filter = '';
        $this->resetPage();
    }

    public function openModal($categoryId = null): void
    {
        $this->resetForm();
        
        if ($categoryId) {
            $this->isEditMode = true;
            $this->categoryId = $categoryId;
            $this->loadCategory($categoryId);
        } else {
            $this->isEditMode = false;
            $this->categoryId = null;
        }
        
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'name', 'description', 'parentId', 'icon', 'color', 
            'sortOrder', 'isActive', 'image', 'currentImage', 'removeImage'
        ]);
        
        $this->color = '#6366f1';
        $this->isActive = true;
        $this->sortOrder = 0;
        $this->resetValidation();
    }

    private function loadCategory(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        
        $this->name = $category->name;
        $this->description = $category->description ?? '';
        $this->parentId = $category->parent_id;
        $this->icon = $category->icon ?? '';
        $this->color = $category->color;
        $this->sortOrder = $category->sort_order;
        $this->isActive = $category->is_active;
        $this->currentImage = $category->image ?? '';
    }

    public function save(): void
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'parent_id' => $this->parentId ?: null,
                'icon' => $this->icon,
                'color' => $this->color,
                'sort_order' => $this->sortOrder,
                'is_active' => $this->isActive,
            ];

            // Handle image upload
            if ($this->image) {
                // Delete old image if exists
                if ($this->currentImage) {
                    Storage::disk('public')->delete($this->currentImage);
                }
                
                $data['image'] = $this->image->store('categories', 'public');
            } elseif ($this->removeImage && $this->currentImage) {
                // Remove current image
                Storage::disk('public')->delete($this->currentImage);
                $data['image'] = null;
            }

            if ($this->isEditMode) {
                Category::findOrFail($this->categoryId)->update($data);
                $message = 'Categoria atualizada com sucesso!';
            } else {
                Category::create($data);
                $message = 'Categoria criada com sucesso!';
            }

            $this->closeModal();
            $this->dispatch('notify', message: $message, type: 'success');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Erro ao salvar categoria: ' . $e->getMessage(), type: 'error');
        }
    }

    public function confirmDelete(int $categoryId, string $categoryName): void
    {
        try {
            \Log::info("confirmDelete chamado - ID: {$categoryId}, Nome: {$categoryName}");
            
            $category = Category::withCount(['products', 'children'])->findOrFail($categoryId);
            
            $this->categoryToDelete = $categoryId;
            $this->categoryNameToDelete = $categoryName;
            $this->productCount = $category->products_count;
            $this->childrenCount = $category->children_count;
            
            \Log::info("Modal de exclusão será exibida - Produtos: {$this->productCount}, Subcategorias: {$this->childrenCount}");
            
            $this->showDeleteModal = true;
        } catch (\Exception $e) {
            \Log::error("Erro ao abrir modal de exclusão: " . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao abrir confirmação de exclusão: ' . $e->getMessage()
            ]);
        }
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->categoryToDelete = null;
        $this->categoryNameToDelete = '';
        $this->productCount = 0;
        $this->childrenCount = 0;
    }

    public function delete(): void
    {
        try {
            if (!$this->categoryToDelete) {
                throw new \Exception('ID da categoria não encontrado');
            }

            $category = Category::with(['products', 'children'])->findOrFail($this->categoryToDelete);
            
            \Log::info('Tentando excluir categoria: ' . $category->name . ' (ID: ' . $category->id . ')');
            
            $productsCount = $category->products()->count();
            $childrenCount = $category->children()->count();
            
            \Log::info("Categoria tem {$productsCount} produtos e {$childrenCount} subcategorias");
            
            // Se tiver produtos, remover a categoria deles (não deletar os produtos)
            if ($productsCount > 0) {
                \DB::table('products')
                    ->where('category_id', $category->id)
                    ->update(['category_id' => null]);
                \Log::info("Removida categoria de {$productsCount} produtos");
            }
            
            // Se tiver subcategorias, deletar também (incluindo imagens)
            if ($childrenCount > 0) {
                foreach ($category->children as $child) {
                    $childProductsCount = $child->products()->count();
                    
                    // Remover categoria dos produtos das subcategorias
                    if ($childProductsCount > 0) {
                        \DB::table('products')
                            ->where('category_id', $child->id)
                            ->update(['category_id' => null]);
                        \Log::info("Removida subcategoria de {$childProductsCount} produtos");
                    }
                    
                    // Deletar imagem da subcategoria
                    if ($child->image) {
                        try {
                            Storage::disk('public')->delete($child->image);
                            \Log::info("Imagem da subcategoria deletada: {$child->image}");
                        } catch (\Exception $e) {
                            \Log::warning("Erro ao deletar imagem: {$e->getMessage()}");
                        }
                    }
                }
                
                // Deletar subcategorias
                $category->children()->delete();
                \Log::info("Subcategorias deletadas");
            }
            
            // Delete image if exists
            if ($category->image) {
                try {
                    Storage::disk('public')->delete($category->image);
                    \Log::info("Imagem da categoria deletada: {$category->image}");
                } catch (\Exception $e) {
                    \Log::warning("Erro ao deletar imagem: {$e->getMessage()}");
                }
            }
            
            // Delete category
            $categoryName = $category->name;
            $category->delete();
            \Log::info("Categoria '{$categoryName}' excluída com sucesso");
            
            $this->closeDeleteModal();
            
            session()->flash('success', "Categoria '{$categoryName}' excluída com sucesso!");
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => "Categoria '{$categoryName}' excluída com sucesso!"
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Categoria não encontrada para exclusão: ' . $this->categoryToDelete);
            
            $this->closeDeleteModal();
            
            session()->flash('error', 'Categoria não encontrada.');
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Categoria não encontrada.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir categoria: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            $this->closeDeleteModal();
            
            $errorMsg = 'Erro ao excluir categoria: ' . $e->getMessage();
            session()->flash('error', $errorMsg);
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $errorMsg
            ]);
        }
    }

    public function toggleActive(int $categoryId): void
    {
        try {
            $category = Category::findOrFail($categoryId);
            $category->update(['is_active' => !$category->is_active]);
            
            $status = $category->is_active ? 'ativada' : 'desativada';
            $this->dispatch('notify', message: "Categoria {$status} com sucesso!", type: 'success');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Erro ao alterar status: ' . $e->getMessage(), type: 'error');
        }
    }

    public function sortBy(string $field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }

    public function removeCurrentImage(): void
    {
        $this->removeImage = true;
        $this->currentImage = '';
    }
}
