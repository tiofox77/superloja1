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
        $categories = Category::query()
            ->when($this->search, fn($query) => $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            }))
            ->when($this->filter === 'active', fn($query) => $query->where('is_active', true))
            ->when($this->filter === 'inactive', fn($query) => $query->where('is_active', false))
            ->when($this->filter === 'parent', fn($query) => $query->whereNull('parent_id'))
            ->when($this->filter === 'child', fn($query) => $query->whereNotNull('parent_id'))
            ->with(['parent', 'children'])
            ->withCount(['products', 'children'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

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
        $category = Category::withCount(['products', 'children'])->findOrFail($categoryId);
        
        $this->categoryToDelete = $categoryId;
        $this->categoryNameToDelete = $categoryName;
        $this->productCount = $category->products_count;
        $this->childrenCount = $category->children_count;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            $category = Category::findOrFail($this->categoryToDelete);
            
            // Delete image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            // Delete category (cascade will handle children if configured)
            $category->delete();
            
            $this->showDeleteModal = false;
            $this->dispatch('notify', message: 'Categoria excluída com sucesso!', type: 'success');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Erro ao excluir categoria: ' . $e->getMessage(), type: 'error');
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
