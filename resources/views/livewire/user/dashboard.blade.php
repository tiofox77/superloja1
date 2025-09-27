<div class="min-h-screen bg-gray-50">
    <!-- Header da Conta -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-2xl">👤</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Olá, {{ auth()->user()->name }}!</h1>
                    <p class="text-purple-100">Bem-vindo à sua área pessoal</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Menu de Navegação -->
        <div class="flex flex-wrap gap-4 mb-8">
            <button class="bg-purple-600 text-white px-6 py-3 rounded-lg font-bold">📊 Dashboard</button>
            <a href="{{ route('user.orders') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">📦 Meus Pedidos</a>
            <a href="{{ route('user.profile') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">👤 Perfil</a>
            <a href="{{ route('auctions') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">🎯 Leilões</a>
            <a href="{{ route('user.wishlist') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">❤️ Favoritos</a>
        </div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">Total de Pedidos</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 text-sm font-medium">Pedidos Pendentes</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">⏳</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">Pedidos Entregues</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['completed_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">✅</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 text-sm font-medium">Total Gasto</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_spent'], 0, ',', '.') }} Kz</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">💰</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pedidos Recentes -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <span class="mr-2">📦</span> Pedidos Recentes
                    </h2>
                    <a href="{{ route('user.orders') }}" class="text-purple-600 hover:text-purple-700 font-medium">Ver todos</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-900">{{ $order->order_number }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>{{ $order->items->count() }} item(s)</span>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900">{{ number_format($order->total_amount, 0, ',', '.') }} Kz</div>
                                    <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <span class="text-4xl mb-2 block">🛒</span>
                            <p>Ainda não fez nenhum pedido</p>
                            <a href="{{ route('products') }}" class="text-purple-600 hover:text-purple-700 font-medium mt-2 inline-block">Explorar produtos</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Leilões Ativos -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <span class="mr-2">🎯</span> Leilões Ativos
                    </h2>
                    <a href="{{ route('auctions') }}" class="text-purple-600 hover:text-purple-700 font-medium">Ver todos</a>
                </div>

                <div class="space-y-4">
                    @forelse($activeAuctions as $auction)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                            <h4 class="font-medium text-gray-900 mb-2">{{ $auction->title }}</h4>
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <div class="text-green-600 font-bold">{{ number_format($auction->current_bid, 0, ',', '.') }} Kz</div>
                                    <div class="text-gray-500">Lance atual</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-red-600 font-medium">
                                        @php
                                            $timeLeft = $auction->end_time->diff(now());
                                        @endphp
                                        @if($timeLeft->days > 0)
                                            {{ $timeLeft->format('%dd %H:%I') }}
                                        @else
                                            {{ $timeLeft->format('%H:%I:%S') }}
                                        @endif
                                    </div>
                                    <div class="text-gray-500">restante</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <span class="text-4xl mb-2 block">🎯</span>
                            <p>Nenhum leilão ativo no momento</p>
                            <a href="{{ route('auctions') }}" class="text-purple-600 hover:text-purple-700 font-medium mt-2 inline-block">Ver leilões</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <span class="mr-2">⚡</span> Ações Rápidas
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('products') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all text-center">
                    <div class="text-3xl mb-2">🛍️</div>
                    <div class="font-bold">Comprar</div>
                </a>
                
                <a href="{{ route('auctions') }}" class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl hover:from-green-600 hover:to-green-700 transition-all text-center">
                    <div class="text-3xl mb-2">🎯</div>
                    <div class="font-bold">Leilões</div>
                </a>
                
                <a href="{{ route('user.orders') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all text-center">
                    <div class="text-3xl mb-2">📦</div>
                    <div class="font-bold">Pedidos</div>
                </a>
                
                <a href="{{ route('request.product') }}" class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-6 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all text-center">
                    <div class="text-3xl mb-2">🔍</div>
                    <div class="font-bold">Solicitar</div>
                </a>
            </div>
        </div>
    </div>
</div>
