<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold flex items-center">
                <span class="mr-3">📦</span> Meus Pedidos
            </h1>
            <p class="text-purple-100 mt-2">Acompanhe o status dos seus pedidos</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <div class="flex flex-wrap gap-4 mb-8">
            <a href="{{ route('user.dashboard') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">📊 Dashboard</a>
            <button class="bg-purple-600 text-white px-6 py-3 rounded-lg font-bold">📦 Meus Pedidos</button>
            <a href="{{ route('user.profile') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">👤 Perfil</a>
            <a href="{{ route('auctions') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">🎯 Leilões</a>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                        <!-- Order Header -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-4 py-2 rounded-full text-sm font-medium 
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <div class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($order->total_amount, 0, ',', '.') }} Kz</div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        @if($item->product && $item->product->featured_image_url)
                                            <img src="{{ $item->product->featured_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <span class="text-2xl">📦</span>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $item->product_name }}</h4>
                                        <p class="text-sm text-gray-500">SKU: {{ $item->product_sku ?? 'N/A' }}</p>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-sm text-gray-600">Quantidade: {{ $item->quantity }}</span>
                                            <span class="font-bold text-gray-900">{{ number_format($item->total_price, 0, ',', '.') }} Kz</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Details -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <h5 class="font-semibold text-gray-900 mb-2">Método de Pagamento:</h5>
                                    <p class="text-gray-600">
                                        @if($order->payment_method === 'bank_transfer') 🏦 Transferência Bancária
                                        @elseif($order->payment_method === 'cash_on_delivery') 💵 Pagamento na Entrega
                                        @elseif($order->payment_method === 'multicaixa') 📱 Multicaixa Express
                                        @else {{ $order->payment_method ?? 'N/A' }} @endif
                                    </p>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900 mb-2">Status do Pagamento:</h5>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            @if($order->shipping_address)
                                <div class="mt-4">
                                    <h5 class="font-semibold text-gray-900 mb-2">Endereço de Entrega:</h5>
                                    <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                                        <p><strong>{{ $order->shipping_address['name'] ?? 'N/A' }}</strong></p>
                                        <p>{{ $order->shipping_address['phone'] ?? 'N/A' }}</p>
                                        <p>{{ $order->shipping_address['address'] ?? 'N/A' }}</p>
                                        <p>{{ $order->shipping_address['city'] ?? 'N/A' }}</p>
                                        @if($order->shipping_address['notes'])
                                            <p class="mt-2 italic">{{ $order->shipping_address['notes'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Ainda não fez nenhum pedido</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Explore nossa loja e encontre os produtos perfeitos para você!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:from-purple-700 hover:to-indigo-700 transition-all">
                        🛍️ Explorar Produtos
                    </a>
                    <a href="{{ route('auctions') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-xl font-bold hover:from-green-600 hover:to-emerald-700 transition-all">
                        🎯 Ver Leilões
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
