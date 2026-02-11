<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Atualização do Sistema</h1>
            <p class="text-gray-500">Gerencie atualizações, backups e manutenção via GitHub</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-sm font-mono font-bold text-gray-700">{{ $currentVersion }}</span>
            <x-admin.ui.button href="{{ route('admin.dashboard') }}" variant="outline" icon="arrow-left">
                Voltar
            </x-admin.ui.button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-1 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
        @foreach(['update' => 'Atualização', 'backups' => 'Backups', 'maintenance' => 'Manutenção', 'history' => 'Histórico'] as $tab => $label)
            <button wire:click="setTab('{{ $tab }}')"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $activeTab === $tab ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            {{-- ═══ TAB: ATUALIZAÇÃO ═══ --}}
            @if($activeTab === 'update')

                <!-- GitHub Config -->
                <x-admin.ui.card title="Repositório GitHub" icon="github">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <x-admin.form.input wire:model="githubRepo" label="Repositório" placeholder="usuario/repositorio" hint="Ex: tiofox77/superloja" />
                        <x-admin.form.input wire:model="githubBranch" label="Branch" placeholder="main" />
                    </div>
                    <x-admin.ui.button wire:click="saveConfig" variant="primary" icon="save" size="sm">
                        Salvar Configuração
                    </x-admin.ui.button>
                </x-admin.ui.card>

                <!-- Prerequisites -->
                <x-admin.ui.card title="Pré-requisitos" icon="shield-check">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($prerequisites as $req)
                            <div class="flex items-center gap-2 p-3 rounded-lg {{ $req['status'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                @if($req['status'])
                                    <i data-lucide="check-circle-2" class="w-4 h-4 text-green-600"></i>
                                @else
                                    <i data-lucide="x-circle" class="w-4 h-4 text-red-600"></i>
                                @endif
                                <div>
                                    <p class="text-xs font-semibold {{ $req['status'] ? 'text-green-800' : 'text-red-800' }}">{{ $req['name'] }}</p>
                                    <p class="text-[10px] {{ $req['status'] ? 'text-green-600' : 'text-red-600' }}">{{ $req['message'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-admin.ui.card>

                <!-- Version Status -->
                <x-admin.ui.card title="Status da Atualização" icon="refresh-cw">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Versão Atual</p>
                            <p class="text-xl font-bold font-mono text-gray-900">{{ $currentVersion }}</p>
                        </div>
                        @if($latestVersion)
                            <div class="text-center">
                                <i data-lucide="arrow-right" class="w-5 h-5 text-gray-400 mx-auto"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Última Versão</p>
                                <p class="text-xl font-bold font-mono {{ $hasUpdate ? 'text-green-600' : 'text-gray-900' }}">{{ $latestVersion }}</p>
                            </div>
                        @else
                            <div class="text-right">
                                <p class="text-sm text-gray-400">Clique em verificar</p>
                            </div>
                        @endif
                    </div>

                    @if($hasUpdate && $updateInfo)
                        <div class="p-4 bg-green-50 border border-green-200 rounded-xl mb-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-green-800">{{ $updateInfo['name'] }}</p>
                                    @if(!empty($updateInfo['published_at']))
                                        <p class="text-xs text-green-600 mt-1">Publicado em {{ \Carbon\Carbon::parse($updateInfo['published_at'])->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                                @if(!empty($updateInfo['html_url']))
                                    <a href="{{ $updateInfo['html_url'] }}" target="_blank" class="text-green-600 hover:text-green-800">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                @endif
                            </div>
                            @if(!empty($updateInfo['body']))
                                <button wire:click="toggleChangelog" class="mt-2 text-xs text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1">
                                    <i data-lucide="{{ $showChangelog ? 'chevron-down' : 'chevron-right' }}" class="w-3 h-3"></i>
                                    Changelog
                                </button>
                                @if($showChangelog)
                                    <div class="mt-2 p-3 bg-white rounded-lg border border-green-300 text-xs text-gray-700 max-h-48 overflow-y-auto whitespace-pre-line">{{ $updateInfo['body'] }}</div>
                                @endif
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    @if(!$isUpdating)
                        <div class="flex flex-wrap gap-3">
                            <x-admin.ui.button wire:click="checkForUpdates" variant="outline" icon="search" size="sm">
                                Verificar Atualizações
                            </x-admin.ui.button>

                            @if($hasUpdate && $canUpdate)
                                <x-admin.ui.button wire:click="startUpdate" wire:confirm="Iniciar atualização do sistema? Um backup será criado automaticamente." variant="primary" icon="download" size="sm">
                                    Iniciar Atualização
                                </x-admin.ui.button>
                            @endif
                        </div>
                    @endif
                </x-admin.ui.card>

                <!-- Progress Bar (during update) -->
                @if($isUpdating || $updateComplete || $hasError)
                    <x-admin.ui.card title="Progresso" icon="loader">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $currentStep ? ($steps[$currentStep] ?? $currentStep) : 'Preparando...' }}</span>
                                <span class="text-sm font-bold {{ $hasError ? 'text-red-600' : ($updateComplete ? 'text-green-600' : 'text-blue-600') }}">{{ $progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="h-3 rounded-full transition-all duration-700 {{ $hasError ? 'bg-red-500' : ($updateComplete ? 'bg-green-500' : 'bg-gradient-to-r from-blue-500 to-purple-600') }}"
                                     style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        @if($updateComplete)
                            <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-center">
                                <i data-lucide="check-circle-2" class="w-10 h-10 text-green-500 mx-auto mb-2"></i>
                                <h3 class="text-lg font-bold text-green-800">Atualização Concluída!</h3>
                                <p class="text-sm text-green-600 mt-1">Versão atual: {{ $currentVersion }}</p>
                            </div>
                        @endif

                        @if($hasError)
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-center gap-2 mb-2">
                                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500"></i>
                                    <h3 class="font-bold text-red-800">Atualização Falhou</h3>
                                </div>
                                <p class="text-sm text-red-600 mb-3">Verifique os logs abaixo. Você pode restaurar um backup ou reverter o código.</p>
                                <div class="flex gap-2">
                                    <x-admin.ui.button wire:click="rollbackCode" wire:confirm="Reverter código para versão anterior (git reset --hard HEAD~1)?" variant="outline" size="sm" icon="undo-2">
                                        Rollback Código
                                    </x-admin.ui.button>
                                </div>
                            </div>
                        @endif
                    </x-admin.ui.card>
                @endif

            {{-- ═══ TAB: BACKUPS ═══ --}}
            @elseif($activeTab === 'backups')

                <x-admin.ui.card title="Backups (BD + Ficheiros)" icon="archive">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-sm text-gray-500">Backup completo inclui banco de dados e ficheiros do projeto. Máximo: 5 mantidos.</p>
                        <x-admin.ui.button wire:click="createManualBackup" variant="primary" icon="plus" size="sm"
                                           wire:loading.attr="disabled" wire:target="createManualBackup">
                            <span wire:loading.remove wire:target="createManualBackup">Criar Backup</span>
                            <span wire:loading wire:target="createManualBackup">A criar...</span>
                        </x-admin.ui.button>
                    </div>

                    @if(count($backups) > 0)
                        <div class="space-y-3">
                            @foreach($backups as $backup)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg {{ ($backup['type'] ?? 'bd') === 'completo' ? 'bg-purple-100' : 'bg-blue-100' }} flex items-center justify-center">
                                            <i data-lucide="{{ ($backup['type'] ?? 'bd') === 'completo' ? 'archive' : 'database' }}" class="w-5 h-5 {{ ($backup['type'] ?? 'bd') === 'completo' ? 'text-purple-600' : 'text-blue-600' }}"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm font-medium text-gray-900">{{ $backup['filename'] }}</p>
                                                @if(($backup['type'] ?? 'bd') === 'completo')
                                                    <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-purple-100 text-purple-700 rounded">BD + Ficheiros</span>
                                                @else
                                                    <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-blue-100 text-blue-700 rounded">Só BD</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500">{{ $backup['date'] }} &middot; {{ $backup['size'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="restoreBackup('{{ $backup['filename'] }}')"
                                                wire:confirm="Restaurar este backup? O banco atual será sobrescrito!"
                                                class="px-3 py-1.5 text-xs font-medium text-orange-700 bg-orange-100 rounded-lg hover:bg-orange-200 transition-colors">
                                            Restaurar
                                        </button>
                                        <button wire:click="deleteBackup('{{ $backup['filename'] }}')"
                                                wire:confirm="Excluir este backup?"
                                                class="px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors">
                                            Excluir
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i data-lucide="archive" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                            <p class="text-sm">Nenhum backup encontrado</p>
                        </div>
                    @endif
                </x-admin.ui.card>

                <!-- Rollback -->
                <x-admin.ui.card title="Rollback de Código" icon="undo-2">
                    <p class="text-sm text-gray-500 mb-4">Reverter o código para o commit anterior via <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">git reset --hard HEAD~1</code>.</p>
                    <x-admin.ui.button wire:click="rollbackCode" wire:confirm="Reverter código para versão anterior? Todas as alterações do último pull serão desfeitas!" variant="outline" size="sm" icon="undo-2">
                        Rollback para Commit Anterior
                    </x-admin.ui.button>
                </x-admin.ui.card>

            {{-- ═══ TAB: MANUTENÇÃO ═══ --}}
            @elseif($activeTab === 'maintenance')

                <x-admin.ui.card title="Ferramentas de Manutenção" icon="wrench">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <button wire:click="clearAllCaches"
                                wire:loading.attr="disabled"
                                wire:target="clearAllCaches, optimizeSystem, runMigrations"
                                class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors text-left group border border-gray-200 disabled:opacity-50 disabled:cursor-wait">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i wire:loading.remove wire:target="clearAllCaches" data-lucide="trash-2" class="w-5 h-5 text-blue-600"></i>
                                <svg wire:loading wire:target="clearAllCaches" class="w-5 h-5 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm">Limpar Caches</h4>
                            <p class="text-xs text-gray-500 mt-1">Config, views, rotas, app</p>
                            <span wire:loading wire:target="clearAllCaches" class="text-xs text-blue-600 font-medium mt-2 block">A executar...</span>
                        </button>

                        <button wire:click="optimizeSystem"
                                wire:loading.attr="disabled"
                                wire:target="clearAllCaches, optimizeSystem, runMigrations"
                                class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors text-left group border border-gray-200 disabled:opacity-50 disabled:cursor-wait">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i wire:loading.remove wire:target="optimizeSystem" data-lucide="zap" class="w-5 h-5 text-green-600"></i>
                                <svg wire:loading wire:target="optimizeSystem" class="w-5 h-5 text-green-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm">Otimizar</h4>
                            <p class="text-xs text-gray-500 mt-1">Cache de config e rotas</p>
                            <span wire:loading wire:target="optimizeSystem" class="text-xs text-green-600 font-medium mt-2 block">A executar...</span>
                        </button>

                        <button wire:click="runMigrations" wire:confirm="Executar todas as migrations pendentes?"
                                wire:loading.attr="disabled"
                                wire:target="clearAllCaches, optimizeSystem, runMigrations"
                                class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors text-left group border border-gray-200 disabled:opacity-50 disabled:cursor-wait">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i wire:loading.remove wire:target="runMigrations" data-lucide="database" class="w-5 h-5 text-purple-600"></i>
                                <svg wire:loading wire:target="runMigrations" class="w-5 h-5 text-purple-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm">Migrations</h4>
                            <p class="text-xs text-gray-500 mt-1">Atualizar banco de dados</p>
                            <span wire:loading wire:target="runMigrations" class="text-xs text-purple-600 font-medium mt-2 block">A executar...</span>
                        </button>
                    </div>

                    {{-- Resultado inline --}}
                    @if(count($logs) > 0)
                        <div class="mt-6 bg-gray-900 rounded-xl p-4 font-mono text-xs space-y-1 max-h-60 overflow-y-auto">
                            @foreach($logs as $log)
                                <div class="flex gap-3 p-1.5 rounded hover:bg-gray-800 transition-colors">
                                    <span class="text-gray-500 whitespace-nowrap">{{ $log['time'] }}</span>
                                    @if($log['type'] === 'success')
                                        <span class="text-green-400 flex-shrink-0">&#10003;</span>
                                    @elseif($log['type'] === 'error')
                                        <span class="text-red-400 flex-shrink-0">&#10007;</span>
                                    @elseif($log['type'] === 'warning')
                                        <span class="text-yellow-400 flex-shrink-0">&#9888;</span>
                                    @else
                                        <span class="text-blue-400 flex-shrink-0">&#8505;</span>
                                    @endif
                                    <span class="{{ $log['type'] === 'success' ? 'text-green-400' : ($log['type'] === 'error' ? 'text-red-400' : ($log['type'] === 'warning' ? 'text-yellow-400' : 'text-blue-400')) }}">
                                        {{ $log['message'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-admin.ui.card>

            {{-- ═══ TAB: HISTÓRICO ═══ --}}
            @elseif($activeTab === 'history')

                <x-admin.ui.card title="Histórico de Atualizações" icon="clock">
                    @if(count($updateHistory) > 0)
                        <div class="space-y-3">
                            @foreach(array_reverse($updateHistory) as $history)
                                <div class="flex items-center gap-3 p-4 rounded-xl {{ $history['status'] === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                    @if($history['status'] === 'success')
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-green-600 flex-shrink-0"></i>
                                    @else
                                        <i data-lucide="x-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800">Versão {{ $history['version'] }}</p>
                                        <p class="text-xs text-gray-600">
                                            {{ \Carbon\Carbon::parse($history['timestamp'])->format('d/m/Y H:i') }}
                                            &middot; {{ $history['user'] ?? 'Sistema' }}
                                            &middot; <span class="font-medium {{ $history['status'] === 'success' ? 'text-green-600' : 'text-red-600' }}">{{ $history['status'] === 'success' ? 'Sucesso' : 'Falhou' }}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i data-lucide="clock" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                            <p class="text-sm">Nenhuma atualização registrada</p>
                        </div>
                    @endif
                </x-admin.ui.card>

            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Console (when there are logs) -->
            @if(count($logs) > 0)
                <x-admin.ui.card title="Console" icon="terminal">
                    <div id="logs-container" class="bg-gray-900 rounded-xl p-3 font-mono text-[11px] space-y-0.5 max-h-56 overflow-y-auto">
                        @foreach($logs as $log)
                            <div class="flex gap-2 p-1 rounded hover:bg-gray-800 transition-colors">
                                <span class="text-gray-500 whitespace-nowrap">{{ $log['time'] }}</span>
                                @if($log['type'] === 'success')
                                    <span class="text-green-400 flex-shrink-0">&#10003;</span>
                                @elseif($log['type'] === 'error')
                                    <span class="text-red-400 flex-shrink-0">&#10007;</span>
                                @elseif($log['type'] === 'warning')
                                    <span class="text-yellow-400 flex-shrink-0">&#9888;</span>
                                @else
                                    <span class="text-blue-400 flex-shrink-0">&#8505;</span>
                                @endif
                                <span class="break-all {{ $log['type'] === 'success' ? 'text-green-400' : ($log['type'] === 'error' ? 'text-red-400' : ($log['type'] === 'warning' ? 'text-yellow-400' : 'text-blue-400')) }}">
                                    {{ $log['message'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </x-admin.ui.card>
            @endif

            <!-- System Info -->
            <x-admin.ui.card title="Sistema" icon="server">
                <div class="space-y-2">
                    @foreach($systemInfo as $key => $value)
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-0">
                            <span class="text-xs text-gray-500">{{ $key }}</span>
                            <span class="text-xs font-medium text-gray-900 font-mono">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </x-admin.ui.card>

            <!-- Quick Stats -->
            <x-admin.ui.card title="Resumo" icon="bar-chart-3">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Backups</span>
                        <span class="text-sm font-bold text-gray-900">{{ count($backups) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Atualizações</span>
                        <span class="text-sm font-bold text-gray-900">{{ count($updateHistory) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Status</span>
                        @if($hasUpdate)
                            <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-0.5 rounded-full">Update Disponível</span>
                        @else
                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-0.5 rounded-full">Atualizado</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Branch</span>
                        <span class="text-xs font-mono font-medium text-gray-900 bg-gray-100 px-2 py-0.5 rounded">{{ $githubBranch }}</span>
                    </div>
                </div>
            </x-admin.ui.card>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll logs container on Livewire updates
    document.addEventListener('livewire:init', () => {
        Livewire.hook('morph.updated', () => {
            const el = document.getElementById('logs-container');
            if (el) {
                setTimeout(() => { el.scrollTop = el.scrollHeight; }, 50);
            }
        });
    });
</script>
@endpush
