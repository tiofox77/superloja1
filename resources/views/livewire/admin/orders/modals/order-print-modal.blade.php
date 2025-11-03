<div>
    @if($showPrintModal && $selectedOrder)
        <!-- Modal Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
             x-show="@entangle('showPrintModal')"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <!-- Modal Container -->
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden"
                 x-show="@entangle('showPrintModal')"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="$wire.closePrintModal()">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-6 rounded-t-2xl print:hidden">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold flex items-center">
                                <span class="mr-3">🖨️</span> Imprimir Pedido
                            </h2>
                            <p class="text-green-100 mt-1">Pedido #{{ $selectedOrder->order_number }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button onclick="window.print()" 
                                    class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
                                <span class="mr-2">🖨️</span> Imprimir
                            </button>
                            <button wire:click="closePrintModal" class="text-white hover:text-gray-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Printable Content -->
                <div class="overflow-y-auto max-h-[calc(90vh-120px)] print:max-h-none print:overflow-visible">
                    <div id="printable-content" class="p-8 print:p-0">
                        <!-- Company Header -->
                        <div class="text-center mb-8 print:mb-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="bg-gradient-to-br from-orange-500 via-orange-600 to-red-500 text-white p-3 rounded-2xl shadow-lg">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                                        <path d="M9 8V17H11V8H9ZM13 8V17H15V8H13Z"/>
                                    </svg>
                                </div>
                            </div>
                            <h1 class="text-3xl font-black text-gray-900 mb-2">SuperLoja</h1>
                            <p class="text-gray-600">Angola - Luanda</p>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <h2 class="text-xl font-bold text-gray-900">RECIBO DE PEDIDO</h2>
                                <p class="text-gray-600 mt-1">Pedido #{{ $selectedOrder->order_number }}</p>
                            </div>
                        </div>

                        <!-- Order Details Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <!-- Customer Info -->
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    Informações do Cliente
                                </h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium">Nome:</span> {{ $selectedOrder->user->name ?? 'N/A' }}</p>
                                    <p><span class="font-medium">Email:</span> {{ $selectedOrder->user->email ?? 'N/A' }}</p>
                                    <p><span class="font-medium">Telefone:</span> {{ $selectedOrder->user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Order Info -->
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    Detalhes do Pedido
                                </h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium">Data:</span> {{ $selectedOrder->created_at->format('d/m/Y H:i') }}</p>
                                    <p><span class="font-medium">Status:</span> {{ ucfirst($selectedOrder->status) }}</p>
                                    <p><span class="font-medium">Pagamento:</span> {{ ucfirst($selectedOrder->payment_status) }}</p>
                                    <p><span class="font-medium">Método:</span> {{ $selectedOrder->payment_method ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        @if($selectedOrder->shipping_address)
                            <div class="mb-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    Endereço de Entrega
                                </h3>
                                @php
                                    $shippingAddress = is_string($selectedOrder->shipping_address) 
                                        ? json_decode($selectedOrder->shipping_address, true) 
                                        : $selectedOrder->shipping_address;
                                @endphp
                                @if($shippingAddress)
                                    <div class="bg-gray-50 p-4 rounded-lg print:bg-white print:border print:border-gray-300">
                                        <p><span class="font-medium">Nome:</span> {{ $shippingAddress['name'] ?? 'N/A' }}</p>
                                        <p><span class="font-medium">Telefone:</span> {{ $shippingAddress['phone'] ?? 'N/A' }}</p>
                                        <p><span class="font-medium">Endereço:</span> {{ $shippingAddress['address'] ?? 'N/A' }}</p>
                                        <p><span class="font-medium">Cidade:</span> {{ $shippingAddress['city'] ?? 'N/A' }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Order Items Table -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                Itens do Pedido
                            </h3>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-50 print:bg-gray-100">
                                            <th class="border border-gray-300 px-4 py-3 text-left font-medium text-gray-900">Produto</th>
                                            <th class="border border-gray-300 px-4 py-3 text-left font-medium text-gray-900">SKU</th>
                                            <th class="border border-gray-300 px-4 py-3 text-right font-medium text-gray-900">Preço Unit.</th>
                                            <th class="border border-gray-300 px-4 py-3 text-center font-medium text-gray-900">Qtd</th>
                                            <th class="border border-gray-300 px-4 py-3 text-right font-medium text-gray-900">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($selectedOrder->items as $item)
                                            <tr>
                                                <td class="border border-gray-300 px-4 py-3">
                                                    <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                                    @if($item->product && $item->product->name !== $item->product_name)
                                                        <div class="text-sm text-gray-600">{{ $item->product->name }}</div>
                                                    @endif
                                                </td>
                                                <td class="border border-gray-300 px-4 py-3 text-gray-600">
                                                    {{ $item->product_sku ?? 'N/A' }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-3 text-right">
                                                    {{ number_format($item->unit_price, 2, ',', '.') }} Kz
                                                </td>
                                                <td class="border border-gray-300 px-4 py-3 text-center">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-3 text-right font-medium">
                                                    {{ number_format($item->total_price, 2, ',', '.') }} Kz
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50 print:bg-gray-100">
                                            <td colspan="4" class="border border-gray-300 px-4 py-3 text-right font-bold text-gray-900">
                                                TOTAL DO PEDIDO:
                                            </td>
                                            <td class="border border-gray-300 px-4 py-3 text-right font-bold text-xl text-green-600">
                                                {{ number_format($selectedOrder->total_amount, 2, ',', '.') }} Kz
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($selectedOrder->notes)
                            <div class="mb-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    Observações
                                </h3>
                                <div class="bg-yellow-50 p-4 rounded-lg print:bg-white print:border print:border-gray-300">
                                    <p class="text-gray-900">{{ $selectedOrder->notes }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Footer -->
                        <div class="mt-12 pt-8 border-t border-gray-300 text-center text-sm text-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-6">
                                <div>
                                    <p class="font-medium text-gray-900">SuperLoja Angola</p>
                                    <p>Luanda, Angola</p>
                                    <p>contato@superloja.vip</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Suporte</p>
                                    <p>+244 923 456 789</p>
                                    <p>Segunda à Sexta: 8h-18h</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Impresso em</p>
                                    <p>{{ now()->format('d/m/Y H:i:s') }}</p>
                                    <p>por: {{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <p>&copy; {{ date('Y') }} SuperLoja Angola. Todos os direitos reservados.</p>
                                <p class="mt-2">Este documento é um recibo oficial do pedido #{{ $selectedOrder->order_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-between print:hidden">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="mr-2">💡</span>
                        Use Ctrl+P ou ⌘+P para imprimir
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.print()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
                            <span class="mr-2">🖨️</span> Imprimir
                        </button>
                        <button wire:click="closePrintModal" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Styles -->
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                #printable-content, #printable-content * {
                    visibility: visible;
                }
                #printable-content {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }
                .print\\:hidden {
                    display: none !important;
                }
                .print\\:bg-white {
                    background-color: white !important;
                }
                .print\\:border {
                    border: 1px solid #d1d5db !important;
                }
                .print\\:border-gray-300 {
                    border-color: #d1d5db !important;
                }
                .print\\:bg-gray-100 {
                    background-color: #f3f4f6 !important;
                }
                .print\\:max-h-none {
                    max-height: none !important;
                }
                .print\\:overflow-visible {
                    overflow: visible !important;
                }
                .print\\:p-0 {
                    padding: 0 !important;
                }
                .print\\:mb-6 {
                    margin-bottom: 1.5rem !important;
                }
            }
        </style>
    @endif
</div>
