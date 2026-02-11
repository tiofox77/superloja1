<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Gerador de Catálogo</h1>
            <p class="text-gray-500">Crie catálogos em PDF dos seus produtos</p>
        </div>
        <x-admin.ui.button wire:click="generatePdf" icon="download" :disabled="$totalSelected === 0 && $products->isEmpty()">
            Gerar PDF {{ $totalSelected > 0 ? "($totalSelected)" : '' }}
        </x-admin.ui.button>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar - Settings -->
        <div class="lg:col-span-1 space-y-6">
            <x-admin.ui.card title="Configurações" icon="settings">
                <div class="space-y-4">
                    <x-admin.form.input 
                        wire:model="title"
                        label="Título do Catálogo"
                        placeholder="Catálogo de Produtos" />
                    
                    <x-admin.form.input 
                        wire:model="subtitle"
                        label="Subtítulo"
                        placeholder="SuperLoja" />
                    
                    <x-admin.form.select 
                        wire:model.live="categoryId"
                        label="Categoria">
                        <option value="">Todas as Categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-admin.form.select>
                    
                    <x-admin.form.select 
                        wire:model.live="priceRange"
                        label="Faixa de Preço">
                        <option value="">Todos os Preços</option>
                        <option value="0-10000">Até 10.000 Kz</option>
                        <option value="10000-50000">10.000 - 50.000 Kz</option>
                        <option value="50000-100000">50.000 - 100.000 Kz</option>
                        <option value="100000-500000">100.000 - 500.000 Kz</option>
                        <option value="500000-9999999">Acima de 500.000 Kz</option>
                    </x-admin.form.select>
                    
                    <x-admin.form.select 
                        wire:model="layout"
                        label="Layout">
                        <option value="grid">Grade (3 por linha)</option>
                        <option value="list">Lista</option>
                        <option value="compact">Compacto (4 por linha)</option>
                    </x-admin.form.select>
                </div>
            </x-admin.ui.card>
            
            <x-admin.ui.card title="Opções" icon="sliders">
                <div class="space-y-3">
                    <x-admin.form.toggle 
                        wire:model.live="onlyActive"
                        label="Apenas Ativos" />
                    
                    <x-admin.form.toggle 
                        wire:model.live="onlyWithStock"
                        label="Apenas com Estoque" />
                    
                    <x-admin.form.toggle 
                        wire:model="showPrices"
                        label="Mostrar Preços" />
                    
                    <x-admin.form.toggle 
                        wire:model="showDescription"
                        label="Mostrar Descrição" />
                </div>
            </x-admin.ui.card>
        </div>
        
        <!-- Main Content - Product Selection -->
        <div class="lg:col-span-3">
            <x-admin.ui.card>
                <!-- Header -->
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <x-admin.form.checkbox 
                            wire:model.live="selectAll"
                            label="Selecionar Todos" />
                        <span class="text-sm text-gray-500">({{ $products->total() }} produtos)</span>
                    </div>
                    @if($totalSelected > 0)
                        <x-admin.ui.badge variant="primary">
                            {{ $totalSelected }} selecionados
                        </x-admin.ui.badge>
                    @endif
                </div>
                
                <!-- Products Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @forelse($products as $product)
                        <div wire:click="toggleProduct({{ $product->id }})"
                             class="relative cursor-pointer group rounded-xl border-2 transition-all overflow-hidden
                                    {{ in_array($product->id, $selectedProducts) ? 'border-primary-500 ring-2 ring-primary-200' : 'border-gray-200 hover:border-gray-300' }}">
                            
                            <!-- Checkbox indicator -->
                            <div class="absolute top-2 right-2 z-10">
                                <div class="w-5 h-5 rounded border-2 flex items-center justify-center transition-colors
                                            {{ in_array($product->id, $selectedProducts) ? 'bg-primary-500 border-primary-500' : 'bg-white border-gray-300' }}">
                                    @if(in_array($product->id, $selectedProducts))
                                        <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Image -->
                            <div class="aspect-square bg-gray-100">
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="package" class="w-8 h-8 text-gray-300"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div class="p-3">
                                <h4 class="text-sm font-medium text-gray-900 line-clamp-1">{{ $product->name }}</h4>
                                <p class="text-sm font-semibold text-primary-600 mt-1">
                                    {{ number_format($product->price, 2, ',', '.') }} Kz
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12">
                            <x-admin.ui.empty-state 
                                icon="package" 
                                title="Nenhum produto encontrado"
                                description="Ajuste os filtros para encontrar produtos." />
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            </x-admin.ui.card>
        </div>
    </div>
</div>
