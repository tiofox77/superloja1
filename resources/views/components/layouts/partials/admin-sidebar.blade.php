<!-- Sidebar Content -->
<div class="flex flex-col h-full sidebar-3d">
    
    <!-- Logo Section -->
    <div class="flex items-center h-16 px-6 animate-fade-in-scale">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-12 w-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg animate-float">
                    <svg class="h-7 w-7 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h1 class="text-xl font-bold text-white drop-shadow-lg">SuperLoja</h1>
                <p class="text-sm text-white opacity-80">Admin Panel</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-6 space-y-2 custom-scrollbar overflow-y-auto">
        
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.dashboard') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
            <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                <svg class="h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-purple-600' : 'text-white' }}" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Products Section -->
        <div class="space-y-3 mt-6">
            <div class="flex items-center px-4 py-2 text-xs font-semibold text-white/60 uppercase tracking-wider">
                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center mr-3">
                    <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                Produtos
            </div>
            
            <!-- Products -->
            <a href="{{ route('admin.products.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.products.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.products.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Gerir Produtos</span>
                @if(request()->routeIs('admin.products.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>
            
            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.categories.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.categories.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Categorias</span>
                @if(request()->routeIs('admin.categories.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>
            
            <!-- Brands -->
            <a href="{{ route('admin.brands.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.brands.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.brands.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.brands.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Marcas</span>
                @if(request()->routeIs('admin.brands.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>
        </div>

        <!-- Vendas Section -->
        <div class="space-y-1 pt-4">
            <div class="flex items-center px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Vendas
            </div>
            
            <!-- POS System -->
            <a href="{{ route('admin.pos.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.pos.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.pos.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.pos.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">POS - Caixa</span>
                @if(request()->routeIs('admin.pos.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>
            
            <!-- Orders -->
            <a href="{{ route('admin.orders.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.orders.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.orders.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Pedidos</span>
                @php
                    $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                @endphp
                @if($pendingOrdersCount > 0)
                    <span class="bg-red-400 text-white text-xs font-medium px-2 py-0.5 rounded-full">
                        {{ $pendingOrdersCount }}
                    </span>
                @endif
            </a>
            
            <!-- Auctions -->
            <a href="{{ route('admin.auctions.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.auctions.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.auctions.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.auctions.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Leilões</span>
                @if(request()->routeIs('admin.auctions.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>

            <!-- Product Requests -->
            <a href="{{ route('admin.product-requests.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.product-requests.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.product-requests.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.product-requests.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Solicitações</span>
                @if(request()->routeIs('admin.product-requests.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>
        </div>

        <!-- Utilizadores Section -->
        <div class="space-y-1 pt-4">
            <div class="flex items-center px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Utilizadores
            </div>
            
            <!-- Users -->
            <a href="{{ route('admin.users.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.users.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.users.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Utilizadores</span>
                @if(request()->routeIs('admin.users.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>
        </div>

        <!-- Marketing Section -->
        <div class="space-y-1 pt-4">
            <div class="flex items-center px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Marketing
            </div>
            
            <!-- Catalog Generator -->
            <a href="{{ route('admin.catalog.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.catalog.*') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.catalog.*') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.catalog.*') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Catálogos</span>
                @if(request()->routeIs('admin.catalog.*'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>

            <!-- Social Media Posts -->
            <a href="{{ route('admin.social-media.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.social-media.index') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.social-media.index') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.social-media.index') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Posts Sociais</span>
                @if(request()->routeIs('admin.social-media.index'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>

            <!-- Social Media Config -->
            <a href="{{ route('admin.social-media.config') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.social-media.config') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.social-media.config') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.social-media.config') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Configurações</span>
                @if(request()->routeIs('admin.social-media.config'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>

            <!-- Banner Generator -->
            <a href="{{ route('admin.social-media.banners') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-2xl mb-2 {{ request()->routeIs('admin.social-media.banners') ? 'nav-item-active text-white' : 'nav-item-3d text-white hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-xl {{ request()->routeIs('admin.social-media.banners') ? 'bg-yellow-400 shadow-lg' : 'bg-white/20' }} mr-3">
                    <svg class="h-5 w-5 {{ request()->routeIs('admin.social-media.banners') ? 'text-purple-600' : 'text-white' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="font-medium flex-1">Gerador de Banners</span>
                @if(request()->routeIs('admin.social-media.banners'))
                    <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                @endif
            </a>
        </div>

        <!-- Configurações Section -->
        <div class="space-y-1 pt-4">
            <div class="flex items-center px-3 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                <svg class="mr-2 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Sistema
            </div>
            
            <!-- Analytics -->
            <a href="#" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 menu-item text-gray-700 hover:bg-gray-100">
                <svg class="flex-shrink-0 mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Analytics
                <span class="ml-auto text-xs text-gray-400">Em breve</span>
            </a>
            
            <!-- Settings -->
            <a href="#" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 menu-item text-gray-700 hover:bg-gray-100">
                <svg class="flex-shrink-0 mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Configurações
            </a>
        </div>
        
    </nav>
    
    <!-- Bottom Info -->
    <div class="flex-shrink-0 p-4 border-t border-gray-200">
        <div class="flex items-center">
            <img class="h-8 w-8 rounded-full" 
                 src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" 
                 alt="{{ auth()->user()->name }}">
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
            <a href="{{ route('home') }}" 
               class="ml-2 flex-shrink-0 p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg"
               title="Ver Loja">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
