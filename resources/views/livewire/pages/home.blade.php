<div class="bg-white">
    <!-- Enhanced Hero Section -->
    <section class="relative min-h-screen overflow-hidden">
        <!-- Background Gradient Animation -->
        <div class="absolute inset-0 bg-gradient-to-br from-orange-500 via-purple-600 to-blue-600 animate-gradient-x"></div>
        
        <!-- Floating Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="floating-shape-1"></div>
            <div class="floating-shape-2"></div>
            <div class="floating-shape-3"></div>
            <div class="floating-shape-4"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-10 min-h-screen flex items-center">
            <div class="container mx-auto px-4">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="text-white space-y-8">
                        <div class="space-y-4 animate-fade-in-up">
                            <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                                🚀 Eletrônicos Premium em Angola
                            </span>
                            <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                                Tecnologia
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">
                                    do Futuro
                                </span>
                            </h1>
                            <p class="text-xl text-white/90 leading-relaxed max-w-xl">
                                Descubra os melhores smartphones, laptops, gaming e acessórios com entrega gratuita em toda Angola.
                            </p>
                        </div>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up" style="animation-delay: 0.3s">
                            <a href="{{ route('products') }}" wire:navigate
                               class="bg-white text-gray-900 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-all duration-300 inline-flex items-center justify-center shadow-2xl hover:shadow-3xl transform hover:scale-105">
                                Explorar Produtos
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <a href="{{ route('auctions') }}" wire:navigate
                               class="border-2 border-white/30 text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 inline-flex items-center justify-center backdrop-blur-sm">
                                Ver Leilões
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-8 pt-8 animate-fade-in-up" style="animation-delay: 0.6s">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-300">{{ $stats['products'] ?? 0 }}+</div>
                                <div class="text-white/80 text-sm">Produtos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-300">{{ $stats['categories'] ?? 0 }}+</div>
                                <div class="text-white/80 text-sm">Categorias</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-300">{{ $stats['brands'] ?? 0 }}+</div>
                                <div class="text-white/80 text-sm">Marcas</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Content - Featured Products -->
                    <div class="space-y-6 animate-fade-in-right" style="animation-delay: 0.4s">
                        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 border border-white/20">
                            <h3 class="text-2xl font-bold text-white mb-6 text-center">Produtos em Destaque</h3>
                            
                            <!-- Featured Products Mini Grid -->
                            @livewire('components.featured-products-mini')
                            
                            <div class="text-center mt-6">
                                <a href="{{ route('products') }}" wire:navigate
                                   class="bg-gradient-to-r from-orange-500 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 inline-flex items-center">
                                    Ver Todos os Produtos
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
            <div class="flex flex-col items-center space-y-2">
                <span class="text-sm text-white/80">Role para baixo</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </section>
    
    <!-- Enhanced Featured Products -->
    <section class="py-24 bg-gradient-to-br from-white via-purple-50 to-pink-50 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 left-10 w-40 h-40 bg-purple-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-60 h-60 bg-pink-500 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 relative">
            <!-- Enhanced Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-100 to-pink-100 rounded-full text-sm font-semibold mb-6">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Mais Vendidos</span>
                </div>
                <h2 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-8 leading-tight">
                    Produtos em 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                        Destaque
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed mb-8">
                    Descubra nossa seleção premium dos produtos mais desejados com ofertas exclusivas, 
                    garantia estendida e entrega prioritária em toda Angola.
                </p>
                
                <!-- Stats Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto mb-12">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">98%</div>
                        <div class="text-gray-600 text-sm">Satisfação dos Clientes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-pink-600 mb-2">24h</div>
                        <div class="text-gray-600 text-sm">Entrega Express</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">2 Anos</div>
                        <div class="text-gray-600 text-sm">Garantia Estendida</div>
                    </div>
                </div>
            </div>
            
            <!-- Products Component -->
            <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-8 border border-white/50 shadow-2xl">
                <livewire:components.featured-products />
            </div>
            
            <!-- Call to Action -->
            <div class="text-center mt-16">
                <a href="{{ route('products') }}" wire:navigate
                   class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-lg rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    Ver Todos os Produtos
                    <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                <p class="text-gray-500 mt-4">Mais de {{ $stats['products'] ?? 0 }} produtos disponíveis</p>
            </div>
        </div>
    </section>

    <!-- Enhanced Latest Products -->
    <section class="py-24 bg-gradient-to-br from-blue-50 via-indigo-50 to-cyan-50 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-10 right-20 w-32 h-32 bg-blue-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-20 w-48 h-48 bg-cyan-500 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-indigo-500 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 relative">
            <!-- Enhanced Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-full text-sm font-semibold mb-6">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Recém Chegados</span>
                </div>
                <h2 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-8 leading-tight">
                    Últimos 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600">
                        Produtos
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed mb-8">
                    Seja o primeiro a descobrir as mais recentes inovações tecnológicas que chegaram à nossa loja. 
                    Produtos com tecnologia de ponta e designs revolucionários.
                </p>
                
                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-4xl mx-auto mb-12">
                    <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-white/50">
                        <div class="text-2xl mb-3">🆕</div>
                        <div class="text-sm font-semibold text-gray-900">Novidades</div>
                        <div class="text-xs text-gray-600">Semanais</div>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-white/50">
                        <div class="text-2xl mb-3">⚡</div>
                        <div class="text-sm font-semibold text-gray-900">Tecnologia</div>
                        <div class="text-xs text-gray-600">Avançada</div>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-white/50">
                        <div class="text-2xl mb-3">🏆</div>
                        <div class="text-sm font-semibold text-gray-900">Qualidade</div>
                        <div class="text-xs text-gray-600">Premium</div>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-white/50">
                        <div class="text-2xl mb-3">🚀</div>
                        <div class="text-sm font-semibold text-gray-900">Entrega</div>
                        <div class="text-xs text-gray-600">Expressa</div>
                    </div>
                </div>
            </div>
            
            <!-- Products Component -->
            <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-8 border border-white/50 shadow-2xl mb-16">
                <livewire:components.latest-products />
            </div>
            
            <!-- Enhanced Call to Action -->
            <div class="text-center">
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl p-12 text-white relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-4 left-4 w-8 h-8 border-2 border-white rounded-full"></div>
                        <div class="absolute bottom-4 right-4 w-12 h-12 border border-white rounded-full"></div>
                        <div class="absolute top-1/2 right-8 w-6 h-6 border-2 border-white rounded-full"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-4">Não perca as novidades!</h3>
                        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                            Novos produtos chegam toda semana. Seja notificado sobre os lançamentos mais esperados.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('products') }}" wire:navigate
                               class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center">
                                Ver Todos os Produtos
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <a href="{{ route('categories') }}" wire:navigate
                               class="border-2 border-white/30 text-white px-8 py-4 rounded-2xl font-bold hover:bg-white hover:text-blue-600 transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center backdrop-blur-sm">
                                Explorar Categorias
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="mt-6 text-blue-200 text-sm">
                            <span class="inline-block px-3 py-1 bg-white/20 rounded-full mr-2">🚚 Entrega grátis acima de 50.000 Kz</span>
                            <span class="inline-block px-3 py-1 bg-white/20 rounded-full">🔒 Compra 100% segura</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Special Offers -->
    <section class="py-20 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-20 h-20 border-2 border-white rounded-full"></div>
            <div class="absolute top-40 right-20 w-32 h-32 border border-white rounded-full"></div>
            <div class="absolute bottom-20 left-40 w-16 h-16 border-2 border-white rounded-full"></div>
        </div>
        
        <div class="container mx-auto px-4 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="text-white space-y-8">
                    <div>
                        <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold mb-4">
                            ⚡ Ofertas Relâmpago
                        </span>
                        <h2 class="text-5xl font-bold mb-6">Ofertas Especiais</h2>
                        <p class="text-xl text-white/90 leading-relaxed mb-8">
                            Participe nos nossos leilões únicos e ganhe produtos incríveis a preços que nunca viu!
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300 mb-2">70%</div>
                            <div class="text-white/80">Desconto máximo</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300 mb-2">24h</div>
                            <div class="text-white/80">Ofertas diárias</div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('auctions') }}" wire:navigate
                           class="bg-white text-purple-600 px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-gray-100 transition-all duration-300 inline-flex items-center justify-center shadow-2xl transform hover:scale-105">
                            Ver Leilões
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('health.wellness') }}" wire:navigate
                           class="border-2 border-white/30 text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:text-purple-600 transition-all duration-300 inline-flex items-center justify-center backdrop-blur-sm">
                            Saúde & Bem-estar
                        </a>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-12 border border-white/20 transform hover:scale-105 transition-all duration-300">
                        <div class="text-8xl mb-6">🎯</div>
                        <h3 class="text-3xl font-bold text-white mb-4">Até 70% OFF</h3>
                        <p class="text-white/90 text-lg mb-6">Em produtos selecionados</p>
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-400 text-gray-900 px-6 py-3 rounded-full font-bold inline-block">
                            Ofertas Limitadas!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Enhanced Call to Action -->
    <section class="py-20 bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 relative overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0 opacity-20">
            <div class="animate-pulse absolute top-20 left-20 w-4 h-4 bg-white rounded-full"></div>
            <div class="animate-pulse absolute bottom-40 right-20 w-6 h-6 bg-white rounded-full" style="animation-delay: 1s"></div>
            <div class="animate-pulse absolute top-40 right-40 w-3 h-3 bg-white rounded-full" style="animation-delay: 2s"></div>
        </div>
        
        <div class="container mx-auto px-4 text-center relative">
            <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold text-white mb-6">
                🚀 Junte-se à SuperLoja
            </span>
            <h2 class="text-5xl font-bold text-white mb-6">Pronto para começar?</h2>
            <p class="text-xl text-white/90 mb-12 max-w-3xl mx-auto leading-relaxed">
                Junte-se a milhares de clientes satisfeitos e descubra a melhor experiência de compra online em Angola com produtos de qualidade e preços imbatíveis.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('products') }}" wire:navigate
                   class="bg-white text-orange-600 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 inline-flex items-center justify-center shadow-2xl transform hover:scale-105">
                    Ver Produtos
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('categories') }}" wire:navigate
                   class="border-2 border-white/30 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-white hover:text-orange-600 transition-all duration-300 inline-flex items-center justify-center backdrop-blur-sm">
                    Explorar Categorias
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
/* Enhanced Animations */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

