<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🧠 Centro de Conhecimento da IA</h1>
            <p class="text-gray-600 mt-1">Visualize e gerencie tudo que a IA aprendeu</p>
        </div>
        
        <button wire:click="openKnowledgeModal"
                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition-all shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Adicionar Conhecimento
        </button>
    </div>

    <!-- Mensagens -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-400">
            {{ session('message') }}
        </div>
    @endif

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <!-- Total Conhecimento -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Base de Conhecimento</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['total_knowledge'] }}</h3>
                    <p class="text-purple-200 text-xs mt-1">Respostas ativas</p>
                </div>
                <div class="text-4xl opacity-50">📚</div>
            </div>
        </div>

        <!-- Total Clientes -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Clientes Conhecidos</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['total_customers'] }}</h3>
                    <p class="text-blue-200 text-xs mt-1">Com histórico</p>
                </div>
                <div class="text-4xl opacity-50">👥</div>
            </div>
        </div>

        <!-- VIP -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Clientes VIP</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['vip_customers'] }}</h3>
                    <p class="text-yellow-200 text-xs mt-1">Alta receita</p>
                </div>
                <div class="text-4xl opacity-50">⭐</div>
            </div>
        </div>

        <!-- Conversas -->
        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Conversas</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['total_conversations'] }}</h3>
                    <p class="text-green-200 text-xs mt-1">Todas plataformas</p>
                </div>
                <div class="text-4xl opacity-50">💬</div>
            </div>
        </div>

        <!-- Taxa de Sucesso -->
        <div class="bg-gradient-to-br from-pink-500 to-pink-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-sm font-medium">Taxa de Sucesso</p>
                    <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['avg_success_rate'], 1) }}%</h3>
                    <p class="text-pink-200 text-xs mt-1">Respostas corretas</p>
                </div>
                <div class="text-4xl opacity-50">✅</div>
            </div>
        </div>
    </div>

    <!-- Análise de Sentimento -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="text-2xl">😊</span>
            Análise de Sentimento (Últimos 7 dias)
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Positivo -->
            <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-green-700 font-semibold">😊 Positivo</span>
                    <span class="text-2xl font-bold text-green-600">{{ $sentimentTrends['positive'] }}%</span>
                </div>
                <div class="w-full bg-green-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $sentimentTrends['positive'] }}%"></div>
                </div>
            </div>

            <!-- Neutro -->
            <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700 font-semibold">😐 Neutro</span>
                    <span class="text-2xl font-bold text-gray-600">{{ $sentimentTrends['neutral'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gray-600 h-2 rounded-full" style="width: {{ $sentimentTrends['neutral'] }}%"></div>
                </div>
            </div>

            <!-- Negativo -->
            <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-red-700 font-semibold">😞 Negativo</span>
                    <span class="text-2xl font-bold text-red-600">{{ $sentimentTrends['negative'] }}%</span>
                </div>
                <div class="w-full bg-red-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ $sentimentTrends['negative'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de 2 colunas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Base de Conhecimento -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-2xl">📚</span>
                Base de Conhecimento (Top 10)
            </h2>

            @if($knowledgeItems->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                    <p class="font-semibold">Nenhum conhecimento ainda</p>
                    <p class="text-sm mt-1">Adicione respostas para a IA aprender</p>
                </div>
            @else
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($knowledgeItems as $item)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow {{ $item->is_active ? 'bg-white' : 'bg-gray-50' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-semibold">
                                            {{ ucfirst($item->category) }}
                                        </span>
                                        @if($item->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">✓ Ativo</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">○ Inativo</span>
                                        @endif
                                    </div>
                                    
                                    <p class="font-semibold text-gray-800 mb-1">{{ $item->question }}</p>
                                    <p class="text-sm text-gray-600 mb-2">{{ \Illuminate\Support\Str::limit($item->answer, 100) }}</p>
                                    
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span>📊 Usado {{ $item->times_used }}x</span>
                                        <span>✅ {{ number_format($item->success_rate, 1) }}% sucesso</span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2 ml-4">
                                    <button wire:click="toggleKnowledge({{ $item->id }})"
                                            class="p-2 {{ $item->is_active ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} rounded transition-colors"
                                            title="{{ $item->is_active ? 'Desativar' : 'Ativar' }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="deleteKnowledge({{ $item->id }})"
                                            onclick="return confirm('Remover este conhecimento?')"
                                            class="p-2 bg-red-100 text-red-700 hover:bg-red-200 rounded transition-colors"
                                            title="Remover">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Top Clientes -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-2xl">👥</span>
                Top Clientes (Por Receita)
            </h2>

            @if($topCustomers->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <p class="font-semibold">Nenhum cliente ainda</p>
                    <p class="text-sm mt-1">Aguardando primeiras conversas</p>
                </div>
            @else
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($topCustomers as $customer)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <!-- Avatar -->
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr($customer->customer_name ?? $customer->customer_identifier, 0, 1) }}
                                    </div>
                                    
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $customer->customer_name ?? 'Cliente ' . substr($customer->customer_identifier, 0, 8) }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-1 {{ $customer->customer_segment === 'vip' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }} rounded text-xs font-semibold">
                                                {{ ucfirst($customer->customer_segment) }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $customer->preferred_platform }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">{{ number_format((float)$customer->total_spent, 2) }} Kz</p>
                                    <p class="text-xs text-gray-500">{{ $customer->total_purchases }} compras</p>
                                    <p class="text-xs text-gray-500">{{ $customer->total_conversations }} conversas</p>
                                </div>
                            </div>

                            @if($customer->interests && count($customer->interests) > 0)
                                <div class="mt-3 flex flex-wrap gap-1">
                                    <span class="text-xs text-gray-500">Interesses:</span>
                                    @foreach($customer->interests as $interest)
                                        <span class="px-2 py-1 bg-purple-50 text-purple-600 rounded-full text-xs">
                                            {{ $interest }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Novo Conhecimento -->
    @if($showKnowledgeModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800">Adicionar Conhecimento</h3>
                    <p class="text-gray-600 mt-1">Ensine a IA uma nova resposta</p>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Categoria -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Categoria</label>
                        <select wire:model="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="faq">FAQ - Perguntas Frequentes</option>
                            <option value="product_info">Informação de Produto</option>
                            <option value="policy">Políticas e Regras</option>
                            <option value="support">Suporte</option>
                        </select>
                    </div>

                    <!-- Pergunta -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pergunta</label>
                        <input type="text" wire:model="question" 
                               placeholder="Ex: Como funciona a entrega?"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('question') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Resposta -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Resposta</label>
                        <textarea wire:model="answer" rows="4"
                                  placeholder="Ex: Fazemos entregas em Luanda e outras províncias..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                        @error('answer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Keywords -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Palavras-chave (separadas por vírgula)</label>
                        <input type="text" wire:model="keywords" 
                               placeholder="Ex: entrega, envio, frete"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Ajuda a IA a identificar quando usar esta resposta</p>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                    <button wire:click="closeKnowledgeModal"
                            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveKnowledge"
                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 font-semibold transition-all shadow-lg">
                        Salvar Conhecimento
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
