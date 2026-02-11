<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pedidos</h1>
            <p class="text-gray-500">Gerencie os pedidos da loja</p>
        </div>
        <div class="flex items-center gap-3">
            <x-admin.ui.button href="{{ route('admin.orders.export-pdf') }}" variant="outline" icon="file-text">
                Exportar PDF
            </x-admin.ui.button>
            <x-admin.ui.button href="{{ route('admin.pos.index') }}" icon="plus">
                Nova Venda
            </x-admin.ui.button>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-gray-500">Pendentes</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i data-lucide="loader" class="w-5 h-5 text-purple-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['processing'] }}</p>
                    <p class="text-xs text-gray-500">Processando</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                    <p class="text-xs text-gray-500">Concluídos</p>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-4 text-white col-span-2 lg:col-span-1">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                    <i data-lucide="banknote" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="text-xl font-bold">{{ number_format($stats['todayTotal'], 0, ',', '.') }} Kz</p>
                    <p class="text-xs text-white/70">Vendas Hoje</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <x-admin.ui.card class="mb-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <x-admin.form.search 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Buscar por ID, cliente ou telefone..." />
            </div>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-3">
                <select wire:model.live="status" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos Status</option>
                    <option value="pending">Pendente</option>
                    <option value="processing">Processando</option>
                    <option value="shipped">Enviado</option>
                    <option value="completed">Concluído</option>
                    <option value="cancelled">Cancelado</option>
                </select>
                
                <input type="date" 
                       wire:model.live="dateFrom"
                       class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Data início">
                
                <input type="date" 
                       wire:model.live="dateTo"
                       class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Data fim">
                
                @if($search || $status || $dateFrom || $dateTo)
                    <button wire:click="clearFilters" 
                            class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                @endif
            </div>
        </div>
    </x-admin.ui.card>
    
    <!-- Orders Table -->
    <x-admin.ui.table>
        <x-slot:head>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pedido</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Cliente</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Itens</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Data</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
            </tr>
        </x-slot:head>
        
        @forelse($orders as $order)
            <tr class="hover:bg-gray-50 transition-colors cursor-pointer" wire:click="viewOrder({{ $order->id }})">
                <td class="px-4 py-4">
                    <span class="font-semibold text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td class="px-4 py-4">
                    <div>
                        <p class="font-medium text-gray-900">{{ $order->customer_name ?? 'Cliente' }}</p>
                        <p class="text-sm text-gray-500">{{ $order->customer_phone ?? '-' }}</p>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <span class="text-sm text-gray-600">{{ $order->items->count() }} {{ $order->items->count() === 1 ? 'item' : 'itens' }}</span>
                </td>
                <td class="px-4 py-4">
                    <span class="font-semibold text-gray-900">{{ number_format($order->total_amount, 2, ',', '.') }} Kz</span>
                </td>
                <td class="px-4 py-4" wire:click.stop>
                    @php
                        $statusColors = [
                            'pending' => 'warning',
                            'processing' => 'info',
                            'shipped' => 'info',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                        ];
                        $statusLabels = [
                            'pending' => 'Pendente',
                            'processing' => 'Processando',
                            'shipped' => 'Enviado',
                            'completed' => 'Concluído',
                            'cancelled' => 'Cancelado',
                        ];
                    @endphp
                    <x-admin.ui.dropdown align="left">
                        <x-slot:trigger>
                            <x-admin.ui.badge :variant="$statusColors[$order->status] ?? 'default'" size="md" :dot="true" class="cursor-pointer">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </x-admin.ui.badge>
                        </x-slot:trigger>
                        
                        <x-admin.ui.dropdown-item wire:click="updateStatus({{ $order->id }}, 'pending')" icon="clock">
                            Pendente
                        </x-admin.ui.dropdown-item>
                        <x-admin.ui.dropdown-item wire:click="updateStatus({{ $order->id }}, 'processing')" icon="loader">
                            Processando
                        </x-admin.ui.dropdown-item>
                        <x-admin.ui.dropdown-item wire:click="updateStatus({{ $order->id }}, 'shipped')" icon="truck">
                            Enviado
                        </x-admin.ui.dropdown-item>
                        <x-admin.ui.dropdown-item wire:click="updateStatus({{ $order->id }}, 'completed')" icon="check-circle">
                            Concluído
                        </x-admin.ui.dropdown-item>
                        <x-admin.ui.dropdown-item wire:click="updateStatus({{ $order->id }}, 'cancelled')" icon="x-circle" danger>
                            Cancelado
                        </x-admin.ui.dropdown-item>
                    </x-admin.ui.dropdown>
                </td>
                <td class="px-4 py-4">
                    <div>
                        <p class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</p>
                    </div>
                </td>
                <td class="px-4 py-4 text-right" wire:click.stop>
                    <x-admin.ui.dropdown>
                        <x-admin.ui.dropdown-item wire:click="viewOrder({{ $order->id }})" icon="eye">
                            Ver Detalhes
                        </x-admin.ui.dropdown-item>
                        <x-admin.ui.dropdown-item href="{{ route('admin.orders.view-proof', $order) }}" icon="file-image">
                            Ver Comprovante
                        </x-admin.ui.dropdown-item>
                    </x-admin.ui.dropdown>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-admin.ui.empty-state 
                        icon="shopping-bag" 
                        title="Nenhum pedido encontrado"
                        description="Não encontramos pedidos com os filtros aplicados." />
                </td>
            </tr>
        @endforelse
    </x-admin.ui.table>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    
    <!-- Order Details Drawer -->
    <x-admin.ui.drawer name="order-details" title="Detalhes do Pedido" maxWidth="lg">
        @if($selectedOrder)
            <div class="space-y-6">
                <!-- Order Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">#{{ str_pad($selectedOrder->id, 5, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-sm text-gray-500">{{ $selectedOrder->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <x-admin.ui.badge :variant="$statusColors[$selectedOrder->status] ?? 'default'" size="lg">
                        {{ $statusLabels[$selectedOrder->status] ?? $selectedOrder->status }}
                    </x-admin.ui.badge>
                </div>
                
                <!-- Customer Info -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Informações do Cliente</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Nome</p>
                            <p class="font-medium text-gray-900">{{ $selectedOrder->customer_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Telefone</p>
                            <p class="font-medium text-gray-900">{{ $selectedOrder->customer_phone ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500">Endereço</p>
                            <p class="font-medium text-gray-900">
                                @if($selectedOrder->shipping_address && is_array($selectedOrder->shipping_address))
                                    {{ implode(', ', array_filter($selectedOrder->shipping_address)) }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Itens do Pedido</h4>
                    <div class="space-y-3">
                        @foreach($selectedOrder->items as $item)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-12 h-12 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                    @if($item->product?->featured_image)
                                        <img src="{{ asset('storage/' . $item->product->featured_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i data-lucide="package" class="w-5 h-5 text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $item->product?->name ?? $item->product_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }}x {{ number_format($item->price, 2, ',', '.') }} Kz</p>
                                </div>
                                <p class="font-semibold text-gray-900">{{ number_format($item->quantity * $item->price, 2, ',', '.') }} Kz</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Order Total -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-2xl font-bold text-primary-600">{{ number_format($selectedOrder->total_amount, 2, ',', '.') }} Kz</span>
                    </div>
                </div>
            </div>
        @endif
        
        <x-slot:footer>
            <x-admin.ui.button variant="outline" @click="$dispatch('close-drawer', 'order-details')">
                Fechar
            </x-admin.ui.button>
            @if($selectedOrder)
                <x-admin.ui.button icon="printer">
                    Imprimir
                </x-admin.ui.button>
            @endif
        </x-slot:footer>
    </x-admin.ui.drawer>
</div>
