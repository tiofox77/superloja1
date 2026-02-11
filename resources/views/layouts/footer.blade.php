@php
    $footerAppName = \App\Models\Setting::get('app_name', 'SuperLoja');
    $footerDesc = \App\Models\Setting::get('app_description', 'O maior e-commerce de Angola. Produtos de qualidade, entregas rápidas e os melhores preços do mercado.');
    $footerLogo = \App\Models\Setting::get('site_logo');
    $footerPhone = \App\Models\Setting::get('contact_phone', '+244 939 729 902');
    $footerEmail = \App\Models\Setting::get('contact_email', 'contato@superloja.vip');
    $footerAddress = \App\Models\Setting::get('address', 'Kilamba J13, Luanda, Angola');
    $footerWhatsapp = \App\Models\Setting::get('whatsapp_number', '');
    $footerFacebook = \App\Models\Setting::get('facebook_url', '');
    $footerInstagram = \App\Models\Setting::get('instagram_url', '');
    $footerTwitter = \App\Models\Setting::get('twitter_url', '');
    $footerYoutube = \App\Models\Setting::get('youtube_url', '');
    $footerTiktok = \App\Models\Setting::get('tiktok_url', '');
@endphp
<footer class="bg-gray-900 text-white" @persist('main-footer')>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    @if($footerLogo)
                        <img src="{{ asset('storage/' . $footerLogo) }}" alt="{{ $footerAppName }}" class="h-10 w-auto object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    <div class="flex items-center space-x-2" style="{{ $footerLogo ? 'display:none;' : '' }}">
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 py-2 rounded-lg font-bold text-xl">
                            {{ substr($footerAppName, 0, 1) }}
                        </div>
                    </div>
                    <span class="text-2xl font-bold">{{ $footerAppName }}</span>
                </div>
                <p class="text-gray-300 mb-4 max-w-md">
                    {{ $footerDesc }}
                </p>
                <div class="flex space-x-4">
                    @if($footerFacebook)
                    <a href="{{ $footerFacebook }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-orange-500 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if($footerInstagram)
                    <a href="{{ $footerInstagram }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-orange-500 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    @endif
                    @if($footerTwitter)
                    <a href="{{ $footerTwitter }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-orange-500 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    @endif
                    @if($footerYoutube)
                    <a href="{{ $footerYoutube }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-orange-500 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    @endif
                    @if($footerTiktok)
                    <a href="{{ $footerTiktok }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-orange-500 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Início</a></li>
                    <li><a href="{{ route('products') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Produtos</a></li>
                    <li><a href="{{ route('health.wellness') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">🍃 Saúde</a></li>
                    <li><a href="{{ route('offers') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Ofertas</a></li>
                    <li><a href="{{ route('auctions') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Leilões</a></li>
                    <li><a href="{{ route('brands') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Marcas</a></li>
                    <li><a href="{{ route('about') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Sobre Nós</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Atendimento</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('contact') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Contacto</a></li>
                    <li><a href="{{ route('faq') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">FAQ</a></li>
                    <li><a href="{{ route('privacy-policy') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Política de Privacidade</a></li>
                    <li><a href="{{ route('terms-of-service') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Termos de Uso</a></li>
                    <li><a href="{{ route('return-policy') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Política de Devolução</a></li>
                    <li><a href="{{ route('product-request') }}" wire:navigate class="text-gray-300 hover:text-orange-500 transition-colors duration-200">Solicitar Produto</a></li>
                </ul>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="mt-8 pt-8 border-t border-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div>
                        <p class="text-gray-300">{{ $footerAddress }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <div>
                        <p class="text-gray-300">{{ $footerPhone }}</p>
                        @if($footerWhatsapp)
                            <p class="text-sm text-gray-400">WhatsApp ativo</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-gray-300">{{ $footerEmail }}</p>
                        <p class="text-sm text-gray-400">Resposta em até 24h</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="mt-8 pt-8 border-t border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h4 class="text-sm font-semibold text-gray-300 mb-2">Métodos de Pagamento</h4>
                    <div class="flex space-x-4">
                        <div class="bg-white rounded-lg p-2 flex items-center justify-center w-12 h-8">
                            <span class="text-xs font-bold text-gray-600">VISA</span>
                        </div>
                        <div class="bg-white rounded-lg p-2 flex items-center justify-center w-12 h-8">
                            <span class="text-xs font-bold text-gray-600">MC</span>
                        </div>
                        <div class="bg-white rounded-lg p-2 flex items-center justify-center w-12 h-8">
                            <span class="text-xs font-bold text-gray-600">MB</span>
                        </div>
                        <div class="bg-white rounded-lg p-2 flex items-center justify-center w-12 h-8">
                            <span class="text-xs font-bold text-gray-600">BPC</span>
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <h4 class="text-sm font-semibold text-gray-300 mb-2">Entrega Segura</h4>
                    <div class="flex items-center space-x-2 text-sm text-gray-400">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>SSL Certificado</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-8 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm mb-4 md:mb-0">
                © {{ date('Y') }} {{ $footerAppName }}. Todos os direitos reservados.
            </p>
            <div class="text-gray-400 text-sm">
                Desenvolvido com ❤️ em Angola
            </div>
        </div>
    </div>
</footer>
