<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-pink-600 to-rose-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold flex items-center">
                <span class="mr-3">❤️</span> Lista de Desejos
            </h1>
            <p class="text-pink-100 mt-2">Seus produtos favoritos</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <div class="flex flex-wrap gap-4 mb-8">
            <a href="{{ route('user.dashboard') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">📊 Dashboard</a>
            <a href="{{ route('user.orders') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">📦 Meus Pedidos</a>
            <a href="{{ route('user.profile') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">👤 Perfil</a>
            <button class="bg-pink-600 text-white px-6 py-3 rounded-lg font-bold">❤️ Lista de Desejos</button>
        </div>

        @if($wishlistItems->count() > 0)
            <!-- Actions Bar -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="mr-2">💖</span> Meus Favoritos
                        </h2>
                        <p class="text-gray-600 mt-1">{{ $wishlistItems->total() }} {{ $wishlistItems->total() === 1 ? 'produto' : 'produtos' }} na sua lista</p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <button wire:click="clearWishlist" wire:confirm="Tem certeza que deseja limpar toda a lista de desejos?" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            🗑️ Limpar Lista
                        </button>
                        <a href="{{ route('products') }}" class="bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white px-6 py-2 rounded-lg font-medium transition-all">
                            🛍️ Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $wishlistItem)
                    @if($wishlistItem->product)
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group" wire:key="wishlist-{{ $wishlistItem->id }}">
                            <!-- Product Image -->
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                @if($wishlistItem->product->main_image)
                                    <img src="{{ Storage::url($wishlistItem->product->main_image) }}" 
                                         alt="{{ $wishlistItem->product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-6xl">
                                        📦
                                    </div>
                                @endif
                                
                                <!-- Remove from Wishlist Button -->
                                <button wire:click="removeFromWishlist({{ $wishlistItem->product->id }})" 
                                        class="absolute top-3 right-3 w-10 h-10 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <!-- Discount Badge -->
                                @if($wishlistItem->product->compare_price && $wishlistItem->product->compare_price > $wishlistItem->product->price)
                                    @php
                                        $discount = round((($wishlistItem->product->compare_price - $wishlistItem->product->price) / $wishlistItem->product->compare_price) * 100);
                                    @endphp
                                    <div class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        -{{ $discount }}%
                                    </div>
                                @endif

                                <!-- Stock Status -->
                                @if($wishlistItem->product->stock_quantity <= 0)
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">Esgotado</span>
                                    </div>
                                @elseif($wishlistItem->product->stock_quantity <= 5)
                                    <div class="absolute bottom-3 left-3 bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        Últimas {{ $wishlistItem->product->stock_quantity }} unidades
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-pink-600 transition-colors">
                                    {{ $wishlistItem->product->name }}
                                </h3>
                                
                                @if($wishlistItem->product->brand)
                                    <p class="text-sm text-gray-500 mb-2">{{ $wishlistItem->product->brand->name }}</p>
                                @endif

                                <!-- Price -->
                                <div class="flex items-center space-x-2 mb-4">
                                    <span class="text-xl font-bold text-pink-600">
                                        {{ number_format($wishlistItem->product->price, 2, ',', '.') }} Kz
                                    </span>
                                    @if($wishlistItem->product->compare_price && $wishlistItem->product->compare_price > $wishlistItem->product->price)
                                        <span class="text-sm text-gray-500 line-through">
                                            {{ number_format($wishlistItem->product->compare_price, 2, ',', '.') }} Kz
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-2">
                                    @if($wishlistItem->product->stock_quantity > 0)
                                        <button wire:click="addToCart({{ $wishlistItem->product->id }})" 
                                                class="flex-1 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white py-2 px-4 rounded-lg font-medium transition-all">
                                            🛒 Adicionar
                                        </button>
                                    @else
                                        <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2 px-4 rounded-lg font-medium cursor-not-allowed">
                                            Indisponível
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('products.show', $wishlistItem->product->id) }}" 
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg font-medium transition-colors">
                                        👁️
                                    </a>
                                </div>

                                <!-- Added Date -->
                                <p class="text-xs text-gray-400 mt-3 text-center">
                                    Adicionado em {{ $wishlistItem->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            @if($wishlistItems->hasPages())
                <div class="mt-12">
                    {{ $wishlistItems->links() }}
                </div>
            @endif

        @else
            <!-- Empty Wishlist -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="mb-8">
                    <div class="w-24 h-24 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-4xl">💔</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Sua lista de desejos está vazia</h2>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Explore nossos produtos e adicione seus favoritos à lista de desejos. 
                        Assim você pode acompanhar os preços e nunca perder as melhores ofertas!
                    </p>
                </div>

                <!-- Suggestions -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-2xl mx-auto">
                        <a href="{{ route('products') }}" class="flex items-center justify-center p-4 bg-gradient-to-br from-pink-50 to-rose-50 border border-pink-200 rounded-xl hover:from-pink-100 hover:to-rose-100 transition-colors group">
                            <div class="text-center">
                                <span class="text-2xl mb-2 block group-hover:scale-110 transition-transform">🛍️</span>
                                <span class="font-medium text-pink-700">Explorar Produtos</span>
                            </div>
                        </a>
                        
                        <a href="{{ route('offers') }}" class="flex items-center justify-center p-4 bg-gradient-to-br from-orange-50 to-red-50 border border-orange-200 rounded-xl hover:from-orange-100 hover:to-red-100 transition-colors group">
                            <div class="text-center">
                                <span class="text-2xl mb-2 block group-hover:scale-110 transition-transform">🔥</span>
                                <span class="font-medium text-orange-700">Ver Ofertas</span>
                            </div>
                        </a>
                        
                        <a href="{{ route('auctions') }}" class="flex items-center justify-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl hover:from-green-100 hover:to-emerald-100 transition-colors group">
                            <div class="text-center">
                                <span class="text-2xl mb-2 block group-hover:scale-110 transition-transform">⚡</span>
                                <span class="font-medium text-green-700">Leilões</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
