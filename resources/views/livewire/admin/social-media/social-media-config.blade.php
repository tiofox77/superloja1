<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Configurações de Redes Sociais</h1>
                <p class="text-purple-100">Configure tokens, IDs de página e autopost para cada plataforma</p>
            </div>
        </div>
    </div>

    <!-- Platforms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($configs as $platformKey => $config)
            <div class="card-3d p-6 bg-white border border-gray-200 hover:shadow-lg transition-all duration-300">
                <!-- Platform Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 {{ $config['color'] }} rounded-xl flex items-center justify-center text-white">
                            <i class="{{ $config['icon'] }} text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $config['name'] }}</h3>
                            <div class="flex items-center space-x-2">
                                @if($config['is_configured'])
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Configurado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Não configurado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Indicators -->
                @if($config['is_configured'])
                    <div class="space-y-3 mb-4">
                        @if($config['is_expired'])
                            <div class="flex items-center justify-between p-2 bg-red-50 rounded-lg">
                                <span class="text-sm text-red-700">Token expirado</span>
                                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Ativo:</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:click="toggleActive('{{ $platformKey }}')"
                                       @if($config['is_active']) checked @endif
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Auto-post:</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:click="toggleAutoPost('{{ $platformKey }}')"
                                       @if($config['auto_post']) checked @endif
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        @if($config['page_id'])
                            <div class="text-xs text-gray-500">
                                ID: {{ Str::limit($config['page_id'], 20) }}
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button wire:click="openConfigModal('{{ $platformKey }}')" 
                            class="flex-1 btn-3d bg-gradient-to-r {{ $config['color'] }} text-white text-sm py-2">
                        {{ $config['is_configured'] ? 'Editar' : 'Configurar' }}
                    </button>
                    
                    @if($config['is_configured'])
                        <button wire:click="testConnection('{{ $platformKey }}')" 
                                class="btn-3d bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                        
                        <button wire:click="deleteConfig('{{ $platformKey }}')" 
                                onclick="return confirm('Tem certeza que deseja remover esta configuração?')"
                                class="btn-3d bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Configuration Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-900">
                            Configurar {{ $platforms[$selectedPlatform]['name'] ?? $selectedPlatform }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <form wire:submit.prevent="saveConfig" class="p-6 space-y-6">
                    <!-- Platform Info -->
                    <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 {{ $platforms[$selectedPlatform]['color'] ?? 'bg-gray-500' }} rounded-xl flex items-center justify-center text-white">
                            <i class="{{ $platforms[$selectedPlatform]['icon'] ?? 'fas fa-share-alt' }} text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $platforms[$selectedPlatform]['name'] ?? $selectedPlatform }}</h4>
                            <p class="text-sm text-gray-600">Configure as credenciais da API</p>
                        </div>
                    </div>

                    <!-- Access Token -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Token de Acesso *
                        </label>
                        <textarea wire:model="access_token" 
                                  rows="3"
                                  placeholder="Cole aqui o token de acesso da API..."
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  required></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Token de longa duração para acesso àAPI
                        </p>
                    </div>

                    <!-- Page ID (if required) -->
                    @if(in_array('page_id', $platforms[$selectedPlatform]['fields'] ?? []))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                ID da Página
                            </label>
                            <input type="text" 
                                   wire:model="page_id"
                                   placeholder="ID da página/conta business"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">
                                ID da página para publicações
                            </p>
                        </div>
                    @endif

                    <!-- App ID -->
                    @if(in_array('app_id', $platforms[$selectedPlatform]['fields'] ?? []))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                App ID
                            </label>
                            <input type="text" 
                                   wire:model="app_id"
                                   placeholder="ID da aplicação"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    @endif

                    <!-- App Secret -->
                    @if(in_array('app_secret', $platforms[$selectedPlatform]['fields'] ?? []))
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                App Secret
                            </label>
                            <input type="password" 
                                   wire:model="app_secret"
                                   placeholder="Chave secreta da aplicação"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    @endif

                    <!-- Settings -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="is_active"
                                   id="is_active"
                                   class="checkbox-modern">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Plataforma ativa
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="auto_post"
                                   id="auto_post"
                                   class="checkbox-modern">
                            <label for="auto_post" class="ml-2 text-sm text-gray-700">
                                Auto-post ativo
                            </label>
                        </div>
                    </div>

                    <!-- Help Text -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h5 class="font-medium text-blue-900 mb-2">Como obter as credenciais:</h5>
                        <div class="text-sm text-blue-800 space-y-1">
                            @if($selectedPlatform === 'facebook')
                                <p>• Acesse <a href="https://developers.facebook.com/" target="_blank" class="underline">Facebook Developers</a></p>
                                <p>• Crie um app e configure as permissões necessárias</p>
                                <p>• Gere um token de longa duração</p>
                            @elseif($selectedPlatform === 'instagram')
                                <p>• Configure primeiro o Facebook (mesmo token)</p>
                                <p>• Use o ID da conta business do Instagram</p>
                                <p>• Conecte o Instagram ao Facebook</p>
                            @else
                                <p>• Acesse o painel de desenvolvedor da plataforma</p>
                                <p>• Crie uma aplicação e obtenha as credenciais</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button type="button" 
                                wire:click="closeModal"
                                class="btn-3d bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-2">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="btn-3d bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2">
                            Salvar Configuração
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
