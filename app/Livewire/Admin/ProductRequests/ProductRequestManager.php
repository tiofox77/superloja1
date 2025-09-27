<?php

declare(strict_types=1);

namespace App\Livewire\Admin\ProductRequests;

use App\Models\ProductRequest;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductRequestManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $selectedRequest = null;

    // Form fields for response
    public $admin_notes = '';
    public $matched_product_id = '';
    public $status = '';

    // Filters
    public $search = '';
    public $filterStatus = '';
    public $filterUrgency = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function render()
    {
        $requests = ProductRequest::query()
            ->with(['user', 'matchedProduct'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('product_name', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterUrgency, function($query) {
                $query->where('urgency', $this->filterUrgency);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $products = Product::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'total' => ProductRequest::count(),
            'pending' => ProductRequest::where('status', 'pending')->count(),
            'in_progress' => ProductRequest::where('status', 'in_progress')->count(),
            'matched' => ProductRequest::where('status', 'matched')->count(),
            'urgent' => ProductRequest::where('urgency', 'high')->count(),
        ];

        return view('livewire.admin.product-requests.product-request-manager', [
            'requests' => $requests,
            'products' => $products,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Solicitações de Produtos',
            'pageTitle' => 'Solicitações'
        ]);
    }

    public function openModal($requestId): void
    {
        $this->selectedRequest = ProductRequest::with(['user', 'matchedProduct'])->findOrFail($requestId);
        $this->admin_notes = $this->selectedRequest->admin_notes ?? '';
        $this->matched_product_id = $this->selectedRequest->matched_product_id ?? '';
        $this->status = $this->selectedRequest->status;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedRequest = null;
        $this->resetFields();
    }

    public function updateRequest(): void
    {
        $this->validate([
            'status' => 'required|in:pending,in_progress,matched,closed',
            'admin_notes' => 'nullable|string',
            'matched_product_id' => 'nullable|exists:products,id',
        ]);

        $this->selectedRequest->update([
            'status' => $this->status,
            'admin_notes' => $this->admin_notes,
            'matched_product_id' => $this->matched_product_id,
        ]);

        $this->dispatch('success', 'Solicitação atualizada com sucesso!');
        $this->closeModal();
    }

    public function deleteRequest($requestId): void
    {
        $request = ProductRequest::findOrFail($requestId);
        $request->delete();
        $this->dispatch('success', 'Solicitação eliminada com sucesso!');
    }

    public function markAsUrgent($requestId): void
    {
        $request = ProductRequest::findOrFail($requestId);
        $request->update(['urgency' => 'high']);
        $this->dispatch('success', 'Solicitação marcada como urgente!');
    }

    public function updateStatus($requestId, $newStatus): void
    {
        $request = ProductRequest::findOrFail($requestId);
        $request->update(['status' => $newStatus]);
        
        $statusLabels = [
            'pending' => 'Pendente',
            'in_progress' => 'Em Progresso',
            'matched' => 'Correspondida',
            'closed' => 'Fechada'
        ];

        $this->dispatch('success', "Status alterado para: {$statusLabels[$newStatus]}");
    }

    private function resetFields(): void
    {
        $this->admin_notes = '';
        $this->matched_product_id = '';
        $this->status = '';
    }
}
