<div>
    <!-- Wishlist Button -->
    <button wire:click="toggleWishlist" class="relative p-3 text-gray-600 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all duration-300 group">
        <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        @if($this->itemCount > 0)
            <span class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-pulse">
                {{ $this->itemCount }}
            </span>
        @endif
        <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            Desejos
        </div>
    </button>

    <!-- Wishlist Dropdown -->
    @if($isOpen)
        <div class="fixed top-20 right-4 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50" 
             x-data="{ show: @entangle('isOpen') }" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-semibold text-gray-900">Lista de Desejos</h3>
                        <p class="text-sm text-gray-500">{{ $this->itemCount }} {{ $this->itemCount === 1 ? 'item' : 'itens' }}</p>
                    </div>
                    <button wire:click="toggleWishlist" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse($wishlistItems as $item)
                        <div class="bg-gray-50 rounded-xl p-3" wire:key="wishlist-item-{{ $item['id'] }}">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($item['image'])
                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xl">❤️</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-sm text-gray-900 truncate">{{ $item['name'] }}</h4>
                                    @if($item['category'])
                                        <p class="text-xs text-gray-500 mb-1">{{ $item['category'] }}</p>
                                    @endif
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm">
                                            @if($item['sale_price'])
                                                <span class="font-semibold text-red-600">{{ number_format($item['sale_price'], 0, ',', '.') }} Kz</span>
                                                <span class="text-xs text-gray-500 line-through ml-1">{{ number_format($item['price'], 0, ',', '.') }} Kz</span>
                                            @else
                                                <span class="font-semibold text-gray-900">{{ number_format($item['price'], 0, ',', '.') }} Kz</span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center space-x-1">
                                            <!-- Move to Cart -->
                                            <button wire:click="moveToCart({{ $item['id'] }})" 
                                                    class="p-1.5 text-orange-500 hover:text-orange-700 hover:bg-orange-50 rounded-lg transition-colors" 
                                                    title="Mover para carrinho">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H17M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8"></path>
                                                </svg>
                                            </button>
                                            
                                            <!-- Remove -->
                                            <button wire:click="removeItemById({{ $item['id'] }})" 
                                                    class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" 
                                                    title="Remover">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <p class="text-sm">Sua lista de desejos está vazia</p>
                            <p class="text-xs text-gray-400 mt-1">Clique no ❤️ nos produtos para adicionar</p>
                        </div>
                    @endforelse
                </div>
                
                @if(count($wishlistItems) > 0)
                    <!-- Action Buttons -->
                    <div class="mt-4 space-y-2">
                        <button class="w-full bg-gradient-to-r from-red-500 to-pink-500 text-white py-3 rounded-xl font-semibold hover:from-red-600 hover:to-pink-600 transition-all duration-300 shadow-lg">
                            Ver Todos os Favoritos
                        </button>
                        <button wire:click="clearWishlist" class="w-full text-gray-600 hover:text-gray-800 py-2 text-sm font-medium transition-colors">
                            Limpar Lista de Desejos
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
