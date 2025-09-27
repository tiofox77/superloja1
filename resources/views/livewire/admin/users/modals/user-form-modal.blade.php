<!-- User Form Modal -->
<div class="fixed inset-0 modal-overlay overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
    <div class="relative w-full max-w-4xl mx-auto modal-3d animate-fade-in-scale" wire:click.stop>
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r {{ $editMode ? 'from-blue-50 to-indigo-50' : 'from-orange-50 to-red-50' }} rounded-t-3xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $editMode ? 'from-blue-500 to-indigo-600' : 'from-orange-500 to-red-600' }} flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($editMode)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        @endif
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold {{ $editMode ? 'text-blue-900' : 'text-orange-900' }}">
                        {{ $editMode ? 'Editar Utilizador' : 'Novo Utilizador' }}
                    </h3>
                    <p class="text-sm {{ $editMode ? 'text-blue-600' : 'text-orange-600' }}">
                        {{ $editMode ? 'Atualize as informações do utilizador' : 'Crie um novo utilizador no sistema' }}
                    </p>
                </div>
            </div>
            <button wire:click="closeModal" class="p-2 rounded-xl hover:bg-white/50 text-gray-500 hover:text-gray-700 transition-all duration-200 group">
                <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form wire:submit.prevent="saveUser" class="p-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Informações Pessoais</h4>
                        </div>

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nome Completo *
                            </label>
                            <input type="text" wire:model="name" 
                                   class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                   placeholder="Digite o nome completo..."
                                   required>
                            @error('name') <span class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                                Email *
                            </label>
                            <input type="email" wire:model="email" 
                                   class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                   placeholder="Digite o email..."
                                   required>
                            @error('email') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-6">
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Telefone
                            </label>
                            <input type="tel" wire:model="phone" 
                                   class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                   placeholder="Digite o telefone...">
                            @error('phone') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- Role and Status -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="role" class="block text-sm font-semibold text-gray-700 mb-3">Função</label>
                                <select wire:model="role" class="input-3d w-full px-4 py-3 text-gray-900">
                                    <option value="customer">Cliente</option>
                                    <option value="seller">Vendedor</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" wire:model="is_active" 
                                           class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500">
                                    <span class="text-sm font-semibold text-gray-700">Utilizador ativo</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Security Information -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Segurança</h4>
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Senha {{ $editMode ? '(deixe vazio para manter)' : '*' }}
                            </label>
                            <input type="password" wire:model="password" 
                                   class="input-3d w-full px-4 py-3 text-gray-900"
                                   placeholder="Digite a senha..."
                                   {{ !$editMode ? 'required' : '' }}>
                            @error('password') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Confirmar Senha {{ $editMode ? '' : '*' }}
                            </label>
                            <input type="password" wire:model="password_confirmation" 
                                   class="input-3d w-full px-4 py-3 text-gray-900"
                                   placeholder="Confirme a senha..."
                                   {{ !$editMode ? 'required' : '' }}>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Localização</h4>
                        </div>

                        <!-- Address -->
                        <div class="mb-6">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Endereço
                            </label>
                            <textarea wire:model="address" rows="3"
                                      class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                      placeholder="Digite o endereço completo..."></textarea>
                            @error('address') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- City -->
                        <div class="mb-6">
                            <label for="city" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Cidade
                            </label>
                            <input type="text" wire:model="city" 
                                   class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                   placeholder="Digite a cidade...">
                            @error('city') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 mt-8">
                <button type="button" wire:click="closeModal" 
                        class="px-6 py-3 border border-gray-300 rounded-2xl text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                    Cancelar
                </button>
                
                <button type="submit" 
                        class="btn-3d px-8 py-3 text-white font-semibold rounded-2xl {{ $editMode ? 'bg-gradient-to-r from-blue-500 to-indigo-600' : 'bg-gradient-to-r from-orange-500 to-red-600' }}">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($editMode)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        @endif
                    </svg>
                    {{ $editMode ? 'Atualizar Utilizador' : 'Criar Utilizador' }}
                </button>
            </div>
        </form>
    </div>
</div>
