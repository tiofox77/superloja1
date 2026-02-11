<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Illuminate\Support\Str;

#[Layout('components.admin.layouts.app')]
#[Title('Marcas')]
class BrandsSpa extends Component
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
    public string $website = '';
    public $logo;
    public bool $is_active = true;
    
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $this->editingId,
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
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
        $this->reset(['editingId', 'name', 'slug', 'description', 'website', 'logo', 'is_active']);
        $this->is_active = true;
        $this->showModal = true;
    }
    
    public function editBrand(int $id): void
    {
        $brand = Brand::find($id);
        if ($brand) {
            $this->editingId = $brand->id;
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->description = $brand->description ?? '';
            $this->website = $brand->website ?? '';
            $this->is_active = $brand->is_active;
            $this->logo = null;
            $this->showModal = true;
        }
    }
    
    public function saveBrand(): void
    {
        $this->validate();
        
        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'website' => $this->website,
            'is_active' => $this->is_active,
        ];
        
        if ($this->logo) {
            $data['logo'] = $this->logo->store('brands', 'public');
        }
        
        if ($this->editingId) {
            Brand::find($this->editingId)->update($data);
            $message = 'Marca atualizada com sucesso!';
        } else {
            Brand::create($data);
            $message = 'Marca criada com sucesso!';
        }
        
        $this->showModal = false;
        $this->reset(['editingId', 'name', 'slug', 'description', 'website', 'logo', 'is_active']);
        
        $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
    }
    
    public function toggleStatus(int $id): void
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->update(['is_active' => !$brand->is_active]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Status atualizado!']);
        }
    }
    
    public function deleteBrand(int $id): void
    {
        $brand = Brand::find($id);
        if ($brand) {
            if ($brand->products()->count() > 0) {
                $this->dispatch('toast', ['type' => 'error', 'message' => 'Marca possui produtos vinculados!']);
                return;
            }
            $brand->delete();
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Marca excluída!']);
        }
    }
    
    public function render()
    {
        $brands = Brand::query()
            ->withCount('products')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->paginate($this->perPage);
        
        return view('livewire.admin.brands.index-spa', [
            'brands' => $brands,
            'totalBrands' => Brand::count(),
            'activeBrands' => Brand::where('is_active', true)->count(),
        ]);
    }
}
