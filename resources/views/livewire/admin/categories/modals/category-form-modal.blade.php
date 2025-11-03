{{-- Modal: CategoryForm Livewire (DO NOT RENAME) --}}
<div x-show="$wire.showModal" x-cloak
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] overflow-y-auto py-6"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click.self="$wire.closeModal()">
    
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-auto my-6 flex flex-col relative"
         style="max-height: calc(100vh - 3rem);"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.stop>
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $isEditMode ? 'Editar Categoria' : 'Nova Categoria' }}
            </h2>
            <button wire:click="closeModal" 
                    type="button"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form wire:submit="save" class="flex-1 overflow-y-auto">
            <div class="p-6 space-y-6">
            
            <!-- Current Image Display (only for edit mode) -->
            @if($isEditMode && $currentImage && !$removeImage)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Imagem Atual
                    </label>
                    <div class="mb-4">
                        <img src="{{ Storage::url($currentImage) }}" 
                             alt="Imagem atual" 
                             class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                        <button type="button" 
                                wire:click="removeCurrentImage" 
                                class="mt-2 text-sm text-red-600 hover:text-red-800">
                            Remover imagem atual
                        </button>
                    </div>
                </div>
            @endif
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nome da Categoria *
                    </label>
                    <input type="text" 
                           wire:model="name"
                           id="name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                           placeholder="Ex: Eletrônicos">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">O slug será gerado automaticamente</p>
                </div>

                <!-- Parent Category -->
                <div>
                    <label for="parentId" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        Categoria Pai <span class="text-xs text-gray-400 font-normal ml-1">(Opcional)</span>
                    </label>
                    <div class="relative">
                        <select wire:model="parentId"
                                id="parentId"
                                class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 appearance-none @error('parentId') border-red-500 @enderror">
                            <option value="">✨ Categoria Principal (Sem Pai)</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}">📁 {{ $parent->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Deixe vazio para criar uma categoria principal. Selecione um pai para criar subcategoria.
                    </p>
                    @error('parentId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Descrição
                </label>
                <textarea wire:model="description"
                          id="description"
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('description') border-red-500 @enderror"
                          placeholder="Descrição da categoria (opcional)"></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Visual Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ícone (Emoji)
                    </label>
                    <input type="text" 
                           wire:model="icon"
                           id="icon"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('icon') border-red-500 @enderror"
                           placeholder="📱">
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Use emojis para representar a categoria</p>
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">
                        Cor
                    </label>
                    <div class="flex space-x-2">
                        <input type="color" 
                               wire:model.live="color"
                               id="color"
                               class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" 
                               wire:model="color"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('color') border-red-500 @enderror"
                               placeholder="#6366f1">
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sort Order -->
                <div>
                    <label for="sortOrder" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ordem de Exibição
                    </label>
                    <input type="number" 
                           wire:model="sortOrder"
                           id="sortOrder"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 @error('sortOrder') border-red-500 @enderror"
                           placeholder="0">
                    @error('sortOrder')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Ordem de exibição (menor primeiro)</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="isActive" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status
                    </label>
                    <div class="flex items-center space-x-3 mt-3">
                        <input type="checkbox" 
                               wire:model="isActive"
                               id="isActive"
                               class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                        <label for="isActive" class="text-sm text-gray-700">
                            Categoria Ativa
                        </label>
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    {{ $isEditMode ? 'Nova Imagem da Categoria' : 'Imagem da Categoria' }}
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-orange-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none">
                                <span>{{ $isEditMode ? 'Carregar nova imagem' : 'Carregar arquivo' }}</span>
                                <input wire:model="image" 
                                       id="image" 
                                       type="file" 
                                       class="sr-only" 
                                       accept="image/*">
                            </label>
                            <p class="pl-1">ou arraste e solte</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF até 2MB</p>
                    </div>
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Statistics (only for edit mode) -->
            @if($isEditMode)
                <div class="bg-gray-50 rounded-xl p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Estatísticas da Categoria</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $categories->where('id', $categoryId)->first()->products_count ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Produtos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $categories->where('id', $categoryId)->first()->children_count ?? 0 }}</div>
                            <div class="text-xs text-gray-600">Subcategorias</div>
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </form>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
            <button wire:click="closeModal"
                    type="button"
                    class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200">
                Cancelar
            </button>
            <button wire:click="save"
                    type="button"
                    class="px-8 py-3 rounded-xl text-white font-semibold transition-all duration-200 flex items-center space-x-2
                           {{ $isEditMode ? 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700' : 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700' }}"
                    wire:loading.attr="disabled">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span wire:loading.remove wire:target="save">{{ $isEditMode ? 'Salvar Alterações' : 'Criar Categoria' }}</span>
                <span wire:loading wire:target="save">{{ $isEditMode ? 'Salvando...' : 'Criando...' }}</span>
            </button>
        </div>
    </div>
</div>