.animate-fade-in-right {
    animation: fadeInRight 0.8s ease-out forwards;
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 15s ease infinite;
}

/* Floating Shapes */
.floating-shape-1, .floating-shape-2, .floating-shape-3, .floating-shape-4 {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
    animation: float 6s ease-in-out infinite;
}

.floating-shape-1 {
    width: 100px;
    height: 100px;
    background: linear-gradient(45deg, #ffffff, #f59e0b);
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-shape-2 {
    width: 150px;
    height: 150px;
    background: linear-gradient(45deg, #ffffff, #8b5cf6);
    top: 60%;
    right: 10%;
    animation-delay: 2s;
}

.floating-shape-3 {
    width: 80px;
    height: 80px;
    background: linear-gradient(45deg, #ffffff, #3b82f6);
    bottom: 30%;
    left: 20%;
    animation-delay: 4s;
}

.floating-shape-4 {
    width: 120px;
    height: 120px;
    background: linear-gradient(45deg, #ffffff, #10b981);
    top: 40%;
    right: 30%;
    animation-delay: 1s;
}

@keyframes float {
    0%, 100% { 
        transform: translateY(0px) scale(1);
        opacity: 0.1;
    }
    50% { 
        transform: translateY(-20px) scale(1.1);
        opacity: 0.15;
    }
}
</style>
@endpush
