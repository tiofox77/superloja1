<div>
    @if($style === 'button')
        <!-- Button Style -->
        <button wire:click="toggleWishlist" 
                class="flex items-center justify-center space-x-2 
                       {{ $size === 'sm' ? 'px-3 py-2 text-sm' : ($size === 'lg' ? 'px-6 py-3 text-lg' : 'px-4 py-2') }}
                       {{ $isInWishlist 
                           ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg' 
                           : 'bg-white border-2 border-pink-300 text-pink-600 hover:bg-pink-50' }}
                       rounded-xl font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
            @if($isInWishlist)
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span>Favoritado</span>
            @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span>Favoritar</span>
            @endif
        </button>
    @else
        <!-- Icon Style -->
        <button wire:click="toggleWishlist" 
                class="relative p-2 rounded-full transition-all duration-300 hover:scale-110 group
                       {{ $isInWishlist 
                           ? 'bg-pink-500 text-white shadow-lg' 
                           : 'bg-white/90 text-pink-500 hover:bg-pink-50 shadow-md' }}">
            @if($isInWishlist)
                <svg class="w-6 h-6 fill-current animate-pulse" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            @else
                <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            @endif
            
            <!-- Tooltip -->
            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                {{ $isInWishlist ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}
            </div>
        </button>
    @endif
</div>
