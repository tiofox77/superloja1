@extends('layouts.app')

@section('title', 'Produtos - SuperLoja')

@section('content')
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
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Todas as Categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marca</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Todas as Marcas</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                    <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option>Nome A-Z</option>
                        <option>Preço: Menor</option>
                        <option>Preço: Maior</option>
                        <option>Mais Recentes</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-8">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
                    <!-- Product Image -->
                    <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative overflow-hidden">
                        @if($product->image_url)
                            <img src="{{ Storage::url($product->image_url) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                        
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
                            <button wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })" 
                                    class="w-full bg-orange-500 text-white py-2 px-3 rounded-lg text-xs font-medium hover:bg-orange-600 transition-colors">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
                                </svg>
                                Adicionar
                            </button>
                            <button onclick="viewProduct({{ $product->id }})" 
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
</div>

<script>
function addToCart(productId) {
    // Implementar lógica do carrinho
    alert('Produto adicionado ao carrinho!');
}

function viewProduct(productId) {
    // Implementar modal de detalhes do produto
    alert('Ver detalhes do produto ' + productId);
}
</script>
@endsection
