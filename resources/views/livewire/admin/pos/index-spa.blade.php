<div class="h-[calc(100vh-140px)] flex gap-6" wire:ignore.self x-data x-init="$nextTick(() => lucide.createIcons())" @updated.window="$nextTick(() => lucide.createIcons())">
    <!-- Products -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Search & Filters -->
        <div class="flex gap-4 mb-4">
            <div class="flex-1">
                <x-admin.form.search wire:model.live.debounce.300ms="search" placeholder="Buscar produtos..." />
            </div>
            <select wire:model.live="categoryId" class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                <option value="">Todas Categorias</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Products Grid -->
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                @forelse($products as $product)
                    <button wire:click="addToCart({{ $product->id }})"
                            class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-primary-300 hover:shadow-md transition-all text-left group">
                        <div class="aspect-square relative bg-gray-100">
                            @if($product->featured_image)
                                <img src="{{ asset('storage/' . $product->featured_image) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i data-lucide="package" class="w-8 h-8 text-gray-300"></i>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 px-2 py-0.5 bg-black/60 text-white text-xs rounded">
                                {{ $product->stock_quantity }}
                            </div>
                            <div class="absolute inset-0 bg-primary-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow">
                                    <i data-lucide="plus" class="w-5 h-5 text-primary-600"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-2">
                            <p class="text-xs font-medium text-gray-900 truncate">{{ $product->name }}</p>
                            <p class="text-sm font-bold text-primary-600">{{ number_format($product->price, 0, ',', '.') }} Kz</p>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full py-12">
                        <x-admin.ui.empty-state 
                            icon="package" 
                            title="Nenhum produto encontrado"
                            description="Ajuste os filtros de busca." />
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Cart -->
    <div class="w-96 flex flex-col bg-white rounded-xl border border-gray-200 shadow-lg">
        <!-- Cart Header -->
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900 flex items-center gap-2">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                Carrinho
            </h2>
            @if(count($cart) > 0)
                <button wire:click="clearCart" wire:confirm="Limpar carrinho?" class="text-sm text-red-600 hover:text-red-700">
                    Limpar
                </button>
            @endif
        </div>
        
        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            @forelse($cart as $key => $item)
                <div class="flex gap-3 p-2 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 rounded bg-gray-200 overflow-hidden flex-shrink-0">
                        @if($item['image'])
                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i data-lucide="package" class="w-5 h-5 text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                        <p class="text-xs text-primary-600 font-semibold">{{ number_format($item['price'], 0, ',', '.') }} Kz</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                class="w-6 h-6 rounded bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </button>
                        <span class="w-8 text-center text-sm font-medium">{{ $item['quantity'] }}</span>
                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                class="w-6 h-6 rounded bg-gray-200 hover:bg-gray-300 flex items-center justify-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <i data-lucide="shopping-cart" class="w-12 h-12 mx-auto mb-2 text-gray-300"></i>
                    <p class="text-sm">Carrinho vazio</p>
                </div>
            @endforelse
        </div>
        
        @if(count($cart) > 0)
            <!-- Customer Info -->
            <div class="px-4 py-3 border-t border-gray-100 space-y-2">
                <input type="text" wire:model="customerName" placeholder="Nome do cliente (opcional)"
                       class="w-full rounded-lg border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                <input type="text" wire:model="customerPhone" placeholder="Telefone (opcional)"
                       class="w-full rounded-lg border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
            
            <!-- Payment -->
            <div class="px-4 py-3 border-t border-gray-100 space-y-3">
                <div class="flex gap-2">
                    @foreach(['cash' => 'Dinheiro', 'card' => 'Cartão', 'transfer' => 'Transfer.'] as $method => $label)
                        <button wire:click="$set('paymentMethod', '{{ $method }}')"
                                class="flex-1 py-2 text-xs font-medium rounded-lg transition-colors
                                       {{ $paymentMethod === $method ? 'bg-primary-100 text-primary-700 border-2 border-primary-500' : 'bg-gray-100 text-gray-600 border-2 border-transparent hover:bg-gray-200' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-500">Desconto (Kz)</label>
                        <input type="number" wire:model.live="discount" min="0" step="100"
                               class="w-full rounded-lg border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Valor Pago (Kz)</label>
                        <input type="number" wire:model.live="amountPaid" min="0" step="100"
                               class="w-full rounded-lg border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
            </div>
            
            <!-- Totals -->
            <div class="px-4 py-3 border-t border-gray-100 space-y-1 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal:</span>
                    <span>{{ number_format($this->subtotal, 2, ',', '.') }} Kz</span>
                </div>
                @if($discount > 0)
                    <div class="flex justify-between text-red-600">
                        <span>Desconto:</span>
                        <span>-{{ number_format($discount, 2, ',', '.') }} Kz</span>
                    </div>
                @endif
                <div class="flex justify-between text-lg font-bold text-gray-900">
                    <span>Total:</span>
                    <span>{{ number_format($this->total, 2, ',', '.') }} Kz</span>
                </div>
                @if($amountPaid >= $this->total && $amountPaid > 0)
                    <div class="flex justify-between text-green-600 font-medium">
                        <span>Troco:</span>
                        <span>{{ number_format($this->change, 2, ',', '.') }} Kz</span>
                    </div>
                @endif
            </div>
            
            <!-- Complete Button -->
            <div class="p-4 border-t border-gray-100">
                <x-admin.ui.button wire:click="completeSale" icon="check" class="w-full justify-center" size="lg">
                    Finalizar Venda
                </x-admin.ui.button>
            </div>
        @endif
    </div>
</div>
