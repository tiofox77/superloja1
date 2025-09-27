<div>
    <!-- Hero Slider -->
    <div class="relative h-[600px] overflow-hidden" x-data="{ autoplay: true }" x-init="
        if (autoplay) {
            setInterval(() => {
                $wire.nextSlide();
            }, 5000);
        }
    ">
        @foreach($slides as $index => $slide)
            <div class="absolute inset-0 transition-opacity duration-1000 {{ $currentSlide === $index ? 'opacity-100' : 'opacity-0' }}">
                <!-- Background Gradient -->
                <div class="absolute inset-0 bg-gradient-to-r {{ $slide['background'] }}"></div>
                
                <!-- Product Image Background (se houver) -->
                @if(isset($slide['image']))
                    <div class="absolute inset-0 opacity-20">
                        <img src="{{ Storage::url($slide['image']) }}" 
                             alt="{{ $slide['title'] }}" 
                             class="w-full h-full object-cover">
                    </div>
                @endif
                
                <!-- Content -->
                <div class="relative h-full flex items-center">
                    <div class="container mx-auto px-4">
                        <div class="flex items-center justify-between">
                            <!-- Text Content -->
                            <div class="max-w-3xl {{ isset($slide['image']) ? 'lg:w-1/2' : 'w-full' }}">
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                                    {{ $slide['title'] }}
                                </h1>
                                <h2 class="text-xl md:text-2xl text-white/90 mb-4 font-medium">
                                    {{ $slide['subtitle'] }}
                                </h2>
                                
                                @if(isset($slide['price']))
                                    <div class="mb-4">
                                        <span class="text-3xl font-bold text-yellow-300 bg-black/20 px-4 py-2 rounded-lg backdrop-blur-sm">
                                            {{ number_format($slide['price'], 0, ',', '.') }} Kz
                                        </span>
                                    </div>
                                @endif
                                
                                <p class="text-lg text-white/80 mb-8 max-w-2xl leading-relaxed">
                                    {{ $slide['description'] }}
                                </p>
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="{{ $slide['button_link'] }}" 
                                       class="bg-white text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                                        {{ $slide['button_text'] }}
                                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                    <a href="/produtos" 
                                       class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-gray-900 transition-colors inline-flex items-center justify-center">
                                        Ver Catálogo
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Product Image (se houver) -->
                            @if(isset($slide['image']))
                                <div class="hidden lg:block lg:w-1/2 pl-12">
                                    <div class="relative">
                                        <img src="{{ Storage::url($slide['image']) }}" 
                                             alt="{{ $slide['title'] }}" 
                                             class="w-full max-w-md mx-auto rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                        <!-- Glow effect -->
                                        <div class="absolute inset-0 bg-white/20 rounded-2xl blur-3xl transform scale-110"></div>
                                    </div>
                                </div>
                            @else
                                <!-- Decorative Elements -->
                                <div class="hidden lg:block">
                                    <div class="absolute top-20 right-20 w-32 h-32 border border-white/20 rounded-full"></div>
                                    <div class="absolute bottom-20 right-40 w-20 h-20 border border-white/10 rounded-full"></div>
                                    <div class="absolute top-40 right-60 w-2 h-2 bg-white/30 rounded-full"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Navigation Arrows -->
        <button wire:click="prevSlide" 
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        
        <button wire:click="nextSlide" 
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
        
        <!-- Slide Indicators -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3">
            @foreach($slides as $index => $slide)
                <button wire:click="goToSlide({{ $index }})" 
                        class="w-3 h-3 rounded-full transition-colors {{ $currentSlide === $index ? 'bg-white' : 'bg-white/50' }}">
                </button>
            @endforeach
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-orange-500 mb-2">500+</div>
                    <div class="text-gray-600">Produtos</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-orange-500 mb-2">10k+</div>
                    <div class="text-gray-600">Clientes</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-orange-500 mb-2">24h</div>
                    <div class="text-gray-600">Entrega</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-orange-500 mb-2">99%</div>
                    <div class="text-gray-600">Satisfação</div>
                </div>
            </div>
        </div>
    </div>
</div>
