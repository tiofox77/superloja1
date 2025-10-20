<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-green-600 to-emerald-600 text-white">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">📱 Gerenciar SMS</h1>
                    <p class="text-green-100 mt-1">Templates e configurações de notificações SMS</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <button wire:click="createDefaultTemplates" 
                        class="btn-3d bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span>📄 Templates Padrão</span>
                </button>
                
                <button wire:click="openModal" 
                        class="btn-3d bg-gradient-to-r from-orange-500 to-red-600 text-white px-6 py-3 font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Novo Template</span>
                </button>
            </div>
        </div>
    </div>

    <!-- API Configuration & Test Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- API Status -->
        <div class="card-3d p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status da API Unimtx
                </h3>
                <button wire:click="testConnection"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                    🔄 Testar Conexão
                </button>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">API Key:</span>
                    <span class="font-mono text-sm">{{ $apiKey ? '••••••••••••' . substr($apiKey, -4) : 'Não configurada' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Assinatura:</span>
                    <span class="font-semibold">{{ $signature }}</span>
                </div>
                @if($connectionStatus)
                    <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-800">{{ $connectionStatus }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Test SMS -->
        <div class="card-3d p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Teste de SMS
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número de Telefone</label>
                    <input type="text" 
                           wire:model="testPhone"
                           placeholder="+244 939 729 902"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('testPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mensagem (máx. 160 chars)</label>
                    <textarea wire:model="testMessage"
                              placeholder="Mensagem de teste da SuperLoja"
                              maxlength="160"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              rows="3"></textarea>
                    @error('testMessage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">{{ strlen($testMessage) }}/160 caracteres</p>
                </div>
                
                <button wire:click="testSms"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                    📤 Enviar SMS Teste
                </button>
                
                @if($testResult)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700">{{ $testResult }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Templates List -->
    <div class="card-3d">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">📄 Templates de SMS</h2>
            <p class="text-gray-600 mt-1">Gerencie os templates para notificações automáticas</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mensagem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variáveis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($templates as $template)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ $template->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $template->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-md truncate">{{ $template->message }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($template->variables)
                                        @foreach($template->variables as $var)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">{{$var}}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleActive({{ $template->id }})"
                                        class="flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-medium transition-colors duration-200
                                               {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    @if($template->is_active)
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        <span>Ativo</span>
                                    @else
                                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                        <span>Inativo</span>
                                    @endif
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button wire:click="openModal({{ $template->id }})"
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                        ✏️ Editar
                                    </button>
                                    <button wire:click="delete({{ $template->id }})"
                                            onclick="return confirm('Tem certeza que deseja excluir este template?')"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                        🗑️ Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <p class="text-lg font-medium">Nenhum template encontrado</p>
                                    <p class="text-sm">Clique em "Templates Padrão" para criar os templates iniciais</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Criar/Editar Template -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-2xl bg-white">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $editingTemplate ? '✏️ Editar Template' : '➕ Novo Template' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                            <input type="text" 
                                   wire:model="type"
                                   placeholder="order_created, order_confirmed, etc."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                            <input type="text" 
                                   wire:model="name"
                                   placeholder="Nome amigável do template"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mensagem</label>
                            <textarea wire:model="message"
                                      placeholder="Use {{variavel}} para inserir dados dinâmicos"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      rows="4"></textarea>
                            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
                            <div class="mt-2 text-xs text-gray-500">
                                <p><strong>Variáveis disponíveis:</strong></p>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">{{customer_name}}</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">{{order_number}}</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">{{total}}</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">{{tracking_code}}</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">{{company_phone}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="is_active"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Template ativo</label>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" 
                                    wire:click="closeModal"
                                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                                {{ $editingTemplate ? 'Atualizar' : 'Criar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
