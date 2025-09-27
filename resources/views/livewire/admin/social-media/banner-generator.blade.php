<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-pink-600 to-purple-600 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Gerador de Banners</h1>
                <p class="text-pink-100">Crie banners profissionais para suas redes sociais</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Configuration Panel -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Banner Type & Size -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Configurações Básicas</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Banner</label>
                        <select wire:model.live="bannerType" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            @foreach($bannerTypes as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tamanho</label>
                        <select wire:model.live="bannerSize" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            @foreach($bannerSizes as $key => $size)
                                <option value="{{ $key }}">{{ $size['name'] }} ({{ $size['width'] }}x{{ $size['height'] }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Text Content -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Conteúdo do Texto</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Título Principal</label>
                        <input type="text" 
                               wire:model.live="mainTitle"
                               placeholder="Digite o título principal..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                        <input type="text" 
                               wire:model.live="subtitle"
                               placeholder="Digite o subtítulo..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Call to Action</label>
                        <input type="text" 
                               wire:model.live="ctaText"
                               placeholder="Ex: Confira agora!"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Design Settings -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Design</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                        <select wire:model.live="template" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            @foreach($templates as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fonte</label>
                        <select wire:model.live="fontFamily" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            @foreach($fonts as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                        <input type="color" 
                               wire:model.live="backgroundColor"
                               class="w-full h-10 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor do Texto</label>
                        <input type="color" 
                               wire:model.live="textColor"
                               class="w-full h-10 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagem de Fundo</label>
                    <input type="file" 
                           wire:model="backgroundImage"
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    @if($backgroundImage)
                        <p class="text-sm text-green-600 mt-1">✓ Imagem carregada</p>
                    @endif
                </div>

                @if($backgroundImage)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opacidade do Overlay (%)</label>
                        <input type="range" 
                               wire:model.live="overlayOpacity"
                               min="0" max="100"
                               class="w-full">
                        <div class="text-center text-sm text-gray-600">{{ $overlayOpacity }}%</div>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Posição do Logo</label>
                        <select wire:model.live="logoPosition" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="top-left">Superior Esquerda</option>
                            <option value="top-right">Superior Direita</option>
                            <option value="bottom-left">Inferior Esquerda</option>
                            <option value="bottom-right">Inferior Direita</option>
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.live="showPrices" id="showPrices" class="checkbox-modern">
                            <label for="showPrices" class="ml-2 text-sm text-gray-700">Mostrar preços</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.live="showDiscount" id="showDiscount" class="checkbox-modern">
                            <label for="showDiscount" class="ml-2 text-sm text-gray-700">Mostrar desconto</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Selection -->
            @if($bannerType !== 'custom' && $bannerType !== 'brand_awareness')
                <div class="card-3d p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Seleção de Produtos</h3>
                    
                    <!-- Quick Selection -->
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700 mb-2">Seleção Rápida</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($categories as $category)
                                <button wire:click="selectProductsByCategory({{ $category->id }})"
                                        class="btn-3d bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1 text-sm">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Selected Products -->
                    @if(!empty($selectedProducts))
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-700 mb-2">Produtos Selecionados ({{ count($selectedProducts) }})</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                @foreach($products->whereIn('id', $selectedProducts)->take(4) as $product)
                                    <div class="relative border border-gray-200 rounded-lg p-2">
                                        <button wire:click="removeProduct({{ $product->id }})"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs">
                                            ×
                                        </button>
                                        @if($product->featured_image_url)
                                            <img src="{{ $product->featured_image_url }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-16 object-cover rounded mb-1">
                                        @endif
                                        <p class="text-xs text-gray-600">{{ Str::limit($product->name, 20) }}</p>
                                        <p class="text-xs font-semibold text-green-600">{{ number_format($product->price, 2) }} Kz</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Product Grid -->
                    <div class="max-h-64 overflow-y-auto">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($products->take(20) as $product)
                                <div class="border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-blue-500 transition-colors {{ in_array($product->id, $selectedProducts) ? 'border-blue-500 bg-blue-50' : '' }}"
                                     wire:click="addProduct({{ $product->id }})">
                                    @if($product->featured_image_url)
                                        <img src="{{ $product->featured_image_url }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-20 object-cover rounded mb-2">
                                    @else
                                        <div class="w-full h-20 bg-gray-200 rounded mb-2 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <p class="text-xs font-medium text-gray-900">{{ Str::limit($product->name, 25) }}</p>
                                    <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                                    <p class="text-xs font-semibold text-green-600">{{ number_format($product->price, 2) }} Kz</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Preview Panel -->
        <div class="space-y-6">
            <!-- Preview -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Preview</h3>
                
                @if($showPreview && $previewUrl)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <img src="{{ $previewUrl }}" 
                             alt="Banner Preview"
                             class="w-full rounded-lg shadow-md">
                    </div>
                @else
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <p class="text-gray-500 mb-4">Preview será exibido aqui</p>
                        <button wire:click="generatePreview" 
                                class="btn-3d bg-gradient-to-r from-purple-500 to-pink-600 text-white px-4 py-2">
                            Gerar Preview
                        </button>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ações</h3>
                
                <div class="space-y-3">
                    <button wire:click="generatePreview" 
                            class="w-full btn-3d bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Atualizar Preview
                    </button>
                    
                    @if($showPreview)
                        <button wire:click="downloadBanner" 
                                class="w-full btn-3d bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Baixar Banner
                        </button>
                        
                        <button onclick="shareToSocialMedia()" 
                                class="w-full btn-3d bg-gradient-to-r from-purple-500 to-pink-600 text-white py-3">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            Compartilhar
                        </button>
                    @endif
                </div>
            </div>

            <!-- Banner Info -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tipo:</span>
                        <span class="font-medium">{{ $bannerTypes[$bannerType] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tamanho:</span>
                        <span class="font-medium">{{ $bannerSizes[$bannerSize]['width'] }}x{{ $bannerSizes[$bannerSize]['height'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Template:</span>
                        <span class="font-medium">{{ $templates[$template] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Produtos:</span>
                        <span class="font-medium">{{ count($selectedProducts) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function shareToSocialMedia() {
        // Implementar lógica de compartilhamento
        alert('Funcionalidade de compartilhamento será implementada');
    }
</script>
