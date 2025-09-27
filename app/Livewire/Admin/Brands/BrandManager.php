<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BrandManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $brandId = null;
    public $selectedBrand = null;

    // Form fields
    public $name = '';
    public $description = '';
    public $website = '';
    public $is_active = true;
    public $logo = null;

    // Filters
    public $search = '';
    public $filterStatus = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'description' => 'nullable|string|max:1000',
        'website' => 'nullable|url|max:255',
        'is_active' => 'boolean',
        'logo' => 'nullable|image|max:2048'
    ];

    protected $queryString = ['search', 'filterStatus', 'sortBy', 'sortDirection'];

    public function mount(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $brands = Brand::withCount('products')
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->filterStatus !== '', fn($query) => $query->where('is_active', $this->filterStatus))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $stats = [
            'total' => Brand::count(),
            'active' => Brand::where('is_active', true)->count(),
            'inactive' => Brand::where('is_active', false)->count(),
            'with_products' => Brand::has('products')->count(),
        ];

        return view('livewire.admin.brands.brand-manager', [
            'brands' => $brands,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerir Marcas',
            'pageTitle' => 'Marcas'
        ]);
    }

    public function openModal($brandId = null): void
    {
        $this->resetFields();
        $this->resetValidation();

        if ($brandId) {
            $this->editMode = true;
            $this->brandId = $brandId;
            $this->loadBrand($brandId);
        } else {
            $this->editMode = false;
            $this->brandId = null;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetFields();
        $this->resetValidation();
    }

    public function openDeleteModal($brandId): void
    {
        $this->selectedBrand = Brand::findOrFail($brandId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->selectedBrand = null;
    }

    public function saveBrand(): void
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $brand = Brand::findOrFail($this->brandId);
                $brand->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'website' => $this->website,
                    'is_active' => $this->is_active,
                ]);

                $this->dispatch('brandUpdated', $brand->id);
                $message = 'Marca actualizada com sucesso!';
            } else {
                $brand = Brand::create([
                    'name' => $this->name,
                    'description' => $this->description,
                    'website' => $this->website,
                    'is_active' => $this->is_active,
                ]);

                $this->dispatch('brandCreated', $brand->id);
                $message = 'Marca criada com sucesso!';
            }

            // Handle logo upload
            if ($this->logo) {
                $logoPath = $this->logo->store('brands', 'public');
                $brand->update(['logo_url' => $logoPath]);
            }

            $this->closeModal();
            session()->flash('success', $message);

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao salvar marca: ' . $e->getMessage());
        }
    }

    public function confirmDelete(): void
    {
        try {
            if ($this->selectedBrand) {
                // Check if brand has products
                if ($this->selectedBrand->products()->count() > 0) {
                    session()->flash('error', 'Não é possível eliminar esta marca pois tem produtos associados.');
                    $this->closeDeleteModal();
                    return;
                }

                $this->selectedBrand->delete();
                $this->dispatch('brandDeleted', $this->selectedBrand->id);
                session()->flash('success', 'Marca eliminada com sucesso!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao eliminar marca: ' . $e->getMessage());
        }

        $this->closeDeleteModal();
    }

    public function toggleStatus($brandId): void
    {
        try {
            $brand = Brand::findOrFail($brandId);
            $brand->update(['is_active' => !$brand->is_active]);

            $this->dispatch('brandStatusToggled', $brandId);
            session()->flash('success', 'Status da marca alterado!');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }

    private function loadBrand($brandId): void
    {
        $brand = Brand::findOrFail($brandId);

        $this->name = $brand->name;
        $this->description = $brand->description ?? '';
        $this->website = $brand->website ?? '';
        $this->is_active = $brand->is_active;
    }

    private function resetFields(): void
    {
        $this->name = '';
        $this->description = '';
        $this->website = '';
        $this->is_active = true;
        $this->logo = null;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }
}
