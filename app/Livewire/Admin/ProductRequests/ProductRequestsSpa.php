<?php

declare(strict_types=1);

namespace App\Livewire\Admin\ProductRequests;

use App\Models\ProductRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.admin.layouts.app')]
#[Title('Solicitações de Produtos')]
class ProductRequestsSpa extends Component
{
    use WithPagination;
    
    #[Url]
    public string $search = '';
    
    #[Url]
    public string $status = '';
    
    public int $perPage = 15;
    
    // Drawer
    public bool $showDrawer = false;
    public ?ProductRequest $selectedRequest = null;
    public string $adminNotes = '';
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function viewRequest(int $id): void
    {
        $this->selectedRequest = ProductRequest::with('user')->find($id);
        $this->adminNotes = $this->selectedRequest?->admin_notes ?? '';
        $this->showDrawer = true;
    }
    
    public function updateStatus(string $newStatus): void
    {
        if ($this->selectedRequest) {
            $this->selectedRequest->update([
                'status' => $newStatus,
                'admin_notes' => $this->adminNotes,
                'responded_at' => now(),
            ]);
            
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Status atualizado!']);
            $this->selectedRequest->refresh();
        }
    }
    
    public function deleteRequest(int $id): void
    {
        ProductRequest::find($id)?->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Solicitação excluída!']);
        $this->showDrawer = false;
    }
    
    public function render()
    {
        $requests = ProductRequest::query()
            ->with('user')
            ->when($this->search, fn($q) => $q->where('product_name', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%"))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        $stats = [
            'total' => ProductRequest::count(),
            'pending' => ProductRequest::where('status', 'pending')->count(),
            'approved' => ProductRequest::where('status', 'approved')->count(),
            'rejected' => ProductRequest::where('status', 'rejected')->count(),
        ];
        
        return view('livewire.admin.product-requests.index-spa', [
            'requests' => $requests,
            'stats' => $stats,
        ]);
    }
}
