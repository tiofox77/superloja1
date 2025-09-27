@extends('layouts.app')

@section('title', 'Leilões - SuperLoja')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Leilões Online</h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                Participe nos nossos leilões e ganhe produtos incríveis a preços únicos. 
                Electrónicos, gadgets e muito mais em leilão!
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
                @foreach($auctions as $auction)
                    @php
                        $timeLeft = $auction->end_time->diff(now());
                        $totalTime = $auction->end_time->diff($auction->start_time);
                        $elapsedTime = now()->diff($auction->start_time);
                        $progressPercentage = $totalTime->days > 0 ? 
                            min(100, ($elapsedTime->days * 24 * 60 + $elapsedTime->h * 60 + $elapsedTime->i) / 
                            ($totalTime->days * 24 * 60 + $totalTime->h * 60 + $totalTime->i) * 100) : 0;
                    @endphp
                    
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group border border-gray-100">
                        <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative overflow-hidden">
                            @if($auction->product && $auction->product->featured_image_url)
                                <img src="{{ $auction->product->featured_image_url }}" 
                                     alt="{{ $auction->product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="bg-gradient-to-br from-purple-100 to-indigo-100 w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-purple-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                            <!-- Live Badge with Glow -->
                            <div class="absolute top-3 left-3">
                                <span class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse shadow-lg">
                                    <div class="flex items-center space-x-1">
                                        <div class="w-2 h-2 bg-white rounded-full animate-ping"></div>
                                        <span>AO VIVO</span>
                                    </div>
                                </span>
                            </div>
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black from-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $auction->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($auction->description, 60) }}</p>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-100 rounded-xl p-4 mb-4 group-hover:from-purple-100 group-hover:to-indigo-100 transition-colors duration-300">
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 113 0v1m0 0V11m0-5.5a1.5 1.5 0 113 0v3"></path>
                                        </svg>
                                        <span class="text-purple-700 font-semibold">Lance Atual:</span>
                                    </div>
                                    <span class="text-2xl font-black text-purple-600 animate-pulse">{{ number_format($auction->current_bid, 0, ',', '.') }} Kz</span>
                                </div>
                                <div class="grid grid-cols-3 gap-2 text-sm">
                                    <div class="text-gray-600">
                                        <span class="text-xs text-gray-500">Inicial:</span><br>
                                        <span class="font-semibold">{{ number_format($auction->starting_price, 0, ',', '.') }} Kz</span>
                                    </div>
                                    <div class="text-gray-600">
                                        <span class="text-xs text-gray-500">Nº Lances:</span><br>
                                        <span class="font-bold text-indigo-600">{{ $auction->bids_count ?? 0 }}</span>
                                    </div>
                                    @if($auction->reserve_price)
                                        <div class="text-gray-600">
                                            <span class="text-xs text-gray-500">Reserva:</span><br>
                                            <span class="font-semibold text-amber-600">{{ number_format($auction->reserve_price, 0, ',', '.') }} Kz</span>
                                        </div>
                                    @else
                                        <div class="text-gray-600">
                                            <span class="text-xs text-gray-500">Próximo:</span><br>
                                            <span class="font-semibold text-green-600">{{ number_format($auction->current_bid + 1000, 0, ',', '.') }} Kz</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-red-700 font-semibold text-sm">Tempo restante:</span>
                                    </div>
                                    <span class="text-red-600 font-black text-lg countdown animate-pulse" data-end="{{ $auction->end_time->format('Y-m-d H:i:s') }}">
                                        @if($timeLeft->days > 0)
                                            {{ $timeLeft->format('%dd %H:%I:%S') }}
                                        @else
                                            {{ $timeLeft->format('%H:%I:%S') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="w-full bg-red-200 rounded-full h-3 overflow-hidden">
                                    <div class="bg-gradient-to-r from-red-500 to-pink-600 h-3 rounded-full transition-all duration-1000 shadow-inner" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-2">
                                <button onclick="openBidModal({{ $auction->id }}, '{{ $auction->title }}', {{ $auction->current_bid }}, {{ $auction->current_bid + 1000 }})" 
                                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white py-3 px-4 rounded-lg font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    🎯 Fazer Lance
                                </button>
                                @if($auction->buy_now_price)
                                    <button onclick="openBuyNowModal({{ $auction->id }}, '{{ $auction->title }}', {{ $auction->buy_now_price }}, {{ $auction->current_bid }})"
                                            class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-2 px-4 rounded-lg font-semibold text-xs transition-all duration-300 transform hover:scale-105">
                                        ⚡ Comprar por {{ number_format($auction->buy_now_price, 0, ',', '.') }} Kz
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $auctions->links() }}
            </div>
        @else
            <!-- No Auctions Available -->
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
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
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
                <a href="{{ route('register') }}" 
                   class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors">
                    Registar Agora
                </a>
                <a href="#" 
                   class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-purple-600 transition-colors">
                    Ver Todos os Leilões
                </a>
            </div>
        </div>
    </div>

    <!-- Bid Modal -->
    <div id="bidModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full mx-4 shadow-2xl overflow-hidden transform transition-all">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-8 text-white text-center relative">
                <button onclick="closeBidModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl">✕</button>
                <h2 class="text-2xl font-bold mb-2">🎯 Fazer Lance</h2>
                <p id="bidModalTitle" class="opacity-90">Produto do Leilão</p>
            </div>
            
            <div class="p-8">
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Lance Atual</div>
                            <div id="currentBidValue" class="text-xl font-bold text-purple-600">0 Kz</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Lance Mínimo</div>
                            <div id="minBidValue" class="text-xl font-bold text-green-600">0 Kz</div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-800 font-bold text-lg mb-3">💰 Seu Lance (Kz)</label>
                    <input type="number" id="bidAmount" class="w-full px-4 py-4 text-xl font-bold border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-center" placeholder="Digite qualquer valor acima do lance atual..." step="1000">
                    <div id="bidError" class="hidden mt-2 p-3 bg-red-50 border-l-4 border-red-400 rounded text-red-600 text-sm"></div>
                    <p class="text-sm text-gray-500 mt-2 text-center">💡 Pode inserir qualquer valor acima do lance atual</p>
                </div>
                
                <div class="mb-8">
                    <p class="text-gray-600 font-medium mb-4">⚡ Sugestões Rápidas:</p>
                    <div id="quickBids" class="grid grid-cols-2 gap-3"></div>
                </div>
                
                <div class="flex gap-4">
                    <button onclick="closeBidModal()" class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold text-lg transition-all">
                        Cancelar
                    </button>
                    <button onclick="submitBid()" class="flex-2 px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-xl font-bold text-lg transition-all">
                        Confirmar Lance
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Buy Now Modal -->
    <div id="buyNowModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full mx-4 shadow-2xl overflow-hidden transform transition-all">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-8 text-white text-center relative">
                <button onclick="closeBuyNowModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl">✕</button>
                <h2 class="text-2xl font-bold mb-2">⚡ Compra Instantânea</h2>
                <p id="buyNowModalTitle" class="opacity-90">Produto do Leilão</p>
            </div>
            
            <div class="p-8 text-center">
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 mb-6">
                    <div class="text-6xl mb-4">💰</div>
                    <div id="buyNowPrice" class="text-4xl font-bold text-emerald-600 mb-2">0 Kz</div>
                    <div class="text-gray-600 font-bold">Preço Final</div>
                    
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Diferença do Lance Atual:</div>
                        <div id="priceDifference" class="text-lg font-bold text-gray-800">+0 Kz</div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded p-4 mb-6">
                    <div class="flex items-center justify-center space-x-2 text-yellow-700">
                        <span class="text-xl">⚠️</span>
                        <span class="font-bold">O leilão será finalizado imediatamente</span>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <button onclick="closeBuyNowModal()" class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold text-lg transition-all">
                        Cancelar
                    </button>
                    <button onclick="submitBuyNow()" class="flex-1 px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl font-bold text-lg transition-all">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update countdown timers every second
    function updateCountdowns() {
        const countdowns = document.querySelectorAll('.countdown');
        
        countdowns.forEach(countdown => {
            const endDate = new Date(countdown.dataset.end);
            const now = new Date();
            const timeLeft = endDate - now;
            
            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                
                if (days > 0) {
                    countdown.textContent = `${days}d ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                } else {
                    countdown.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }
                
                // Update progress bar
                const card = countdown.closest('.bg-white');
                const progressBar = card.querySelector('.bg-red-500');
                if (progressBar) {
                    // Calculate progress based on time elapsed
                    const totalTimeElement = card.querySelector('[data-total-time]');
                    if (totalTimeElement) {
                        const totalTime = parseInt(totalTimeElement.dataset.totalTime);
                        const elapsed = totalTime - timeLeft;
                        const percentage = Math.min(100, (elapsed / totalTime) * 100);
                        progressBar.style.width = percentage + '%';
                    }
                }
            } else {
                countdown.textContent = 'FINALIZADO';
                countdown.classList.remove('text-red-600');
                countdown.classList.add('text-gray-500');
                
                // Disable buttons
                const card = countdown.closest('.bg-white');
                const buttons = card.querySelectorAll('button');
                buttons.forEach(button => {
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                });
            }
        });
    }
    
    // Update immediately and then every second
    updateCountdowns();
    setInterval(updateCountdowns, 1000);

    // Modal functionality
    let currentAuctionId = null;
    let currentBidAmount = 0;
    let minBidAmount = 0;

    // Open bid modal
    window.openBidModal = function(auctionId, title, currentBid, minBid) {
        currentAuctionId = auctionId;
        currentBidAmount = currentBid;
        minBidAmount = minBid;
        
        document.getElementById('bidModalTitle').textContent = title;
        document.getElementById('currentBidValue').textContent = formatNumber(currentBid) + ' Kz';
        document.getElementById('minBidValue').textContent = formatNumber(minBid) + ' Kz';
        document.getElementById('bidAmount').value = '';
        document.getElementById('bidAmount').min = currentBid + 1;
        document.getElementById('bidError').classList.add('hidden');
        
        // Generate quick bid buttons - incrementos flexíveis baseados no lance atual
        const quickBidsContainer = document.getElementById('quickBids');
        const suggestions = [
            currentBid + 1000,    // +1000 Kz
            currentBid + 5000,    // +5000 Kz
            currentBid + 10000,   // +10000 Kz
            currentBid + 25000    // +25000 Kz
        ];
        quickBidsContainer.innerHTML = suggestions.map(amount => 
            `<button onclick="setBidAmount(${amount})" class="px-3 py-2 bg-gray-100 hover:bg-purple-100 hover:text-purple-700 border border-gray-200 rounded-lg transition-all font-medium text-sm">
                +${formatNumber(amount - currentBid)} Kz
            </button>`
        ).join('');
        
        document.getElementById('bidModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    // Close bid modal
    window.closeBidModal = function() {
        document.getElementById('bidModal').classList.add('hidden');
        document.body.style.overflow = '';
    };

    // Set bid amount from quick buttons
    window.setBidAmount = function(amount) {
        document.getElementById('bidAmount').value = amount;
    };

    // Submit bid
    window.submitBid = function() {
        const bidValue = parseInt(document.getElementById('bidAmount').value);
        const errorDiv = document.getElementById('bidError');
        
        // Validação básica - apenas precisa ser maior que o lance atual
        if (!bidValue || bidValue <= currentBidAmount) {
            const errorMsg = `O lance deve ser maior que o atual: ${formatNumber(currentBidAmount)} Kz`;
            errorDiv.textContent = errorMsg;
            errorDiv.classList.remove('hidden');
            toastr.error(errorMsg);
            return;
        }
        
        // Esconde erro se havia
        errorDiv.classList.add('hidden');
        
        // Simula envio do lance
        toastr.success(`Lance de ${formatNumber(bidValue)} Kz enviado com sucesso!`);
        closeBidModal();
        
        // Atualiza a página (em implementação real seria AJAX)
        setTimeout(() => location.reload(), 1000);
    };

    // Open buy now modal
    window.openBuyNowModal = function(auctionId, title, buyPrice, currentBid) {
        currentAuctionId = auctionId;
        
        document.getElementById('buyNowModalTitle').textContent = title;
        document.getElementById('buyNowPrice').textContent = formatNumber(buyPrice) + ' Kz';
        document.getElementById('priceDifference').textContent = '+' + formatNumber(buyPrice - currentBid) + ' Kz';
        
        document.getElementById('buyNowModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    // Close buy now modal
    window.closeBuyNowModal = function() {
        document.getElementById('buyNowModal').classList.add('hidden');
        document.body.style.overflow = '';
    };

    // Submit buy now
    window.submitBuyNow = function() {
        if (confirm('Tem certeza que deseja comprar este item imediatamente?')) {
            toastr.success('Compra realizada com sucesso! O leilão foi finalizado.');
            closeBuyNowModal();
            
            // Atualiza a página (em implementação real seria AJAX)
            setTimeout(() => location.reload(), 1000);
        }
    };

    // Format number helper
    function formatNumber(num) {
        return new Intl.NumberFormat('pt-BR').format(num);
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'bidModal') closeBidModal();
        if (e.target.id === 'buyNowModal') closeBuyNowModal();
    });
});
</script>
@endpush
