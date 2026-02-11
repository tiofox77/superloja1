<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Usuários</h1>
            <p class="text-gray-500">Gerencie os usuários do sistema</p>
        </div>
        <x-admin.ui.button wire:click="openCreateModal" icon="user-plus">
            Novo Usuário
        </x-admin.ui.button>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                <p class="text-sm text-gray-500">Total de Usuários</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                <i data-lucide="shield" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalAdmins) }}</p>
                <p class="text-sm text-gray-500">Administradores</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <i data-lucide="user" class="w-6 h-6 text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
                <p class="text-sm text-gray-500">Clientes</p>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <x-admin.ui.card class="mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <x-admin.form.search 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Buscar por nome ou email..." />
            </div>
            <div class="flex gap-3">
                <select wire:model.live="role" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos os Tipos</option>
                    <option value="admin">Administrador</option>
                    <option value="customer">Cliente</option>
                </select>
                
                @if($search || $role)
                    <button wire:click="clearFilters" 
                            class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                @endif
            </div>
        </div>
    </x-admin.ui.card>
    
    <!-- Users Table -->
    <x-admin.ui.table>
        <x-slot:head>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Usuário</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipo</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Cadastro</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
            </tr>
        </x-slot:head>
        
        @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-4">
                    <div class="flex items-center gap-3">
                        <x-admin.ui.avatar :alt="$user->name" size="md" />
                        <div>
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                            @if($user->id === auth()->id())
                                <span class="text-xs text-primary-600">(Você)</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                <td class="px-4 py-4">
                    <x-admin.ui.badge 
                        :variant="$user->role === 'admin' ? 'secondary' : 'default'" 
                        size="sm">
                        {{ $user->role === 'admin' ? 'Admin' : 'Cliente' }}
                    </x-admin.ui.badge>
                </td>
                <td class="px-4 py-4 text-sm text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="px-4 py-4 text-right">
                    <x-admin.ui.dropdown>
                        <x-admin.ui.dropdown-item wire:click="editUser({{ $user->id }})" icon="edit-2">
                            Editar
                        </x-admin.ui.dropdown-item>
                        @if($user->id !== auth()->id())
                            <x-admin.ui.dropdown-item 
                                wire:click="deleteUser({{ $user->id }})" 
                                wire:confirm="Tem certeza que deseja excluir este usuário?"
                                icon="trash-2" 
                                danger>
                                Excluir
                            </x-admin.ui.dropdown-item>
                        @endif
                    </x-admin.ui.dropdown>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <x-admin.ui.empty-state 
                        icon="users" 
                        title="Nenhum usuário encontrado"
                        description="Não encontramos usuários com os filtros aplicados." />
                </td>
            </tr>
        @endforelse
    </x-admin.ui.table>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
    
    <!-- User Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9998] overflow-y-auto" x-data x-init="$el.querySelector('input')?.focus()">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('showModal', false)"></div>
            
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl" @click.stop>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $editingUserId ? 'Editar Usuário' : 'Novo Usuário' }}
                        </h3>
                        <button wire:click="$set('showModal', false)" class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    
                    <form wire:submit="saveUser" class="p-6 space-y-4">
                        <x-admin.form.input 
                            wire:model="name"
                            label="Nome"
                            placeholder="Nome completo"
                            :error="$errors->first('name')" />
                        
                        <x-admin.form.input 
                            wire:model="email"
                            type="email"
                            label="Email"
                            placeholder="email@exemplo.com"
                            :error="$errors->first('email')" />
                        
                        <x-admin.form.input 
                            wire:model="password"
                            type="password"
                            label="{{ $editingUserId ? 'Nova Senha (deixe vazio para manter)' : 'Senha' }}"
                            placeholder="••••••••"
                            :error="$errors->first('password')" />
                        
                        <x-admin.form.select 
                            wire:model="userRole"
                            label="Tipo de Usuário"
                            :error="$errors->first('userRole')">
                            <option value="customer">Cliente</option>
                            <option value="admin">Administrador</option>
                        </x-admin.form.select>
                        
                        <div class="flex justify-end gap-3 pt-4">
                            <x-admin.ui.button type="button" variant="outline" wire:click="$set('showModal', false)">
                                Cancelar
                            </x-admin.ui.button>
                            <x-admin.ui.button type="submit" icon="save">
                                {{ $editingUserId ? 'Atualizar' : 'Criar' }}
                            </x-admin.ui.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
