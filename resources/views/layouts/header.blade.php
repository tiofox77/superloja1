<!-- Modern Header -->
<header class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                @php
                    $siteLogo = \App\Models\Setting::get('site_logo');
                    $appName = \App\Models\Setting::get('app_name', 'SuperLoja');
                    $appDesc = \App\Models\Setting::get('app_description', 'Sua loja online de confiança em Angola');
                    
                    // Verificar se existe um logo personalizado (não default)
                    $hasCustomLogo = !empty($siteLogo) && $siteLogo !== '/images/logo.png';
                    $logoUrl = '';
                    
                    if ($hasCustomLogo) {
                        // Se já começa com http:// ou https://, usar direto
                        if (\Illuminate\Support\Str::startsWith($siteLogo, ['http://', 'https://'])) {
                            $logoUrl = $siteLogo;
                        } 
                        // Se começa com /storage/, usar url() para gerar URL completa
                        elseif (\Illuminate\Support\Str::startsWith($siteLogo, '/storage/')) {
                            $logoUrl = url($siteLogo);
                        }
                        // Se começa com storage/ (sem barra), adicionar barra e usar url()
                        elseif (\Illuminate\Support\Str::startsWith($siteLogo, 'storage/')) {
                            $logoUrl = url('/' . $siteLogo);
                        }
                        // Para qualquer outro caminho, usar asset()
                        else {
                            $logoUrl = asset(ltrim($siteLogo, '/'));
                        }
                    }
                @endphp
                <a href="{{ route('home') }}" wire:navigate class="flex items-center space-x-2 group">
                    @if($hasCustomLogo)
                        <img src="{{ $logoUrl }}" alt="{{ $appName }}" class="h-10 w-auto object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    
                    <div class="flex items-center space-x-2" style="{{ $hasCustomLogo ? 'display: none;' : '' }}">
                        <div class="text-gray-900 font-bold text-lg">
                            {{ $appName }}
                        </div>
                    </div>
                </a>
            </div>

            <!-- Center Navigation -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('home') }}" wire:navigate class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-gray-900 border-b-2 border-orange-500 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                    Início
                </a>
                <a href="{{ route('categories') }}" wire:navigate class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('categories') ? 'text-gray-900 border-b-2 border-orange-500 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                    Categorias
                </a>
                <a href="{{ route('products') }}" wire:navigate class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('products') ? 'text-gray-900 border-b-2 border-orange-500 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                    Produtos
                </a>
                <a href="{{ route('health.wellness.pt') }}" wire:navigate class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs(['health.wellness', 'health.wellness.pt']) ? 'text-gray-900 border-b-2 border-orange-500 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                    Saúde
                </a>
                <a href="{{ route('offers') }}" wire:navigate class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('offers') ? 'text-gray-900 border-b-2 border-orange-500 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                    Ofertas
                </a>
                <a href="{{ route('auctions') }}" wire:navigate class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('auctions') ? 'text-gray-900 border-b-2 border-orange-500 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                    Leilões
                </a>
                <a href="{{ route('product-request') }}" wire:navigate class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('product-request') ? 'text-gray-900 border-b-2 border-orange-500 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                    Solicitar
                </a>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center space-x-4">
                
                <!-- Search Icon -->
                <button class="p-2 text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Action Icons -->
                <div class="flex items-center space-x-4">
                    
                    <!-- Wishlist -->
                    @livewire('components.wishlist-header')

                    <!-- Notifications -->
                    @livewire('notification-dropdown')

                    <!-- Cart -->
                    @livewire('components.cart-header')

                    <!-- User Account -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-600 hover:text-gray-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
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
                                        <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-xl transition-all duration-200">
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
                                        
                                        <a href="{{ route('user.dashboard') }}" wire:navigate class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all duration-200">
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
                                        
                                        <a href="{{ route('user.profile') }}" wire:navigate class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition-all duration-200">
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
                                        <a href="{{ route('user.dashboard') }}" wire:navigate class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all duration-200">
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
                                        
                                        <a href="{{ route('user.profile') }}" wire:navigate class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-xl transition-all duration-200">
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
                                        
                                        <a href="{{ route('user.orders') }}" wire:navigate class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 rounded-xl transition-all duration-200">
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
                                        
                                        <a href="{{ route('user.wishlist') }}" wire:navigate class="flex items-center space-x-3 px-3 py-3 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 rounded-xl transition-all duration-200">
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
                        <button class="p-2 text-gray-600 hover:text-gray-900 transition-colors" onclick="window.location='{{ route('login') }}'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </button>
                    @endauth
                </div><!-- /Action Icons -->

                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div><!-- /Right Actions -->
        </div><!-- /flex items-center justify-between -->
    </div><!-- /max-w-7xl container -->

</header><!-- /header -->

<script>
// Header script - minimal functionality
</script>
