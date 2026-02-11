<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Leilões Online</h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                Participe nos nossos leilões e ganhe produtos incríveis a preços únicos. 
                Eletrónicos, gadgets e muito mais em leilão!
            </p>
        </div>
    </div>

    <!-- Live Auctions -->
    <div class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Leilões Ativos</h2>
                <p class="text-gray-600">Participe agora nos leilões em curso</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                <span class="text-red-600 font-semibold">AO VIVO</span>
            </div>
        </div>

        @if($auctions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($auctions as $auction)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative overflow-hidden">
                            @if($auction->product && $auction->product->featured_image_url)
                                <img src="{{ $auction->product->featured_image_url }}" 
                                     alt="{{ $auction->product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="text-gray-400">Sem imagem</div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse shadow-lg">
                                    AO VIVO
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $auction->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($auction->description, 60) }}</p>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-100 rounded-xl p-4 mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-purple-700 font-semibold">Lance Atual:</span>
                                    <span class="text-2xl font-black text-purple-600">{{ number_format($auction->current_bid, 0, ',', '.') }} Kz</span>
                                </div>
                            </div>

                            <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-red-700 font-semibold text-sm">Tempo restante:</span>
                                    <span class="text-red-600 font-black text-lg">
                                        @php
                                            $timeLeft = $auction->end_time->diff(now());
                                        @endphp
                                        @if($timeLeft->days > 0)
                                            {{ $timeLeft->format('%dd %H:%I') }}
                                        @else
                                            {{ $timeLeft->format('%H:%I:%S') }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <button class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white py-3 px-4 rounded-lg font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                🎯 Fazer Lance
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $auctions->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhum Leilão Ativo</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Não há leilões ativos no momento. Volte em breve para participar em novos leilões emocionantes!
                </p>
                <a href="{{ route('home') }}" wire:navigate
                   class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Voltar à Página Inicial
                </a>
            </div>
        @endif
    </div>

    <!-- How it Works -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Como Funcionam os Leilões</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Processo simples e transparente para participar</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Registe-se</h3>
                    <p class="text-gray-600">Crie a sua conta e verifique a identidade para participar nos leilões</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Faça Lances</h3>
                    <p class="text-gray-600">Escolha produtos e faça lances em tempo real. Acompanhe os leilões ao vivo</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Ganhe & Pague</h3>
                    <p class="text-gray-600">Se ganhar, pague de forma segura e receba o produto na sua casa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Pronto para Participar?</h2>
            <p class="text-xl text-purple-100 mb-8">
                Registe-se agora e comece a fazer lances nos melhores produtos!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" wire:navigate
                   class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors">
                    Registar Agora
                </a>
                <a href="{{ route('products') }}" wire:navigate
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-purple-600 transition-colors">
                    Ver Produtos
                </a>
            </div>
        </div>
    </div>
</div>
