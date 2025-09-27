<!-- Product Request Response Modal -->
<div class="fixed inset-0 modal-overlay overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
    <div class="relative w-full max-w-4xl mx-auto modal-3d animate-fade-in-scale" wire:click.stop>
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-t-3xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-emerald-900">Responder Solicitação</h3>
                    <p class="text-sm text-emerald-600">Gerencie e responda à solicitação do cliente</p>
                </div>
            </div>
            <button wire:click="closeModal" class="p-2 rounded-xl hover:bg-white/50 text-gray-500 hover:text-gray-700 transition-all duration-200 group">
                <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                
                <!-- Left Column - Request Details -->
                <div class="space-y-6">
                    <!-- Client Information -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Informações do Cliente</h4>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-500">Nome:</span>
                                <span class="text-sm text-gray-900 font-semibold">{{ $selectedRequest->name ?? '' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-500">Email:</span>
                                <span class="text-sm text-gray-900">{{ $selectedRequest->email ?? '' }}</span>
                            </div>
                            @if($selectedRequest && $selectedRequest->phone)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-500">Telefone:</span>
                                    <span class="text-sm text-gray-900">{{ $selectedRequest->phone }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-500">Data:</span>
                                <span class="text-sm text-gray-900">{{ $selectedRequest->created_at->format('d/m/Y H:i') ?? '' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-3">
                                <span class="text-sm font-medium text-gray-500">Urgência:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $selectedRequest && $selectedRequest->urgency === 'high' ? 'bg-red-100 text-red-800' : 
                                       ($selectedRequest && $selectedRequest->urgency === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $selectedRequest ? ucfirst($selectedRequest->urgency) : '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Request Details -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Detalhes do Produto</h4>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Produto Solicitado:</label>
                                <p class="text-gray-900 font-semibold mt-1">{{ $selectedRequest->product_name ?? '' }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Descrição:</label>
                                <p class="text-gray-700 mt-1 text-sm leading-relaxed">{{ $selectedRequest->description ?? '' }}</p>
                            </div>

                            @if($selectedRequest && ($selectedRequest->brand || $selectedRequest->model))
                                <div class="grid grid-cols-2 gap-4">
                                    @if($selectedRequest->brand)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Marca:</label>
                                            <p class="text-gray-900 mt-1">{{ $selectedRequest->brand }}</p>
                                        </div>
                                    @endif
                                    @if($selectedRequest->model)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Modelo:</label>
                                            <p class="text-gray-900 mt-1">{{ $selectedRequest->model }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if($selectedRequest && ($selectedRequest->budget_min || $selectedRequest->budget_max))
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Orçamento:</label>
                                    <p class="text-gray-900 mt-1">
                                        @if($selectedRequest->budget_min && $selectedRequest->budget_max)
                                            {{ number_format($selectedRequest->budget_min, 0) }} - {{ number_format($selectedRequest->budget_max, 0) }} Kz
                                        @elseif($selectedRequest->budget_min)
                                            A partir de {{ number_format($selectedRequest->budget_min, 0) }} Kz
                                        @else
                                            Até {{ number_format($selectedRequest->budget_max, 0) }} Kz
                                        @endif
                                    </p>
                                </div>
                            @endif

                            <div>
                                <label class="text-sm font-medium text-gray-500">Condição Preferida:</label>
                                <p class="text-gray-900 mt-1">{{ $selectedRequest ? ucfirst($selectedRequest->condition_preference) : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Response Form -->
                <div class="space-y-6">
                    <form wire:submit.prevent="updateRequest">
                        <!-- Status Management -->
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900">Gestão da Solicitação</h4>
                            </div>

                            <!-- Status -->
                            <div class="mb-6">
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Status da Solicitação
                                </label>
                                <select wire:model="status" class="input-3d w-full px-4 py-3 text-gray-900">
                                    <option value="pending">Pendente</option>
                                    <option value="in_progress">Em Progresso</option>
                                    <option value="matched">Correspondida</option>
                                    <option value="closed">Fechada</option>
                                </select>
                            </div>

                            <!-- Matched Product -->
                            <div class="mb-6">
                                <label for="matched_product_id" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Produto Correspondente
                                </label>
                                <select wire:model="matched_product_id" class="input-3d w-full px-4 py-3 text-gray-900">
                                    <option value="">Selecionar produto...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - {{ number_format($product->price, 2) }} Kz</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Admin Notes -->
                            <div class="mb-6">
                                <label for="admin_notes" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Notas Administrativas
                                </label>
                                <textarea wire:model="admin_notes" rows="4"
                                          class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                          placeholder="Adicione notas sobre o progresso, alternativas encontradas, etc..."></textarea>
                            </div>
                        </div>

                        <!-- Current Status Display -->
                        @if($selectedRequest && $selectedRequest->admin_notes)
                            <div class="card-3d p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">Notas Anteriores</h4>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $selectedRequest->admin_notes }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <button type="button" wire:click="closeModal" 
                                    class="px-6 py-3 border border-gray-300 rounded-2xl text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                                Cancelar
                            </button>
                            
                            <button type="submit" 
                                    class="btn-3d px-8 py-3 text-white font-semibold rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Atualizar Solicitação
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
