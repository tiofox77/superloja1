<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.admin.layouts.app')]
#[Title('Pedidos')]
class OrdersSpa extends Component
{
    use WithPagination;
    
    #[Url]
    public string $search = '';
    
    #[Url]
    public string $status = '';
    
    #[Url]
    public string $dateFrom = '';
    
    #[Url]
    public string $dateTo = '';
    
    public int $perPage = 15;
    public ?int $selectedOrderId = null;
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    
    public function viewOrder(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
        $this->dispatch('open-drawer', name: 'order-details');
    }
    
    public function updateStatus(int $orderId, string $newStatus): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => $newStatus]);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Status do pedido atualizado!',
            ]);
        }
    }
    
    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }
    
    public function render()
    {
        $orders = Order::query()
            ->with(['items'])
            ->when($this->search, fn($q) => $q->where(function($query) {
                $query->where('id', 'like', "%{$this->search}%")
                      ->orWhere('customer_name', 'like', "%{$this->search}%")
                      ->orWhere('customer_phone', 'like', "%{$this->search}%");
            }))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        $selectedOrder = $this->selectedOrderId ? Order::with('items.product')->find($this->selectedOrderId) : null;
        
        // Stats
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::whereIn('status', ['completed', 'delivered'])->count(),
            'todayTotal' => Order::whereDate('created_at', today())->sum('total_amount'),
        ];
        
        return view('livewire.admin.orders.index-spa', [
            'orders' => $orders,
            'selectedOrder' => $selectedOrder,
            'stats' => $stats,
        ]);
    }
}
