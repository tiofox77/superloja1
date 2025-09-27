<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Solicitações de Produtos</h1>
                    <p class="text-emerald-100 mt-1">Gerencie pedidos de produtos dos clientes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>

        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pendentes</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['pending']) }}</p>
        </div>

        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Em Progresso</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['in_progress']) }}</p>
        </div>

        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Correspondidas</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['matched']) }}</p>
        </div>

        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.865-.833-2.632 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Urgentes</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['urgent']) }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-3d p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pesquisar</label>
                <input type="text" wire:model.live="search" placeholder="Produto, nome, email..." 
                       class="input-3d w-full px-4 py-2 text-gray-900">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="filterStatus" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="">Todos os status</option>
                    <option value="pending">Pendente</option>
                    <option value="in_progress">Em Progresso</option>
                    <option value="matched">Correspondida</option>
                    <option value="closed">Fechada</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urgência</label>
                <select wire:model.live="filterUrgency" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="">Todas</option>
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                <select wire:model.live="sortBy" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="created_at">Data</option>
                    <option value="urgency">Urgência</option>
                    <option value="status">Status</option>
                    <option value="product_name">Produto</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Direção</label>
                <select wire:model.live="sortDirection" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="desc">Decrescente</option>
                    <option value="asc">Crescente</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="card-3d overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto Solicitado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orçamento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urgência</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center">
                                            <span class="text-white font-semibold text-sm">
                                                {{ strtoupper(substr($request->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $request->email }}</div>
                                        @if($request->phone)
                                            <div class="text-xs text-gray-400">{{ $request->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $request->product_name }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($request->description, 50) }}</div>
                                @if($request->brand)
                                    <div class="text-xs text-gray-400">Marca: {{ $request->brand }}</div>
                                @endif
                                @if($request->model)
                                    <div class="text-xs text-gray-400">Modelo: {{ $request->model }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($request->budget_min || $request->budget_max)
                                    <div class="text-sm text-gray-900">
                                        @if($request->budget_min && $request->budget_max)
                                            {{ number_format($request->budget_min, 0) }} - {{ number_format($request->budget_max, 0) }} Kz
                                        @elseif($request->budget_min)
                                            A partir de {{ number_format($request->budget_min, 0) }} Kz
                                        @else
                                            Até {{ number_format($request->budget_max, 0) }} Kz
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">Sem orçamento</span>
                                @endif
                                <div class="text-xs text-gray-500">{{ ucfirst($request->condition_preference) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $request->urgency === 'high' ? 'bg-red-100 text-red-800' : 
                                       ($request->urgency === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    @if($request->urgency === 'high')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    {{ ucfirst($request->urgency) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $request->status === 'matched' ? 'bg-green-100 text-green-800' : 
                                       ($request->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                        ($request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ match($request->status) {
                                        'pending' => 'Pendente',
                                        'in_progress' => 'Em Progresso',
                                        'matched' => 'Correspondida',
                                        'closed' => 'Fechada',
                                        default => ucfirst($request->status)
                                    } }}
                                </span>
                                @if($request->matchedProduct)
                                    <div class="text-xs text-green-600 mt-1">
                                        Produto: {{ $request->matchedProduct->name }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $request->created_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $request->created_at->format('H:i') }}</div>
                                @if($request->expires_at)
                                    <div class="text-xs text-orange-600">Expira: {{ $request->expires_at->format('d/m') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($request->urgency !== 'high')
                                        <button wire:click="markAsUrgent({{ $request->id }})" 
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                title="Marcar como urgente">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.865-.833-2.632 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    
                                    <button wire:click="openModal({{ $request->id }})" 
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="deleteRequest({{ $request->id }})" 
                                            onclick="return confirm('Tem certeza que deseja eliminar esta solicitação?')"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma solicitação encontrada</h3>
                                <p class="mt-1 text-sm text-gray-500">As solicitações dos clientes aparecerão aqui.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
    </div>

    <!-- Include Modal -->
    @if($showModal)
        @include('livewire.admin.product-requests.modals.request-response-modal')
    @endif
</div>
