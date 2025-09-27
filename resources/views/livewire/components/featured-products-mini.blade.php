<div class="grid grid-cols-2 gap-4">
    @forelse($products as $product)
        <a href="/produtos" class="block">
            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 hover:bg-white/30 transition-all duration-300 transform hover:scale-105 cursor-pointer group">
                <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center mb-3 overflow-hidden relative">
                    @if($product->featured_image)
                        <img src="{{ Storage::url($product->featured_image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform duration-300">
                    @else
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                    
                    <!-- Overlay de hover -->
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white transform scale-0 group-hover:scale-100 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
                <h4 class="text-white font-semibold text-sm mb-1 truncate group-hover:text-yellow-300 transition-colors">{{ $product->name }}</h4>
                <p class="text-yellow-300 font-bold text-sm group-hover:text-yellow-200 transition-colors">
                    {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }} Kz
                </p>
                <div class="mt-2">
                    @if($product->sale_price && $product->sale_price > 0)
                        @php
                            $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                        @endphp
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full group-hover:bg-red-600 transition-colors">-{{ $discount }}% OFF</span>
                    @elseif($product->is_featured)
                        <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded-full group-hover:bg-purple-600 transition-colors">Destaque</span>
                    @else
                        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full group-hover:bg-blue-600 transition-colors">{{ $product->category->name ?? 'Produto' }}</span>
                    @endif
                </div>
            </div>
        </a>
    @empty
        <!-- Fallback se não houver produtos -->
        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h4 class="text-white font-semibold text-sm mb-1">iPhone 15 Pro</h4>
            <p class="text-yellow-300 font-bold text-sm">1.299.000 Kz</p>
            <div class="mt-2">
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">-15% OFF</span>
            </div>
        </div>
        
        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h4 class="text-white font-semibold text-sm mb-1">MacBook Pro</h4>
            <p class="text-yellow-300 font-bold text-sm">2.499.000 Kz</p>
            <div class="mt-2">
                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Novo</span>
            </div>
        </div>
    @endforelse
</div>
