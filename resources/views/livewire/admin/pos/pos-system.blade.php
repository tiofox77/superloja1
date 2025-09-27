<div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">POS - Ponto de Venda</h1>
                        <p class="text-blue-100 text-sm">Sistema de vendas SuperLoja</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $cartItemCount }}</div>
                        <div class="text-xs text-blue-100">Itens</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ number_format($cartTotal, 2) }} Kz</div>
                        <div class="text-xs text-blue-100">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex overflow-hidden">
        <!-- Left Panel - Products -->
        <div class="flex-1 flex flex-col">
            <!-- Search and Filters -->
            <div class="bg-white shadow-sm border-b p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live.debounce.300ms="search"
                                   placeholder="Buscar produto, SKU ou código de barras..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <select wire:model.live="categoryFilter" class="w-full py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Todas as categorias</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <select wire:model.live="brandFilter" class="w-full py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Todas as marcas</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model.live="showOnlyInStock" class="checkbox-modern">
                        <span class="ml-2 text-sm text-gray-700">Apenas produtos em estoque</span>
                    </label>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto p-4">
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 cursor-pointer"
                                 wire:click="addToCart({{ $product->id }})">
                                <div class="p-4">
                                    @if($product->featured_image_url)
                                        <img src="{{ $product->featured_image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-32 object-cover rounded-lg mb-3">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <h3 class="font-semibold text-sm text-gray-900 mb-1" title="{{ $product->name }}">
                                        {{ Str::limit($product->name, 30) }}
                                    </h3>
                                    
                                    <p class="text-xs text-gray-500 mb-2">{{ $product->category->name }}</p>
                                    
                                    <div class="flex justify-between items-center">
                                        <div>
                                            @if($product->sale_price)
                                                <span class="text-lg font-bold text-green-600">{{ number_format($product->sale_price, 2) }} Kz</span>
                                                <br>
                                                <span class="text-xs text-gray-500 line-through">{{ number_format($product->price, 2) }} Kz</span>
                                            @else
                                                <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 2) }} Kz</span>
                                            @endif
                                        </div>
                                        
                                        @if($product->manage_stock)
                                            <div class="text-right">
                                                <div class="text-xs {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $product->stock_quantity > 0 ? $product->stock_quantity . ' em estoque' : 'Sem estoque' }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum produto encontrado</h3>
                        <p class="text-gray-500">Ajuste os filtros ou verifique se existem produtos em estoque.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Panel - Cart -->
        <div class="w-96 bg-white shadow-lg border-l flex flex-col">
            <!-- Cart Header -->
            <div class="p-4 border-b bg-gray-50">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900">Carrinho</h2>
                    <div class="flex space-x-2">
                        <button wire:click="toggleCartDetails" 
                                class="p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        @if(!empty($cart))
                            <button wire:click="clearCart" 
                                    class="p-2 text-red-600 hover:text-red-800 rounded-lg hover:bg-red-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto">
                @if(!empty($cart))
                    <div class="divide-y divide-gray-200">
                        @foreach($cart as $itemId => $item)
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-sm text-gray-900">{{ $item['name'] }}</h4>
                                    <button wire:click="removeFromCart('{{ $itemId }}')" 
                                            class="text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="updateQuantity('{{ $itemId }}', {{ $item['quantity'] - 1 }})"
                                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        
                                        <span class="w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                                        
                                        <button wire:click="updateQuantity('{{ $itemId }}', {{ $item['quantity'] + 1 }})"
                                                class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="font-semibold">{{ number_format($item['total'], 2) }} Kz</div>
                                        <div class="text-xs text-gray-500">{{ number_format($item['price'], 2) }} Kz cada</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center p-8">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            <p class="text-gray-500">Carrinho vazio</p>
                            <p class="text-sm text-gray-400">Clique nos produtos para adicionar</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Cart Summary -->
            @if(!empty($cart))
                <div class="border-t bg-gray-50 p-4 space-y-3">
                    <!-- Discount -->
                    <div class="flex items-center space-x-2">
                        <input type="number" 
                               wire:model.live="discountPercentage"
                               placeholder="Desconto %"
                               min="0" max="100"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <button wire:click="applyDiscount" 
                                class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm">
                            Aplicar
                        </button>
                    </div>

                    @if($showCartDetails)
                        <!-- Totals -->
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span>{{ number_format($cartSubtotal, 2) }} Kz</span>
                            </div>
                            
                            @if($cartDiscount > 0)
                                <div class="flex justify-between text-orange-600">
                                    <span>Desconto ({{ $discountPercentage }}%):</span>
                                    <span>-{{ number_format($cartDiscount, 2) }} Kz</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">IVA ({{ $taxRate }}%):</span>
                                <span>{{ number_format($cartTax, 2) }} Kz</span>
                            </div>
                            
                            <div class="border-t pt-2 flex justify-between font-bold text-lg">
                                <span>Total:</span>
                                <span>{{ number_format($cartTotal, 2) }} Kz</span>
                            </div>
                        </div>
                    @endif

                    <!-- Checkout Button -->
                    <button wire:click="openPaymentModal" 
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-lg font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-200">
                        Processar Venda
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Modal -->
    @if($showPaymentModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-900">Processar Pagamento</h3>
                        <button wire:click="closePaymentModal" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Total -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($cartTotal, 2) }} Kz</div>
                        <div class="text-sm text-gray-600">Total a pagar</div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pagamento</label>
                        <select wire:model.live="paymentMethod" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="cash">Dinheiro</option>
                            <option value="card">Cartão</option>
                            <option value="transfer">Transferência</option>
                            <option value="multicaixa">Multicaixa Express</option>
                        </select>
                    </div>

                    @if($paymentMethod === 'cash')
                        <!-- Amount Received -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Valor Recebido</label>
                            <input type="number" 
                                   wire:model.live="amountReceived"
                                   step="0.01"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        </div>

                        <!-- Change -->
                        @if($change > 0)
                            <div class="p-3 bg-green-50 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-green-800">Troco:</span>
                                    <span class="text-lg font-bold text-green-800">{{ number_format($change, 2) }} Kz</span>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Customer Info -->
                    <div class="space-y-3">
                        <h4 class="font-medium text-gray-900">Informações do Cliente (Opcional)</h4>
                        <input type="text" 
                               wire:model="customerName"
                               placeholder="Nome do cliente"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <input type="email" 
                               wire:model="customerEmail"
                               placeholder="Email do cliente"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <input type="tel" 
                               wire:model="customerPhone"
                               placeholder="Telefone do cliente"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                        <textarea wire:model="notes" 
                                  rows="2"
                                  placeholder="Observações da venda..."
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                    </div>
                </div>

                <div class="p-6 border-t bg-gray-50 rounded-b-2xl">
                    <div class="flex space-x-3">
                        <button wire:click="closePaymentModal" 
                                class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button wire:click="processSale" 
                                class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-2 rounded-lg font-medium hover:from-green-600 hover:to-emerald-700">
                            Finalizar Venda
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Listen for receipt printing
        Livewire.on('printReceipt', (event) => {
            console.log('Receipt for order:', event[0].orderId);
            // Implement receipt printing logic here
        });

        // Alerts are handled globally by the admin layout

        // Barcode scanner support
        let barcodeBuffer = '';
        let barcodeTimeout;

        document.addEventListener('keydown', function(e) {
            // If Enter key is pressed and we have a barcode buffer
            if (e.key === 'Enter' && barcodeBuffer.length > 0) {
                e.preventDefault();
                Livewire.dispatch('productScanned', [barcodeBuffer]);
                barcodeBuffer = '';
                return;
            }

            // If alphanumeric key, add to buffer
            if (/^[a-zA-Z0-9]$/.test(e.key)) {
                barcodeBuffer += e.key;
                
                // Clear buffer after 100ms of inactivity
                clearTimeout(barcodeTimeout);
                barcodeTimeout = setTimeout(() => {
                    barcodeBuffer = '';
                }, 100);
            }
        });
    });
</script>
