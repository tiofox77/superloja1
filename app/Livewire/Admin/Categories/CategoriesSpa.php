<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Str;

#[Layout('components.admin.layouts.app')]
#[Title('Categorias')]
class CategoriesSpa extends Component
{
    use WithPagination, WithFileUploads;
    
    #[Url]
    public string $search = '';
    
    public int $perPage = 12;
    
    // Modal
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public ?int $parent_id = null;
    public $image;
    public bool $is_active = true;
    public int $sort_order = 0;
    
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->editingId,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }
    
    public function updatedName(): void
    {
        if (!$this->editingId) {
            $this->slug = Str::slug($this->name);
        }
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'name', 'slug', 'description', 'parent_id', 'image', 'is_active', 'sort_order']);
        $this->is_active = true;
        $this->showModal = true;
    }
    
    public function editCategory(int $id): void
    {
        $category = Category::find($id);
        if ($category) {
            $this->editingId = $category->id;
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->description = $category->description ?? '';
            $this->parent_id = $category->parent_id;
            $this->is_active = $category->is_active;
            $this->sort_order = $category->sort_order ?? 0;
            $this->image = null;
            $this->showModal = true;
        }
    }
    
    public function saveCategory(): void
    {
        $this->validate();
        
        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];
        
        if ($this->image) {
            $data['image'] = $this->image->store('categories', 'public');
        }
        
        if ($this->editingId) {
            Category::find($this->editingId)->update($data);
            $message = 'Categoria atualizada com sucesso!';
        } else {
            Category::create($data);
            $message = 'Categoria criada com sucesso!';
        }
        
        $this->showModal = false;
        $this->reset(['editingId', 'name', 'slug', 'description', 'parent_id', 'image', 'is_active', 'sort_order']);
        
        $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
    }
    
    public function toggleStatus(int $id): void
    {
        $category = Category::find($id);
        if ($category) {
            $category->update(['is_active' => !$category->is_active]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Status atualizado!']);
        }
    }
    
    public function deleteCategory(int $id): void
    {
        $category = Category::find($id);
        if ($category) {
            if ($category->products()->count() > 0) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Categoria possui produtos vinculados!']);
                return;
            }
            $category->delete();
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Categoria excluída!']);
        }
    }
    
    public function render()
    {
        // Se houver busca, retorna flat
        if ($this->search) {
            $categories = Category::query()
                ->withCount('products')
                ->where('name', 'like', "%{$this->search}%")
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
            
            $rootCategories = collect([]);
        } else {
            // Retorna hierarquicamente: categorias raiz com suas subcategorias
            $rootCategories = Category::query()
                ->whereNull('parent_id')
                ->with(['children' => function($q) {
                    $q->withCount('products')->orderBy('sort_order')->orderBy('name');
                }])
                ->withCount('products')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
            
            $categories = collect([]);
        }
        
        $parentCategories = Category::whereNull('parent_id')->orderBy('name')->get();
        
        return view('livewire.admin.categories.index-spa', [
            'categories' => $categories,
            'rootCategories' => $rootCategories,
            'parentCategories' => $parentCategories,
            'totalCategories' => Category::count(),
            'activeCategories' => Category::where('is_active', true)->count(),
        ]);
    }
}
