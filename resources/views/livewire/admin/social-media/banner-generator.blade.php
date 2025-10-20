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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Configuration Panel -->
        <div class="space-y-6">
            <!-- Banner Type & Size -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">⚙️ Configurações Rápidas</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tamanho</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="$set('bannerSize', 'facebook_post')" 
                                    class="btn-3d {{ $bannerSize === 'facebook_post' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }} py-2">
                                📘 Facebook
                            </button>
                            <button wire:click="$set('bannerSize', 'instagram_post')" 
                                    class="btn-3d {{ $bannerSize === 'instagram_post' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700' }} py-2">
                                📷 Instagram
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="$set('template', 'card')" 
                                    class="btn-3d {{ $template === 'card' ? 'bg-purple-500 text-white' : 'bg-gray-100 text-gray-700' }} py-2">
                                🎴 Card
                            </button>
                            <button wire:click="$set('template', 'modern')" 
                                    class="btn-3d {{ $template === 'modern' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700' }} py-2">
                                ✨ Moderno
                            </button>
                        </div>
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

            <!-- Design Settings - SIMPLIFICADO -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">🎨 Cores</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                        <input type="color" 
                               wire:model.live="backgroundColor"
                               class="w-full h-12 border border-gray-300 rounded-lg cursor-pointer">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL/Logo</label>
                        <input type="text" 
                               wire:model.live="logoUrl"
                               placeholder="superloja.vip"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Product Selection -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">🛍️ Produtos no Banner</h3>
                    
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
                            <h4 class="font-medium text-green-700 mb-2">✓ {{ count($selectedProducts) }} produto(s) selecionado(s)</h4>
                            <div class="grid grid-cols-2 gap-3">
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
                    <div class="max-h-80 overflow-y-auto">
                        <div class="grid grid-cols-2 gap-3">
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
            </div>
        </div>

        <!-- Preview Panel -->
        <div class="space-y-6">
            <!-- Preview -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">👁️ Preview</h3>
                
                @if($showPreview && $previewUrl)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <img src="{{ $previewUrl }}?t={{ time() }}" 
                             alt="Banner Preview"
                             class="w-full rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
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
                <h3 class="text-lg font-bold text-gray-900 mb-4">🚀 Ações</h3>
                
                <div class="space-y-3">
                    <button wire:click="generatePreview" 
                            class="w-full btn-3d bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-4 text-lg font-semibold">
                        👁️ Gerar Preview
                    </button>
                    
                    @if($showPreview)
                        <button wire:click="downloadBanner" 
                                class="w-full btn-3d bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 text-lg font-semibold">
                            📥 Baixar Banner
                        </button>
                    @endif
                </div>
            </div>

            <!-- Banner Info -->
            <div class="card-3d p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">ℹ️ Informações</h3>
                
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between p-2 bg-gray-50 rounded">
                        <span class="text-gray-600">📐 Dimensões:</span>
                        <span class="font-bold text-blue-600">{{ $bannerSizes[$bannerSize]['width'] }}x{{ $bannerSizes[$bannerSize]['height'] }}px</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-50 rounded">
                        <span class="text-gray-600">🎨 Template:</span>
                        <span class="font-bold text-purple-600">{{ $templates[$template] }}</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-50 rounded">
                        <span class="text-gray-600">🛍️ Produtos:</span>
                        <span class="font-bold text-green-600">{{ count($selectedProducts) }}</span>
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
