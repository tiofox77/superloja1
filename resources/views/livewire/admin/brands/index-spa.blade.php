<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Marcas</h1>
            <p class="text-gray-500">Gerencie as marcas dos produtos</p>
        </div>
        <x-admin.ui.button wire:click="openCreateModal" icon="tag">
            Nova Marca
        </x-admin.ui.button>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                <i data-lucide="tag" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBrands }}</p>
                <p class="text-sm text-gray-500">Total de Marcas</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $activeBrands }}</p>
                <p class="text-sm text-gray-500">Marcas Ativas</p>
            </div>
        </div>
    </div>
    
    <!-- Search -->
    <x-admin.ui.card class="mb-6">
        <x-admin.form.search 
            wire:model.live.debounce.300ms="search" 
            placeholder="Buscar marcas..." />
    </x-admin.ui.card>
    
    <!-- Brands Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @forelse($brands as $brand)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden card-hover group">
                <!-- Logo -->
                <div class="aspect-square relative bg-gray-50 flex items-center justify-center p-4">
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" 
                             alt="{{ $brand->name }}"
                             class="max-w-full max-h-full object-contain">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-secondary-100 to-secondary-50 flex items-center justify-center">
                            <span class="text-2xl font-bold text-secondary-400">{{ strtoupper(substr($brand->name, 0, 2)) }}</span>
                        </div>
                    @endif
                    
                    <!-- Status -->
                    <div class="absolute top-2 right-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $brand->is_active ? 'bg-green-500' : 'bg-red-500' }} block"></span>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <button wire:click="editBrand({{ $brand->id }})"
                                class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                        </button>
                        <button wire:click="deleteBrand({{ $brand->id }})"
                                wire:confirm="Tem certeza?"
                                class="p-2 bg-white rounded-lg text-gray-700 hover:text-red-600 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Info -->
                <div class="p-3 text-center border-t border-gray-100">
                    <h3 class="font-medium text-gray-900 text-sm truncate">{{ $brand->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $brand->products_count }} produtos</p>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <x-admin.ui.empty-state 
                    icon="tag" 
                    title="Nenhuma marca encontrada"
                    description="Crie sua primeira marca." />
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $brands->links() }}
    </div>
    
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9998] overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl" @click.stop>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $editingId ? 'Editar Marca' : 'Nova Marca' }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    
                    <form wire:submit="saveBrand" class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <x-admin.form.input 
                                wire:model.live="name"
                                label="Nome"
                                placeholder="Nome da marca"
                                :error="$errors->first('name')" />
                            
                            <x-admin.form.input 
                                wire:model="slug"
                                label="Slug"
                                placeholder="slug-da-marca"
                                :error="$errors->first('slug')" />
                        </div>
                        
                        <x-admin.form.textarea 
                            wire:model="description"
                            label="Descrição"
                            rows="2"
                            placeholder="Descrição da marca..." />
                        
                        <x-admin.form.input 
                            wire:model="website"
                            label="Website"
                            placeholder="https://www.marca.com"
                            :error="$errors->first('website')" />
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                            <input type="file" wire:model="logo" accept="image/*" class="text-sm">
                            @error('logo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <x-admin.form.toggle 
                            wire:model="is_active"
                            label="Marca Ativa" />
                        
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
