<div class="min-h-screen bg-gray-50 flex flex-col" wire:loading.class="opacity-75">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white shadow-xl">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="w-7 h-7 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">POS - Ponto de Venda</h1>
                        <p class="text-primary-100 text-sm flex items-center gap-1">
                            <i data-lucide="zap" class="w-3 h-3"></i>
                            Sistema rápido de vendas
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold flex items-center justify-center gap-1">
                            <i data-lucide="package" class="w-5 h-5"></i>
                            {{ $cartItemCount }}
                        </div>
                        <div class="text-xs text-primary-100">Itens</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold flex items-center justify-center gap-1">
                            <i data-lucide="coins" class="w-5 h-5"></i>
                            {{ number_format($cartTotal, 0) }}
                        </div>
                        <div class="text-xs text-primary-100">Total (Kz)</div>
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
                                   wire:model.live.debounce.500ms="search"
                                   placeholder="Buscar produto, SKU ou código de barras..."
                                   class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i data-lucide="loader-2" class="w-5 h-5 text-primary-500 animate-spin"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select wire:model.live="categoryFilter" class="w-full py-3 pl-3 pr-10 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                            <option value="">📁 Todas categorias</option>
                            @foreach($this->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select wire:model.live="brandFilter" class="w-full py-3 pl-3 pr-10 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                            <option value="">🏷️ Todas marcas</option>
                            @foreach($this->brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" wire:model.live="showOnlyInStock" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900 flex items-center gap-1">
                                <i data-lucide="package-check" class="w-4 h-4"></i>
                                Apenas em estoque
                            </span>
                        </label>
                        <button wire:click="$set('search', ''); $set('categoryFilter', ''); $set('brandFilter', ''); $set('showOnlyInStock', false);"
                                class="text-xs text-gray-600 hover:text-primary-600 flex items-center gap-1 px-2 py-1 rounded-lg hover:bg-gray-100 transition-colors">
                            <i data-lucide="x-circle" class="w-3 h-3"></i>
                            Limpar filtros
                        </button>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700">
                            <i data-lucide="box" class="w-4 h-4 inline"></i>
                            Exibindo: <strong class="text-primary-600">{{ $products->count() }}</strong> de <strong>{{ $products->total() }}</strong>
                        </span>
                        <div wire:loading wire:target="categoryFilter,brandFilter,showOnlyInStock,search" class="text-sm text-primary-600 flex items-center gap-1">
                            <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                            Carregando...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto p-4">
                <div class="mb-3 text-xs text-gray-500 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    Total de produtos ativos: <strong>{{ $products->total() }}</strong> | Mostrando nesta página: <strong>{{ $products->count() }}</strong>
                </div>
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 cursor-pointer group border border-gray-100"
                                 wire:click="addToCart({{ $product->id }})"
                                 wire:loading.class="opacity-50 pointer-events-none"
                                 wire:target="addToCart">
                                <div class="p-4">
                                    @if($product->featured_image_url)
                                        <img src="{{ $product->featured_image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-32 object-cover rounded-lg mb-3">
                                    @else
                                        <div class="w-full h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl mb-3 flex items-center justify-center">
                                            <i data-lucide="package" class="w-12 h-12 text-gray-400"></i>
                                        </div>
                                    @endif
                                    
                                    <h3 class="font-semibold text-sm text-gray-900 mb-1 group-hover:text-primary-600 transition-colors" title="{{ $product->name }}">
                                        {{ Str::limit($product->name, 30) }}
                                    </h3>
                                    
                                    <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                                        <i data-lucide="tag" class="w-3 h-3"></i>
                                        {{ $product->category->name }}
                                    </p>
                                    
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
                                                <div class="text-xs font-medium {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }} flex items-center gap-1 justify-end">
                                                    <i data-lucide="{{ $product->stock_quantity > 0 ? 'check-circle' : 'x-circle' }}" class="w-3 h-3"></i>
                                                    {{ $product->stock_quantity > 0 ? $product->stock_quantity : 'Esgotado' }}
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
                    <div class="text-center py-16">
                        <div class="mb-4">
                            <i data-lucide="inbox" class="mx-auto w-16 h-16 text-gray-300"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Nenhum produto encontrado</h3>
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
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="w-5 h-5 text-primary-600"></i>
                        Carrinho
                    </h2>
                    <div class="flex space-x-2">
                        <button wire:click="toggleCartDetails" 
                                class="p-2 text-gray-600 hover:text-gray-900 rounded-xl hover:bg-gray-200 transition-colors">
                            <i data-lucide="chevron-{{ $showCartDetails ? 'up' : 'down' }}" class="w-5 h-5"></i>
                        </button>
                        @if(!empty($cart))
                            <button wire:click="clearCart" 
                                    class="p-2 text-red-600 hover:text-red-700 rounded-xl hover:bg-red-50 transition-colors">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
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
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-medium text-sm text-gray-900 flex-1">{{ $item['name'] }}</h4>
                                    <button wire:click="removeFromCart('{{ $itemId }}')" 
                                            class="text-red-500 hover:text-red-700 p-1 rounded-lg hover:bg-red-50 transition-all">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-1">
                                        <button wire:click="updateQuantity('{{ $itemId }}', {{ max(1, $item['quantity'] - 1) }})"
                                                class="w-9 h-9 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center hover:from-primary-100 hover:to-primary-200 hover:text-primary-700 transition-all active:scale-95">
                                            <i data-lucide="minus" class="w-4 h-4"></i>
                                        </button>
                                        
                                        <input type="number" 
                                               wire:model.blur="cart.{{ $itemId }}.quantity"
                                               wire:change="updateQuantity('{{ $itemId }}', $event.target.value)"
                                               class="w-14 h-9 text-center font-bold border-2 border-gray-200 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-200"
                                               min="1">
                                        
                                        <button wire:click="updateQuantity('{{ $itemId }}', {{ $item['quantity'] + 1 }})"
                                                class="w-9 h-9 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center hover:from-primary-100 hover:to-primary-200 hover:text-primary-700 transition-all active:scale-95">
                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="font-bold text-gray-900">{{ number_format($item['total'], 0) }} Kz</div>
                                        <div class="text-xs text-gray-500 flex items-center gap-1 justify-end">
                                            <i data-lucide="tag" class="w-3 h-3"></i>
                                            {{ number_format($item['price'], 0) }} Kz
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center p-8">
                        <div class="text-center">
                            <div class="mb-4">
                                <i data-lucide="shopping-cart" class="mx-auto w-16 h-16 text-gray-300"></i>
                            </div>
                            <p class="text-gray-600 font-medium mb-1">Carrinho vazio</p>
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
                        <div class="relative flex-1">
                            <input type="number" 
                                   wire:model.blur="discountPercentage"
                                   placeholder="Desconto %"
                                   min="0" max="100"
                                   class="w-full px-3 py-2 pl-9 border-2 border-gray-200 rounded-xl text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="percent" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                        <button wire:click="applyDiscount" 
                                class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 text-sm font-medium transition-all active:scale-95 flex items-center gap-1">
                            <i data-lucide="badge-percent" class="w-4 h-4"></i>
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
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-xl font-bold hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl active:scale-[0.98] flex items-center justify-center gap-2">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
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
