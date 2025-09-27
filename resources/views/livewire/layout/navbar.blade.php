<nav class="bg-white shadow-lg sticky top-0 z-50">
    <!-- Main Header -->
    <div class="border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 py-2 rounded-lg font-bold text-xl shadow-lg">
                            S
                        </div>
                        <div>
                            <span class="text-2xl font-bold text-gray-900">SuperLoja</span>
                            <p class="text-xs text-gray-500">Eletrônicos em Angola</p>
                        </div>
                    </a>
                </div>
                
                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                    <div class="relative w-full">
                        <input type="text" 
                               wire:model.live.debounce.300ms="search"
                               placeholder="Pesquisar produtos, marcas..." 
                               class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors">
                            Buscar
                        </button>
                    </div>
                </div>
                
                <!-- Right Actions -->
                <div class="flex items-center space-x-2">
                    <!-- Favorites (Desktop) -->
                    <div class="hidden lg:block">
                        <button wire:click="toggleFavorites" 
                                class="relative p-3 text-gray-600 hover:text-orange-500 transition-colors rounded-lg hover:bg-orange-50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-[20px] h-5 flex items-center justify-center font-bold">
                                3
                            </span>
                        </button>
                    </div>

                    <!-- Cart -->
                    <livewire:components.shopping-cart />
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        @auth
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-orange-500 transition-colors px-3 py-2 rounded-lg hover:bg-orange-50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="hidden sm:inline font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        @else
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('login') }}" class="flex items-center space-x-1 text-gray-600 hover:text-orange-500 transition-colors px-4 py-2 rounded-lg hover:bg-orange-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Entrar</span>
                                </a>
                                <a href="{{ route('register') }}" class="bg-orange-500 text-white hover:bg-orange-600 transition-colors px-4 py-2 rounded-lg font-medium">
                                    Registar
                                </a>
                            </div>
                        @endauth
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button wire:click="toggleMobileMenu" class="lg:hidden p-2 text-gray-600 hover:text-orange-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="hidden lg:flex items-center justify-center space-x-8 py-4">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Início</a>
                <a href="{{ route('categories') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Categorias</a>
                <a href="{{ route('products') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Produtos</a>
                <a href="{{ route('offers') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Ofertas</a>
                <a href="{{ route('auctions') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Leilões</a>
                <a href="{{ route('health.wellness') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Saúde</a>
                <a href="{{ route('brands') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Marcas</a>
                <a href="{{ route('request.product') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Solicitar</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">Contacto</a>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    @if($mobileMenuOpen)
        <div class="lg:hidden bg-white border-t border-gray-200" x-show="$wire.mobileMenuOpen" x-transition>
            <div class="px-4 py-4 space-y-4">
                <!-- Mobile Search -->
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Pesquisar produtos..." 
                           class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Mobile Navigation -->
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Início</a>
                    <a href="{{ route('categories') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Categorias</a>
                    <a href="{{ route('products') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Produtos</a>
                    <a href="{{ route('offers') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Ofertas</a>
                    <a href="{{ route('auctions') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Leilões</a>
                    <a href="{{ route('health.wellness') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Saúde</a>
                    <a href="{{ route('brands') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Marcas</a>
                    <a href="{{ route('request.product') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Solicitar</a>
                    <a href="{{ route('contact') }}" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 rounded-lg transition-colors">Contacto</a>
                </div>
                
                <!-- Mobile Auth -->
                @guest
                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Entrar</a>
                        <a href="{{ route('register') }}" class="block w-full text-center px-4 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Registar</a>
                    </div>
                @endguest
            </div>
        </div>
    @endif
</nav>
