<div class="bg-gradient-to-br from-orange-50 via-white to-red-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    🛒 Solicitar Produto
                </h1>
                <p class="text-xl text-orange-100 max-w-2xl mx-auto">
                    Não encontrou o que procura? Solicite o produto desejado e nós faremos o possível para conseguir!
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Informações do Serviço -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-gray-100">
                <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                    🔍
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Busca Personalizada</h3>
                <p class="text-gray-600 text-sm">Nossa equipe irá procurar o produto específico que você precisa</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-gray-100">
                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                    💰
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Melhor Preço</h3>
                <p class="text-gray-600 text-sm">Negociamos diretamente com fornecedores para conseguir preços competitivos</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-gray-100">
                <div class="w-16 h-16 bg-purple-100 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                    ⚡
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Resposta Rápida</h3>
                <p class="text-gray-600 text-sm">Resposta em até 24h sobre disponibilidade e prazo de entrega</p>
            </div>
        </div>

        <!-- Formulário de Solicitação -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center mr-3 text-xl">📝</span>
                Formulário de Solicitação
            </h2>
            
            <form wire:submit.prevent="submitRequest" class="space-y-6">
                
                <!-- Informações Pessoais -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800 flex items-center">
                            <span class="mr-2">👤</span> Suas Informações
                        </h3>
                        @auth
                            <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Dados preenchidos automaticamente
                            </div>
                        @else
                            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('login') }}" class="hover:underline">Faça login para preenchimento automático</a>
                            </div>
                        @endauth
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                            <input type="text" 
                                   wire:model.blur="name" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="Seu nome completo">
                            @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" 
                                   wire:model.blur="email" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="seu@email.com">
                            @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                            <input type="text" 
                                   wire:model.blur="phone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="939729902">
                            @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Informações do Produto -->
                <div class="bg-blue-50 rounded-xl p-6">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="mr-2">🏷️</span> Produto Desejado
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Produto *</label>
                                <input type="text" 
                                       wire:model.blur="product_name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Ex: iPhone 15 Pro Max 256GB">
                                @error('product_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                                <select wire:model.blur="product_category" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    <option value="">Selecione a categoria</option>
                                    <option value="Eletrônicos">📱 Eletrônicos</option>
                                    <option value="Moda e Acessórios">👕 Moda e Acessórios</option>
                                    <option value="Casa e Decoração">🏠 Casa e Decoração</option>
                                    <option value="Beleza e Cuidados">💄 Beleza e Cuidados</option>
                                    <option value="Esporte e Lazer">⚽ Esporte e Lazer</option>
                                    <option value="Saúde e Bem-estar">🏥 Saúde e Bem-estar</option>
                                    <option value="Automóveis">🚗 Automóveis</option>
                                    <option value="Livros e Educação">📚 Livros e Educação</option>
                                    <option value="Brinquedos">🧸 Brinquedos</option>
                                    <option value="Ferramentas">🔧 Ferramentas</option>
                                    <option value="Outros">❓ Outros</option>
                                </select>
                                @error('product_category') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição Detalhada *</label>
                            <textarea wire:model.blur="product_description" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                      placeholder="Descreva o produto em detalhes: marca, modelo, cor, tamanho, especificações técnicas, etc."></textarea>
                            @error('product_description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Detalhes da Compra -->
                <div class="bg-green-50 rounded-xl p-6">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="mr-2">💰</span> Detalhes da Compra
                    </h3>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preço Preferido (AOA)</label>
                            <input type="number" 
                                   wire:model.blur="preferred_price" 
                                   step="0.01" 
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="Ex: 150000">
                            @error('preferred_price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            <p class="text-gray-500 text-xs mt-1">Deixe em branco se não tem preferência</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantidade *</label>
                            <input type="number" 
                                   wire:model.blur="quantity" 
                                   min="1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="1">
                            @error('quantity') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Urgência *</label>
                            <select wire:model.blur="urgency" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="">Selecione a urgência</option>
                                <option value="Baixa">🟢 Baixa (1-2 semanas)</option>
                                <option value="Média">🟡 Média (3-7 dias)</option>
                                <option value="Alta">🟠 Alta (1-3 dias)</option>
                                <option value="Urgente">🔴 Urgente (24h)</option>
                            </select>
                            @error('urgency') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Informações Adicionais -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Informações Adicionais</label>
                    <textarea wire:model.blur="additional_info" 
                              rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                              placeholder="Alguma informação adicional que possa nos ajudar a encontrar o produto ideal..."></textarea>
                    @error('additional_info') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Botão de Envio -->
                <div class="text-center pt-6">
                    <button type="submit" 
                            class="bg-gradient-to-r from-orange-600 to-red-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-orange-700 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        📱 Enviar Solicitação via WhatsApp
                    </button>
                    <p class="text-gray-500 text-sm mt-2">
                        Você será redirecionado para o WhatsApp com sua solicitação preenchida
                    </p>
                </div>
            </form>
        </div>

        <!-- Como Funciona -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <span class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center mr-3 text-xl">❓</span>
                Como Funciona?
            </h2>
            
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl font-bold">
                        1
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Solicite</h3>
                    <p class="text-gray-600 text-sm">Preencha o formulário com detalhes do produto</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl font-bold">
                        2
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Buscamos</h3>
                    <p class="text-gray-600 text-sm">Nossa equipe procura o produto com fornecedores</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl font-bold">
                        3
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Cotação</h3>
                    <p class="text-gray-600 text-sm">Enviamos preço e prazo de entrega</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl font-bold">
                        4
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Compra</h3>
                    <p class="text-gray-600 text-sm">Se aprovar, processamos seu pedido</p>
                </div>
            </div>
        </div>

        <!-- Vantagens -->
        <div class="grid md:grid-cols-2 gap-8 mt-12">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="mr-2">✅</span> Vantagens do Serviço
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Acesso a produtos não disponíveis no site
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Negociação direta com fornecedores
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Preços competitivos e personalizados
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                        Suporte especializado durante todo processo
                    </li>
                </ul>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="mr-2">📞</span> Outras Formas de Contacto
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center text-gray-700">
                        <span class="text-green-600 mr-3">📱</span>
                        <div>
                            <p class="font-medium">WhatsApp</p>
                            <p class="text-sm text-gray-500">+244 939 729 902</p>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <span class="text-blue-600 mr-3">📧</span>
                        <div>
                            <p class="font-medium">Email</p>
                            <p class="text-sm text-gray-500">contato@superloja.ao</p>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <span class="text-orange-600 mr-3">🏢</span>
                        <div>
                            <p class="font-medium">Presencial</p>
                            <p class="text-sm text-gray-500">Kilamba J13, Luanda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
