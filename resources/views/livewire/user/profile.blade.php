<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold flex items-center">
                <span class="mr-3">👤</span> Meu Perfil
            </h1>
            <p class="text-green-100 mt-2">Gerencie suas informações pessoais</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <div class="flex flex-wrap gap-4 mb-8">
            <a href="{{ route('user.dashboard') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">📊 Dashboard</a>
            <a href="{{ route('user.orders') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">📦 Meus Pedidos</a>
            <button class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold">👤 Perfil</button>
            <a href="{{ route('auctions') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors">🎯 Leilões</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Avatar Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="mr-2">📸</span> Foto de Perfil
                    </h2>
                    
                    <div class="text-center">
                        <div class="relative inline-block mb-4">
                            @if($current_avatar)
                                <img src="{{ $current_avatar }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover border-4 border-green-200">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white text-4xl font-bold border-4 border-green-200">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="absolute bottom-0 right-0 w-8 h-8 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-white text-xs">📷</span>
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ auth()->user()->email }}</p>
                        
                        <div class="space-y-2">
                            <button wire:click="toggleAvatarSection" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                                {{ $showAvatarSection ? 'Cancelar' : 'Alterar Foto' }}
                            </button>
                            
                            @if($current_avatar)
                                <button wire:click="deleteAvatar" class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                    Remover Foto
                                </button>
                            @endif
                        </div>

                        @if($showAvatarSection)
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nova Foto</label>
                                    <input type="file" wire:model="avatar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                @if($avatar)
                                    <div class="mb-4">
                                        <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-20 h-20 rounded-full object-cover mx-auto border-2 border-gray-200">
                                    </div>
                                @endif
                                
                                <button wire:click="updateAvatar" wire:loading.attr="disabled" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50">
                                    <span wire:loading.remove wire:target="updateAvatar">Salvar Foto</span>
                                    <span wire:loading wire:target="updateAvatar">Salvando...</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="mr-2">📊</span> Resumo da Conta
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                            <span class="text-blue-800 font-medium">Membro desde</span>
                            <span class="text-blue-600">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <span class="text-green-800 font-medium">Status</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">{{ auth()->user()->role === 'admin' ? '👑 Admin' : '👤 Cliente' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="lg:col-span-2">
                <form wire:submit.prevent="updateProfile">
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="mr-2">📝</span> Informações Pessoais
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                                <input type="text" wire:model="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" wire:model="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                                <input type="text" wire:model="phone" placeholder="+244 923 456 789" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cidade</label>
                                <input type="text" wire:model="city" placeholder="Luanda" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data de Nascimento</label>
                                <input type="date" wire:model="birth_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Género</label>
                                <select wire:model="gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="">Selecionar...</option>
                                    <option value="male">Masculino</option>
                                    <option value="female">Feminino</option>
                                    <option value="other">Outro</option>
                                </select>
                                @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Endereço</label>
                            <textarea wire:model="address" rows="2" placeholder="Endereço completo..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Biografia</label>
                            <textarea wire:model="bio" rows="3" placeholder="Conte um pouco sobre você..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                            @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="submit" wire:loading.attr="disabled" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-3 rounded-lg font-bold hover:from-green-700 hover:to-emerald-700 transition-all shadow-lg disabled:opacity-50">
                                <span wire:loading.remove wire:target="updateProfile">💾 Salvar Alterações</span>
                                <span wire:loading wire:target="updateProfile">Salvando...</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Password Section -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="mr-2">🔒</span> Alterar Senha
                        </h2>
                        <button wire:click="togglePasswordSection" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            {{ $showPasswordSection ? 'Cancelar' : 'Alterar Senha' }}
                        </button>
                    </div>
                    
                    @if($showPasswordSection)
                        <form wire:submit.prevent="updatePassword">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Senha Atual *</label>
                                    <input type="password" wire:model="current_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nova Senha *</label>
                                    <input type="password" wire:model="new_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha *</label>
                                    <input type="password" wire:model="new_password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    @error('new_password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" wire:loading.attr="disabled" class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-6 py-3 rounded-lg font-bold hover:from-red-700 hover:to-pink-700 transition-all shadow-lg disabled:opacity-50">
                                        <span wire:loading.remove wire:target="updatePassword">🔐 Alterar Senha</span>
                                        <span wire:loading wire:target="updatePassword">Alterando...</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p class="text-gray-600">Clique em "Alterar Senha" para definir uma nova senha para sua conta.</p>
                    @endif
                </div>

                <!-- Account Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="mr-2">⚙️</span> Ações da Conta
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('user.orders') }}" class="flex items-center p-4 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-blue-600">📦</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Meus Pedidos</h4>
                                <p class="text-sm text-gray-600">Ver histórico de compras</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.wishlist') }}" class="flex items-center p-4 border border-pink-200 rounded-lg hover:bg-pink-50 transition-colors">
                            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-pink-600">❤️</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Lista de Desejos</h4>
                                <p class="text-sm text-gray-600">Produtos favoritos</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('auctions') }}" class="flex items-center p-4 border border-green-200 rounded-lg hover:bg-green-50 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-green-600">🎯</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Leilões</h4>
                                <p class="text-sm text-gray-600">Participar de leilões</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('products') }}" class="flex items-center p-4 border border-purple-200 rounded-lg hover:bg-purple-50 transition-colors">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-purple-600">🛍️</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Produtos</h4>
                                <p class="text-sm text-gray-600">Explorar catálogo</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
