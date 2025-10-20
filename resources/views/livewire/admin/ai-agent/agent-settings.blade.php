<div class="p-6" x-data="{ activeTab: 'system' }">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">⚙️ Configurações do AI Agent</h1>
        <p class="text-gray-600 mt-1">Configure integrações e comportamento do agente</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('message') }}</div>
    @endif

    <!-- Test Result Alert -->
    @if($testResult)
        @php
            [$type, $message] = explode(':', $testResult, 2);
            $alertClass = match($type) {
                'success' => 'bg-green-100 text-green-700 border-green-400',
                'error' => 'bg-red-100 text-red-700 border-red-400',
                'info' => 'bg-blue-100 text-blue-700 border-blue-400',
                default => 'bg-gray-100 text-gray-700 border-gray-400',
            };
        @endphp
        <div class="mb-4 p-4 border-l-4 {{ $alertClass }} rounded-lg">
            {{ $message }}
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex flex-wrap -mb-px">
                <button @click="activeTab = 'system'" 
                        :class="activeTab === 'system' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    💾 Configurações Sistema
                </button>
                <button @click="activeTab = 'basic'" 
                        :class="activeTab === 'basic' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    🤖 Configurações Básicas
                </button>
                <button @click="activeTab = 'integrations'" 
                        :class="activeTab === 'integrations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    🔗 Integrações
                </button>
                <button @click="activeTab = 'ai-config'" 
                        :class="activeTab === 'ai-config' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    🤖 Configuração de IA
                </button>
                <button @click="activeTab = 'advanced'" 
                        :class="activeTab === 'advanced' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    🎛️ Avançado
                </button>
                <button @click="activeTab = 'webhooks'" 
                        :class="activeTab === 'webhooks' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    🔔 Webhooks
                </button>
                <button @click="activeTab = 'cronjobs'" 
                        :class="activeTab === 'cronjobs' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm whitespace-nowrap transition-colors">
                    ⏰ Cron Jobs
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="space-y-6">
            <!-- Configurações do Sistema (Banco de Dados) -->
            <div x-show="activeTab === 'system'" x-cloak class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">💾 Configurações do Sistema</h2>
                <p class="text-sm text-gray-600 mb-4">Todas estas configurações são armazenadas no banco de dados</p>
                
                <form wire:submit="saveSystemConfigs" class="space-y-6">
                    <!-- AI Agent Settings -->
                    <div class="border-b pb-4">
                        <h3 class="font-bold text-lg mb-3">🤖 AI Agent</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="ai_agent_enabled" 
                                       id="ai_agent_enabled" 
                                       class="mr-2">
                                <label for="ai_agent_enabled" class="text-sm font-medium text-gray-700">
                                    AI Agent Habilitado
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Frequência de Análise
                                </label>
                                <select wire:model="ai_analysis_frequency" class="w-full px-4 py-2 border rounded-lg">
                                    <option value="daily">Diária</option>
                                    <option value="weekly">Semanal</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="ai_auto_post_enabled" 
                                       id="ai_auto_post_enabled" 
                                       class="mr-2">
                                <label for="ai_auto_post_enabled" class="text-sm font-medium text-gray-700">
                                    Posts Automáticos Habilitados
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Facebook Settings -->
                    <div class="border-b pb-4">
                        <h3 class="font-bold text-lg mb-3">📘 Facebook</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Facebook App ID
                                </label>
                                <input type="text" 
                                       wire:model="facebook_app_id" 
                                       placeholder="ID do App Facebook..."
                                       class="w-full px-4 py-2 border rounded-lg">
                                @if(\App\Models\SystemConfig::has('facebook_app_id'))
                                    <p class="text-xs text-green-600 mt-1">✓ Configurado no banco de dados</p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Facebook App Secret
                                </label>
                                <input type="password" 
                                       wire:model="facebook_app_secret" 
                                       placeholder="Secret do App Facebook..."
                                       class="w-full px-4 py-2 border rounded-lg">
                                @if(\App\Models\SystemConfig::has('facebook_app_secret'))
                                    <p class="text-xs text-green-600 mt-1">✓ Configurado no banco de dados (criptografado)</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Deixe vazio para manter o valor atual</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Facebook Verify Token (para Webhooks)
                                </label>
                                <input type="password" 
                                       wire:model="facebook_verify_token" 
                                       placeholder="Token de verificação..."
                                       class="w-full px-4 py-2 border rounded-lg">
                                @if(\App\Models\SystemConfig::has('facebook_verify_token'))
                                    <p class="text-xs text-green-600 mt-1">✓ Configurado no banco de dados (criptografado)</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Use esta mesma string ao configurar o webhook</p>
                            </div>
                        </div>
                    </div>

                    <!-- Instagram Settings -->
                    <div class="border-b pb-4">
                        <h3 class="font-bold text-lg mb-3">📸 Instagram</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Instagram Business Account ID
                                </label>
                                <input type="text" 
                                       wire:model="instagram_business_account_id" 
                                       placeholder="ID da conta business..."
                                       class="w-full px-4 py-2 border rounded-lg">
                                @if(\App\Models\SystemConfig::has('instagram_business_account_id'))
                                    <p class="text-xs text-green-600 mt-1">✓ Configurado no banco de dados</p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Instagram Verify Token (para Webhooks)
                                </label>
                                <input type="password" 
                                       wire:model="instagram_verify_token" 
                                       placeholder="Token de verificação..."
                                       class="w-full px-4 py-2 border rounded-lg">
                                @if(\App\Models\SystemConfig::has('instagram_verify_token'))
                                    <p class="text-xs text-green-600 mt-1">✓ Configurado no banco de dados (criptografado)</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Use esta mesma string ao configurar o webhook</p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Alert -->
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800 flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>
                                <strong>Importante:</strong> Todas estas configurações são salvas no banco de dados de forma segura. 
                                Valores sensíveis (secrets e tokens) são criptografados automaticamente.
                            </span>
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg font-medium">
                        💾 Salvar Todas Configurações do Sistema
                    </button>
                </form>
            </div>

            <!-- Configurações Básicas -->
            <div x-show="activeTab === 'basic'" x-cloak class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">🤖 Configurações Básicas</h2>
                
                <form wire:submit="saveBasicSettings" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Agent</label>
                        <input type="text" 
                               wire:model="name" 
                               class="w-full px-4 py-2 border rounded-lg">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               wire:model="is_active" 
                               id="is_active" 
                               class="mr-2">
                        <label for="is_active" class="text-sm font-medium text-gray-700">
                            Agent Ativo
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            System Prompt (Personalidade do Agent)
                        </label>
                        <textarea wire:model="system_prompt" 
                                  rows="4" 
                                  class="w-full px-4 py-2 border rounded-lg"
                                  placeholder="Defina como o agent deve se comportar..."></textarea>
                        @error('system_prompt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Recursos Habilitados</label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="messenger_enabled" class="mr-2">
                            <span class="text-sm">📘 Facebook Messenger</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="instagram_enabled" class="mr-2">
                            <span class="text-sm">📸 Instagram Direct</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="auto_post_enabled" class="mr-2">
                            <span class="text-sm">📱 Postagem Automática</span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        💾 Salvar Configurações
                    </button>
                </form>
            </div>

            <!-- Integrações -->
            <div x-show="activeTab === 'integrations'" x-cloak class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">🔗 Integrações</h2>

                <!-- Facebook -->
                <div class="mb-6 p-4 border rounded-lg">
                    <h3 class="font-bold text-lg mb-3 flex items-center">
                        <span class="text-2xl mr-2">📘</span> Facebook
                    </h3>
                    
                    <form wire:submit="saveFacebookToken" class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Access Token</label>
                            <input type="text" 
                                   wire:model="facebook_access_token" 
                                   placeholder="Insira o access token..."
                                   class="w-full px-4 py-2 border rounded-lg">
                            @error('facebook_access_token') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            @if(\App\Models\AiIntegrationToken::getByPlatform('facebook'))
                                <p class="text-xs text-green-600 mt-1">✓ Token já configurado</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Page ID</label>
                            <input type="text" 
                                   wire:model="facebook_page_id" 
                                   placeholder="ID da página do Facebook..."
                                   class="w-full px-4 py-2 border rounded-lg">
                            @error('facebook_page_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                💾 Salvar Token
                            </button>
                            <button type="button" 
                                    wire:click="testFacebookConnection"
                                    wire:loading.attr="disabled"
                                    wire:target="testFacebookConnection"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">
                                <span wire:loading.remove wire:target="testFacebookConnection">🧪 Testar Conexão</span>
                                <span wire:loading wire:target="testFacebookConnection">⏳ Testando...</span>
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 p-3 bg-blue-50 rounded text-sm">
                        <p class="font-semibold mb-2">📚 Como obter:</p>
                        <ol class="list-decimal list-inside space-y-1 text-gray-700">
                            <li>Acesse <a href="https://developers.facebook.com" target="_blank" class="text-blue-600 underline">Facebook Developers</a></li>
                            <li>Crie um App e adicione "Messenger"</li>
                            <li>Gere um Page Access Token</li>
                            <li>Cole aqui e salve</li>
                        </ol>
                    </div>
                </div>

                <!-- Instagram -->
                <div class="p-4 border rounded-lg">
                    <h3 class="font-bold text-lg mb-3 flex items-center">
                        <span class="text-2xl mr-2">📸</span> Instagram
                    </h3>
                    
                    <form wire:submit="saveInstagramToken" class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Access Token</label>
                            <input type="text" 
                                   wire:model="instagram_access_token" 
                                   placeholder="Insira o access token..."
                                   class="w-full px-4 py-2 border rounded-lg">
                            @error('instagram_access_token') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            @if(\App\Models\AiIntegrationToken::getByPlatform('instagram'))
                                <p class="text-xs text-green-600 mt-1">✓ Token já configurado</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Instagram Business Account ID</label>
                            <input type="text" 
                                   wire:model="instagram_page_id" 
                                   placeholder="ID da conta business..."
                                   class="w-full px-4 py-2 border rounded-lg">
                            @error('instagram_page_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                                💾 Salvar Token
                            </button>
                            <button type="button" 
                                    wire:click="testInstagramConnection"
                                    wire:loading.attr="disabled"
                                    wire:target="testInstagramConnection"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">
                                <span wire:loading.remove wire:target="testInstagramConnection">🧪 Testar Conexão</span>
                                <span wire:loading wire:target="testInstagramConnection">⏳ Testando...</span>
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 p-3 bg-pink-50 rounded text-sm">
                        <p class="font-semibold mb-2">📚 Como obter:</p>
                        <ol class="list-decimal list-inside space-y-1 text-gray-700">
                            <li>Converta sua conta para Business</li>
                            <li>Vincule ao Facebook Page</li>
                            <li>Use a Graph API para obter token</li>
                            <li>Cole aqui e salve</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Configurações de IA -->
            <div x-show="activeTab === 'ai-config'" x-cloak class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">🤖 Configurações de Inteligência Artificial</h2>
                
                <form wire:submit="saveSystemConfigs" class="space-y-6">
                    <!-- Provider Selection -->
                    <div class="p-4 bg-gradient-to-r from-purple-50 to-blue-50 border border-purple-200 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <span class="text-lg">🔮</span> Selecionar Provider de IA
                        </label>
                        <select wire:model="ai_provider" class="w-full px-4 py-3 border border-purple-300 rounded-lg font-medium">
                            <option value="openai">🤖 OpenAI (GPT-4, GPT-3.5)</option>
                            <option value="claude">🧠 Anthropic Claude (Claude 3.5 Sonnet, Opus)</option>
                        </select>
                        <p class="text-xs text-gray-600 mt-2">
                            <strong>Selecionado:</strong> {{ $ai_provider == 'openai' ? 'OpenAI GPT' : 'Anthropic Claude' }}
                        </p>
                    </div>

                    <!-- OpenAI Configuration -->
                    <div class="p-4 border border-gray-300 rounded-lg {{ $ai_provider == 'openai' ? 'bg-green-50 border-green-300' : 'bg-gray-50 opacity-60' }}">
                        <h3 class="font-bold text-lg mb-3 flex items-center">
                            <span class="text-2xl mr-2">🤖</span> OpenAI Configuration
                            @if($ai_provider == 'openai')
                                <span class="ml-2 text-xs bg-green-500 text-white px-2 py-1 rounded-full">ATIVO</span>
                            @endif
                        </h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    🔑 API Key
                                </label>
                                <input type="password" 
                                       wire:model="openai_api_key" 
                                       placeholder="sk-..."
                                       class="w-full px-4 py-2 border rounded-lg"
                                       {{ $ai_provider != 'openai' ? 'disabled' : '' }}>
                                @if(\App\Models\SystemConfig::has('openai_api_key'))
                                    <p class="text-xs text-green-600 mt-1">✓ API Key configurada (criptografada)</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Deixe vazio para manter a chave atual</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    🎯 Modelo
                                </label>
                                <select wire:model="openai_model" 
                                        class="w-full px-4 py-2 border rounded-lg"
                                        {{ $ai_provider != 'openai' ? 'disabled' : '' }}>
                                    <option value="gpt-4o">GPT-4o (Mais avançado, multimodal)</option>
                                    <option value="gpt-4o-mini">GPT-4o Mini (Rápido e eficiente)</option>
                                    <option value="gpt-4-turbo">GPT-4 Turbo (Contexto grande)</option>
                                    <option value="gpt-4">GPT-4 (Clássico, mais preciso)</option>
                                    <option value="gpt-3.5-turbo">GPT-3.5 Turbo (Rápido e econômico)</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    Modelo atual: <strong>{{ $openai_model }}</strong>
                                </p>
                            </div>

                            <!-- Test Button -->
                            <div class="pt-3">
                                <button type="button" 
                                        wire:click="testOpenAIConnection"
                                        wire:loading.attr="disabled"
                                        wire:target="testOpenAIConnection"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 flex items-center gap-2"
                                        {{ $ai_provider != 'openai' ? 'disabled' : '' }}>
                                    <span wire:loading.remove wire:target="testOpenAIConnection">🧪 Testar API OpenAI</span>
                                    <span wire:loading wire:target="testOpenAIConnection">⏳ Testando...</span>
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-blue-50 rounded text-sm">
                            <p class="font-semibold mb-2">📚 Como obter API Key:</p>
                            <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                <li>Acesse <a href="https://platform.openai.com/api-keys" target="_blank" class="text-blue-600 underline">OpenAI Platform</a></li>
                                <li>Crie uma conta ou faça login</li>
                                <li>Vá em "API Keys" e clique em "Create new secret key"</li>
                                <li>Copie a chave e cole aqui</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Claude Configuration -->
                    <div class="p-4 border border-gray-300 rounded-lg {{ $ai_provider == 'claude' ? 'bg-purple-50 border-purple-300' : 'bg-gray-50 opacity-60' }}">
                        <h3 class="font-bold text-lg mb-3 flex items-center">
                            <span class="text-2xl mr-2">🧠</span> Claude AI Configuration
                            @if($ai_provider == 'claude')
                                <span class="ml-2 text-xs bg-purple-500 text-white px-2 py-1 rounded-full">ATIVO</span>
                            @endif
                        </h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    🔑 API Key
                                </label>
                                <input type="password" 
                                       wire:model="claude_api_key" 
                                       placeholder="sk-ant-..."
                                       class="w-full px-4 py-2 border rounded-lg"
                                       {{ $ai_provider != 'claude' ? 'disabled' : '' }}>
                                @if(\App\Models\SystemConfig::has('claude_api_key'))
                                    <p class="text-xs text-green-600 mt-1">✓ API Key configurada (criptografada)</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">Deixe vazio para manter a chave atual</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    🎯 Modelo
                                </label>
                                <select wire:model="claude_model" 
                                        class="w-full px-4 py-2 border rounded-lg"
                                        {{ $ai_provider != 'claude' ? 'disabled' : '' }}>
                                    <option value="claude-3-5-sonnet-20241022">Claude 3.5 Sonnet (Mais recente, balanceado)</option>
                                    <option value="claude-3-opus-20240229">Claude 3 Opus (Mais inteligente)</option>
                                    <option value="claude-3-sonnet-20240229">Claude 3 Sonnet (Balanceado)</option>
                                    <option value="claude-3-haiku-20240307">Claude 3 Haiku (Mais rápido)</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    Modelo atual: <strong>{{ $claude_model }}</strong>
                                </p>
                            </div>

                            <!-- Test Button -->
                            <div class="pt-3">
                                <button type="button" 
                                        wire:click="testClaudeConnection"
                                        wire:loading.attr="disabled"
                                        wire:target="testClaudeConnection"
                                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 disabled:opacity-50 flex items-center gap-2"
                                        {{ $ai_provider != 'claude' ? 'disabled' : '' }}>
                                    <span wire:loading.remove wire:target="testClaudeConnection">🧪 Testar API Claude</span>
                                    <span wire:loading wire:target="testClaudeConnection">⏳ Testando...</span>
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-purple-50 rounded text-sm">
                            <p class="font-semibold mb-2">📚 Como obter API Key:</p>
                            <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                <li>Acesse <a href="https://console.anthropic.com/" target="_blank" class="text-purple-600 underline">Anthropic Console</a></li>
                                <li>Crie uma conta ou faça login</li>
                                <li>Vá em "API Keys" e gere uma nova chave</li>
                                <li>Copie a chave e cole aqui</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-900 flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>
                                <strong>Importante:</strong> As API Keys são armazenadas de forma criptografada no banco de dados. 
                                O provider selecionado será usado para todas as funcionalidades do AI Agent (análise de produtos, conversas, geração de posts, etc).
                            </span>
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-600 text-white rounded-lg hover:shadow-lg font-medium text-lg">
                        💾 Salvar Configurações de IA
                    </button>
                </form>
            </div>

            <!-- Configurações Avançadas -->
            <div x-show="activeTab === 'advanced'" x-cloak class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">🎛️ Configurações Avançadas</h2>
                
                <form wire:submit="saveAdvancedSettings" class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               wire:model="auto_response_enabled" 
                               id="auto_response" 
                               class="mr-2">
                        <label for="auto_response" class="text-sm font-medium text-gray-700">
                            Respostas Automáticas Habilitadas
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Frequência de Análise
                        </label>
                        <select wire:model="analysis_frequency" class="w-full px-4 py-2 border rounded-lg">
                            <option value="daily">Diária</option>
                            <option value="weekly">Semanal</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Frequência de Posts Automáticos
                        </label>
                        <select wire:model="auto_post_frequency" class="w-full px-4 py-2 border rounded-lg">
                            <option value="once_daily">1x por dia</option>
                            <option value="twice_daily">2x por dia</option>
                            <option value="weekly">Semanal</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Delay de Resposta (segundos)
                        </label>
                        <input type="number" 
                               wire:model="response_delay_seconds" 
                               min="0" 
                               max="10" 
                               class="w-full px-4 py-2 border rounded-lg">
                        <p class="text-xs text-gray-500 mt-1">Simula tempo de digitação</p>
                    </div>

                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        💾 Salvar Avançado
                    </button>
                </form>
            </div>

            <!-- Webhooks -->
            <div x-show="activeTab === 'webhooks'" x-cloak class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">🔔 URLs dos Webhooks</h2>
                
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            📘 Facebook Webhook URL
                        </label>
                        <div class="flex gap-2">
                            <input type="text" 
                                   value="{{ route('webhooks.facebook') }}" 
                                   readonly 
                                   class="flex-1 px-4 py-2 border rounded-lg bg-white">
                            <button onclick="navigator.clipboard.writeText('{{ route('webhooks.facebook') }}'); alert('URL copiada!')" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                📋 Copiar
                            </button>
                            <button type="button"
                                    wire:click="testWebhook('facebook')"
                                    class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                                🔗 Info
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Configure esta URL no Facebook Developers → Webhooks
                        </p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            📸 Instagram Webhook URL
                        </label>
                        <div class="flex gap-2">
                            <input type="text" 
                                   value="{{ route('webhooks.instagram') }}" 
                                   readonly 
                                   class="flex-1 px-4 py-2 border rounded-lg bg-white">
                            <button onclick="navigator.clipboard.writeText('{{ route('webhooks.instagram') }}'); alert('URL copiada!')" 
                                    class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
                                📋 Copiar
                            </button>
                            <button type="button"
                                    wire:click="testWebhook('instagram')"
                                    class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                                🔗 Info
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Configure esta URL no Facebook Developers → Instagram → Webhooks
                        </p>
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800 flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>
                                <strong>Importante:</strong> Os verify tokens estão configurados na aba <strong>"💾 Configurações Sistema"</strong> 
                                e são armazenados de forma criptografada no banco de dados. Use os mesmos tokens ao configurar os webhooks no Facebook Developers.
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cron Jobs Tab -->
            <div x-show="activeTab === 'cronjobs'" x-cloak class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">⏰ Configuração de Cron Jobs</h2>
                        <p class="text-gray-600 mt-1">Configure publicação automática de posts no cPanel</p>
                    </div>
                    <div class="px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg font-semibold">
                        🤖 Automação
                    </div>
                </div>

                <!-- Mensagens de Sucesso/Erro -->
                @if (session()->has('cron_test_success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-400">
                        {{ session('cron_test_success') }}
                        @if (session()->has('cron_output'))
                            <pre class="mt-2 p-2 bg-white rounded text-xs overflow-x-auto">{{ session('cron_output') }}</pre>
                        @endif
                    </div>
                @endif

                @if (session()->has('cron_test_error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-400">
                        {{ session('cron_test_error') }}
                    </div>
                @endif

                <!-- Cron Jobs Configurados -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Tarefas Agendadas do Sistema
                    </h3>

                    <div class="grid gap-4">
                        @foreach($cronJobs as $job)
                            <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow bg-gradient-to-br from-white to-gray-50">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="font-bold text-lg text-gray-800">{{ $job['name'] }}</h4>
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                {{ $job['status'] === 'active' ? '✓ Ativo' : '○ Inativo' }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 mb-3">{{ $job['description'] }}</p>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-gray-700"><strong>Frequência:</strong> {{ $job['frequency'] }}</span>
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                                </svg>
                                                <code class="text-xs bg-gray-100 px-2 py-1 rounded font-mono">{{ $job['cron'] }}</code>
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-gray-700"><strong>Próxima:</strong> {{ $job['next_run'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="ml-4">
                                        <button wire:click="testCronJob('{{ $job['command'] }}')" 
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold flex items-center gap-2 transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                            </svg>
                                            Testar Agora
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Alerta Importante -->
                <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                    <div class="flex">
                        <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-bold text-yellow-800 mb-1">⚠️ Cron Job Necessário para Publicação Automática</h3>
                            <p class="text-sm text-yellow-700">
                                Sem o Cron Job configurado no cPanel, as tarefas acima <strong>NÃO serão executadas automaticamente</strong>. 
                                Configure seguindo as instruções abaixo.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Passo a Passo -->
                <div class="space-y-6">
                    <!-- Passo 1 -->
                    <div class="border-l-4 border-blue-500 bg-blue-50 p-5 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                1
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-bold text-blue-900 mb-2">Acessar cPanel</h3>
                                <p class="text-blue-800 mb-3">Faça login no cPanel da sua hospedagem e procure por <strong>"Cron Jobs"</strong></p>
                                <div class="bg-white p-3 rounded border border-blue-200">
                                    <p class="text-sm text-gray-700">
                                        📍 Geralmente em: <strong>Advanced</strong> → <strong>Cron Jobs</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Passo 2 -->
                    <div class="border-l-4 border-green-500 bg-green-50 p-5 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                2
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-bold text-green-900 mb-2">Configurar Frequência</h3>
                                <p class="text-green-800 mb-3">Selecione: <strong>Every Minute (* * * * *)</strong></p>
                                
                                <div class="bg-white p-4 rounded border border-green-200 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-700 w-24">Minuto:</span>
                                        <code class="px-3 py-1 bg-gray-800 text-green-400 rounded font-mono">*</code>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-700 w-24">Hora:</span>
                                        <code class="px-3 py-1 bg-gray-800 text-green-400 rounded font-mono">*</code>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-700 w-24">Dia:</span>
                                        <code class="px-3 py-1 bg-gray-800 text-green-400 rounded font-mono">*</code>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-700 w-24">Mês:</span>
                                        <code class="px-3 py-1 bg-gray-800 text-green-400 rounded font-mono">*</code>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-700 w-24">Dia Semana:</span>
                                        <code class="px-3 py-1 bg-gray-800 text-green-400 rounded font-mono">*</code>
                                    </div>
                                </div>
                                <p class="text-xs text-green-700 mt-2">✅ Isso faz o sistema verificar posts a cada 1 minuto</p>
                            </div>
                        </div>
                    </div>

                    <!-- Passo 3 - COMANDO -->
                    <div class="border-l-4 border-purple-500 bg-purple-50 p-5 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                3
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-bold text-purple-900 mb-2">Comando do Cron Job</h3>
                                <p class="text-purple-800 mb-3">Copie e cole este comando no campo <strong>"Command"</strong>:</p>
                                
                                <!-- Comando Principal -->
                                <div class="bg-gray-900 p-4 rounded-lg mb-3" x-data="{ copied: false }">
                                    <div class="flex items-start justify-between gap-3">
                                        <code class="text-green-400 font-mono text-sm flex-1 break-all">
                                            /usr/local/bin/php /home/<span class="text-yellow-300">SEU_USUARIO</span>/public_html/artisan schedule:run >> /home/<span class="text-yellow-300">SEU_USUARIO</span>/logs/cron.log 2>&1
                                        </code>
                                        <button @click="navigator.clipboard.writeText('/usr/local/bin/php /home/SEU_USUARIO/public_html/artisan schedule:run >> /home/SEU_USUARIO/logs/cron.log 2>&1'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                class="flex-shrink-0 px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded text-sm flex items-center gap-1 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            <span x-text="copied ? 'Copiado!' : 'Copiar'"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-yellow-50 border border-yellow-300 p-3 rounded-lg">
                                    <p class="text-sm text-yellow-800 font-semibold mb-2">⚠️ IMPORTANTE: Substituir valores!</p>
                                    <ul class="text-xs text-yellow-700 space-y-1 list-disc list-inside">
                                        <li><code class="bg-yellow-200 px-1 rounded">SEU_USUARIO</code> → Seu username do cPanel (ex: superloja)</li>
                                        <li><code class="bg-yellow-200 px-1 rounded">/usr/local/bin/php</code> → Caminho do PHP (pode variar, ver abaixo)</li>
                                        <li><code class="bg-yellow-200 px-1 rounded">public_html</code> → Pasta do Laravel (pode ser outra)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Passo 4 - Caminho do PHP -->
                    <div class="border-l-4 border-orange-500 bg-orange-50 p-5 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                4
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-bold text-orange-900 mb-2">Descobrir Caminho do PHP</h3>
                                <p class="text-orange-800 mb-3">Execute no <strong>Terminal SSH</strong> ou <strong>Terminal do cPanel</strong>:</p>
                                
                                <div class="bg-gray-900 p-4 rounded-lg mb-3" x-data="{ copied: false }">
                                    <div class="flex items-start justify-between gap-3">
                                        <code class="text-green-400 font-mono text-sm flex-1">which php</code>
                                        <button @click="navigator.clipboard.writeText('which php'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                class="flex-shrink-0 px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white rounded text-sm">
                                            <span x-text="copied ? '✓ Copiado' : '📋 Copiar'"></span>
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-white p-3 rounded border border-orange-200">
                                    <p class="text-sm font-semibold text-gray-800 mb-2">Caminhos comuns do PHP:</p>
                                    <ul class="text-xs text-gray-700 space-y-1 font-mono">
                                        <li>• <code class="bg-gray-100 px-2 py-1 rounded">/usr/local/bin/php</code></li>
                                        <li>• <code class="bg-gray-100 px-2 py-1 rounded">/usr/bin/php</code></li>
                                        <li>• <code class="bg-gray-100 px-2 py-1 rounded">/opt/cpanel/ea-php83/root/usr/bin/php</code></li>
                                        <li>• <code class="bg-gray-100 px-2 py-1 rounded">/usr/local/bin/php8.3</code></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Passo 5 - Criar Pasta de Logs -->
                    <div class="border-l-4 border-indigo-500 bg-indigo-50 p-5 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                5
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-bold text-indigo-900 mb-2">Criar Pasta de Logs (Opcional)</h3>
                                <p class="text-indigo-800 mb-3">Para salvar logs do cron job, execute via SSH:</p>
                                
                                <div class="bg-gray-900 p-4 rounded-lg" x-data="{ copied: false }">
                                    <div class="flex items-start justify-between gap-3">
                                        <code class="text-green-400 font-mono text-sm flex-1">mkdir -p ~/logs && chmod 755 ~/logs</code>
                                        <button @click="navigator.clipboard.writeText('mkdir -p ~/logs && chmod 755 ~/logs'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                class="flex-shrink-0 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm">
                                            <span x-text="copied ? '✓ Copiado' : '📋 Copiar'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Verificação -->
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 border-2 border-green-300 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-green-800 mb-3 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Como Verificar Se Está Funcionando
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="bg-white p-4 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-gray-800 mb-2">📊 Método 1: Ver Logs</h4>
                                <code class="text-sm bg-gray-900 text-green-400 p-2 rounded block font-mono">cat ~/logs/cron.log</code>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-gray-800 mb-2">🧪 Método 2: Testar Manualmente</h4>
                                <code class="text-sm bg-gray-900 text-green-400 p-2 rounded block font-mono">php artisan ai:publish-posts</code>
                                <p class="text-xs text-gray-600 mt-2">Deve mostrar: "✅ X post(s) publicado(s) com sucesso!"</p>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-gray-800 mb-2">👀 Método 3: Monitorar Posts</h4>
                                <p class="text-sm text-gray-700">Agende um post para daqui a 2 minutos e aguarde. Status deve mudar de "⏰ Agendado" para "✅ Publicado"</p>
                            </div>
                        </div>
                    </div>

                    <!-- Troubleshooting -->
                    <div class="bg-red-50 border border-red-200 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-red-800 mb-3 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Problemas Comuns
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="bg-white p-3 rounded border border-red-200">
                                <p class="font-semibold text-gray-800 text-sm mb-1">❌ Cron não executa</p>
                                <p class="text-xs text-gray-600">→ Verificar caminho do PHP está correto</p>
                                <p class="text-xs text-gray-600">→ Verificar caminho do projeto está correto</p>
                                <p class="text-xs text-gray-600">→ Verificar permissões das pastas storage/ e bootstrap/cache/</p>
                            </div>

                            <div class="bg-white p-3 rounded border border-red-200">
                                <p class="font-semibold text-gray-800 text-sm mb-1">❌ Posts não publicam</p>
                                <p class="text-xs text-gray-600">→ Configurar tokens do Facebook na aba "🔗 Integrações"</p>
                                <p class="text-xs text-gray-600">→ Executar: <code class="bg-gray-100 px-1">php artisan storage:link</code></p>
                            </div>
                        </div>
                    </div>

                    <!-- Ajuda -->
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm text-blue-800">
                                    <strong>Precisa de ajuda?</strong> Consulte o arquivo <code class="bg-blue-100 px-2 py-1 rounded">SCHEDULER_README.md</code> 
                                    na raiz do projeto para instruções detalhadas sobre outras formas de configuração (Windows, VPS, etc).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
