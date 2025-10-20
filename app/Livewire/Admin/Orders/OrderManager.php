<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Models\User;
use App\Services\SmsService;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManager extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $filterStatus = '';
    public $filterPaymentStatus = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Selection
    public $selectedOrders = [];
    public $selectAll = false;

    // Modals
    public $showViewModal = false;
    public $showPrintModal = false;
    public $selectedOrder = null;

    protected $queryString = [
        'search', 
        'filterStatus', 
        'filterPaymentStatus', 
        'filterDateFrom', 
        'filterDateTo', 
        'sortBy', 
        'sortDirection'
    ];

    public function mount(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedFilterPaymentStatus(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedFilterDateFrom(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedFilterDateTo(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function updatedSelectedOrders(): void
    {
        // Verificar se todos os pedidos da página atual estão selecionados
        $currentPageOrderIds = $this->getOrders()->paginate(15)->pluck('id')->toArray();
        
        if (empty($this->selectedOrders)) {
            $this->selectAll = false;
        } else {
            $selectedInCurrentPage = array_intersect($currentPageOrderIds, $this->selectedOrders);
            $this->selectAll = count($selectedInCurrentPage) === count($currentPageOrderIds);
        }
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectAllOrders();
        } else {
            $this->deselectAllOrders();
        }
    }

    public function selectAllOrders(): void
    {
        $currentPageOrderIds = $this->getOrders()->paginate(15)->pluck('id')->toArray();
        $this->selectedOrders = array_unique(array_merge($this->selectedOrders, $currentPageOrderIds));
    }

    public function deselectAllOrders(): void
    {
        $currentPageOrderIds = $this->getOrders()->paginate(15)->pluck('id')->toArray();
        $this->selectedOrders = array_diff($this->selectedOrders, $currentPageOrderIds);
    }

    public function updateSelectAllState(): void
    {
        $currentPageOrderIds = $this->getOrders()->paginate(15)->pluck('id')->toArray();
        
        if (empty($currentPageOrderIds)) {
            $this->selectAll = false;
        } else {
            $selectedInCurrentPage = array_intersect($currentPageOrderIds, $this->selectedOrders);
            $this->selectAll = count($selectedInCurrentPage) === count($currentPageOrderIds);
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'filterStatus', 'filterPaymentStatus', 'filterDateFrom', 'filterDateTo']);
        $this->resetPage();
        $this->updateSelectAllState();
    }

    public function bulkAction($action): void
    {
        if (empty($this->selectedOrders)) {
            $this->dispatch('showAlert', [
                'type' => 'warning',
                'message' => 'Selecione pelo menos um pedido para executar a ação.'
            ]);
            return;
        }

        try {
            $count = 0;
            switch ($action) {
                case 'mark_processing':
                    $count = Order::whereIn('id', $this->selectedOrders)->update(['status' => 'processing']);
                    $message = "{$count} pedido(s) marcado(s) como em processamento!";
                    break;
                    
                case 'mark_shipped':
                    $count = Order::whereIn('id', $this->selectedOrders)->update([
                        'status' => 'shipped',
                        'shipped_at' => now()
                    ]);
                    $message = "{$count} pedido(s) marcado(s) como enviado(s)!";
                    break;
                    
                case 'mark_delivered':
                    $count = Order::whereIn('id', $this->selectedOrders)->update([
                        'status' => 'delivered',
                        'delivered_at' => now()
                    ]);
                    $message = "{$count} pedido(s) marcado(s) como entregue(s)!";
                    break;
                    
                case 'cancel':
                    $count = Order::whereIn('id', $this->selectedOrders)->update(['status' => 'cancelled']);
                    $message = "{$count} pedido(s) cancelado(s)!";
                    break;
                    
                default:
                    throw new \Exception('Ação não reconhecida.');
            }

            $this->selectedOrders = [];
            $this->selectAll = false;
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro na ação em lote de pedidos: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao executar a ação: ' . $e->getMessage()
            ]);
        }
    }

    public function exportOrders(): void
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'payment_status' => $this->filterPaymentStatus,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo
        ];
        
        if (!empty($this->selectedOrders)) {
            $filters['selected_ids'] = implode(',', $this->selectedOrders);
        }
        
        $url = route('admin.orders.export-pdf') . '?' . http_build_query($filters);
        
        $this->dispatch('openUrl', ['url' => $url]);
        
        $message = !empty($this->selectedOrders) 
            ? 'Gerando PDF com ' . count($this->selectedOrders) . ' pedido(s) selecionado(s)...'
            : 'Gerando PDF com todos os pedidos filtrados...';
            
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    public function exportOrdersExcel(): void
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'payment_status' => $this->filterPaymentStatus,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo
        ];
        
        if (!empty($this->selectedOrders)) {
            $filters['selected_ids'] = implode(',', $this->selectedOrders);
        }
        
        $url = route('admin.orders.export-csv') . '?' . http_build_query($filters);
        
        $this->dispatch('openUrl', ['url' => $url]);
        
        $message = !empty($this->selectedOrders) 
            ? 'Gerando CSV com ' . count($this->selectedOrders) . ' pedido(s) selecionado(s)...'
            : 'Gerando CSV com todos os pedidos filtrados...';
            
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    public function viewOrder($orderId): void
    {
        $this->selectedOrder = Order::with(['user', 'items.product'])->find($orderId);
        
        if (!$this->selectedOrder) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Pedido não encontrado!'
            ]);
            return;
        }

        $this->showViewModal = true;
    }

    public function closeViewModal(): void
    {
        $this->showViewModal = false;
        $this->selectedOrder = null;
    }

    public function printOrder($orderId): void
    {
        $this->selectedOrder = Order::with(['user', 'items.product'])->find($orderId);
        
        if (!$this->selectedOrder) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Pedido não encontrado!'
            ]);
            return;
        }

        $this->showPrintModal = true;
    }

    public function closePrintModal(): void
    {
        $this->showPrintModal = false;
        $this->selectedOrder = null;
    }

    public function updateOrderStatus($orderId, $status): void
    {
        $order = Order::find($orderId);
        
        if (!$order) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Pedido não encontrado!'
            ]);
            return;
        }

        $statusTranslations = [
            'pending' => 'pendente',
            'processing' => 'em processamento',
            'shipped' => 'enviado',
            'delivered' => 'entregue',
            'cancelled' => 'cancelado'
        ];

        // Armazenar status anterior para comparação
        $previousStatus = $order->status;
        
        $order->update(['status' => $status]);

        if ($status === 'shipped') {
            $order->update(['shipped_at' => now()]);
        } elseif ($status === 'delivered') {
            $order->update(['delivered_at' => now()]);
        }

        // Enviar SMS se o status mudou
        if ($previousStatus !== $status) {
            $this->sendOrderStatusSms($order, $status);
        }

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => "Pedido #{$order->order_number} atualizado para: " . ($statusTranslations[$status] ?? $status)
        ]);
    }

    private function sendOrderStatusSms($order, $status)
    {
        try {
            $smsService = new SmsService();
            
            switch ($status) {
                case 'processing':
                    $smsService->sendOrderConfirmedNotification($order);
                    break;
                case 'shipped':
                    $smsService->sendOrderShippedNotification($order);
                    break;
                case 'delivered':
                    $smsService->sendOrderDeliveredNotification($order);
                    break;
                case 'cancelled':
                    $smsService->sendOrderCancelledNotification($order);
                    break;
            }
        } catch (\Exception $e) {
            // Log do erro mas não interromper o fluxo
            \Log::error('Erro ao enviar SMS de status do pedido: ' . $e->getMessage());
        }
    }

    public function updatePaymentStatus($orderId, $paymentStatus): void
    {
        $order = Order::find($orderId);
        
        if (!$order) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Pedido não encontrado!'
            ]);
            return;
        }

        $paymentTranslations = [
            'pending' => 'pendente',
            'paid' => 'pago',
            'failed' => 'falhou',
            'refunded' => 'reembolsado'
        ];

        $order->update(['payment_status' => $paymentStatus]);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => "Status de pagamento do pedido #{$order->order_number} atualizado para: " . ($paymentTranslations[$paymentStatus] ?? $paymentStatus)
        ]);
    }

    public function downloadPaymentProof($orderId): void
    {
        $order = Order::find($orderId);
        
        if (!$order || !$order->payment_proof) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Comprovativo não encontrado!'
            ]);
            return;
        }

        if (!Storage::disk('public')->exists($order->payment_proof)) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Arquivo do comprovativo não existe!'
            ]);
            return;
        }

        // Dispatch para abrir URL de download
        $downloadUrl = route('admin.orders.download-proof', $order->id);
        $this->dispatch('openUrl', ['url' => $downloadUrl]);
        
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Download do comprovativo iniciado!'
        ]);
    }

    public function getOrders()
    {
        return Order::query()
            ->with('user')
            ->when($this->search, fn($query) => $query->where(function($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%')
                               ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            }))
            ->when($this->filterStatus, fn($query) => $query->where('status', $this->filterStatus))
            ->when($this->filterPaymentStatus, fn($query) => $query->where('payment_status', $this->filterPaymentStatus))
            ->when($this->filterDateFrom, fn($query) => $query->whereDate('created_at', '>=', $this->filterDateFrom))
            ->when($this->filterDateTo, fn($query) => $query->whereDate('created_at', '<=', $this->filterDateTo))
            ->orderBy($this->sortBy, $this->sortDirection);
    }

    public function render()
    {
        $orders = $this->getOrders()->paginate(15);

        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'paid' => Order::where('payment_status', 'paid')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];

        // Atualizar estado do checkbox "selecionar todos" após renderizar
        $this->updateSelectAllState();

        return view('livewire.admin.orders.order-manager', [
            'orders' => $orders,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerir Pedidos',
            'pageTitle' => 'Pedidos'
        ]);
    }
}
