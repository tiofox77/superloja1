<!-- Auction Form Modal -->
<div class="fixed inset-0 modal-overlay overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
    <div class="relative w-full max-w-5xl mx-auto modal-3d animate-fade-in-scale" wire:click.stop>
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r {{ $editMode ? 'from-blue-50 to-indigo-50' : 'from-orange-50 to-red-50' }} rounded-t-3xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $editMode ? 'from-blue-500 to-indigo-600' : 'from-orange-500 to-red-600' }} flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($editMode)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        @endif
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold {{ $editMode ? 'text-blue-900' : 'text-orange-900' }}">
                        {{ $editMode ? 'Editar Leilão' : 'Novo Leilão' }}
                    </h3>
                    <p class="text-sm {{ $editMode ? 'text-blue-600' : 'text-orange-600' }}">
                        {{ $editMode ? 'Atualize as informações do leilão' : 'Crie um novo leilão para a plataforma' }}
                    </p>
                </div>
            </div>
            <button wire:click="closeModal" class="p-2 rounded-xl hover:bg-white/50 text-gray-500 hover:text-gray-700 transition-all duration-200 group">
                <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form wire:submit.prevent="saveAuction" class="p-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Informações Básicas</h4>
                        </div>

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Produto *
                            </label>
                            <select wire:model="product_id" class="input-3d w-full px-4 py-3 text-gray-900" required>
                                <option value="">Selecionar produto...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->sku }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <span class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </span> @enderror
                        </div>


                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Título do Leilão *
                            </label>
                            <input type="text" wire:model="title" 
                                   class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                   placeholder="Digite o título do leilão..."
                                   required>
                            @error('title') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                Descrição *
                            </label>
                            <textarea wire:model="description" rows="4"
                                      class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                      placeholder="Descreva o leilão..."
                                      required></textarea>
                            @error('description') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Pricing Information -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Preços e Lances</h4>
                        </div>

                        <!-- Starting Price -->
                        <div class="mb-6">
                            <label for="starting_price" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2"></path>
                                </svg>
                                Preço Inicial (Kz) *
                            </label>
                            <input type="number" step="0.01" min="0.01" wire:model="starting_price" 
                                   class="input-3d w-full px-4 py-3 text-gray-900"
                                   placeholder="0.00" required>
                            @error('starting_price') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- Reserve Price -->
                        <div class="mb-6">
                            <label for="reserve_price" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Preço de Reserva (Kz)
                            </label>
                            <input type="number" step="0.01" min="0.01" wire:model="reserve_price" 
                                   class="input-3d w-full px-4 py-3 text-gray-900"
                                   placeholder="0.00 (opcional)">
                            @error('reserve_price') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- Buy Now Price -->
                        <div class="mb-6">
                            <label for="buy_now_price" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Comprar Agora (Kz)
                            </label>
                            <input type="number" step="0.01" min="0.01" wire:model="buy_now_price" 
                                   class="input-3d w-full px-4 py-3 text-gray-900"
                                   placeholder="0.00 (opcional)">
                            @error('buy_now_price') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Timing Information -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Período do Leilão</h4>
                        </div>

                        <!-- Start Time -->
                        <div class="mb-6">
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Data e Hora de Início *
                            </label>
                            <input type="datetime-local" wire:model="start_time" 
                                   class="input-3d w-full px-4 py-3 text-gray-900" required>
                            @error('start_time') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- End Time -->
                        <div class="mb-6">
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Data e Hora de Fim *
                            </label>
                            <input type="datetime-local" wire:model="end_time" 
                                   class="input-3d w-full px-4 py-3 text-gray-900" required>
                            @error('end_time') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status and Featured -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-3">Status</label>
                                <select wire:model="status" class="input-3d w-full px-4 py-3 text-gray-900">
                                    <option value="draft">Rascunho</option>
                                    <option value="active">Ativo</option>
                                    <option value="ended">Terminado</option>
                                    <option value="cancelled">Cancelado</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" wire:model="featured" 
                                           class="checkbox-modern"
                                           style="--checkbox-color: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); --checkbox-border: #d97706;">
                                    <span class="text-sm font-semibold text-gray-700">Destacar leilão</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 mt-8">
                <button type="button" wire:click="closeModal" 
                        class="px-6 py-3 border border-gray-300 rounded-2xl text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                    Cancelar
                </button>
                
                <button type="submit" 
                        class="btn-3d px-8 py-3 text-white font-semibold rounded-2xl {{ $editMode ? 'bg-gradient-to-r from-blue-500 to-indigo-600' : 'bg-gradient-to-r from-orange-500 to-red-600' }}">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($editMode)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        @endif
                    </svg>
                    {{ $editMode ? 'Atualizar Leilão' : 'Criar Leilão' }}
                </button>
            </div>
        </form>
    </div>
</div>
