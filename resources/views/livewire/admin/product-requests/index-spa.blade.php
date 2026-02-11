<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Solicitações de Produtos</h1>
            <p class="text-gray-500">Produtos solicitados pelos clientes</p>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                <i data-lucide="inbox" class="w-5 h-5 text-blue-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500">Total</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                <p class="text-xs text-gray-500">Pendentes</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
                <p class="text-xs text-gray-500">Aprovadas</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                <p class="text-xs text-gray-500">Rejeitadas</p>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <x-admin.ui.card class="mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <x-admin.form.search wire:model.live.debounce.300ms="search" placeholder="Buscar por produto..." />
            </div>
            <select wire:model.live="status" class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                <option value="">Todos os Status</option>
                <option value="pending">Pendente</option>
                <option value="approved">Aprovada</option>
                <option value="rejected">Rejeitada</option>
            </select>
        </div>
    </x-admin.ui.card>
    
    <!-- Requests Table -->
    <x-admin.ui.table>
        <x-slot:head>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produto</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Cliente</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Data</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
            </tr>
        </x-slot:head>
        
        @forelse($requests as $request)
            @php
                $statusColors = [
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                ];
                $statusLabels = [
                    'pending' => 'Pendente',
                    'approved' => 'Aprovada',
                    'rejected' => 'Rejeitada',
                ];
            @endphp
            <tr class="hover:bg-gray-50 transition-colors cursor-pointer" wire:click="viewRequest({{ $request->id }})">
                <td class="px-4 py-4">
                    <div>
                        <p class="font-medium text-gray-900">{{ $request->product_name }}</p>
                        <p class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($request->description, 50) }}</p>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-3">
                        <x-admin.ui.avatar :alt="$request->user?->name ?? 'Anônimo'" size="sm" />
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $request->user?->name ?? 'Anônimo' }}</p>
                            <p class="text-xs text-gray-500">{{ $request->user?->email ?? $request->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4">
                    <x-admin.ui.badge :variant="$statusColors[$request->status] ?? 'default'" size="sm">
                        {{ $statusLabels[$request->status] ?? $request->status }}
                    </x-admin.ui.badge>
                </td>
                <td class="px-4 py-4 text-sm text-gray-600">
                    {{ $request->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="px-4 py-4 text-right" @click.stop>
                    <x-admin.ui.dropdown>
                        <x-admin.ui.dropdown-item wire:click="viewRequest({{ $request->id }})" icon="eye">
                            Ver Detalhes
                        </x-admin.ui.dropdown-item>
                        <x-admin.ui.dropdown-item wire:click="deleteRequest({{ $request->id }})" wire:confirm="Excluir?" icon="trash-2" danger>
                            Excluir
                        </x-admin.ui.dropdown-item>
                    </x-admin.ui.dropdown>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <x-admin.ui.empty-state 
                        icon="inbox" 
                        title="Nenhuma solicitação encontrada"
                        description="As solicitações de produtos aparecerão aqui." />
                </td>
            </tr>
        @endforelse
    </x-admin.ui.table>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $requests->links() }}
    </div>
    
    <!-- Drawer -->
    @if($showDrawer && $selectedRequest)
        <div class="fixed inset-0 z-[9998] overflow-hidden">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showDrawer', false)"></div>
            
            <div class="fixed inset-y-0 right-0 w-full max-w-lg bg-white shadow-2xl flex flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Detalhes da Solicitação</h3>
                        <p class="text-sm text-gray-500">#{{ $selectedRequest->id }}</p>
                    </div>
                    <button wire:click="$set('showDrawer', false)" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6 space-y-6">
                    <!-- Status -->
                    <div class="flex items-center justify-between">
                        @php
                            $statusColors = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'];
                            $statusLabels = ['pending' => 'Pendente', 'approved' => 'Aprovada', 'rejected' => 'Rejeitada'];
                        @endphp
                        <x-admin.ui.badge :variant="$statusColors[$selectedRequest->status] ?? 'default'" size="lg">
                            {{ $statusLabels[$selectedRequest->status] ?? $selectedRequest->status }}
                        </x-admin.ui.badge>
                        <span class="text-sm text-gray-500">{{ $selectedRequest->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Produto Solicitado</h4>
                        <p class="text-lg font-bold text-gray-900">{{ $selectedRequest->product_name }}</p>
                        @if($selectedRequest->description)
                            <p class="text-sm text-gray-600 mt-2">{{ $selectedRequest->description }}</p>
                        @endif
                        @if($selectedRequest->reference_url)
                            <a href="{{ $selectedRequest->reference_url }}" target="_blank" 
                               class="inline-flex items-center gap-1 text-sm text-primary-600 hover:text-primary-700 mt-2">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                                Ver Referência
                            </a>
                        @endif
                    </div>
                    
                    <!-- Customer Info -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Cliente</h4>
                        <div class="flex items-center gap-3">
                            <x-admin.ui.avatar :alt="$selectedRequest->user?->name ?? 'Anônimo'" size="md" />
                            <div>
                                <p class="font-medium text-gray-900">{{ $selectedRequest->user?->name ?? 'Anônimo' }}</p>
                                <p class="text-sm text-gray-500">{{ $selectedRequest->user?->email ?? $selectedRequest->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Admin Notes -->
                    <div>
                        <x-admin.form.textarea 
                            wire:model="adminNotes"
                            label="Notas do Admin"
                            rows="3"
                            placeholder="Adicione observações..." />
                    </div>
                    
                    <!-- Actions -->
                    @if($selectedRequest->status === 'pending')
                        <div class="flex gap-3">
                            <x-admin.ui.button wire:click="updateStatus('approved')" variant="success" icon="check" class="flex-1">
                                Aprovar
                            </x-admin.ui.button>
                            <x-admin.ui.button wire:click="updateStatus('rejected')" variant="danger" icon="x" class="flex-1">
                                Rejeitar
                            </x-admin.ui.button>
                        </div>
                    @endif
                </div>
                
                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-100">
                    <x-admin.ui.button variant="outline" wire:click="$set('showDrawer', false)" class="w-full">
                        Fechar
                    </x-admin.ui.button>
                </div>
            </div>
        </div>
    @endif
</div>
