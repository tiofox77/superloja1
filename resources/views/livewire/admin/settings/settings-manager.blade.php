<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">⚙️ Configurações do Sistema</h1>
                    <p class="text-purple-100 mt-1">Gerencie as configurações da SuperLoja</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <button wire:click="resetDefaults" 
                        class="btn-3d bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Resetar</span>
                </button>
                
                <button wire:click="save" wire:loading.attr="disabled"
                        class="btn-3d bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" wire:loading>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove>💾 Salvar</span>
                    <span wire:loading>Salvando...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="card-3d mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6 py-4" aria-label="Tabs">
                <button wire:click="$set('activeTab', 'general')"
                        class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'general' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    🏢 Geral
                </button>
                <button wire:click="$set('activeTab', 'sms')"
                        class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'sms' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    📱 SMS
                </button>
                <button wire:click="$set('activeTab', 'payment')"
                        class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'payment' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    💳 Pagamentos
                </button>
                <button wire:click="$set('activeTab', 'notifications')"
                        class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'notifications' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    🔔 Notificações
                </button>
            </nav>
        </div>
    </div>

    <!-- Settings Content -->
    <div class="card-3d p-6">
        
        @if($activeTab === 'general')
            <!-- General Settings -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($defaultSettings['general'] as $key => $config)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $config['label'] }}
                                @if($config['description'])
                                    <span class="text-xs text-gray-500 block">{{ $config['description'] }}</span>
                                @endif
                            </label>
                            <input type="text" 
                                   wire:model="settings.{{ $key }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="{{ $config['default'] }}">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeTab === 'sms')
            <!-- SMS Settings -->
            <div class="space-y-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-blue-900 mb-2">📱 Configurações da API Unimtx</h4>
                    <p class="text-sm text-blue-800">Configure suas credenciais para envio de SMS automático.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($defaultSettings['sms'] as $key => $config)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $config['label'] }}
                                @if($config['description'])
                                    <span class="text-xs text-gray-500 block">{{ $config['description'] }}</span>
                                @endif
                            </label>
                            
                            @if($config['type'] === 'boolean')
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           wire:model="settings.{{ $key }}"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-600">Ativo</span>
                                </div>
                            @else
                                <input type="{{ $key === 'unimtx_access_key' ? 'password' : 'text' }}" 
                                       wire:model="settings.{{ $key }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="{{ $config['default'] }}">
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="flex space-x-3 pt-4">
                    <button wire:click="testSmsConnection"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                        🔍 Testar Configurações SMS
                    </button>
                </div>
            </div>
        @endif

        @if($activeTab === 'payment')
            <!-- Payment Settings -->
            <div class="space-y-6">
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-green-900 mb-2">💳 Informações de Pagamento</h4>
                    <p class="text-sm text-green-800">Configure os dados bancários que aparecerão no checkout.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($defaultSettings['payment'] as $key => $config)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $config['label'] }}
                                @if($config['description'])
                                    <span class="text-xs text-gray-500 block">{{ $config['description'] }}</span>
                                @endif
                            </label>
                            <input type="text" 
                                   wire:model="settings.{{ $key }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="{{ $config['default'] }}">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeTab === 'notifications')
            <!-- Notification Settings -->
            <div class="space-y-6">
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-yellow-900 mb-2">🔔 Configurações de Notificações</h4>
                    <p class="text-sm text-yellow-800">Controle como e quando as notificações são enviadas.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($defaultSettings['notifications'] as $key => $config)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $config['label'] }}
                                @if($config['description'])
                                    <span class="text-xs text-gray-500 block">{{ $config['description'] }}</span>
                                @endif
                            </label>
                            
                            @if($config['type'] === 'boolean')
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           wire:model="settings.{{ $key }}"
                                           class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-600">Habilitado</span>
                                </div>
                            @else
                                <input type="email" 
                                       wire:model="settings.{{ $key }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                       placeholder="{{ $config['default'] }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <!-- Help Section -->
    <div class="card-3d p-6 mt-6 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Ajuda e Informações</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
            <div>
                <h4 class="font-medium text-gray-900 mb-2">🔐 Segurança</h4>
                <p>Configurações sensíveis como API Keys são criptografadas automaticamente no banco de dados.</p>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-2">🔄 Backup</h4>
                <p>Sempre faça backup das configurações antes de fazer alterações importantes.</p>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-2">📱 SMS</h4>
                <p>Para usar SMS, obtenha uma API Key da Unimtx em <a href="https://www.unimtx.com" target="_blank" class="text-blue-600 hover:underline">unimtx.com</a></p>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-2">💳 Pagamentos</h4>
                <p>Os dados bancários configurados aparecerão automaticamente no checkout para os clientes.</p>
            </div>
        </div>
    </div>
</div>
