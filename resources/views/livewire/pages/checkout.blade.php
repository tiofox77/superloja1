<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">🛒 Finalizar Compra</h1>
            <p class="text-gray-600">Complete os dados para finalizar seu pedido</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details (Left Column) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Items Review -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        📦 <span class="ml-2">Seus Itens</span>
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg border" wire:key="checkout-{{ $item['id'] }}">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if(isset($item['image']) && $item['image'])
                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl">📦</span>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-500">SKU: {{ $item['sku'] ?? 'N/A' }}</p>
                                    <p class="text-lg font-bold text-orange-600">{{ number_format($item['price'], 0, ',', '.') }} Kz cada</p>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center bg-white rounded-lg border border-gray-200">
                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                                class="p-2 hover:bg-gray-100 rounded-l-lg">-</button>
                                        <span class="px-4 py-2 font-medium">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                                class="p-2 hover:bg-gray-100 rounded-r-lg">+</button>
                                    </div>
                                    
                                    <button wire:click="removeItem({{ $item['id'] }})" 
                                            class="text-red-500 hover:text-red-700 p-2">🗑️</button>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-bold text-lg text-gray-900">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} Kz</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        🚚 <span class="ml-2">Dados de Entrega</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                            <input type="text" wire:model="delivery_name" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
                            @error('delivery_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                            <input type="tel" wire:model="delivery_phone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                                   placeholder="+244 XXX XXX XXX">
                            @error('delivery_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Endereço Completo *</label>
                            <textarea wire:model="delivery_address" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                                      placeholder="Rua, número, bairro..."></textarea>
                            @error('delivery_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cidade *</label>
                            <input type="text" wire:model="delivery_city" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200">
                            @error('delivery_city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                            <input type="text" wire:model="delivery_notes" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                                   placeholder="Pontos de referência...">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        💳 <span class="ml-2">Método de Pagamento</span>
                    </h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $payment_method === 'bank_transfer' ? 'border-orange-500 bg-orange-50' : '' }}">
                            <input type="radio" wire:model="payment_method" value="bank_transfer" class="text-orange-500">
                            <div class="ml-3 flex-1">
                                <div class="font-medium text-gray-900">🏦 Transferência Bancária</div>
                                <div class="text-sm text-gray-500">Transfira para nossa conta bancária</div>
                                @if($payment_method === 'bank_transfer')
                                    <div class="mt-2 p-2 bg-blue-50 rounded-lg text-sm">
                                        <strong>Dados Bancários:</strong><br>
                                        Banco: BFA - Banco de Fomento Angola<br>
                                        Conta: 0000 0000 0000 0000<br>
                                        IBAN: AO06 0000 0000 0000 0000 0000 0
                                    </div>
                                @endif
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $payment_method === 'bank_deposit' ? 'border-orange-500 bg-orange-50' : '' }}">
                            <input type="radio" wire:model="payment_method" value="bank_deposit" class="text-orange-500">
                            <div class="ml-3 flex-1">
                                <div class="font-medium text-gray-900">🏪 Depósito Bancário</div>
                                <div class="text-sm text-gray-500">Deposite diretamente no banco</div>
                                @if($payment_method === 'bank_deposit')
                                    <div class="mt-2 p-2 bg-blue-50 rounded-lg text-sm">
                                        <strong>Dados para Depósito:</strong><br>
                                        Beneficiário: SuperLoja Angola<br>
                                        Banco: BFA<br>
                                        Conta: 0000 0000 0000 0000
                                    </div>
                                @endif
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $payment_method === 'multicaixa' ? 'border-orange-500 bg-orange-50' : '' }}">
                            <input type="radio" wire:model="payment_method" value="multicaixa" class="text-orange-500">
                            <div class="ml-3 flex-1">
                                <div class="font-medium text-gray-900">📱 Multicaixa Express</div>
                                <div class="text-sm text-gray-500">Pagamento via aplicativo Multicaixa</div>
                                @if($payment_method === 'multicaixa')
                                    <div class="mt-2 p-2 bg-blue-50 rounded-lg text-sm">
                                        <strong>Dados Multicaixa:</strong><br>
                                        Número: +244 923 456 789<br>
                                        Nome: SuperLoja Angola
                                    </div>
                                @endif
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $payment_method === 'cash_on_delivery' ? 'border-orange-500 bg-orange-50' : '' }}">
                            <input type="radio" wire:model="payment_method" value="cash_on_delivery" class="text-orange-500">
                            <div class="ml-3 flex-1">
                                <div class="font-medium text-gray-900">💵 Pagamento na Entrega</div>
                                <div class="text-sm text-gray-500">Pague em dinheiro quando receber</div>
                                @if($payment_method === 'cash_on_delivery')
                                    <div class="mt-2 p-2 bg-yellow-50 rounded-lg text-sm text-yellow-800">
                                        ⚠️ Tenha o valor exato ou próximo para facilitar o troco.
                                    </div>
                                @endif
                            </div>
                        </label>
                    </div>

                    <!-- Payment Proof Upload -->
                    @if(in_array($payment_method, ['bank_transfer', 'bank_deposit', 'multicaixa']))
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h3 class="font-medium text-yellow-800 mb-3 flex items-center">
                                📎 <span class="ml-2">Comprovativo de Pagamento</span>
                            </h3>
                            
                            <div class="space-y-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Obrigatório:</strong> Anexe o comprovativo do pagamento (screenshot, foto ou PDF).
                                </p>
                                
                                <div class="flex flex-col space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Selecionar Arquivo:</label>
                                    <input type="file" wire:model="payment_proof" accept="image/*,.pdf" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition-colors">
                                    @error('payment_proof') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                @if($payment_proof)
                                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                        <div class="flex items-center text-green-700">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Arquivo anexado: {{ $payment_proof->getClientOriginalName() }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded">
                                    <strong>Formatos aceitos:</strong> JPG, PNG, PDF (máx. 10MB)<br>
                                    <strong>Dica:</strong> Certifique-se de que o comprovativo seja legível e contenha todas as informações.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary (Right Column) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        📊 <span class="ml-2">Resumo do Pedido</span>
                    </h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">{{ number_format($subtotal, 0, ',', '.') }} Kz</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Taxa (10%):</span>
                            <span class="font-medium">{{ number_format($tax, 0, ',', '.') }} Kz</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Entrega:</span>
                            <span class="text-green-600 font-medium">Grátis</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-900">Total:</span>
                                <span class="text-2xl font-black text-orange-600">{{ number_format($total, 0, ',', '.') }} Kz</span>
                            </div>
                        </div>
                    </div>
                    
                    <button wire:click="placeOrder" wire:loading.attr="disabled"
                            onclick="console.log('Botão clicado!')"
                            class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-4 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg disabled:opacity-50">
                        <span wire:loading.remove wire:target="placeOrder">✅ Finalizar Pedido</span>
                        <span wire:loading wire:target="placeOrder">🔄 Processando...</span>
                    </button>
                    
                    <p class="text-xs text-gray-500 mt-4 text-center">
                        🔒 Seus dados estão seguros e protegidos
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
