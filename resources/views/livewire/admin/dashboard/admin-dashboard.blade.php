<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="card-3d p-8 mb-8 bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-800 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-20 -translate-y-20"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-white rounded-full translate-x-16 translate-y-16"></div>
            <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-white rounded-full animate-float"></div>
        </div>
        
        <div class="relative z-10 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-3xl flex items-center justify-center shadow-2xl animate-float">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold mb-2 drop-shadow-lg">Dashboard Admin</h1>
                    <p class="text-white/80 text-lg">Bem-vindo ao centro de controlo da SuperLoja</p>
                    <p class="text-white/60 text-sm mt-1">Período: {{ $selectedPeriod }} • Última actualização: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <div class="flex flex-col space-y-4">
                <!-- Date Filter -->
                <select wire:model.live="dateFilter" wire:change="setDateFilter($event.target.value)"
                        class="glass-morphism text-white border border-white/30 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400/50 bg-white/10">
                    <option value="7">Últimos 7 Dias</option>
                    <option value="30">Este Mês</option>
                    <option value="90">Últimos 3 Meses</option>
                    <option value="365">Este Ano</option>
                </select>
                
                <!-- Refresh Button -->
                <button wire:click="refreshData" 
                        class="btn-3d bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-6 py-3 rounded-2xl transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span class="font-semibold">Actualizar</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Advanced Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Products Stats -->
        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Total Produtos</h3>
                <div class="flex items-baseline space-x-2">
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_products']) }}</p>
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-green-600 font-medium">{{ $stats['active_products'] }} ativos</span>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-sm">
                    <svg class="w-4 h-4 text-yellow-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <span class="text-gray-600">{{ $stats['featured'] ?? 0 }} em destaque</span>
                </div>
            </div>
        </div>

        <!-- Categories Stats -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-xl">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Categorias</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_categories']) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Brands Stats -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-xl">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Marcas</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_brands']) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.brands.index') }}" class="text-purple-600 hover:text-purple-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Users Stats -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-xl">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Clientes</h3>
                    <div class="flex items-baseline">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-orange-600 hover:text-orange-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Cards -->
    @if($stats['low_stock_products'] > 0 || $stats['pending_orders'] > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Low Stock Alert -->
            @if($stats['low_stock_products'] > 0)
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.865-.833-2.632 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-medium text-red-800">Alerta: Stock Baixo</h3>
                            <p class="text-red-700">{{ $stats['low_stock_products'] }} produto(s) com stock baixo (≤10 unidades)</p>
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors text-sm">
                            Ver
                        </a>
                    </div>
                </div>
            @endif

            <!-- Pending Orders Alert -->
            @if($stats['pending_orders'] > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-medium text-yellow-800">Pedidos Pendentes</h3>
                            <p class="text-yellow-700">{{ $stats['pending_orders'] }} pedido(s) aguardando processamento</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="bg-yellow-600 text-white px-3 py-1 rounded-lg hover:bg-yellow-700 transition-colors text-sm">
                            Ver
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Recent Activities -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Products -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Produtos Recentes</h2>
                        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Ver todos →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentProducts->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentProducts as $product)
                                <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="h-12 w-12 flex-shrink-0">
                                        @if($product->featured_image)
                                            <img class="h-12 w-12 rounded-lg object-cover" src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $product->category ? $product->category->name : 'Sem categoria' }}
                                            @if($product->brand)
                                                • {{ $product->brand->name }}
                                            @endif
                                        </p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-sm font-medium text-green-600">{{ number_format($product->price, 2) }} Kz</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum produto</h3>
                            <p class="mt-1 text-sm text-gray-500">Comece criando o primeiro produto.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Pedidos Recentes</h2>
                        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Ver todos →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-2 bg-indigo-100 rounded-lg">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">#{{ $order->id ?? 'ORD' . str_pad((string)$order->id, 4, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-sm text-gray-500">{{ $order->user->name ?? 'Cliente' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ number_format($order->total ?? 0, 2) }} Kz</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($order->status ?? 'pending') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum pedido</h3>
                            <p class="mt-1 text-sm text-gray-500">Os pedidos aparecerão aqui quando criados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Quick Actions & Stats -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ações Rápidas</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg hover:from-orange-100 hover:to-red-100 transition-all duration-200 group">
                        <div class="p-2 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Adicionar Produto</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg hover:from-green-100 hover:to-emerald-100 transition-all duration-200 group">
                        <div class="p-2 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Adicionar Categoria</span>
                    </a>

                    <a href="{{ route('admin.brands.index') }}" 
                       class="flex items-center p-3 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg hover:from-purple-100 hover:to-indigo-100 transition-all duration-200 group">
                        <div class="p-2 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Adicionar Marca</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center p-3 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg hover:from-blue-100 hover:to-cyan-100 transition-all duration-200 group">
                        <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Ver Pedidos</span>
                    </a>
                </div>
            </div>

            <!-- Top Categories -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Categorias</h2>
                @if(count($topCategories) > 0)
                    <div class="space-y-3">
                        @foreach($topCategories as $category)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center text-white font-semibold text-xs">
                                        {{ substr($category['name'], 0, 2) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $category['name'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-600">{{ $category['products_count'] }}</span>
                                    <span class="text-xs text-gray-400 ml-1">produtos</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Sem categorias ainda</p>
                    </div>
                @endif
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Status do Sistema</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Base de Dados</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></div>
                            Online
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Cache</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></div>
                            Funcional
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Storage</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></div>
                            Disponível
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
