<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-cyan-600 to-blue-600 text-white">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Gerador de Catálogos</h1>
                    <p class="text-cyan-100 mt-1">Crie catálogos profissionais e posts para redes sociais</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration Panel -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        <!-- Catalog Settings -->
        <div class="xl:col-span-2">
            <div class="card-3d p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Configurações do Catálogo</h3>
                </div>

                <div class="space-y-6">
                    <!-- Title and Description -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Título do Catálogo</label>
                            <input type="text" wire:model="catalogTitle" 
                                   class="input-3d w-full px-4 py-3 text-gray-900">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Layout</label>
                            <select wire:model="catalogLayout" class="input-3d w-full px-4 py-3 text-gray-900">
                                <option value="grid">Grade</option>
                                <option value="list">Lista</option>
                                <option value="magazine">Revista</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                        <textarea wire:model="catalogDescription" rows="2"
                                  class="input-3d w-full px-4 py-3 text-gray-900"></textarea>
                    </div>

                    <!-- Options -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" wire:model="includeImages" 
                                   class="checkbox-modern checkbox-success">
                            <span class="text-sm text-gray-700">Incluir Imagens</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" wire:model="includePrices" 
                                   class="checkbox-modern"
                                   style="--checkbox-color: linear-gradient(135deg, #059669 0%, #047857 100%); --checkbox-border: #047857;">
                            <span class="text-sm text-gray-700">Incluir Preços</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" wire:model="includeDescriptions" 
                                   class="checkbox-modern"
                                   style="--checkbox-color: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); --checkbox-border: #0284c7;">
                            <span class="text-sm text-gray-700">Incluir Descrições</span>
                        </label>
                        <div>
                            <label class="block text-sm text-gray-700 mb-1">Produtos/Página</label>
                            <input type="number" wire:model="productsPerPage" min="4" max="50"
                                   class="input-3d w-full px-3 py-2 text-gray-900">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Panel -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Estatísticas</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Produtos Selecionados:</span>
                        <span class="font-bold text-lg text-cyan-600">{{ $stats['total_products'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Disponíveis:</span>
                        <span class="font-semibold text-gray-900">{{ $stats['total_available'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Páginas Estimadas:</span>
                        <span class="font-semibold text-gray-900">{{ $stats['estimated_pages'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Categorias:</span>
                        <span class="font-semibold text-gray-900">{{ $stats['categories_count'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Marcas:</span>
                        <span class="font-semibold text-gray-900">{{ $stats['brands_count'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ações</h3>
                <div class="space-y-3">
                    <!-- Download Images Button -->
                    <button wire:click="downloadImagesForProducts" 
                            @if($downloadingImages) disabled @endif
                            class="btn-3d w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-3 font-semibold {{ $downloadingImages ? 'opacity-50 cursor-not-allowed' : '' }}">
                        @if($downloadingImages)
                            <svg class="w-5 h-5 mr-2 inline animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Baixando...
                        @else
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Baixar Imagens
                        @endif
                    </button>

                    <!-- Progress Bar -->
                    @if($downloadingImages && $imageDownloadTotal > 0)
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="bg-purple-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ ($imageDownloadProgress / $imageDownloadTotal) * 100 }}%"></div>
                        </div>
                        <div class="text-sm text-gray-600 text-center">
                            {{ $imageDownloadProgress }} de {{ $imageDownloadTotal }} imagens processadas
                        </div>
                    @endif
                    
                    <button wire:click="generatePreview" 
                            class="btn-3d w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 font-semibold">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Pré-visualizar
                    </button>
                    
                    <button wire:click="generatePDF" 
                            class="btn-3d w-full bg-gradient-to-r from-red-500 to-pink-600 text-white py-3 font-semibold">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Gerar PDF
                    </button>

                    <div class="grid grid-cols-2 gap-2">
                        <button wire:click="generateSocialPost('facebook')" 
                                class="btn-3d bg-gradient-to-r from-blue-600 to-blue-700 text-white py-2 text-sm font-semibold">
                            <svg class="w-4 h-4 mr-1 inline" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>
                        
                        <button wire:click="generateSocialPost('instagram')" 
                                class="btn-3d bg-gradient-to-r from-pink-500 to-purple-600 text-white py-2 text-sm font-semibold">
                            <svg class="w-4 h-4 mr-1 inline" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C8.396 0 7.989.016 6.756.072 5.526.128 4.718.336 4.012.628c-.72.304-1.335.742-1.942 1.349-.607.607-1.045 1.222-1.349 1.942-.292.706-.5 1.514-.556 2.744C.016 7.989 0 8.396 0 12.017c0 3.621.016 4.028.072 5.261.056 1.23.264 2.038.556 2.744.304.72.742 1.335 1.349 1.942.607.607 1.222 1.045 1.942 1.349.706.292 1.514.5 2.744.556 1.233.056 1.64.072 5.261.072 3.621 0 4.028-.016 5.261-.072 1.23-.056 2.038-.264 2.744-.556.72-.304 1.335-.742 1.942-1.349.607-.607 1.045-1.222 1.349-1.942.292-.706.5-1.514.556-2.744.056-1.233.072-1.64.072-5.261 0-3.621-.016-4.028-.072-5.261-.056-1.23-.264-2.038-.556-2.744-.304-.72-.742-1.335-1.349-1.942C17.337 1.368 16.722.93 16.002.628c-.706-.292-1.514-.5-2.744-.556C12.028.016 11.621 0 8.017 0h4zm-.152 2.197c.63-.003 1.218-.006 2.131-.006 3.562 0 3.988.013 5.39.066 1.3.059 2.006.274 2.477.456.622.243 1.066.535 1.532 1.001.466.466.758.91 1.001 1.532.182.471.397 1.177.456 2.477.053 1.402.066 1.828.066 5.39 0 3.562-.013 3.988-.066 5.39-.059 1.3-.274 2.006-.456 2.477-.243.622-.535 1.066-1.001 1.532-.466.466-.91.758-1.532 1.001-.471.182-1.177.397-2.477.456-1.402.053-1.828.066-5.39.066-3.562 0-3.988-.013-5.39-.066-1.3-.059-2.006-.274-2.477-.456-.622-.243-1.066-.535-1.532-1.001-.466-.466-.758-.91-1.001-1.532-.182-.471-.397-1.177-.456-2.477-.053-1.402-.066-1.828-.066-5.39 0-3.562.013-3.988.066-5.39.059-1.3.274-2.006.456-2.477.243-.622.535-1.066 1.001-1.532.466-.466.91-.758 1.532-1.001.471-.182 1.177-.397 2.477-.456 1.226-.056 1.702-.067 4.238-.07v.001zm5.478 2.874a1.094 1.094 0 1 0 0 2.187 1.094 1.094 0 0 0 0-2.187zM12.017 7.87a4.147 4.147 0 1 0 0 8.294 4.147 4.147 0 0 0 0-8.294zm0 2.05a2.097 2.097 0 1 1 0 4.193 2.097 2.097 0 0 1 0-4.193z"/>
                            </svg>
                            Instagram
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-3d p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pesquisar</label>
                <input type="text" wire:model.live="search" placeholder="Nome do produto..." 
                       class="input-3d w-full px-4 py-2 text-gray-900">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                <select wire:model.live="filterCategory" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                <select wire:model.live="filterBrand" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="">Todas as marcas</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="filterStatus" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="active">Apenas ativos</option>
                    <option value="all">Todos</option>
                </select>
            </div>

            <div class="flex flex-col justify-end space-y-2">
                <button wire:click="selectAllProducts" 
                        class="btn-3d bg-gradient-to-r from-green-500 to-emerald-600 text-white py-2 text-sm font-semibold">
                    Selecionar Todos
                </button>
                <button wire:click="clearSelection" 
                        class="btn-3d bg-gradient-to-r from-gray-500 to-gray-600 text-white py-2 text-sm font-semibold">
                    Limpar Seleção
                </button>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="card-3d p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Selecionar Produtos</h3>
            <div class="flex items-center space-x-4">
                @if($products->total() > 0)
                    <div class="text-sm text-gray-600">
                        {{ count($selectedProducts) }} de {{ $products->total() }} selecionados
                    </div>
                @else
                    <div class="text-sm text-red-600 font-medium">
                        Nenhum produto encontrado
                    </div>
                @endif
            </div>
        </div>

        @if($products->total() === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto encontrado</h3>
                <p class="text-gray-500 mb-4">Ajuste os filtros ou verifique se existem produtos cadastrados no sistema.</p>
                <button wire:click="$set('filterStatus', 'all')" class="btn-3d bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2">
                    Mostrar Todos os Produtos
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="card-3d p-4 transition-all duration-300 {{ in_array($product->id, $selectedProducts) ? 'ring-2 ring-cyan-500 bg-cyan-50' : '' }}">
                    <div class="relative">
                        <label class="cursor-pointer">
                            <input type="checkbox" 
                                   wire:click="toggleProduct({{ $product->id }})"
                                   {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}
                                   class="absolute top-2 right-2 checkbox-modern"
                                   style="--checkbox-color: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); --checkbox-border: #0891b2;">
                            
                            @if($product->featured_image_url)
                                <img src="{{ $product->featured_image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-32 object-cover rounded-lg mb-3"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center" style="display: none;">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-xs text-gray-500">Sem imagem</span>
                                    </div>
                                </div>
                            @else
                                <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-xs text-gray-500">Sem imagem</span>
                                    </div>
                                </div>
                            @endif

                            <h4 class="font-semibold text-gray-900 text-sm mb-1" title="{{ $product->name }}">{{ Str::limit($product->name, 30) }}</h4>
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs text-gray-500">{{ $product->category->name ?? 'N/A' }}</p>
                                <button wire:click="selectByCategory({{ $product->category_id }})" 
                                        class="text-xs text-blue-600 hover:text-blue-800 hover:underline"
                                        title="Selecionar todos desta categoria">
                                    +Cat
                                </button>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs text-gray-500">{{ $product->brand->name ?? 'N/A' }}</p>
                                <button wire:click="selectByBrand({{ $product->brand_id }})" 
                                        class="text-xs text-green-600 hover:text-green-800 hover:underline"
                                        title="Selecionar todos desta marca">
                                    +Brand
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-lg font-bold text-cyan-600">{{ number_format($product->price, 2) }} Kz</p>
                                <span class="text-xs {{ $product->is_active ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Preview Modal -->
    @if($showModal && $previewUrl)
        <div class="fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4" 
             style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
            <div class="modal-3d w-full max-w-6xl h-5/6 flex flex-col bg-white rounded-2xl shadow-2xl">
                <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-t-2xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">Pré-visualização do Catálogo</h3>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ $previewUrl }}" target="_blank" 
                           class="bg-white/20 hover:bg-white/30 px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                            Abrir em Nova Aba
                        </a>
                        <button wire:click="closeModal" 
                                class="text-white hover:text-gray-200 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex-1 p-6 overflow-hidden">
                    <iframe src="{{ $previewUrl }}" 
                            class="w-full h-full border border-gray-200 rounded-lg"
                            frameborder="0"
                            scrolling="auto">
                    </iframe>
                </div>
                <div class="p-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                    <div class="flex justify-end space-x-3">
                        <button wire:click="closeModal" 
                                class="btn-3d bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2">
                            Fechar
                        </button>
                        <button wire:click="generatePreview" 
                                class="btn-3d bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2">
                            Atualizar Preview
                        </button>
                        <button wire:click="generatePDF" 
                                class="btn-3d bg-gradient-to-r from-red-500 to-pink-600 text-white px-4 py-2">
                            Gerar PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Listen for image download progress updates
        Livewire.on('imageDownloadProgress', (event) => {
            const data = event[0];
            console.log(`Baixando imagem ${data.current}/${data.total}: ${data.product}`);
            
            // Show toast notification for progress
            if (typeof toastr !== 'undefined') {
                toastr.info(`Processando: ${data.product} (${data.current}/${data.total})`, 'Download de Imagens', {
                    timeOut: 2000,
                    progressBar: true
                });
            }
        });

        // Listen for social media post generation
        Livewire.on('socialPostGenerated', (event) => {
            const data = event[0];
            
            // Create modal or display area for social media content
            let modal = document.createElement('div');
            modal.className = 'fixed inset-0 modal-overlay z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="modal-3d w-full max-w-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Post para ${data.platform.charAt(0).toUpperCase() + data.platform.slice(1)}</h3>
                        <button onclick="this.closest('.modal-overlay').remove()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Texto do Post:</label>
                            <textarea readonly class="w-full p-3 border border-gray-300 rounded-lg resize-none" rows="8">${data.content.text}</textarea>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button onclick="navigator.clipboard.writeText('${data.content.text.replace(/'/g, "\\'")}').then(() => { 
                                if (typeof toastr !== 'undefined') toastr.success('Texto copiado!'); 
                            })" 
                                    class="btn-3d bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2">
                                Copiar Texto
                            </button>
                            <button onclick="this.closest('.modal-overlay').remove()" 
                                    class="btn-3d bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2">
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        });

        // Alerts are handled globally by the admin layout

        // Debug modal
        window.addEventListener('livewire:updated', () => {
            const modal = document.querySelector('.modal-overlay');
            if (modal) {
                console.log('Modal detectado:', modal);
            }
        });
    });

    // Auto-refresh product list after images download
    let lastImageDownloadStatus = false;
    setInterval(() => {
        const downloadButton = document.querySelector('[wire\\:click="downloadImagesForProducts"]');
        if (downloadButton) {
            const isDownloading = downloadButton.hasAttribute('disabled');
            if (lastImageDownloadStatus && !isDownloading) {
                // Download finished, refresh the component
                Livewire.dispatch('refreshComponent');
            }
            lastImageDownloadStatus = isDownloading;
        }
    }, 1000);
</script>
