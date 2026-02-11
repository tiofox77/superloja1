<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Leilões</h1>
            <p class="text-gray-500">Gerencie os leilões de produtos</p>
        </div>
        <x-admin.ui.button wire:click="openCreateModal" icon="gavel">
            Novo Leilão
        </x-admin.ui.button>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                <i data-lucide="gavel" class="w-5 h-5 text-blue-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500">Total</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                <i data-lucide="activity" class="w-5 h-5 text-green-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                <p class="text-xs text-gray-500">Ativos</p>
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
            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-gray-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['ended'] }}</p>
                <p class="text-xs text-gray-500">Encerrados</p>
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
                <option value="active">Ativo</option>
                <option value="ended">Encerrado</option>
                <option value="cancelled">Cancelado</option>
            </select>
        </div>
    </x-admin.ui.card>
    
    <!-- Auctions Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($auctions as $auction)
            @php
                $statusColors = [
                    'pending' => 'warning',
                    'active' => 'success',
                    'ended' => 'default',
                    'cancelled' => 'danger',
                ];
                $statusLabels = [
                    'pending' => 'Pendente',
                    'active' => 'Ativo',
                    'ended' => 'Encerrado',
                    'cancelled' => 'Cancelado',
                ];
            @endphp
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden card-hover group">
                <!-- Image -->
                <div class="aspect-video relative bg-gray-100">
                    @if($auction->product?->featured_image)
                        <img src="{{ asset('storage/' . $auction->product->featured_image) }}" 
                             alt="{{ $auction->product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i data-lucide="package" class="w-12 h-12 text-gray-300"></i>
                        </div>
                    @endif
                    
                    <div class="absolute top-3 right-3">
                        <x-admin.ui.badge :variant="$statusColors[$auction->status] ?? 'default'" size="sm">
                            {{ $statusLabels[$auction->status] ?? $auction->status }}
                        </x-admin.ui.badge>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <button wire:click="editAuction({{ $auction->id }})"
                                class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                            <i data-lucide="edit-2" class="w-5 h-5"></i>
                        </button>
                        <button wire:click="deleteAuction({{ $auction->id }})"
                                wire:confirm="Excluir este leilão?"
                                class="p-2 bg-white rounded-lg text-gray-700 hover:text-red-600 transition-colors">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Info -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 truncate">{{ $auction->product?->name ?? 'Produto removido' }}</h3>
                    
                    <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <p class="text-gray-500">Lance Atual</p>
                            <p class="font-bold text-primary-600">{{ number_format($auction->current_price ?? $auction->starting_price, 2, ',', '.') }} Kz</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Lances</p>
                            <p class="font-semibold text-gray-900">{{ $auction->bids_count }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            {{ $auction->starts_at?->format('d/m H:i') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            {{ $auction->ends_at?->format('d/m H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <x-admin.ui.empty-state 
                    icon="gavel" 
                    title="Nenhum leilão encontrado"
                    description="Crie seu primeiro leilão." />
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $auctions->links() }}
    </div>
    
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9998] overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl" @click.stop>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $editingId ? 'Editar Leilão' : 'Novo Leilão' }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    
                    <form wire:submit="saveAuction" class="p-6 space-y-4">
                        <x-admin.form.select wire:model="product_id" label="Produto" :error="$errors->first('product_id')">
                            <option value="">Selecione um produto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </x-admin.form.select>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <x-admin.form.input 
                                wire:model="starting_price"
                                type="number"
                                step="0.01"
                                label="Preço Inicial (Kz)"
                                :error="$errors->first('starting_price')" />
                            
                            <x-admin.form.input 
                                wire:model="reserve_price"
                                type="number"
                                step="0.01"
                                label="Preço Reserva (Kz)"
                                hint="Opcional" />
                        </div>
                        
                        <x-admin.form.input 
                            wire:model="bid_increment"
                            type="number"
                            step="0.01"
                            label="Incremento Mínimo (Kz)"
                            :error="$errors->first('bid_increment')" />
                        
                        <div class="grid grid-cols-2 gap-4">
                            <x-admin.form.input 
                                wire:model="starts_at"
                                type="datetime-local"
                                label="Início"
                                :error="$errors->first('starts_at')" />
                            
                            <x-admin.form.input 
                                wire:model="ends_at"
                                type="datetime-local"
                                label="Término"
                                :error="$errors->first('ends_at')" />
                        </div>
                        
                        <x-admin.form.select wire:model="auctionStatus" label="Status">
                            <option value="pending">Pendente</option>
                            <option value="active">Ativo</option>
                            <option value="ended">Encerrado</option>
                            <option value="cancelled">Cancelado</option>
                        </x-admin.form.select>
                        
                        <div class="flex justify-end gap-3 pt-4">
                            <x-admin.ui.button type="button" variant="outline" wire:click="$set('showModal', false)">
                                Cancelar
                            </x-admin.ui.button>
                            <x-admin.ui.button type="submit" icon="save">
                                {{ $editingId ? 'Atualizar' : 'Criar' }}
                            </x-admin.ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
