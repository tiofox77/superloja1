<div>
    @if($showViewModal && $selectedOrder)
        <!-- Modal Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
             x-show="@entangle('showViewModal')"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <!-- Modal Container -->
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                 x-show="@entangle('showViewModal')"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="$wire.closeViewModal()">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold flex items-center">
                                <span class="mr-3">📋</span> Detalhes do Pedido
                            </h2>
                            <p class="text-blue-100 mt-1">Pedido #{{ $selectedOrder->order_number }}</p>
                        </div>
                        <button wire:click="closeViewModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Order Info Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Customer Info -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="mr-2">👤</span> Informações do Cliente
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Nome:</span>
                                    <p class="text-gray-900">{{ $selectedOrder->user->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Email:</span>
                                    <p class="text-gray-900">{{ $selectedOrder->user->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Telefone:</span>
                                    <p class="text-gray-900">{{ $selectedOrder->user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="mr-2">📦</span> Detalhes do Pedido
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Data:</span>
                                    <p class="text-gray-900">{{ $selectedOrder->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Status:</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($selectedOrder->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($selectedOrder->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($selectedOrder->status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($selectedOrder->status === 'delivered') bg-green-100 text-green-800
                                        @elseif($selectedOrder->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($selectedOrder->status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Pagamento:</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($selectedOrder->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($selectedOrder->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($selectedOrder->payment_status === 'failed') bg-red-100 text-red-800
                                        @elseif($selectedOrder->payment_status === 'refunded') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($selectedOrder->payment_status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Método de Pagamento:</span>
                                    <p class="text-gray-900">{{ $selectedOrder->payment_method ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    @if($selectedOrder->shipping_address)
                        <div class="bg-blue-50 rounded-xl p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="mr-2">🚚</span> Endereço de Entrega
                            </h3>
                            @php
                                $shippingAddress = is_string($selectedOrder->shipping_address) 
                                    ? json_decode($selectedOrder->shipping_address, true) 
                                    : $selectedOrder->shipping_address;
                            @endphp
                            @if($shippingAddress)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Nome:</span>
                                        <p class="text-gray-900">{{ $shippingAddress['name'] ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Telefone:</span>
                                        <p class="text-gray-900">{{ $shippingAddress['phone'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <span class="text-sm font-medium text-gray-500">Endereço:</span>
                                        <p class="text-gray-900">{{ $shippingAddress['address'] ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Cidade:</span>
                                        <p class="text-gray-900">{{ $shippingAddress['city'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Order Items -->
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="mr-2">🛍️</span> Itens do Pedido
                            </h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unit.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qtd</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($selectedOrder->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($item->product && $item->product->main_image)
                                                        <img src="{{ Storage::url($item->product->main_image) }}" 
                                                             alt="{{ $item->product_name }}" 
                                                             class="w-12 h-12 rounded-lg object-cover mr-4">
                                                    @else
                                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                                            <span class="text-gray-500 text-xs">📦</span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                                                        @if($item->product)
                                                            <p class="text-sm text-gray-500">{{ $item->product->name }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->product_sku ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ number_format($item->unit_price, 2, ',', '.') }} Kz
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ number_format($item->total_price, 2, ',', '.') }} Kz
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Proof Section -->
                    @if($selectedOrder->payment_proof)
                        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="mr-2">📎</span> Comprovativo de Pagamento
                            </h3>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    @php
                                        $extension = strtolower(pathinfo($selectedOrder->payment_proof, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                                        $isPdf = $extension === 'pdf';
                                    @endphp
                                    
                                    @if($isImage)
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @elseif($isPdf)
                                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            Comprovativo anexado
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Tipo: {{ strtoupper($extension) }} | 
                                            Método: {{ ucfirst($selectedOrder->payment_method) }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    @if($isImage || $isPdf)
                                        <button onclick="window.open('{{ route('admin.orders.view-proof', $selectedOrder->id) }}', '_blank')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </button>
                                    @endif
                                    
                                    <button wire:click="downloadPaymentProof({{ $selectedOrder->id }})"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Baixar
                                    </button>
                                </div>
                            </div>
                            
                            @if($isImage)
                                <!-- Quick Preview for Images -->
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 mb-2">Pré-visualização:</p>
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <img src="{{ Storage::url($selectedOrder->payment_proof) }}" 
                                             alt="Comprovativo de pagamento" 
                                             class="w-full max-h-60 object-contain bg-gray-50"
                                             onclick="window.open('{{ route('admin.orders.view-proof', $selectedOrder->id) }}', '_blank')"
                                             style="cursor: pointer;">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Clique na imagem para visualizar em tamanho completo</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Order Summary -->
                    <div class="mt-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6">
                        <div class="flex justify-between items-center text-lg">
                            <span class="font-semibold text-gray-900">Total do Pedido:</span>
                            <span class="font-bold text-2xl text-green-600">
                                {{ number_format($selectedOrder->total_amount, 2, ',', '.') }} Kz
                            </span>
                        </div>
                        @if($selectedOrder->notes)
                            <div class="mt-4 pt-4 border-t border-green-200">
                                <span class="text-sm font-medium text-gray-500">Observações:</span>
                                <p class="text-gray-900 mt-1">{{ $selectedOrder->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex flex-col sm:flex-row gap-3 justify-between">
                    <div class="flex flex-wrap gap-2">
                        <!-- Status Update Buttons -->
                        <select wire:change="updateOrderStatus({{ $selectedOrder->id }}, $event.target.value)" 
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Alterar Status</option>
                            <option value="pending" {{ $selectedOrder->status === 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="processing" {{ $selectedOrder->status === 'processing' ? 'selected' : '' }}>Em Processamento</option>
                            <option value="shipped" {{ $selectedOrder->status === 'shipped' ? 'selected' : '' }}>Enviado</option>
                            <option value="delivered" {{ $selectedOrder->status === 'delivered' ? 'selected' : '' }}>Entregue</option>
                            <option value="cancelled" {{ $selectedOrder->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        </select>

                        <select wire:change="updatePaymentStatus({{ $selectedOrder->id }}, $event.target.value)"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Status Pagamento</option>
                            <option value="pending" {{ $selectedOrder->payment_status === 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="paid" {{ $selectedOrder->payment_status === 'paid' ? 'selected' : '' }}>Pago</option>
                            <option value="failed" {{ $selectedOrder->payment_status === 'failed' ? 'selected' : '' }}>Falhou</option>
                            <option value="refunded" {{ $selectedOrder->payment_status === 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="printOrder({{ $selectedOrder->id }})" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
                            <span class="mr-2">🖨️</span> Imprimir
                        </button>
                        <button wire:click="closeViewModal" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
