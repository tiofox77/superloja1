<footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 py-2 rounded-lg font-bold text-xl">
                        S
                    </div>
                    <span class="text-2xl font-bold">SuperLoja</span>
                </div>
                <p class="text-gray-300 mb-4 max-w-md">
                    A melhor loja de eletrônicos de Angola. Oferecemos produtos de qualidade com entrega rápida e segura em todo o país.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-orange-500 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-orange-500 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-orange-500 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.219-.359-1.219c0-1.142.662-1.995 1.488-1.995.219 0 .518.156.518.518 0 .315-.201.789-.312 1.227-.219.937.469 1.703 1.391 1.703 1.671 0 2.955-1.764 2.955-4.311 0-2.255-1.618-3.83-3.93-3.83-2.678 0-4.249 2.008-4.249 4.081 0 .808.312 1.674.703 2.147a.36.36 0 0 1 .084.343c-.094.312-.312 1.268-.359 1.445-.063.219-.219.266-.5.156-1.391-.656-2.26-2.677-2.26-4.311 0-2.97 2.16-5.7 6.229-5.7 3.27 0 5.811 2.33 5.811 5.448 0 3.251-2.047 5.87-4.894 5.87-1.656 0-2.216-.859-2.216-.859s-.485 1.85-.6 2.3c-.219.839-.812 1.893-1.211 2.536.912.281 1.879.437 2.882.437 6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001.012.001z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-orange-500 transition-colors">Início</a></li>
                    <li><a href="{{ route('products') }}" class="text-gray-300 hover:text-orange-500 transition-colors">Produtos</a></li>
                    <li><a href="{{ route('categories') }}" class="text-gray-300 hover:text-orange-500 transition-colors">Categorias</a></li>
                    <li><a href="{{ route('offers') }}" class="text-gray-300 hover:text-orange-500 transition-colors">Ofertas</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-orange-500 transition-colors">Contacto</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Luanda, Angola</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+244 123 456 789</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>info@superloja.vip</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-300 text-sm mb-4 md:mb-0">
                {{ date('Y') }} SuperLoja. Todos os direitos reservados.
            </p>
            <div class="flex space-x-6 text-sm">
                <a href="#" class="text-gray-300 hover:text-orange-500 transition-colors">Política de Privacidade</a>
                <a href="#" class="text-gray-300 hover:text-orange-500 transition-colors">Termos de Uso</a>
                <a href="#" class="text-gray-300 hover:text-orange-500 transition-colors">FAQ</a>
            </div>
        </div>
    </div>
</footer>
