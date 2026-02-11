<div class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-4 text-sm">
            <a href="{{ route('home') }}" wire:navigate class="text-blue-600 hover:underline">Início</a>
            <span class="mx-2">›</span>
            <a href="{{ route('products') }}" wire:navigate class="text-blue-600 hover:underline">Produtos</a>
            <span class="mx-2">›</span>
            <span class="text-gray-600">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-6">
                <!-- Imagem do Produto -->
                <div class="flex items-center justify-center bg-gray-100 rounded-lg p-4">
                    @if($product->featured_image)
                        <img src="{{ asset('storage/' . $product->featured_image) }}" 
                             alt="{{ $product->name }}"
                             class="max-w-full h-auto max-h-96 object-contain">
                    @else
                        <div class="w-full h-64 flex items-center justify-center text-gray-400">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Detalhes do Produto -->
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                    @if($product->category)
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Categoria:</span> {{ $product->category->name }}
                        </p>
                    @endif

                    @if($product->brand)
                        <p class="text-sm text-gray-600 mb-4">
                            <span class="font-semibold">Marca:</span> {{ $product->brand->name }}
                        </p>
                    @endif

                    <!-- Preço -->
                    <div class="mb-6">
                        @if($product->sale_price && $product->sale_price > 0)
                            <div class="flex items-baseline gap-3">
                                <span class="text-4xl font-bold text-orange-600">{{ number_format($product->sale_price, 0, ',', '.') }} Kz</span>
                                <span class="text-xl text-gray-400 line-through">{{ number_format($product->price, 0, ',', '.') }} Kz</span>
                            </div>
                            <span class="inline-block mt-2 bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                Economize {{ number_format($product->price - $product->sale_price, 0, ',', '.') }} Kz
                            </span>
                        @else
                            <span class="text-4xl font-bold text-gray-900">{{ number_format($product->price, 0, ',', '.') }} Kz</span>
                        @endif
                    </div>

                    <!-- Descrição -->
                    @if($product->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Descrição</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if($product->stock_quantity > 0)
                            <span class="inline-flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Em Stock ({{ $product->stock_quantity }} disponíveis)
                            </span>
                        @else
                            <span class="inline-flex items-center text-red-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Fora de Stock
                            </span>
                        @endif
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex gap-4 mt-auto">
                        @if($product->stock_quantity > 0)
                            <button class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                Adicionar ao Carrinho
                            </button>
                        @else
                            <button disabled class="flex-1 bg-gray-300 text-gray-500 font-bold py-3 px-6 rounded-lg cursor-not-allowed">
                                Indisponível
                            </button>
                        @endif
                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produtos Relacionados -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Produtos Relacionados</h2>
            <livewire:components.featured-products />
        </div>
    </div>
</div>
