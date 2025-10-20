<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
            <span class="text-4xl">🔔</span>
            Canais de Notificação
        </h1>
        <p class="text-gray-600 mt-2">Configure como deseja receber alertas da IA Agent</p>
    </div>


    <form wire:submit.prevent="save">
        <!-- Canais de Notificação -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <span class="text-2xl">📢</span>
                Canais Disponíveis
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div class="border-2 rounded-lg p-5 {{ $email_enabled ? 'border-blue-300 bg-blue-50' : 'border-gray-200 bg-gray-50' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">📧</div>
                            <div>
                                <h3 class="font-bold text-gray-800">Email</h3>
                                <p class="text-xs text-gray-600">Receba alertas por email</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="email_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    @if($email_enabled)
                        <div class="space-y-3">
                            <input type="email" wire:model="email" 
                                   placeholder="email@exemplo.com"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" wire:click="testEmail"
                                    wire:loading.attr="disabled"
                                    wire:target="testEmail"
                                    class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 font-semibold text-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="testEmail">🧪 Testar Email</span>
                                <span wire:loading wire:target="testEmail" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Enviando...
                                </span>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- SMS -->
                <div class="border-2 rounded-lg p-5 {{ $sms_enabled ? 'border-green-300 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">📱</div>
                            <div>
                                <h3 class="font-bold text-gray-800">SMS</h3>
                                <p class="text-xs text-gray-600">Alertas por mensagem de texto</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="sms_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                    
                    @if($sms_enabled)
                        <div class="space-y-3">
                            <input type="text" wire:model="phone" 
                                   placeholder="+244 923 456 789"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs text-blue-800">
                                    <strong>Provider:</strong> Unimtx<br>
                                    <strong>Configurar:</strong> <a href="{{ route('admin.settings.index') }}" class="underline hover:text-blue-900">Configuracoes - SMS</a><br>
                                    <strong>Access Key necessaria para enviar SMS</strong>
                                </p>
                            </div>
                            
                            <button type="button" wire:click="testSMS"
                                    wire:loading.attr="disabled"
                                    wire:target="testSMS"
                                    class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 font-semibold text-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="testSMS">🧪 Testar SMS</span>
                                <span wire:loading wire:target="testSMS" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Enviando SMS...
                                </span>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Facebook Messenger -->
                <div class="border-2 rounded-lg p-5 {{ $facebook_messenger_enabled ? 'border-purple-300 bg-purple-50' : 'border-gray-200 bg-gray-50' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">💬</div>
                            <div>
                                <h3 class="font-bold text-gray-800">Facebook Messenger</h3>
                                <p class="text-xs text-gray-600">Mensagens diretas no Messenger</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="facebook_messenger_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    
                    @if($facebook_messenger_enabled)
                        <div class="space-y-3">
                            <input type="text" wire:model="facebook_messenger_id" 
                                   placeholder="Seu ID do Messenger"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <p class="text-xs text-gray-500">
                                💡 Envie uma mensagem para a página do Facebook para obter seu ID
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Instagram -->
                <div class="border-2 rounded-lg p-5 {{ $instagram_enabled ? 'border-pink-300 bg-pink-50' : 'border-gray-200 bg-gray-50' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">📸</div>
                            <div>
                                <h3 class="font-bold text-gray-800">Instagram</h3>
                                <p class="text-xs text-gray-600">Mensagens diretas no Instagram</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="instagram_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-pink-600"></div>
                        </label>
                    </div>
                    
                    @if($instagram_enabled)
                        <div class="space-y-3">
                            <input type="text" wire:model="instagram_id" 
                                   placeholder="Seu ID do Instagram"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <p class="text-xs text-gray-500">
                                💡 Envie uma mensagem para o perfil comercial para obter seu ID
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Browser (Painel) -->
                <div class="border-2 rounded-lg p-5 {{ $browser_enabled ? 'border-yellow-300 bg-yellow-50' : 'border-gray-200 bg-gray-50' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="text-3xl">🔔</div>
                            <div>
                                <h3 class="font-bold text-gray-800">Painel Admin</h3>
                                <p class="text-xs text-gray-600">Notificações no sino e badges</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="browser_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600"></div>
                        </label>
                    </div>
                    
                    @if($browser_enabled)
                        <p class="text-sm text-gray-600">
                            ✅ Notificações aparecem no sino 🔔 e nos badges do menu
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Filtros de Notificação -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <span class="text-2xl">⚙️</span>
                Filtros e Preferências
            </h2>

            <!-- Só Urgentes -->
            <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                <label class="flex items-center justify-between cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl">🚨</div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Apenas Conversas Urgentes</h3>
                            <p class="text-sm text-gray-600">Receber apenas quando cliente está insatisfeito ou situação urgente</p>
                        </div>
                    </div>
                    <input type="checkbox" wire:model="urgent_only" class="w-6 h-6 text-red-600 rounded focus:ring-red-500">
                </label>
            </div>

            <!-- Tipos de Notificação -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Tipos de Notificação</h3>
                <p class="text-sm text-gray-600 mb-4">Marque os tipos que deseja receber (vazio = todos)</p>
                
                <div class="space-y-2">
                    @foreach($availableTypes as $key => $label)
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" wire:model="notification_types" value="{{ $key }}"
                                   class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Horário de Silêncio -->
            <div class="p-4 border border-gray-200 rounded-lg">
                <label class="flex items-center justify-between cursor-pointer mb-4">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl">🌙</div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Horário de Silêncio</h3>
                            <p class="text-sm text-gray-600">Não receber notificações em determinados horários</p>
                        </div>
                    </div>
                    <input type="checkbox" wire:model="quiet_hours_enabled" class="w-6 h-6 text-purple-600 rounded focus:ring-purple-500">
                </label>

                @if($quiet_hours_enabled)
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Início (hora)</label>
                            <input type="number" wire:model="quiet_hours_start" min="0" max="23"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fim (hora)</label>
                            <input type="number" wire:model="quiet_hours_end" min="0" max="23"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        ⚠️ Conversas urgentes ignoram horário de silêncio
                    </p>
                @endif
            </div>
        </div>

        <!-- Botão Salvar -->
        <div class="flex justify-end gap-3">
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                    </svg>
                    Salvar Configurações
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Salvando...
                </span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('notify', (event) => {
            const data = event[0] || event;
            if (data.type === 'success') {
                toastr.success(data.message);
            } else if (data.type === 'error') {
                toastr.error(data.message);
            } else if (data.type === 'info') {
                toastr.info(data.message);
            } else if (data.type === 'warning') {
                toastr.warning(data.message);
            }
        });
    });
</script>
@endpush
