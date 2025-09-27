<div>
    <!-- Cart Button -->
    <button wire:click="toggleCart" class="relative p-3 text-gray-600 hover:text-orange-500 hover:bg-gradient-to-br hover:from-orange-50 hover:to-red-50 rounded-2xl transition-all duration-300 group shadow-lg hover:shadow-xl">
        <div class="relative">
            <!-- Carrinho melhorado com sacola de compras -->
            <svg class="w-7 h-7 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119.993zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
            
            <!-- Efeito de brilho -->
            <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-red-400 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-sm"></div>
        </div>
        
        @if($this->itemCount > 0)
            <span class="absolute -top-2 -right-2 bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold shadow-lg animate-bounce border-2 border-white">
                {{ $this->itemCount > 99 ? '99+' : $this->itemCount }}
            </span>
        @endif
        
        <!-- Tooltip melhorado -->
        <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-gray-800 to-gray-900 text-white text-sm px-4 py-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-2xl">
            <span class="font-medium">🛒 Carrinho</span>
            <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-800"></div>
        </div>
    </button>

    <!-- Cart Dropdown -->
    @if($isOpen)
        <div class="fixed top-20 right-4 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50" 
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
                        <h3 class="font-semibold text-gray-900">Seu Carrinho</h3>
                        <p class="text-sm text-gray-500">{{ $this->itemCount }} {{ $this->itemCount === 1 ? 'item' : 'itens' }}</p>
                    </div>
                    <button wire:click="toggleCart" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4 max-h-80 overflow-y-auto">
                    @forelse($cartItems as $item)
                        <div class="bg-gray-50 rounded-xl p-4" wire:key="cart-item-{{ $item['id'] }}">
                            <div class="flex items-start space-x-3">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($item['image'])
                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl">📦</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-sm text-gray-900">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-gray-500 mb-2">SKU: {{ $item['sku'] ?? 'N/A' }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center bg-white rounded-lg border border-gray-200">
                                            <button wire:click="decreaseQuantity({{ $item['id'] }})" class="p-2 hover:bg-gray-100 rounded-l-lg transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span class="px-3 py-2 text-sm font-medium min-w-[40px] text-center">{{ $item['quantity'] }}</span>
                                            <button wire:click="increaseQuantity({{ $item['id'] }})" class="p-2 hover:bg-gray-100 rounded-r-lg transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Price -->
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500">{{ number_format($item['price'], 0, ',', '.') }} Kz cada</p>
                                            <p class="font-semibold text-sm text-orange-600">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} Kz</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Remove Button -->
                                <button wire:click="removeItem({{ $item['id'] }})" class="text-gray-400 hover:text-red-500 p-1 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H17M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8"></path>
                            </svg>
                            <p class="text-sm">Seu carrinho está vazio</p>
                        </div>
                    @endforelse
                </div>
                
                @if(count($cartItems) > 0)
                    <!-- Cart Summary -->
                    <div class="border-t border-gray-200 mt-4 pt-4 space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">{{ number_format($this->total, 0, ',', '.') }} Kz</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Entrega:</span>
                            <span class="text-green-600 font-medium">Grátis</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Taxa:</span>
                            <span class="font-medium">{{ number_format($this->total * 0.1, 0, ',', '.') }} Kz</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900">Total:</span>
                                <span class="font-bold text-lg text-orange-600">{{ number_format($this->total * 1.1, 0, ',', '.') }} Kz</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-4 space-y-2">
                        <button wire:click="checkout" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg disabled:opacity-50">
                            <span wire:loading.remove wire:target="checkout">Finalizar Compra</span>
                            <span wire:loading wire:target="checkout">Processando...</span>
                        </button>
                        <button wire:click="clearCart" class="w-full text-gray-600 hover:text-gray-800 py-2 text-sm font-medium transition-colors">
                            Limpar Carrinho
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
