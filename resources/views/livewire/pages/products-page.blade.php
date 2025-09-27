<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Todos os Produtos</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Descubra nossa coleção completa de produtos tecnológicos com {{ $products->total() }} produtos disponíveis.</p>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                    <select wire:model.live="selectedCategory" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Todas as Categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marca</label>
                    <select wire:model.live="selectedBrand" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Todas as Marcas</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                    <select wire:model.live="sortBy" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="name">Nome A-Z</option>
                        <option value="price-low">Preço: Menor</option>
                        <option value="price-high">Preço: Maior</option>
                        <option value="newest">Mais Recentes</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-8">
            @forelse($products as $product)
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
                        
                        <!-- Overlay com ícones -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center space-x-3">
                            <!-- Ver Detalhes -->
                            <button wire:click="viewProduct({{ $product->id }})" 
                                    class="bg-white text-gray-700 p-2 rounded-full shadow-lg transform scale-0 group-hover:scale-100 transition-all duration-300 hover:bg-orange-500 hover:text-white">
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
                        
                        <!-- Discount Badge -->
                        @if($product->sale_price && $product->sale_price > 0)
                            @php
                                $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                            @endphp
                            <div class="absolute top-2 left-2">
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">
                                    -{{ $discount }}%
                                </span>
                            </div>
                        @endif

                        <!-- Category Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="bg-orange-500 text-white text-xs px-1.5 py-0.5 rounded-full font-medium">
                                {{ $product->category->name ?? 'Produto' }}
                            </span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-3">
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
                        <h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[2.5rem]">
                            {{ $product->name }}
                        </h3>
                        
                        <!-- Price -->
                        <div class="mb-3">
                            <div class="flex flex-col space-y-1">
                                <span class="text-lg font-bold text-orange-500">
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
                                    class="w-full bg-orange-500 text-white py-2 px-3 rounded-lg text-xs font-medium hover:bg-orange-600 transition-colors">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
                                </svg>
                                Adicionar
                            </button>
                            <button wire:click="viewProduct({{ $product->id }})" 
                                    class="w-full text-orange-500 border border-orange-500 py-1.5 px-3 rounded-lg text-xs font-medium hover:bg-orange-50 transition-colors">
                                Ver Detalhes
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto encontrado</h3>
                    <p class="text-gray-500">Não há produtos disponíveis no momento.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Product Details Modal -->
    @if($showModal && $selectedProduct)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showModal') }" x-show="show" style="display: none;">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" wire:click="closeModal"></div>

                <!-- Modal -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <!-- Close Button -->
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
                                                           {{ $index === $mainImageIndex ? 'border-orange-500' : 'border-gray-200 hover:border-gray-300' }}">
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
                                <!-- Category -->
                                <div class="mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        {{ $selectedProduct->category->name ?? 'Produto' }}
                                    </span>
                                </div>

                                <!-- Product Name -->
                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $selectedProduct->name }}</h3>

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
                                        <span class="text-2xl font-bold text-orange-500">
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
                                                @if($i < ($selectedProduct->rating ?? 0))
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
                                        <span class="ml-2 text-sm text-gray-500">({{ $selectedProduct->reviews_count ?? 0 }})</span>
                                    </div>
                                    
                                    <!-- Sales Counter -->
                                    <div class="flex items-center text-sm text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <span class="font-medium">{{ $selectedProduct->order_count ?? 0 }} vendidos</span>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($selectedProduct->description)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Descrição</h4>
                                        <p class="text-sm text-gray-600">{{ $selectedProduct->description }}</p>
                                    </div>
                                @endif

                                <!-- Product Variants -->
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
                                                                              ? 'border-orange-500 bg-orange-500 text-white' 
                                                                              : 'border-gray-300 hover:border-orange-500 hover:bg-orange-50' }}">
                                                                {{ $variant->value }}
                                                                @if($variant->price_adjustment != 0)
                                                                    <span class="ml-1 font-medium {{ isset($selectedVariants[$variantName]) && $selectedVariants[$variantName] == $variant->id ? 'text-orange-100' : 'text-orange-600' }}">
                                                                        {{ $variant->price_adjustment > 0 ? '+' : '' }}{{ number_format($variant->price_adjustment, 0, ',', '.') }} Kz
                                                                    </span>
                                                                @endif
                                                                <span class="ml-1 {{ isset($selectedVariants[$variantName]) && $selectedVariants[$variantName] == $variant->id ? 'text-orange-100' : 'text-gray-500' }}">({{ $variant->stock_quantity }})</span>
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

                                <!-- Stock Status -->
                                <div class="mb-4">
                                    @if($selectedProduct->stock_quantity > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Em estoque ({{ $selectedProduct->stock_quantity }} unidades)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            Fora de estoque
                                        </span>
                                    @endif
                                    
                                    @if($selectedProduct->variants && $selectedProduct->variants->count() > 0)
                                        <div class="mt-2">
                                            <span class="text-xs text-gray-500">
                                                {{ $selectedProduct->variants->where('is_active', true)->where('stock_quantity', '>', 0)->count() }} variantes disponíveis
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-2">
                                    @if($selectedProduct->stock_quantity > 0)
                                        <button wire:click="addToCart({{ $selectedProduct->id }})" 
                                                class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
                                            </svg>
                                            Adicionar ao Carrinho
                                        </button>
                                    @else
                                        <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-lg font-medium cursor-not-allowed">
                                            Produto Indisponível
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
