<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
            <span class="text-4xl">🔄</span>
            Atualizacao do Sistema
        </h1>
        <p class="text-gray-600 mt-2">Atualize o sistema automaticamente via GitHub</p>
    </div>

    <!-- Configuracao -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Configuracao do Repositorio
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Repositorio GitHub *</label>
                <input type="text" wire:model="githubRepo" 
                       placeholder="usuario/repositorio"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Exemplo: tiofox77/superloja</p>
                <p class="text-xs text-amber-600 mt-1">⚠️ Repositorio deve ser publico e ter releases</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Branch</label>
                <input type="text" wire:model="githubBranch" 
                       placeholder="main"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
        </div>

        <button wire:click="saveConfig"
                wire:loading.attr="disabled"
                class="px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-colors disabled:opacity-50">
            <span wire:loading.remove wire:target="saveConfig">Salvar Configuracao</span>
            <span wire:loading wire:target="saveConfig" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Salvando...
            </span>
        </button>
    </div>

    <!-- Status Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <!-- Info -->
        <div class="flex items-start gap-4 mb-6">
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Status da Atualizacao</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <p class="text-xs text-gray-500">Versao Atual</p>
                        <p class="font-mono text-sm font-bold text-gray-800">{{ $currentVersion }}</p>
                    </div>
                    @if($latestVersion)
                        <div>
                            <p class="text-xs text-gray-500">Ultima Versao</p>
                            <p class="font-mono text-sm font-bold {{ $hasUpdate ? 'text-green-600' : 'text-gray-800' }}">{{ $latestVersion }}</p>
                        </div>
                    @endif
                </div>

                @if($hasUpdate && $updateInfo)
                    <div class="p-3 bg-green-50 border border-green-200 rounded-lg mb-3">
                        <p class="text-sm font-semibold text-green-800 mb-1">{{ $updateInfo['name'] }}</p>
                        <p class="text-xs text-green-600">Publicado em {{ \Carbon\Carbon::parse($updateInfo['published_at'])->format('d/m/Y H:i') }}</p>
                    </div>
                @endif

                <p class="text-gray-600 text-sm">Branch: <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $githubBranch }}</span></p>
            </div>
        </div>

        <!-- Botao Verificar -->
        @if(!$isUpdating)
            <button wire:click="checkForUpdates"
                    wire:loading.attr="disabled"
                    class="w-full px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all flex items-center justify-center gap-3 mb-3 disabled:opacity-50">
                <span wire:loading.remove wire:target="checkForUpdates" class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Verificar Atualizacoes
                </span>
                <span wire:loading wire:target="checkForUpdates" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Verificando...
                </span>
            </button>
        @endif

        <!-- Botao Atualizar -->
        @if(!$isUpdating && !$updateComplete)
            <button wire:click="startUpdate"
                    wire:loading.attr="disabled"
                    class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-bold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg flex items-center justify-center gap-3 disabled:opacity-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Iniciar Atualizacao
            </button>
        @endif

        @if($updateComplete)
            <div class="bg-green-50 border-2 border-green-500 rounded-xl p-6 text-center">
                <div class="text-6xl mb-4">✅</div>
                <h3 class="text-2xl font-bold text-green-800 mb-2">Atualizacao Concluida!</h3>
                <p class="text-green-600 mb-4">Sistema atualizado com sucesso</p>
                <button wire:click="$refresh" 
                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Recarregar Pagina
                </button>
            </div>
        @endif
    </div>

    <!-- Progress Bar -->
    @if($isUpdating || $updateComplete)
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700">Progresso</span>
                    <span class="text-sm font-bold text-purple-600">{{ $progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-6 rounded-full transition-all duration-500 flex items-center justify-end pr-2"
                         style="width: {{ $progress }}%">
                        @if($progress > 10)
                            <span class="text-white text-xs font-bold">{{ $progress }}%</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Current Step -->
            <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                @if($isUpdating)
                    <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                @else
                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-semibold text-gray-700">{{ $currentStep ? $steps[$currentStep] : 'Preparando...' }}</span>
            </div>
        </div>
    @endif

    <!-- Logs -->
    @if(count($logs) > 0)
        <div class="bg-gray-900 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-bold text-white">Console de Logs</h3>
                <div class="flex-1"></div>
                <span class="text-xs text-gray-400">{{ count($logs) }} registros</span>
            </div>

            <div class="bg-black rounded-lg p-4 font-mono text-sm space-y-2 max-h-96 overflow-y-auto custom-scrollbar">
                @foreach($logs as $log)
                    <div class="flex gap-3 hover:bg-gray-800 p-2 rounded transition-colors">
                        <span class="text-gray-500 text-xs whitespace-nowrap">{{ $log['time'] }}</span>
                        
                        @if($log['type'] === 'success')
                            <span class="text-green-400">✓</span>
                        @elseif($log['type'] === 'error')
                            <span class="text-red-400">✗</span>
                        @elseif($log['type'] === 'info')
                            <span class="text-blue-400">ℹ</span>
                        @else
                            <span class="text-yellow-400">⚠</span>
                        @endif
                        
                        <span class="flex-1 {{ 
                            $log['type'] === 'success' ? 'text-green-400' : 
                            ($log['type'] === 'error' ? 'text-red-400' : 
                            ($log['type'] === 'info' ? 'text-blue-400' : 'text-yellow-400'))
                        }}">
                            {{ $log['message'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Auto-executar steps
        Livewire.on('next-step', (event) => {
            const data = event[0] || event;
            const step = data.step;
            
            setTimeout(() => {
                switch(step) {
                    case 2:
                        @this.call('executeStep2');
                        break;
                    case 3:
                        @this.call('executeStep3');
                        break;
                    case 4:
                        @this.call('executeStep4');
                        break;
                    case 5:
                        @this.call('executeStep5');
                        break;
                    case 6:
                        @this.call('executeStep6');
                        break;
                }
            }, 1000); // Delay de 1 segundo entre steps
        });
        
        // Toastr
        Livewire.on('notify', (event) => {
            const data = event[0] || event;
            if (data.type === 'success') {
                toastr.success(data.message);
            } else if (data.type === 'error') {
                toastr.error(data.message);
            }
        });
    });
</script>
@endpush
