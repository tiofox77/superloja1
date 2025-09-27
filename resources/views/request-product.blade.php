@extends('layouts.app')

@section('title', 'Solicitar Produto - SuperLoja')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Solicitar Produto</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Não encontrou o produto que procura? Não se preocupe! 
                Solicite-nos e nós encontramos para si ao melhor preço.
            </p>
        </div>
    </div>

    <!-- Request Form -->
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Descreva o Produto Desejado</h2>
                    <p class="text-gray-600">Preencha o formulário abaixo e entraremos em contacto consigo</p>
                </div>

                <form class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="product_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome do Produto *
                        </label>
                        <input type="text" 
                               id="product_name" 
                               name="product_name" 
                               placeholder="Ex: iPhone 15 Pro Max 256GB"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                            Categoria
                        </label>
                        <select id="category" 
                                name="category"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecione uma categoria</option>
                            <option value="smartphones">Smartphones</option>
                            <option value="computadores">Computadores</option>
                            <option value="gaming">Gaming</option>
                            <option value="audio">Áudio e Som</option>
                            <option value="casa">Casa Inteligente</option>
                            <option value="acessorios">Acessórios</option>
                            <option value="saude">Saúde e Bem-estar</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-semibold text-gray-700 mb-2">
                            Marca Preferida
                        </label>
                        <input type="text" 
                               id="brand" 
                               name="brand" 
                               placeholder="Ex: Apple, Samsung, Sony..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Descrição Detalhada *
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="5"
                                  placeholder="Descreva em detalhe o produto que procura: especificações técnicas, cor, tamanho, etc."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  required></textarea>
                    </div>

                    <!-- Budget -->
                    <div>
                        <label for="budget" class="block text-sm font-semibold text-gray-700 mb-2">
                            Orçamento Máximo (Kz)
                        </label>
                        <input type="number" 
                               id="budget" 
                               name="budget" 
                               placeholder="Ex: 500000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Seu Nome *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   placeholder="Nome completo"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Telefone *
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   placeholder="+244 900 000 000"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               placeholder="seu@email.com"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>

                    <!-- Urgency -->
                    <div>
                        <label for="urgency" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nível de Urgência
                        </label>
                        <select id="urgency" 
                                name="urgency"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="normal">Normal (5-10 dias)</option>
                            <option value="urgent">Urgente (2-5 dias)</option>
                            <option value="very_urgent">Muito Urgente (1-2 dias)</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Enviar Solicitação
                        </button>
                    </div>

                    <p class="text-sm text-gray-500 text-center">
                        * Campos obrigatórios. Entraremos em contacto consigo em até 24 horas.
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- How it Works -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Como Funciona</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Processo simples para encontrar o produto dos seus sonhos</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">1. Descreva</h3>
                    <p class="text-gray-600 text-sm">Preencha o formulário com os detalhes do produto</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">2. Procuramos</h3>
                    <p class="text-gray-600 text-sm">Nossa equipe procura o melhor preço no mercado</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">3. Contactamos</h3>
                    <p class="text-gray-600 text-sm">Entramos em contacto com uma proposta</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">4. Entregamos</h3>
                    <p class="text-gray-600 text-sm">Produto entregue na sua casa com garantia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Perguntas Frequentes</h2>
            </div>

            <div class="max-w-3xl mx-auto space-y-6">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Quanto tempo demora para encontrar o produto?</h3>
                    <p class="text-gray-600">Normalmente entre 24-48 horas. Para produtos urgentes, podemos encontrar em algumas horas.</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Há algum custo por este serviço?</h3>
                    <p class="text-gray-600">Não! O serviço de busca é completamente gratuito. Só paga se decidir comprar o produto.</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">E se não encontrarem o produto?</h3>
                    <p class="text-gray-600">Contactamos sempre, mesmo que não encontremos. Podemos sugerir alternativas similares.</p>
                </div>

                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">O produto tem garantia?</h3>
                    <p class="text-gray-600">Sim! Todos os produtos vendidos pela SuperLoja têm garantia mínima de 6 meses.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
