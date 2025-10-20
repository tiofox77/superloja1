<!-- Modern Header -->
<header class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18">
            
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-orange-500 via-orange-600 to-red-500 text-white p-3 rounded-2xl shadow-lg transform group-hover:scale-105 transition-all duration-300">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                                <path d="M9 8V17H11V8H9ZM13 8V17H15V8H13Z"/>
                            </svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-pulse"></div>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-2xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                            SuperLoja
                        </h1>
                        <p class="text-xs text-gray-500 font-medium">Angola</p>
                    </div>
                </a>
            </div>

            <!-- Center Navigation -->
            <nav class="hidden lg:flex items-center space-x-1 bg-gray-50/80 rounded-full px-2 py-1">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('home') ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-700 hover:bg-white hover:text-orange-600 hover:shadow-md' }}">
                    🏠 Início
                </a>
                <a href="{{ route('health.wellness.pt') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 whitespace-nowrap {{ request()->routeIs(['health.wellness', 'health.wellness.pt']) ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-700 hover:bg-white hover:text-orange-600 hover:shadow-md' }}">
                    🍃 Saúde
                </a>
                <a href="{{ route('products') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('products') ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-700 hover:bg-white hover:text-orange-600 hover:shadow-md' }}">
                    📦 Produtos
                </a>
                <a href="{{ route('offers') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('offers') ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-700 hover:bg-white hover:text-orange-600 hover:shadow-md' }}">
                    🔥 Ofertas
                </a>
                <a href="{{ route('auctions') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('auctions') ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-700 hover:bg-white hover:text-orange-600 hover:shadow-md' }}">
                    ⚡ Leilões
                </a>
                <a href="{{ route('product-request') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('product-request') ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-700 hover:bg-white hover:text-orange-600 hover:shadow-md' }}">
                    🛒 Solicitar
                </a>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                
                <!-- Search -->
                <div class="hidden md:block relative">
                    <div class="relative group">
                        <input type="text" 
                               placeholder="Buscar produtos..." 
                               class="w-48 lg:w-64 pl-10 pr-4 py-2.5 bg-gray-50/80 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500/50 focus:bg-white text-sm placeholder-gray-500 transition-all duration-300">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-4 h-4 text-gray-400 group-focus-within:text-orange-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-1 sm:space-x-2">
                    
                    <!-- Wishlist -->
                    @livewire('components.wishlist-header')

                    <!-- Notifications -->
                    @livewire('notification-dropdown')

                    <!-- Cart -->
                    @livewire('components.cart-header')

                    <!-- User Account -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-3 text-gray-600 hover:text-blue-500 hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50 rounded-2xl transition-all duration-300 group flex items-center space-x-3 shadow-lg hover:shadow-xl">
                                <div class="relative">
                                    <!-- Avatar melhorado com múltiplos efeitos -->
                                    <div class="relative w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 via-purple-500 to-indigo-600 p-0.5 shadow-lg group-hover:shadow-xl transition-all duration-300">
                                        <img class="w-full h-full rounded-full object-cover border-2 border-white shadow-md group-hover:scale-105 transition-transform duration-300" 
                                             src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=ffffff&background=gradient&bold=true' }}" 
                                             alt="{{ auth()->user()->name }}">
                                        
                                        <!-- Anel de status animado -->
                                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full border-3 border-white shadow-lg">
                                            <div class="w-full h-full bg-green-400 rounded-full animate-pulse"></div>
                                            <div class="absolute inset-0 bg-green-300 rounded-full animate-ping opacity-75"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Efeito de brilho rotativo -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-30 transition-opacity duration-300 blur-sm animate-pulse"></div>
                                </div>
                                
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors">{{ auth()->user()->name }}</p>
                                    <div class="flex items-center space-x-1">
                                        @if(auth()->user()->role === 'admin')
                                            <span class="text-xs px-2 py-0.5 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-full font-bold shadow-sm">👑 Admin</span>
                                        @else
                                            <span class="text-xs px-2 py-0.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-full font-medium shadow-sm">👤 Cliente</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Ícone dropdown melhorado -->
                                <div class="relative">
                                    <svg class="w-5 h-5 transition-all duration-300 group-hover:text-blue-600" :class="open ? 'rotate-180 text-blue-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                </div>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50">
                                
                                <!-- User Info Header -->
                                <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <div class="flex items-center space-x-4">
                                        <!-- Avatar melhorado no dropdown -->
                                        <div class="relative">
                                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 via-purple-500 to-indigo-600 p-0.5 shadow-lg">
                                                <img class="w-full h-full rounded-2xl object-cover border-2 border-white shadow-md" 
                                                     src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=ffffff&background=6366f1&bold=true' }}" 
                                                     alt="{{ auth()->user()->name }}">
                                            </div>
                                            <!-- Status online -->
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full border-2 border-white shadow-md">
                                                <div class="w-full h-full bg-green-400 rounded-full animate-pulse"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 text-lg">{{ auth()->user()->name }}</p>
                                            <p class="text-sm text-gray-600 mb-2">{{ auth()->user()->email }}</p>
                                            @if(auth()->user()->role === 'admin')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-purple-500 to-indigo-600 text-white shadow-md">
                                                    <span class="mr-1">👑</span> SuperLoja Admin
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500 to-cyan-600 text-white shadow-md">
                                                    <span class="mr-1">👤</span> Cliente Premium
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Menu Items -->
                                <div class="p-2">
                                    @if(auth()->user()->role === 'admin')
                                        <!-- Admin Menu -->
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Painel Admin</p>
                                                <p class="text-xs text-gray-500">Gerenciar sistema</p>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Área do Cliente</p>
                                                <p class="text-xs text-gray-500">Dashboard e pedidos</p>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ route('user.profile') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Meu Perfil</p>
                                                <p class="text-xs text-gray-500">Dados pessoais</p>
                                            </div>
                                        </a>
                                    @else
                                        <!-- Customer Menu -->
                                        <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Meu Painel</p>
                                                <p class="text-xs text-gray-500">Pedidos e compras</p>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ route('user.profile') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Meu Perfil</p>
                                                <p class="text-xs text-gray-500">Dados pessoais</p>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ route('user.orders') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Meus Pedidos</p>
                                                <p class="text-xs text-gray-500">Histórico de compras</p>
                                            </div>
                                        </a>
                                        
                                        <a href="{{ route('user.wishlist') }}" class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Lista de Desejos</p>
                                                <p class="text-xs text-gray-500">Produtos favoritos</p>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                                
                                <!-- Logout -->
                                <div class="border-t border-gray-100 p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-3 w-full px-3 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">Sair</p>
                                                <p class="text-xs text-gray-500">Encerrar sessão</p>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <button class="relative p-3 text-gray-600 hover:text-blue-500 hover:bg-blue-50 rounded-2xl transition-all duration-300 group" onclick="window.location='{{ route('login') }}'">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Entrar
                            </div>
                        </button>
                    @endauth
                </div>

                <!-- Auth Links (só aparece se não estiver logado) -->
                @guest
                    <div class="hidden lg:flex items-center space-x-3">
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-300">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-2xl hover:from-orange-600 hover:to-red-600 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Registrar
                        </a>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 text-gray-600 hover:text-orange-500 hover:bg-orange-50 rounded-xl transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Search Bar Mobile -->
    <div class="md:hidden px-4 pb-4">
        <div class="relative">
            <input type="text" 
                   placeholder="Buscar produtos..." 
                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-orange-500/50 text-sm">
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>



</header>

<script>
// Header script - minimal functionality
</script>
