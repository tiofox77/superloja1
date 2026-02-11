<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Categorias</h1>
            <p class="text-gray-500">Organize os produtos por categorias</p>
        </div>
        <x-admin.ui.button wire:click="openCreateModal" icon="folder-plus">
            Nova Categoria
        </x-admin.ui.button>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <i data-lucide="folder" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalCategories }}</p>
                <p class="text-sm text-gray-500">Total de Categorias</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $activeCategories }}</p>
                <p class="text-sm text-gray-500">Categorias Ativas</p>
            </div>
        </div>
    </div>
    
    <!-- Search -->
    <x-admin.ui.card class="mb-6">
        <x-admin.form.search 
            wire:model.live.debounce.300ms="search" 
            placeholder="Buscar categorias..." />
    </x-admin.ui.card>
    
    <!-- Categories Hierarchical View -->
    @if($search)
        <!-- Search Results - Flat View -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($categories as $category)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden card-hover group">
                    <div class="aspect-video relative bg-gray-100">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-50">
                                <i data-lucide="{{ $category->parent_id ? 'folder-open' : 'folder' }}" class="w-12 h-12 text-primary-300"></i>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            <x-admin.ui.badge :variant="$category->is_active ? 'success' : 'danger'" size="sm">
                                {{ $category->is_active ? 'Ativa' : 'Inativa' }}
                            </x-admin.ui.badge>
                        </div>
                        
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <button wire:click="editCategory({{ $category->id }})"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                                <i data-lucide="edit-2" class="w-5 h-5"></i>
                            </button>
                            <button wire:click="toggleStatus({{ $category->id }})"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                                <i data-lucide="{{ $category->is_active ? 'eye-off' : 'eye' }}" class="w-5 h-5"></i>
                            </button>
                            <button wire:click="deleteCategory({{ $category->id }})"
                                    wire:confirm="Tem certeza que deseja excluir esta categoria?"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-red-600 transition-colors">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            @if($category->parent_id)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700">
                                    <i data-lucide="corner-down-right" class="w-3 h-3 mr-1"></i>
                                    Subcategoria
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                    <i data-lucide="folder" class="w-3 h-3 mr-1"></i>
                                    Categoria
                                </span>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
                        @if($category->parent)
                            <p class="text-xs text-gray-500 mt-1">{{ $category->parent->name }}</p>
                        @endif
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="text-gray-500">{{ $category->products_count }} produtos</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <x-admin.ui.empty-state 
                        icon="search" 
                        title="Nenhuma categoria encontrada"
                        description="Tente buscar com outros termos." />
                </div>
            @endforelse
        </div>
    @else
        <!-- Hierarchical View -->
        <div class="space-y-6">
            @forelse($rootCategories as $rootCategory)
                <!-- Root Category -->
                <div class="bg-white rounded-xl border-2 border-blue-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 border-b border-blue-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">
                                        <i data-lucide="folder" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $rootCategory->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $rootCategory->products_count }} produtos diretos</p>
                                    </div>
                                    <x-admin.ui.badge :variant="$rootCategory->is_active ? 'success' : 'danger'">
                                        {{ $rootCategory->is_active ? 'Ativa' : 'Inativa' }}
                                    </x-admin.ui.badge>
                                </div>
                                @if($rootCategory->description)
                                    <p class="text-sm text-gray-600 ml-13">{{ $rootCategory->description }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <button wire:click="editCategory({{ $rootCategory->id }})"
                                        class="p-2 rounded-lg bg-white hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition-colors">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </button>
                                <button wire:click="toggleStatus({{ $rootCategory->id }})"
                                        class="p-2 rounded-lg bg-white hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition-colors">
                                    <i data-lucide="{{ $rootCategory->is_active ? 'eye-off' : 'eye' }}" class="w-4 h-4"></i>
                                </button>
                                <button wire:click="deleteCategory({{ $rootCategory->id }})"
                                        wire:confirm="Tem certeza que deseja excluir esta categoria?"
                                        class="p-2 rounded-lg bg-white hover:bg-red-50 text-gray-700 hover:text-red-600 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Subcategories -->
                    @if($rootCategory->children->count() > 0)
                        <div class="p-4 bg-gray-50">
                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i data-lucide="corner-down-right" class="w-4 h-4"></i>
                                Subcategorias ({{ $rootCategory->children->count() }})
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($rootCategory->children as $subCategory)
                                    <div class="bg-white rounded-lg border border-indigo-200 p-3 hover:shadow-md transition-shadow group">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center gap-2 flex-1">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="folder-open" class="w-4 h-4 text-indigo-600"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h5 class="font-semibold text-gray-900 truncate">{{ $subCategory->name }}</h5>
                                                    <p class="text-xs text-gray-500">{{ $subCategory->products_count }} produtos</p>
                                                </div>
                                            </div>
                                            <x-admin.ui.badge :variant="$subCategory->is_active ? 'success' : 'danger'" size="sm">
                                                {{ $subCategory->is_active ? 'Ativa' : 'Inativa' }}
                                            </x-admin.ui.badge>
                                        </div>
                                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button wire:click="editCategory({{ $subCategory->id }})"
                                                    class="flex-1 px-2 py-1.5 text-xs rounded bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 transition-colors">
                                                <i data-lucide="edit-2" class="w-3 h-3 inline mr-1"></i>Editar
                                            </button>
                                            <button wire:click="toggleStatus({{ $subCategory->id }})"
                                                    class="px-2 py-1.5 text-xs rounded bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 transition-colors">
                                                <i data-lucide="{{ $subCategory->is_active ? 'eye-off' : 'eye' }}" class="w-3 h-3"></i>
                                            </button>
                                            <button wire:click="deleteCategory({{ $subCategory->id }})"
                                                    wire:confirm="Tem certeza que deseja excluir esta subcategoria?"
                                                    class="px-2 py-1.5 text-xs rounded bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-600 transition-colors">
                                                <i data-lucide="trash-2" class="w-3 h-3"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 text-center">
                            <p class="text-sm text-gray-500">Nenhuma subcategoria</p>
                        </div>
                    @endif
                </div>
            @empty
                <x-admin.ui.empty-state 
                    icon="folder" 
                    title="Nenhuma categoria encontrada"
                    description="Crie sua primeira categoria para organizar os produtos." />
            @endforelse
        </div>
    @endif
    
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9998] overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl" @click.stop>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $editingId ? 'Editar Categoria' : 'Nova Categoria' }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    
                    <form wire:submit="saveCategory" class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <x-admin.form.input 
                                wire:model.live="name"
                                label="Nome"
                                placeholder="Nome da categoria"
                                :error="$errors->first('name')" />
                            
                            <x-admin.form.input 
                                wire:model="slug"
                                label="Slug"
                                placeholder="slug-da-categoria"
                                :error="$errors->first('slug')" />
                        </div>
                        
                        <x-admin.form.textarea 
                            wire:model="description"
                            label="Descrição"
                            rows="2"
                            placeholder="Descrição da categoria..." />
                        
                        <div class="grid grid-cols-2 gap-4">
                            <x-admin.form.select 
                                wire:model="parent_id"
                                label="Categoria Pai"
                                placeholder="Nenhuma (raiz)">
                                <option value="">Nenhuma (raiz)</option>
                                @foreach($parentCategories as $parent)
                                    @if($parent->id !== $editingId)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endif
                                @endforeach
                            </x-admin.form.select>
                            
                            <x-admin.form.input 
                                wire:model="sort_order"
                                type="number"
                                label="Ordem"
                                min="0" />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagem</label>
                            <input type="file" wire:model="image" accept="image/*" class="text-sm">
                            @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <x-admin.form.toggle 
                            wire:model="is_active"
                            label="Categoria Ativa"
                            hint="Categorias inativas não aparecem na loja" />
                        
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
