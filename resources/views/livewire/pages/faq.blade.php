<div class="bg-gradient-to-br from-orange-50 via-white to-red-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    ❓ Perguntas Frequentes
                </h1>
                <p class="text-xl text-orange-100 max-w-2xl mx-auto">
                    Encontre respostas rápidas para as perguntas mais comuns sobre nossos serviços
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Quick Contact -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-12 border border-gray-100">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    💬 Não encontrou sua resposta?
                </h2>
                <p class="text-gray-600 mb-6">
                    Nossa equipe está pronta para ajudar! Entre em contacto connosco.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/244939729902" target="_blank"
                       class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                        📱 WhatsApp: +244 939 729 902
                    </a>
                    <a href="{{ route('contact') }}"
                       class="border border-orange-500 text-orange-600 hover:bg-orange-500 hover:text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center justify-center">
                        📧 Formulário de Contacto
                    </a>
                </div>
            </div>
        </div>

        <!-- FAQ Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center text-2xl">
                    🛒
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Compras</h3>
                <p class="text-gray-600 text-sm">Como fazer pedidos e pagamentos</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center text-2xl">
                    🚚
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Entregas</h3>
                <p class="text-gray-600 text-sm">Prazos e áreas de entrega</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                <div class="w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-4 flex items-center justify-center text-2xl">
                    ↩️
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Devoluções</h3>
                <p class="text-gray-600 text-sm">Políticas de troca e devolução</p>
            </div>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-4">
            @php
                $faqs = [
                    [
                        'category' => 'Compras',
                        'question' => 'Como posso fazer um pedido?',
                        'answer' => 'Para fazer um pedido, navegue pelos nossos produtos, adicione os itens desejados ao carrinho e siga para o checkout. Você precisará criar uma conta ou fazer login para finalizar a compra.'
                    ],
                    [
                        'category' => 'Pagamento',
                        'question' => 'Quais formas de pagamento vocês aceitam?',
                        'answer' => 'Aceitamos transferência bancária, depósito bancário, Multicaixa Express e pagamento na entrega (cash on delivery). Para pagamentos eletrônicos, você deve anexar o comprovativo.'
                    ],
                    [
                        'category' => 'Entregas',
                        'question' => 'Qual é o prazo de entrega?',
                        'answer' => 'Em Luanda, as entregas são feitas em 24-48 horas úteis. No interior do país, o prazo é de 3-5 dias úteis, dependendo da localização.'
                    ],
                    [
                        'category' => 'Entregas',
                        'question' => 'Vocês entregam em todo o país?',
                        'answer' => 'Sim! Entregamos em todas as 18 províncias de Angola. Os prazos podem variar dependendo da distância e acessibilidade da localização.'
                    ],
                    [
                        'category' => 'Pagamento',
                        'question' => 'É seguro comprar online?',
                        'answer' => 'Absolutamente! Nossa plataforma usa criptografia SSL e seguimos as melhores práticas de segurança. Seus dados pessoais e de pagamento estão sempre protegidos.'
                    ],
                    [
                        'category' => 'Produtos',
                        'question' => 'Como posso verificar a disponibilidade de um produto?',
                        'answer' => 'A disponibilidade é mostrada na página do produto. Se um item estiver esgotado, você pode clicar em "Notificar quando disponível" para receber um alerta.'
                    ],
                    [
                        'category' => 'Devoluções',
                        'question' => 'Posso devolver ou trocar um produto?',
                        'answer' => 'Sim, você tem até 7 dias após o recebimento para solicitar troca ou devolução. O produto deve estar em perfeitas condições, com embalagem original.'
                    ],
                    [
                        'category' => 'Conta',
                        'question' => 'Como posso acompanhar meu pedido?',
                        'answer' => 'Após fazer o pedido, você receberá um e-mail com informações. Você também pode acompanhar o status na sua área do cliente no site.'
                    ],
                    [
                        'category' => 'Atendimento',
                        'question' => 'Como posso entrar em contacto com o suporte?',
                        'answer' => 'Você pode nos contactar via WhatsApp (+244 939 729 902), e-mail (contato@superloja.ao) ou através do formulário de contacto no site. Atendemos 24/7!'
                    ]
                ];
            @endphp

            @foreach($faqs as $index => $faq)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <button wire:click="toggleFaq({{ $index }})" 
                            class="w-full px-6 py-4 text-left hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-inset">
                        <div class="flex items-center justify-between">
                            <div class="flex items-start space-x-3">
                                <span class="inline-block px-2 py-1 bg-orange-100 text-orange-600 text-xs font-medium rounded-full">
                                    {{ $faq['category'] }}
                                </span>
                                <h3 class="text-lg font-semibold text-gray-900 flex-1">
                                    {{ $faq['question'] }}
                                </h3>
                            </div>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform {{ isset($openFaq[$index]) ? 'rotate-180' : '' }}" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    
                    @if(isset($openFaq[$index]))
                        <div class="px-6 pb-4">
                            <div class="pl-20">
                                <div class="border-t border-gray-200 pt-4">
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $faq['answer'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Contact CTA -->
        <div class="mt-16 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-2xl p-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">
                Ainda tem dúvidas?
            </h2>
            <p class="text-orange-100 mb-6 max-w-2xl mx-auto">
                Nossa equipe está sempre disponível para ajudá-lo. Entre em contacto conosco através do WhatsApp ou visite nossa loja em Kilamba J13.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/244939729902" target="_blank"
                   class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    📱 Falar no WhatsApp
                </a>
                <a href="{{ route('contact') }}"
                   class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-orange-600 transition-colors">
                    📧 Página de Contacto
                </a>
            </div>
        </div>
    </div>
</div>
