<!-- Brand Form Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="brandModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900" id="brandModalTitle">
                {{ $editMode ? 'Editar Marca' : 'Nova Marca' }}
            </h3>
            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form wire:submit.prevent="saveBrand" id="brandForm" class="mt-6">
            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Informações da Marca</h4>
                    
                    <!-- Brand Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome da Marca *
                        </label>
                        <input type="text" 
                               wire:model="name" 
                               id="name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="Digite o nome da marca">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Descrição
                        </label>
                        <textarea wire:model="description" 
                                  id="description"
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Digite a descrição da marca"></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="mb-4">
                        <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">
                            Website
                        </label>
                        <div class="relative">
                            <input type="url" 
                                   wire:model="website" 
                                   id="website"
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('website') border-red-500 @enderror"
                                   placeholder="https://exemplo.com">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </div>
                        </div>
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="is_active" 
                                   id="is_active"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Marca ativa
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Marcas inativas não aparecerão na loja</p>
                    </div>
                </div>

                <!-- Logo Upload -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Logo da Marca</h4>
                    
                    <div class="space-y-4">
                        <!-- Current Logo (Edit Mode) -->
                        @if($editMode && !$logo)
                            <div id="currentImageSection" class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Atual</label>
                                @if($selectedBrand && $selectedBrand->logo_url)
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ Storage::url($selectedBrand->logo_url) }}" 
                                             alt="Logo atual" 
                                             class="h-16 w-16 object-contain bg-white rounded-lg border border-gray-200 p-2">
                                        <div class="text-sm text-gray-600">
                                            <p>Logo atual da marca</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">Nenhum logo carregado</p>
                                @endif
                            </div>
                        @endif

                        <!-- Logo Upload -->
                        <div>
                            <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ $editMode ? 'Novo Logo' : 'Logo da Marca' }}
                            </label>
                            <input type="file" 
                                   wire:model="logo" 
                                   id="logo"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('logo') border-red-500 @enderror">
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</p>
                            
                            <!-- Preview -->
                            @if($logo)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Pré-visualização:</p>
                                    <img src="{{ $logo->temporaryUrl() }}" 
                                         class="h-20 w-20 object-contain bg-white rounded-lg border border-gray-200 p-2">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistics Section (Edit Mode Only) -->
                @if($editMode)
                    <div id="statisticsSection" class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Estatísticas da Marca</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $selectedBrand->products_count ?? 0 }}</div>
                                <div class="text-sm text-gray-600">Produtos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">
                                    {{ $selectedBrand ? \Carbon\Carbon::parse($selectedBrand->created_at)->diffInDays(now()) : 0 }}
                                </div>
                                <div class="text-sm text-gray-600">Dias ativa</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                <button type="button" 
                        wire:click="closeModal"
                        class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ $editMode ? 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700' : 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <span id="brandSubmitText">
                        {{ $editMode ? 'Salvar Alterações' : 'Criar Marca' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
