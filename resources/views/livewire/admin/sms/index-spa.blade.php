<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Templates SMS</h1>
            <p class="text-gray-500">Gerencie templates de mensagens SMS</p>
        </div>
        <div class="flex items-center gap-3">
            <x-admin.ui.button wire:click="openTestModal" variant="outline" icon="send">
                Testar SMS
            </x-admin.ui.button>
            <x-admin.ui.button wire:click="openCreateModal" icon="plus">
                Novo Template
            </x-admin.ui.button>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500">Templates</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                <p class="text-xs text-gray-500">Ativos</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                <i data-lucide="megaphone" class="w-5 h-5 text-purple-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $stats['promotional'] }}</p>
                <p class="text-xs text-gray-500">Promocionais</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5 text-primary-600"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-gray-900">{{ $totalCustomers }}</p>
                <p class="text-xs text-gray-500">Clientes</p>
            </div>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="flex gap-1 border-b border-gray-200 mb-6">
        <button wire:click="setTab('templates')"
                class="px-4 py-2 text-sm font-medium transition-colors border-b-2 -mb-px
                       {{ $activeTab === 'templates' ? 'text-primary-600 border-primary-500' : 'text-gray-500 border-transparent hover:text-gray-700' }}">
            Templates
        </button>
        <button wire:click="setTab('logs')"
                class="px-4 py-2 text-sm font-medium transition-colors border-b-2 -mb-px
                       {{ $activeTab === 'logs' ? 'text-primary-600 border-primary-500' : 'text-gray-500 border-transparent hover:text-gray-700' }}">
            Histórico de Envios
        </button>
    </div>
    
    <!-- Search -->
    <x-admin.ui.card class="mb-6">
        <x-admin.form.search wire:model.live.debounce.300ms="search" 
                            placeholder="{{ $activeTab === 'templates' ? 'Buscar templates...' : 'Buscar por telefone ou mensagem...' }}" />
    </x-admin.ui.card>
    
    @if($activeTab === 'templates')
        <!-- Templates Table -->
        <x-admin.ui.table>
        <x-slot:head>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nome</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipo</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mensagem</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
            </tr>
        </x-slot:head>
        
        @forelse($templates as $template)
            @php
                $typeColors = [
                    'promotional' => 'primary',
                    'transactional' => 'info',
                    'notification' => 'warning',
                ];
                $typeLabels = [
                    'promotional' => 'Promocional',
                    'transactional' => 'Transacional',
                    'notification' => 'Notificação',
                ];
            @endphp
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-4">
                    <p class="font-medium text-gray-900">{{ $template->name }}</p>
                </td>
                <td class="px-4 py-4">
                    <x-admin.ui.badge :variant="$typeColors[$template->type] ?? 'default'" size="sm">
                        {{ $typeLabels[$template->type] ?? ucfirst($template->type) }}
                    </x-admin.ui.badge>
                </td>
                <td class="px-4 py-4">
                    <p class="text-sm text-gray-600 truncate max-w-xs">{{ Str::limit($template->message, 60) }}</p>
                </td>
                <td class="px-4 py-4">
                    <button wire:click="toggleStatus({{ $template->id }})"
                            class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium transition-colors
                                   {{ $template->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $template->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                        {{ $template->is_active ? 'Ativo' : 'Inativo' }}
                    </button>
                </td>
                <td class="px-4 py-4 text-right">
                    <x-admin.ui.dropdown>
                        <x-admin.ui.dropdown-item wire:click="editTemplate({{ $template->id }})" icon="edit-2">
                            Editar
                        </x-admin.ui.dropdown-item>
                        <x-admin.ui.dropdown-item wire:click="deleteTemplate({{ $template->id }})" wire:confirm="Excluir?" icon="trash-2" danger>
                            Excluir
                        </x-admin.ui.dropdown-item>
                    </x-admin.ui.dropdown>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <x-admin.ui.empty-state 
                        icon="file-text" 
                        title="Nenhum template encontrado"
                        description="Crie seu primeiro template SMS." />
                </td>
            </tr>
        @endforelse
    </x-admin.ui.table>
    
        <!-- Pagination -->
        <div class="mt-6">
            {{ $templates->links() }}
        </div>
    @else
        <!-- Logs Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i data-lucide="send" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $logStats['total'] }}</p>
                    <p class="text-xs text-gray-500">Total Enviados</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $logStats['sent'] }}</p>
                    <p class="text-xs text-gray-500">Sucesso</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $logStats['failed'] }}</p>
                    <p class="text-xs text-gray-500">Falhas</p>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i data-lucide="calendar" class="w-5 h-5 text-purple-600"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $logStats['today'] }}</p>
                    <p class="text-xs text-gray-500">Hoje</p>
                </div>
            </div>
        </div>
        
        <!-- Logs Table -->
        <x-admin.ui.table>
            <x-slot:head>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Data/Hora</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Telefone</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mensagem</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Erro</th>
                </tr>
            </x-slot:head>
            
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-4">
                        <p class="text-sm text-gray-900">{{ $log->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <p class="font-medium text-gray-900">{{ $log->phone }}</p>
                        @if($log->user)
                            <p class="text-xs text-gray-500">{{ $log->user->name }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-sm text-gray-600 truncate max-w-xs">{{ Str::limit($log->message, 50) }}</p>
                        @if($log->template)
                            <p class="text-xs text-gray-500">Template: {{ $log->template->name }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        @if($log->status === 'sent')
                            <x-admin.ui.badge variant="success" size="sm">Enviado</x-admin.ui.badge>
                        @elseif($log->status === 'failed')
                            <x-admin.ui.badge variant="danger" size="sm">Falhou</x-admin.ui.badge>
                        @else
                            <x-admin.ui.badge variant="warning" size="sm">Pendente</x-admin.ui.badge>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        @if($log->error)
                            <p class="text-xs text-red-600 truncate max-w-xs" title="{{ $log->error }}">{{ Str::limit($log->error, 40) }}</p>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-admin.ui.empty-state 
                            icon="inbox" 
                            title="Nenhum registro encontrado"
                            description="Os envios de SMS aparecerão aqui." />
                    </td>
                </tr>
            @endforelse
        </x-admin.ui.table>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    @endif
    
    <!-- Template Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9998] overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl" @click.stop>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $editingId ? 'Editar Template' : 'Novo Template' }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    
                    <form wire:submit="saveTemplate" class="p-6 space-y-4">
                        <x-admin.form.input 
                            wire:model="name"
                            label="Nome do Template"
                            placeholder="Ex: Boas vindas"
                            :error="$errors->first('name')" />
                        
                        <x-admin.form.select 
                            wire:model="type"
                            label="Tipo">
                            <option value="promotional">Promocional</option>
                            <option value="transactional">Transacional</option>
                            <option value="notification">Notificação</option>
                        </x-admin.form.select>
                        
                        <div>
                            <x-admin.form.textarea 
                                wire:model="messageText"
                                label="Mensagem"
                                rows="4"
                                placeholder="Digite a mensagem..."
                                :error="$errors->first('messageText')" />
                            <p class="text-xs text-gray-500 mt-1">
                                Use variáveis: @{{nome}}, @{{pedido}}, @{{valor}}
                            </p>
                        </div>
                        
                        <x-admin.form.toggle 
                            wire:model="is_active"
                            label="Template Ativo" />
                        
                        <div class="flex justify-end gap-3 pt-4">
                            <x-admin.ui.button type="button" variant="outline" wire:click="$set('showModal', false)">
                                Cancelar
                            </x-admin.ui.button>
                            <x-admin.ui.button type="submit" icon="save">
                                {{ $editingId ? 'Atualizar' : 'Criar' }}
                            </x-admin.ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Test SMS Modal -->
    @if($showTestModal)
        <div class="fixed inset-0 z-[9998] overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showTestModal', false)"></div>
            
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl" @click.stop>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                <i data-lucide="send" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Testar Envio de SMS</h3>
                                <p class="text-xs text-gray-500">Envie um SMS de teste</p>
                            </div>
                        </div>
                        <button wire:click="$set('showTestModal', false)" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    
                    <form wire:submit="testSms" class="p-6 space-y-4">
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <p class="text-sm text-blue-800">
                                <strong>📱 Importante:</strong> Certifique-se de que o SMS está configurado nas Configurações do Sistema.
                            </p>
                        </div>
                        
                        <x-admin.form.input 
                            wire:model="testPhone"
                            label="Número de Telefone"
                            type="tel"
                            placeholder="+244 923 456 789"
                            icon="phone"
                            :error="$errors->first('testPhone')" />
                        
                        <div>
                            <x-admin.form.textarea 
                                wire:model="testMessage"
                                label="Mensagem"
                                rows="3"
                                placeholder="Digite a mensagem de teste..."
                                :error="$errors->first('testMessage')" />
                            <p class="text-xs text-gray-500 mt-1">
                                Máximo 160 caracteres • Contador: <span class="font-medium">{{ strlen($testMessage) }}</span>
                            </p>
                        </div>
                        
                        <div class="flex justify-end gap-3 pt-4">
                            <x-admin.ui.button type="button" variant="outline" wire:click="$set('showTestModal', false)">
                                Cancelar
                            </x-admin.ui.button>
                            <x-admin.ui.button type="submit" icon="send">
                                Enviar SMS
                            </x-admin.ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
