<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <!-- Cart Button -->
    <button wire:click="toggleCart" class="relative p-3 text-gray-600 hover:text-orange-500 transition-colors rounded-lg hover:bg-orange-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
            <circle cx="9" cy="20" r="1"></circle>
            <circle cx="20" cy="20" r="1"></circle>
        </svg>
        @if($this->itemCount > 0)
            <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full min-w-[20px] h-5 flex items-center justify-center font-bold">
                {{ $this->itemCount }}
            </span>
        @endif
    </button>

    <!-- Cart Sidebar -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-hidden">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black/50 transition-opacity" 
                 wire:click="toggleCart">
            </div>

            <!-- Slide-over panel -->
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="w-screen max-w-md transform transition ease-in-out duration-500">
                    
                    <div class="flex h-full flex-col bg-white shadow-xl">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-6 py-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">
                                Carrinho de Compras
                                @if($this->itemCount > 0)
                                    <span class="ml-2 text-sm text-gray-500">({{ $this->itemCount }} item{{ $this->itemCount > 1 ? 's' : '' }})</span>
                                @endif
                            </h2>
                            <button wire:click="toggleCart" 
                                    class="text-gray-400 hover:text-gray-500 transition-colors">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Cart Items -->
                        <div class="flex-1 overflow-y-auto px-6 py-6">
                            @if(empty($items))
                                <!-- Empty Cart -->
                                <div class="flex flex-col items-center justify-center h-full text-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Carrinho vazio</h3>
                                    <p class="text-gray-500 mb-6">Adicione produtos ao seu carrinho para começar.</p>
                                    <button wire:click="toggleCart" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors">
                                        Continuar Comprando
                                    </button>
                                </div>
                            @else
                                <!-- Cart Items List -->
                                <div class="space-y-6">
                                    @foreach($items as $item)
                                        <div class="flex items-center space-x-4 group">
                                            <!-- Product Image -->
                                            <div class="h-16 w-16 flex-shrink-0 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>

                                            <!-- Product Info -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</h4>
                                                <p class="text-sm text-gray-500">{{ number_format($item['price'], 0, ',', '.') }} Kz</p>
                                                
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center mt-2 space-x-2">
                                                    <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    
                                                    <span class="min-w-[2rem] text-center text-sm font-medium">{{ $item['quantity'] }}</span>
                                                    
                                                    <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                                            class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Item Total & Remove -->
                                            <div class="flex flex-col items-end space-y-2">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} Kz
                                                </p>
                                                <button wire:click="removeItem({{ $item['id'] }})"
                                                        class="text-red-600 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Footer with Totals and Checkout -->
                        @if(!empty($items))
                            <div class="border-t border-gray-200 px-6 py-6">
                                <!-- Totals -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="text-gray-900">{{ number_format($this->total, 0, ',', '.') }} Kz</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Entrega</span>
                                        <span class="text-gray-900">Grátis</span>
                                    </div>
                                    <div class="border-t pt-2">
                                        <div class="flex justify-between text-base font-medium">
                                            <span class="text-gray-900">Total</span>
                                            <span class="text-gray-900">{{ number_format($this->total, 0, ',', '.') }} Kz</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Checkout Buttons -->
                                <div class="space-y-3">
                                    <button class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                                        Finalizar Compra
                                    </button>
                                    <button wire:click="toggleCart" class="w-full text-orange-500 border border-orange-500 py-3 px-4 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                                        Continuar Comprando
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
