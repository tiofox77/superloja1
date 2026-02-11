<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Produtos</h1>
            <p class="text-gray-500">Gerencie o catálogo de produtos da loja</p>
        </div>
        <div class="flex items-center gap-3">
            <x-admin.ui.button href="{{ route('admin.products.import') }}" variant="outline" icon="upload">
                Importar
            </x-admin.ui.button>
            <x-admin.ui.button wire:click="openCreateModal" icon="plus-circle">
                Novo Produto
            </x-admin.ui.button>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
                <p class="text-sm text-gray-500">Total de Produtos</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($activeProducts) }}</p>
                <p class="text-sm text-gray-500">Produtos Ativos</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($lowStockProducts) }}</p>
                <p class="text-sm text-gray-500">Estoque Baixo</p>
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
                    placeholder="Buscar produtos..." />
            </div>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-3">
                <select wire:model.live="category" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todas Categorias</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="brand" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todas Marcas</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="status" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos Status</option>
                    <option value="active">Ativos</option>
                    <option value="inactive">Inativos</option>
                </select>
                
                @if($search || $category || $brand || $status)
                    <button wire:click="clearFilters" 
                            class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                @endif
            </div>
            
            <!-- View Toggle -->
            <div class="flex items-center gap-1 bg-gray-100 rounded-xl p-1">
                <button wire:click="$set('viewMode', 'grid')" 
                        class="p-2 rounded-lg transition-colors {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-primary-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                </button>
                <button wire:click="$set('viewMode', 'list')" 
                        class="p-2 rounded-lg transition-colors {{ $viewMode === 'list' ? 'bg-white shadow-sm text-primary-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i data-lucide="list" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <!-- Bulk Actions -->
        @if(count($selected) > 0)
            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ count($selected) }} selecionados</span>
                <button wire:click="deleteSelected" 
                        wire:confirm="Tem certeza que deseja excluir os produtos selecionados?"
                        class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Excluir selecionados
                </button>
            </div>
        @endif
    </x-admin.ui.card>
    
    <!-- Products Grid -->
    @if($viewMode === 'grid')
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($products as $product)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden card-hover group">
                    <!-- Image -->
                    <div class="aspect-square relative bg-gray-100">
                        @if($product->featured_image)
                            <img src="{{ asset('storage/' . $product->featured_image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i data-lucide="image" class="w-12 h-12 text-gray-300"></i>
                            </div>
                        @endif
                        
                        <!-- Checkbox -->
                        <div class="absolute top-3 left-3">
                            <input type="checkbox" 
                                   wire:model.live="selected" 
                                   value="{{ $product->id }}"
                                   class="w-5 h-5 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <x-admin.ui.badge :variant="$product->is_active ? 'success' : 'danger'" size="sm">
                                {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                            </x-admin.ui.badge>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <button wire:click="openEditModal({{ $product->id }})"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                                <i data-lucide="edit-2" class="w-5 h-5"></i>
                            </button>
                            <button wire:click="toggleStatus({{ $product->id }})"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                                <i data-lucide="{{ $product->is_active ? 'eye-off' : 'eye' }}" class="w-5 h-5"></i>
                            </button>
                            <button wire:click="deleteProduct({{ $product->id }})"
                                    wire:confirm="Tem certeza que deseja excluir este produto?"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-red-600 transition-colors">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="p-4">
                        <p class="text-xs text-gray-500 mb-1">{{ $product->category?->name ?? 'Sem categoria' }}</p>
                        <h3 class="font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                @if($product->is_on_sale)
                                    <span class="text-lg font-bold text-primary-600">{{ number_format($product->sale_price, 2, ',', '.') }} Kz</span>
                                    <span class="text-sm text-gray-400 line-through ml-1">{{ number_format($product->price, 2, ',', '.') }}</span>
                                @else
                                    <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2, ',', '.') }} Kz</span>
                                @endif
                            </div>
                            <span class="text-sm {{ $product->stock_quantity <= 10 ? 'text-red-600' : 'text-gray-500' }}">
                                {{ $product->stock_quantity }} un.
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <x-admin.ui.empty-state 
                        icon="package" 
                        title="Nenhum produto encontrado"
                        description="Não encontramos produtos com os filtros aplicados." />
                    <div class="text-center mt-4">
                        <x-admin.ui.button wire:click="openCreateModal" icon="plus">
                            Criar Primeiro Produto
                        </x-admin.ui.button>
                    </div>
                </div>
            @endforelse
        </div>
    @else
        <!-- Products Table -->
        <x-admin.ui.table>
            <x-slot:head>
                <tr>
                    <th class="px-4 py-3 w-12">
                        <input type="checkbox" 
                               wire:model.live="selectAll"
                               wire:click="toggleSelectAll"
                               class="w-4 h-4 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produto</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Categoria</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Preço</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Estoque</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
                </tr>
            </x-slot:head>
            
            @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <input type="checkbox" 
                               wire:model.live="selected" 
                               value="{{ $product->id }}"
                               class="w-4 h-4 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">SKU: {{ $product->sku ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $product->category?->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($product->is_on_sale)
                            <span class="text-sm font-semibold text-primary-600">{{ number_format($product->sale_price, 2, ',', '.') }} Kz</span>
                            <span class="text-xs text-gray-400 line-through block">{{ number_format($product->price, 2, ',', '.') }}</span>
                        @else
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($product->price, 2, ',', '.') }} Kz</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-sm {{ $product->stock_quantity <= 10 ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                            {{ $product->stock_quantity }} un.
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <x-admin.ui.badge :variant="$product->is_active ? 'success' : 'danger'" size="sm" :dot="true">
                            {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                        </x-admin.ui.badge>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <x-admin.ui.dropdown>
                            <x-admin.ui.dropdown-item wire:click="openEditModal({{ $product->id }})" icon="edit-2">
                                Editar
                            </x-admin.ui.dropdown-item>
                            <x-admin.ui.dropdown-item wire:click="toggleStatus({{ $product->id }})" icon="{{ $product->is_active ? 'eye-off' : 'eye' }}">
                                {{ $product->is_active ? 'Desativar' : 'Ativar' }}
                            </x-admin.ui.dropdown-item>
                            <x-admin.ui.dropdown-item wire:click="deleteProduct({{ $product->id }})" wire:confirm="Tem certeza?" icon="trash-2" danger>
                                Excluir
                            </x-admin.ui.dropdown-item>
                        </x-admin.ui.dropdown>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <x-admin.ui.empty-state 
                            icon="package" 
                            title="Nenhum produto encontrado"
                            description="Não encontramos produtos com os filtros aplicados." />
                    </td>
                </tr>
            @endforelse
        </x-admin.ui.table>
    @endif
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9998] overflow-y-auto" x-data x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="fixed inset-0 flex items-center justify-center p-4 overflow-y-auto">
                <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl my-8" @click.stop>
                    <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center">
                                <i data-lucide="{{ $editingId ? 'edit-3' : 'plus-circle' }}" class="w-5 h-5 text-primary-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $editingId ? 'Editar Produto' : 'Novo Produto' }}
                            </h3>
                        </div>
                        <button wire:click="closeModal" class="p-2 rounded-xl hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-all active:scale-95">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <form wire:submit="saveProduct" class="p-6 space-y-6 max-h-[calc(100vh-12rem)] overflow-y-auto">
                        <!-- Informações Básicas -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="info" class="w-4 h-4 text-gray-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Informações Básicas</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input
                                    wire:model="name"
                                    label="Nome do Produto"
                                    placeholder="Ex: Fone Bluetooth Premium"
                                    icon="package"
                                    :error="$errors->first('name')" />

                                <x-admin.form.input
                                    wire:model="sku"
                                    label="SKU / Código"
                                    placeholder="Deixe vazio para gerar automaticamente"
                                    icon="hash"
                                    :error="$errors->first('sku')" />
                                <p class="text-xs text-gray-500 -mt-2">Opcional: será gerado automaticamente se não fornecido</p>
                            </div>
                        </div>

                        <!-- Categorização -->
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="folder-tree" class="w-4 h-4 text-indigo-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Categorização</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Categoria Principal -->
                                <div>
                                    <x-admin.form.select
                                        wire:model="parent_category_id"
                                        label="Categoria Principal"
                                        icon="folder"
                                        :error="$errors->first('parent_category_id')">
                                        <option value="">📁 Selecione a categoria principal</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </x-admin.form.select>
                                    <p class="mt-1.5 text-xs text-gray-500 flex items-center gap-1">
                                        <i data-lucide="info" class="w-3 h-3"></i>
                                        Primeiro, escolha a categoria principal
                                    </p>
                                </div>

                                <!-- Subcategoria -->
                                <div>
                                    @if(empty($parent_category_id))
                                        <x-admin.form.select
                                            wire:model="category_id"
                                            label="Subcategoria"
                                            icon="folder-open"
                                            disabled
                                            :error="$errors->first('category_id')">
                                            <option value="">📂 Selecione uma categoria principal primeiro</option>
                                        </x-admin.form.select>
                                        <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                            Desabilitada até selecionar categoria principal
                                        </p>
                                    @else
                                        <x-admin.form.select
                                            wire:model="category_id"
                                            label="Subcategoria"
                                            icon="folder-open"
                                            :error="$errors->first('category_id')">
                                            <option value="">📂 Nenhuma subcategoria (opcional)</option>
                                            @if(!empty($parent_category_id))
                                                @foreach($this->subcategories() as $subcat)
                                                    <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                                                @endforeach
                                            @endif
                                        </x-admin.form.select>
                                        <p class="mt-1.5 text-xs text-gray-500 flex items-center gap-1">
                                            <i data-lucide="info" class="w-3 h-3"></i>
                                            Opcional: refine com uma subcategoria
                                        </p>
                                    @endif
                                </div>
                                
                                <!-- Marca -->
                                <div class="md:col-span-2">
                                    <x-admin.form.select
                                        wire:model="brand_id"
                                        label="Marca / Fabricante"
                                        icon="tag">
                                        <option value="">🏷️ Sem marca</option>
                                        @foreach($brands as $b)
                                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                                        @endforeach
                                    </x-admin.form.select>
                                    <p class="mt-1.5 text-xs text-gray-500 flex items-center gap-1">
                                        <i data-lucide="info" class="w-3 h-3"></i>
                                        Opcional: adicione a marca do produto
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Preços -->
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="dollar-sign" class="w-4 h-4 text-green-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Preços</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input
                                    wire:model="price"
                                    type="number"
                                    step="0.01"
                                    label="Preço de Venda"
                                    placeholder="0,00"
                                    icon="coins"
                                    :error="$errors->first('price')" />

                                <x-admin.form.input
                                    wire:model="sale_price"
                                    type="number"
                                    step="0.01"
                                    label="Preço Promocional"
                                    placeholder="0,00"
                                    icon="badge-percent"
                                    :error="$errors->first('sale_price')" />

                                <x-admin.form.input
                                    wire:model="cost_price"
                                    type="number"
                                    step="0.01"
                                    label="Preço de Custo"
                                    placeholder="0,00"
                                    icon="calculator"
                                    :error="$errors->first('cost_price')" />
                            </div>
                        </div>

                        <!-- Estoque -->
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="package-check" class="w-4 h-4 text-blue-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Controle de Estoque</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input
                                    wire:model="stock_quantity"
                                    type="number"
                                    min="0"
                                    label="Quantidade em Estoque"
                                    placeholder="0"
                                    icon="boxes"
                                    :error="$errors->first('stock_quantity')" />

                                <x-admin.form.input
                                    wire:model="low_stock_threshold"
                                    type="number"
                                    min="0"
                                    label="Alerta de Estoque Baixo"
                                    placeholder="10"
                                    icon="alert-triangle"
                                    :error="$errors->first('low_stock_threshold')" />

                                <x-admin.form.select
                                    wire:model="stock_status"
                                    label="Status de Disponibilidade"
                                    icon="activity"
                                    :error="$errors->first('stock_status')">
                                    <option value="in_stock">✅ Em estoque</option>
                                    <option value="out_of_stock">❌ Sem estoque</option>
                                    <option value="on_backorder">⏳ Sob encomenda</option>
                                </x-admin.form.select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.form.select
                                wire:model="condition"
                                label="Condição"
                                :error="$errors->first('condition')">
                                <option value="new">Novo</option>
                                <option value="used">Usado</option>
                                <option value="refurbished">Recondicionado</option>
                            </x-admin.form.select>

                            <x-admin.form.input
                                wire:model="barcode"
                                label="Código de Barras"
                                placeholder="Opcional"
                                :error="$errors->first('barcode')" />
                        </div>

                        <x-admin.form.textarea
                            wire:model="short_description"
                            label="Descrição curta"
                            rows="2"
                            placeholder="Resumo do produto" />

                        <x-admin.form.textarea
                            wire:model="description"
                            label="Descrição"
                            rows="5"
                            placeholder="Descrição completa"
                            :error="$errors->first('description')" />

                        <x-admin.form.textarea
                            wire:model="condition_notes"
                            label="Notas da condição"
                            rows="2"
                            placeholder="Opcional" />

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <x-admin.form.input wire:model="weight" type="number" step="0.01" label="Peso" placeholder="0" :error="$errors->first('weight')" />
                            <x-admin.form.input wire:model="length" type="number" step="0.01" label="Comprimento" placeholder="0" :error="$errors->first('length')" />
                            <x-admin.form.input wire:model="width" type="number" step="0.01" label="Largura" placeholder="0" :error="$errors->first('width')" />
                            <x-admin.form.input wire:model="height" type="number" step="0.01" label="Altura" placeholder="0" :error="$errors->first('height')" />
                        </div>

                        <!-- Imagens e Toggles -->
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="images" class="w-4 h-4 text-purple-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Imagens do Produto</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Imagem Principal</label>
                                    
                                    <!-- Preview da Imagem Atual -->
                                    @if($currentFeaturedImage)
                                        <div class="mb-4 relative group">
                                            <img src="{{ asset('storage/' . $currentFeaturedImage) }}" 
                                                 class="w-full h-48 rounded-xl object-cover border-2 border-gray-200" 
                                                 alt="Imagem atual">
                                            <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-lg flex items-center gap-1">
                                                <i data-lucide="check" class="w-3 h-3"></i>
                                                Atual
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Upload Area -->
                                    <div class="relative">
                                        <input type="file" 
                                               wire:model="featuredImageUpload" 
                                               accept="image/*" 
                                               id="featured-image-upload"
                                               class="hidden">
                                        <label for="featured-image-upload" 
                                               class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-white hover:bg-gray-50 transition-all group">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i data-lucide="upload-cloud" class="w-10 h-10 text-gray-400 group-hover:text-primary-500 transition-colors mb-2"></i>
                                                <p class="mb-1 text-sm text-gray-600 font-medium">
                                                    <span class="text-primary-600">Clique para escolher</span> ou arraste aqui
                                                </p>
                                                <p class="text-xs text-gray-500">PNG, JPG, WEBP (max. 2MB)</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    @error('featuredImageUpload') 
                                        <p class="text-xs text-red-600 mt-2 flex items-center gap-1">
                                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    
                                    <div wire:loading wire:target="featuredImageUpload" class="mt-2 flex items-center gap-2 text-sm text-primary-600">
                                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                        Carregando imagem...
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                        <p class="text-xs font-semibold text-gray-700 mb-3 flex items-center gap-1">
                                            <i data-lucide="settings-2" class="w-3.5 h-3.5"></i>
                                            Configurações
                                        </p>
                                        <div class="space-y-3">
                                            <x-admin.form.toggle wire:model="is_active" label="Ativo" hint="Exibir na loja" />
                                            <x-admin.form.toggle wire:model="is_featured" label="Destaque" hint="Aparece em seções especiais" />
                                            <x-admin.form.toggle wire:model="manage_stock" label="Gerir estoque" hint="Controlar estoque automaticamente" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Galeria -->
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="image-plus" class="w-4 h-4 text-orange-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Galeria de Imagens <span class="text-gray-500 font-normal">(opcional)</span></h4>
                            </div>
                            
                            <!-- Preview das Imagens Atuais -->
                            @if(!empty($currentImages))
                                <div class="mb-4 grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                                    @foreach($currentImages as $img)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $img) }}" 
                                                 class="w-full h-20 rounded-lg object-cover border-2 border-gray-200 group-hover:border-primary-400 transition-colors" 
                                                 alt="Galeria">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 rounded-lg transition-opacity flex items-center justify-center">
                                                <i data-lucide="eye" class="w-5 h-5 text-white"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <!-- Upload Area -->
                            <div class="relative">
                                <input type="file" 
                                       wire:model="galleryUploads" 
                                       accept="image/*" 
                                       multiple
                                       id="gallery-upload"
                                       class="hidden">
                                <label for="gallery-upload" 
                                       class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-white hover:bg-gray-50 transition-all group">
                                    <div class="flex flex-col items-center justify-center">
                                        <i data-lucide="images" class="w-8 h-8 text-gray-400 group-hover:text-orange-500 transition-colors mb-2"></i>
                                        <p class="mb-1 text-sm text-gray-600 font-medium">
                                            <span class="text-orange-600">Adicionar múltiplas imagens</span>
                                        </p>
                                        <p class="text-xs text-gray-500">Clique ou arraste várias imagens aqui</p>
                                    </div>
                                </label>
                            </div>
                            
                            @error('galleryUploads.*') 
                                <p class="text-xs text-red-600 mt-2 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            
                            <div wire:loading wire:target="galleryUploads" class="mt-2 flex items-center gap-2 text-sm text-orange-600">
                                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                Carregando imagens da galeria...
                            </div>
                        </div>

                        <div class="sticky bottom-0 -mx-6 -mb-6 px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex justify-between items-center">
                            <div wire:loading wire:target="saveProduct" class="text-sm text-primary-600 flex items-center gap-2">
                                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                Salvando...
                            </div>
                            <div class="flex gap-3">
                                <x-admin.ui.button type="button" variant="outline" wire:click="closeModal" icon="x">
                                    Cancelar
                                </x-admin.ui.button>
                                <x-admin.ui.button type="submit" icon="{{ $editingId ? 'check' : 'plus' }}">
                                    {{ $editingId ? 'Atualizar Produto' : 'Criar Produto' }}
                                </x-admin.ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
