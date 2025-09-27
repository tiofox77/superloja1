<div class="flex justify-center">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 2xl:grid-cols-6 gap-4 max-w-7xl">
    @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
            <!-- Product Image -->
            <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative overflow-hidden group">
                @if($product->featured_image)
                    <img src="{{ Storage::url($product->featured_image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                @else
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                @endif
                
                <!-- NEW Badge -->
                <div class="absolute top-2 left-2">
                    <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs px-2 py-1 rounded-full font-bold animate-pulse">
                        NOVO
                    </span>
                </div>

                <!-- Discount Badge -->
                @if($product->sale_price && $product->sale_price > 0)
                    @php
                        $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                    @endphp
                    <div class="absolute top-2 right-2">
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">
                            -{{ $discount }}%
                        </span>
                    </div>
                @endif

                <!-- Overlay com ícones -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center space-x-3">
                    <!-- Ver Detalhes -->
                    <button wire:click="viewProduct({{ $product->id }})" 
                            class="bg-white text-gray-700 p-2 rounded-full shadow-lg transform scale-0 group-hover:scale-100 transition-all duration-300 hover:bg-blue-500 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                    
                    <!-- Adicionar à Lista de Desejos -->
                    <button wire:click="toggleWishlist({{ $product->id }})" 
                            class="p-2 rounded-full shadow-lg transform scale-0 group-hover:scale-100 transition-all duration-300 delay-75
                                   {{ $this->isInWishlist($product->id) 
                                      ? 'bg-red-500 text-white hover:bg-red-600' 
                                      : 'bg-white text-gray-700 hover:bg-red-500 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="{{ $this->isInWishlist($product->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Category Badge -->
                <div class="absolute bottom-2 right-2">
                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                        {{ $product->category->name ?? 'Sem categoria' }}
                    </span>
                </div>
            </div>

            <!-- Product Info -->
            <div class="p-2">
                <!-- Added Date -->
                <div class="flex items-center mb-2">
                    <svg class="w-3 h-3 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs text-green-600 font-medium">
                        Adicionado {{ $product->created_at->format('d/m') }}
                    </span>
                </div>

                <!-- Rating -->
                <div class="flex items-center mb-2">
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            @if($i < ($product->rating ?? 0))
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="w-3 h-3 text-gray-300 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-1 text-xs text-gray-500">({{ $product->reviews_count ?? 0 }})</span>
                </div>
                
                <!-- Product Name -->
                <h3 class="text-sm font-semibold text-gray-900 mb-3 line-clamp-2 min-h-[2.5rem]">
                    {{ $product->name }}
                </h3>
                
                <!-- Price -->
                <div class="mb-4">
                    <div class="flex flex-col space-y-1">
                        <span class="text-lg font-bold text-blue-600">
                            {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }} Kz
                        </span>
                        @if($product->sale_price && $product->sale_price > 0)
                            <span class="text-xs text-gray-500 line-through">
                                {{ number_format($product->price, 0, ',', '.') }} Kz
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-2">
                    <button wire:click="addToCart({{ $product->id }})" 
                            class="w-full bg-blue-600 text-white py-2 px-3 rounded-lg text-xs font-medium hover:bg-blue-700 transition-colors">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
                        </svg>
                        Adicionar
                    </button>
                    <button wire:click="viewProduct({{ $product->id }})" 
                            class="w-full text-blue-600 border border-blue-600 py-1.5 px-3 rounded-lg text-xs font-medium hover:bg-blue-50 transition-colors">
                        Ver Detalhes
                    </button>
                </div>
            </div>
        </div>
    @endforeach
    </div>

    <!-- Product Modal -->
    @if($showModal && $selectedProduct)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:key="modal-{{ $selectedProduct->id }}">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="absolute top-0 right-0 pt-4 pr-4">
                            <button wire:click="closeModal" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-600">
                                <span class="sr-only">Fechar</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="sm:flex sm:items-start">
                            <!-- Product Image Gallery -->
                            <div class="w-full sm:w-1/2 mb-4 sm:mb-0 sm:mr-6">
                                <!-- Main Image -->
                                <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg overflow-hidden mb-3">
                                    @if(count($currentImages) > 0 && isset($currentImages[$mainImageIndex]))
                                        <img src="{{ Storage::url($currentImages[$mainImageIndex]) }}" 
                                             alt="{{ $selectedProduct->name }}" 
                                             class="w-full h-full object-cover">
                                    @elseif($selectedProduct->featured_image)
                                        <img src="{{ Storage::url($selectedProduct->featured_image) }}" 
                                             alt="{{ $selectedProduct->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Thumbnail Gallery -->
                                @if(count($currentImages) > 1)
                                    <div class="flex space-x-2 overflow-x-auto">
                                        @foreach($currentImages as $index => $image)
                                            <button wire:click="setMainImage({{ $index }})" 
                                                    class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-lg overflow-hidden border-2 transition-colors
                                                           {{ $index === $mainImageIndex ? 'border-blue-500' : 'border-gray-200 hover:border-gray-300' }}">
                                                <img src="{{ Storage::url($image) }}" 
                                                     alt="Imagem {{ $index + 1 }}" 
                                                     class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="w-full sm:w-1/2">
                                <!-- NEW Badge -->
                                <div class="mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        🆕 NOVO - {{ $selectedProduct->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                <!-- Product Name -->
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $selectedProduct->name }}</h3>
                                
                                <!-- Brand -->
                                @if($selectedProduct->brand)
                                    <div class="mb-3">
                                        <span class="text-sm text-gray-600">Marca: </span>
                                        <span class="text-sm font-medium text-gray-900">{{ $selectedProduct->brand->name }}</span>
                                    </div>
                                @endif

                                <!-- Price -->
                                <div class="mb-4">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-2xl font-bold text-blue-600">
                                            {{ number_format($this->finalPrice, 0, ',', '.') }} Kz
                                        </span>
                                        @if($selectedProduct->sale_price && $selectedProduct->sale_price > 0 && count($selectedVariants) == 0)
                                            <span class="text-lg text-gray-500 line-through">
                                                {{ number_format($selectedProduct->price, 0, ',', '.') }} Kz
                                            </span>
                                            @php
                                                $discount = round((($selectedProduct->price - $selectedProduct->sale_price) / $selectedProduct->price) * 100);
                                            @endphp
                                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">
                                                -{{ $discount }}%
                                            </span>
                                        @endif
                                        
                                        @if(count($selectedVariants) > 0)
                                            <span class="text-xs text-gray-500">
                                                (Preço com variantes selecionadas)
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Rating & Sales -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex text-yellow-400">
                                            @for($i = 0; $i < 5; $i++)
                                                @if($i < ($selectedProduct->rating_average ?? 0))
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-500">({{ $selectedProduct->rating_count ?? 0 }})</span>
                                    </div>
                                    
                                    <!-- Sales Counter -->
                                    <div class="flex items-center text-sm text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <span class="font-medium">{{ $selectedProduct->order_count ?? 0 }} vendidos</span>
                                    </div>
                                </div>

                                <!-- Variants -->
                                @if($selectedProduct->variants && $selectedProduct->variants->count() > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-900 mb-3">Variantes Disponíveis</h4>
                                        @php
                                            $variantGroups = $selectedProduct->variants->groupBy('name');
                                        @endphp
                                        
                                        @foreach($variantGroups as $variantName => $variants)
                                            <div class="mb-3">
                                                <label class="block text-xs font-medium text-gray-700 mb-2">{{ $variantName }}</label>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($variants as $variant)
                                                        @if($variant->is_active && $variant->stock_quantity > 0)
                                                            <button type="button" 
                                                                    wire:click="selectVariant('{{ $variantName }}', {{ $variant->id }})"
                                                                    class="px-3 py-1.5 text-xs border rounded-lg transition-colors
                                                                           {{ isset($selectedVariants[$variantName]) && $selectedVariants[$variantName] == $variant->id 
                                                                              ? 'border-blue-500 bg-blue-500 text-white' 
                                                                              : 'border-gray-300 hover:border-blue-500 hover:bg-blue-50' }}">
                                                                {{ $variant->value }}
                                                                @if($variant->price_adjustment != 0)
                                                                    <span class="ml-1 font-medium {{ isset($selectedVariants[$variantName]) && $selectedVariants[$variantName] == $variant->id ? 'text-blue-100' : 'text-blue-600' }}">
                                                                        {{ $variant->price_adjustment > 0 ? '+' : '' }}{{ number_format($variant->price_adjustment, 0, ',', '.') }} Kz
                                                                    </span>
                                                                @endif
                                                                <span class="ml-1 {{ isset($selectedVariants[$variantName]) && $selectedVariants[$variantName] == $variant->id ? 'text-blue-100' : 'text-gray-500' }}">({{ $variant->stock_quantity }})</span>
                                                            </button>
                                                        @else
                                                            <button type="button" disabled class="px-3 py-1.5 text-xs border border-gray-200 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                                                {{ $variant->value }} (Indisponível)
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex space-x-3">
                                    <button wire:click="addToCart({{ $selectedProduct->id }})" 
                                            class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
                                        </svg>
                                        Adicionar ao Carrinho
                                    </button>
                                    <button wire:click="toggleWishlist({{ $selectedProduct->id }})" 
                                            class="p-3 border-2 rounded-lg transition-colors {{ $this->isInWishlist($selectedProduct->id) ? 'border-red-500 bg-red-500 text-white hover:bg-red-600' : 'border-gray-300 text-gray-700 hover:border-red-500 hover:text-red-500' }}">
                                        <svg class="w-5 h-5" fill="{{ $this->isInWishlist($selectedProduct->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
