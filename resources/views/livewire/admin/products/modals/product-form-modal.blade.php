@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!-- Product Form Modal -->
@if($showModal)
<div class="fixed inset-0 modal-overlay overflow-y-auto h-full w-full z-[9999] flex items-start justify-center p-4" wire:click="closeModal">
    <div class="relative w-full max-w-7xl mx-auto modal-3d animate-fade-in-scale my-8" @click.stop>
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
                    <h3 class="text-2xl font-bold {{ $editMode ? 'text-blue-900' : 'text-orange-900' }}" id="productModalTitle">
                        {{ $editMode ? 'Editar Produto' : 'Novo Produto' }}
                    </h3>
                    <p class="text-sm {{ $editMode ? 'text-blue-600' : 'text-orange-600' }}">
                        {{ $editMode ? 'Atualize as informações do produto' : 'Preencha os dados do novo produto' }}
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
        <div class="max-h-[80vh] overflow-y-auto">
            <form wire:submit.prevent="saveProduct" id="productForm" class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Coluna Esquerda -->
                    <div class="space-y-6">
                        <!-- Informações Básicas -->
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Informações Básicas</h4>
                            </div>
                            
                            <!-- Nome do Produto -->
                            <div class="mb-4">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Nome do Produto *
                                </label>
                                <input type="text" 
                                       wire:model="name" 
                                       class="input-3d w-full px-4 py-2 @error('name') border-red-500 @enderror"
                                       placeholder="Digite o nome do produto..."
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- SKU -->
                            <div class="mb-4">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    SKU *
                                </label>
                                <input type="text" 
                                       wire:model="sku" 
                                       class="input-3d w-full px-4 py-2 @error('sku') border-red-500 @enderror"
                                       placeholder="Digite o código SKU..."
                                       required>
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- Descrição -->
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                    Descrição *
                                </label>
                                <textarea wire:model="description" 
                                          rows="3" 
                                          class="input-3d w-full px-4 py-2 @error('description') border-red-500 @enderror"
                                          placeholder="Descreva o produto..."
                                          required></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Preços -->
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Preços</h4>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Preço de Venda -->
                                <div>
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Preço de Venda *
                                    </label>
                                    <input type="number" 
                                           wire:model="price" 
                                           step="0.01"
                                           min="0"
                                           class="input-3d w-full px-4 py-2 @error('price') border-red-500 @enderror"
                                           placeholder="0,00"
                                           required>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <!-- Preço de Promoção -->
                                <div>
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                        </svg>
                                        Preço de Promoção
                                    </label>
                                    <input type="number" 
                                           wire:model="sale_price" 
                                           step="0.01"
                                           min="0"
                                           class="input-3d w-full px-4 py-2 @error('sale_price') border-red-500 @enderror"
                                           placeholder="0,00">
                                    @error('sale_price')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Stock</h4>
                            </div>
                            
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                    Quantidade em Stock *
                                </label>
                                <input type="number" 
                                       wire:model="stock_quantity" 
                                       min="0"
                                       class="input-3d w-full px-4 py-2 @error('stock_quantity') border-red-500 @enderror"
                                       placeholder="0"
                                       required>
                                @error('stock_quantity')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Direita -->
                    <div class="space-y-6">
                        <!-- Categoria e Marca -->
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Categoria e Marca</h4>
                            </div>
                            
                            <!-- Categoria Principal -->
                            <div class="mb-4">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Categoria Principal *
                                </label>
                                <div class="relative">
                                    <select wire:model.live="parent_category_id" class="input-3d w-full px-4 py-2 pr-10 appearance-none @error('parent_category_id') border-red-500 @enderror" required>
                                        <option value="">Selecione a categoria principal</option>
                                        @foreach($parentCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('parent_category_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Subcategoria (opcional) -->
                            @if($parent_category_id && count($this->subcategories) > 0)
                            <div class="mb-4">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Subcategoria <span class="text-gray-400 text-xs">(Opcional)</span>
                                </label>
                                <div class="relative">
                                    <select wire:model="category_id" class="input-3d w-full px-4 py-2 pr-10 appearance-none @error('category_id') border-red-500 @enderror">
                                        <option value="">Nenhuma subcategoria</option>
                                        @foreach($this->subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            @endif
                            
                            <!-- Marca -->
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Marca *
                                </label>
                                <div class="relative">
                                    <select wire:model="brand_id" class="input-3d w-full px-4 py-2 pr-10 appearance-none @error('brand_id') border-red-500 @enderror" required>
                                        <option value="">Selecione uma marca</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('brand_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status e Configurações -->
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Configurações</h4>
                            </div>
                            
                            <div class="space-y-4">
                                <!-- Status Ativo -->
                                <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-teal-300 transition-colors duration-200 {{ $is_active ? 'bg-teal-50 border-teal-300' : 'bg-gray-50' }}">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               wire:model.live="is_active" 
                                               id="is_active"
                                               class="checkbox-modern checkbox-success">
                                        <label for="is_active" class="flex items-center cursor-pointer ml-3">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-teal-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                                </svg>
                                                <div>
                                                    <span class="text-sm font-medium text-gray-900">Produto Ativo</span>
                                                    <p class="text-xs text-gray-500">Produto visível na loja</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Produto em Destaque -->
                                <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-yellow-300 transition-colors duration-200 {{ $is_featured ? 'bg-yellow-50 border-yellow-300' : 'bg-gray-50' }}">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               wire:model.live="is_featured" 
                                               id="is_featured"
                                               class="checkbox-modern"
                                               style="--checkbox-color: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); --checkbox-border: #d97706;">
                                        <label for="is_featured" class="flex items-center cursor-pointer ml-3">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                                <div>
                                                    <span class="text-sm font-medium text-gray-900">Produto em Destaque</span>
                                                    <p class="text-xs text-gray-500">Aparece na página inicial</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Imagens -->
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Imagens</h4>
                            </div>
                            
                            <!-- Imagem Principal -->
                            <div class="mb-4">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Imagem Principal
                                </label>
                                <input type="file" 
                                       wire:model="image" 
                                       accept="image/*"
                                       class="input-3d w-full px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                                       
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <!-- Livewire Preview -->
                                @if($image)
                                    <div class="mt-3">
                                        <div class="relative inline-block">
                                            <img src="{{ $image->temporaryUrl() }}" 
                                                 alt="Preview" 
                                                 class="w-32 h-32 object-cover rounded-lg shadow-md border-2 border-indigo-200">
                                            <div class="absolute -top-2 -right-2">
                                                <button type="button" 
                                                        wire:click="removeImage"
                                                        class="w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <p class="text-sm text-green-600 mt-2">✓ Imagem carregada: {{ $image->getClientOriginalName() }}</p>
                                    </div>
                                @endif
                                
                                @if($editMode && isset($productId))
                                    @php
                                        $currentProduct = \App\Models\Product::find($productId);
                                    @endphp
                                    @if($currentProduct && $currentProduct->featured_image)
                                        <div class="mt-3">
                                            <div class="relative inline-block">
                                                <img src="{{ Storage::url($currentProduct->featured_image) }}" 
                                                     alt="Imagem atual" 
                                                     class="w-32 h-32 object-cover rounded-lg shadow-md border-2 border-gray-300">
                                                <div class="absolute top-1 left-1">
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-md">Atual</span>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2">📎 Imagem atual do produto</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            
                            <!-- Galeria -->
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Galeria (múltiplas imagens)
                                </label>
                                <input type="file" 
                                       wire:model="gallery" 
                                       accept="image/*"
                                       multiple
                                       class="input-3d w-full px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-600 hover:file:bg-purple-100">
                                       
                                @error('gallery.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($gallery && count($gallery) > 0)
                                    <div class="mt-3">
                                        <p class="text-sm text-green-600 mb-3">✓ {{ count($gallery) }} imagens selecionadas</p>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                            @foreach($gallery as $index => $galleryImage)
                                                <div class="relative group">
                                                    @php
                                                        $imageUrl = null;
                                                        try {
                                                            $imageUrl = $galleryImage->temporaryUrl();
                                                        } catch (Exception $e) {
                                                            $imageUrl = null;
                                                        }
                                                    @endphp
                                                    
                                                    @if($imageUrl)
                                                        <img src="{{ $imageUrl }}" 
                                                             alt="Gallery {{ $index + 1 }}" 
                                                             class="w-20 h-20 object-cover rounded-lg shadow-md border-2 border-purple-200 transition-transform group-hover:scale-105"
                                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center" style="display: none;">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="absolute -top-1 -right-1">
                                                        <button type="button" 
                                                                wire:click="removeGalleryImage({{ $index }})"
                                                                class="w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors text-xs">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($editMode && isset($productId))
                                    @php
                                        $currentProduct = \App\Models\Product::find($productId);
                                        $productImages = [];
                                        if($currentProduct && $currentProduct->images) {
                                            if(is_string($currentProduct->images)) {
                                                $decoded = json_decode($currentProduct->images, true);
                                                $productImages = is_array($decoded) ? $decoded : [];
                                            } elseif(is_array($currentProduct->images)) {
                                                $productImages = $currentProduct->images;
                                            }
                                        }
                                    @endphp
                                    @if($currentProduct && !empty($productImages))
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-600 mb-3">📷 Imagens atuais da galeria ({{ count($productImages) }})</p>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                                @foreach($productImages as $index => $existingImage)
                                                    <div class="relative group">
                                                        <img src="{{ Storage::url($existingImage) }}" 
                                                             alt="Gallery existing {{ $index + 1 }}" 
                                                             class="w-20 h-20 object-cover rounded-lg shadow-md border-2 border-gray-300 transition-transform group-hover:scale-105">
                                                        <div class="absolute top-1 left-1">
                                                            <span class="px-1 py-0.5 bg-blue-100 text-blue-800 text-xs rounded">{{ $index + 1 }}</span>
                                                        </div>
                                                        <div class="absolute -top-1 -right-1">
                                                            <button type="button" 
                                                                    wire:click="removeExistingImage({{ $productId }}, {{ $index }})"
                                                                    class="w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors text-xs"
                                                                    onclick="return confirm('Tem certeza que deseja remover esta imagem?')">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        @if($currentProduct)
                                            <div class="mt-3">
                                                <p class="text-sm text-gray-500 italic">📷 Nenhuma imagem na galeria deste produto</p>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Variantes -->
                <div class="mt-8">
                    <div class="card-3d p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">Variantes do Produto</h4>
                                    <p class="text-sm text-gray-500">Adicione diferentes versões do produto (cor, tamanho, etc.)</p>
                                </div>
                            </div>
                            <button type="button" 
                                    wire:click="addVariant"
                                    class="btn-3d bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-4 py-2 font-medium flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Nova Variante</span>
                            </button>
                        </div>

                        <!-- Lista de Variantes -->
                        <div class="space-y-4">
                            @forelse($variants ?? [] as $index => $variant)
                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50" wire:key="variant-{{ $index }}">
                                    <div class="flex items-center justify-between mb-4">
                                        <h5 class="font-medium text-gray-900">Variante {{ $index + 1 }}</h5>
                                        <button type="button" 
                                                wire:click="removeVariant({{ $index }})"
                                                onclick="return confirm('Tem certeza que deseja remover esta variante? Esta ação não pode ser desfeita.')"
                                                class="text-red-500 hover:text-red-700 p-1 transition-colors"
                                                title="Remover variante">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <!-- Nome da Variante -->
                                        <div>
                                            <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                                <svg class="w-3 h-3 mr-1 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                Nome
                                            </label>
                                            <input type="text" 
                                                   wire:model="variants.{{ $index }}.name"
                                                   class="input-3d w-full px-3 py-2 text-sm"
                                                   placeholder="Ex: Cor">
                                        </div>

                                        <!-- Valor da Variante -->
                                        <div>
                                            <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                                <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                Valor
                                            </label>
                                            <input type="text" 
                                                   wire:model="variants.{{ $index }}.value"
                                                   class="input-3d w-full px-3 py-2 text-sm"
                                                   placeholder="Ex: Vermelho">
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <!-- Ajuste de Preço da Variante -->
                                        <div>
                                            <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                                <svg class="w-3 h-3 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                Ajuste Preço
                                            </label>
                                            <input type="number" 
                                                   wire:model="variants.{{ $index }}.price_adjustment"
                                                   step="0.01"
                                                   class="input-3d w-full px-3 py-2 text-sm"
                                                   placeholder="0,00">
                                        </div>

                                        <!-- Stock da Variante -->
                                        <div>
                                            <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                                <svg class="w-3 h-3 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                Stock
                                            </label>
                                            <input type="number" 
                                                   wire:model="variants.{{ $index }}.stock_quantity"
                                                   min="0"
                                                   class="input-3d w-full px-3 py-2 text-sm"
                                                   placeholder="0">
                                        </div>

                                        <!-- SKU Sufixo da Variante -->
                                        <div>
                                            <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                                                <svg class="w-3 h-3 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                SKU Sufixo
                                            </label>
                                            <input type="text" 
                                                   wire:model="variants.{{ $index }}.sku_suffix"
                                                   class="input-3d w-full px-3 py-2 text-sm"
                                                   placeholder="VER-M">
                                        </div>
                                    </div>
                                    
                                    <!-- Seção de Imagens da Variante -->
                                    <div class="mt-4">
                                        <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                            <svg class="w-4 h-4 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Imagens da Variante
                                        </label>
                                        
                                        <input type="file" 
                                               wire:model="variants.{{ $index }}.images" 
                                               multiple
                                               accept="image/*"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 cursor-pointer">
                                        
                                        @error('variants.' . $index . '.images.*')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        
                                        <!-- Preview das imagens da variante -->
                                        @if(isset($variants[$index]['images']) && is_array($variants[$index]['images']) && count($variants[$index]['images']) > 0)
                                            <div class="mt-3">
                                                <p class="text-sm text-green-600 mb-3">✓ {{ count($variants[$index]['images']) }} imagens selecionadas</p>
                                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                                    @foreach($variants[$index]['images'] as $imgIndex => $variantImage)
                                                        <div class="relative group">
                                                            @php
                                                                $imageUrl = null;
                                                                try {
                                                                    $imageUrl = $variantImage->temporaryUrl();
                                                                } catch (Exception $e) {
                                                                    $imageUrl = null;
                                                                }
                                                            @endphp
                                                            
                                                            @if($imageUrl)
                                                                <img src="{{ $imageUrl }}" 
                                                                     alt="Variant {{ $imgIndex + 1 }}" 
                                                                     class="w-16 h-16 object-cover rounded-lg shadow-md border-2 border-pink-200 transition-transform group-hover:scale-105">
                                                                <div class="absolute -top-1 -right-1">
                                                                    <button type="button" 
                                                                            wire:click="removeVariantImage({{ $index }}, {{ $imgIndex }})"
                                                                            class="w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors text-xs">
                                                                        <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Imagens existentes da variante (se for edição) -->
                                        @if(isset($variants[$index]['existing_images']) && is_array($variants[$index]['existing_images']) && !empty($variants[$index]['existing_images']))
                                            <div class="mt-3">
                                                <p class="text-sm text-gray-600 mb-3">📷 Imagens atuais da variante ({{ count($variants[$index]['existing_images']) }})</p>
                                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                                    @foreach($variants[$index]['existing_images'] as $imgIndex => $existingImage)
                                                        <div class="relative group">
                                                            <img src="{{ Storage::url($existingImage) }}" 
                                                                 alt="Existing Variant {{ $imgIndex + 1 }}" 
                                                                 class="w-16 h-16 object-cover rounded-lg shadow-md border-2 border-gray-300 transition-transform group-hover:scale-105">
                                                            <div class="absolute top-1 left-1">
                                                                <span class="px-1 py-0.5 bg-blue-100 text-blue-800 text-xs rounded">{{ $imgIndex + 1 }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p>Nenhuma variante adicionada</p>
                                    <p class="text-sm">Clique em "Nova Variante" para começar</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Botões de Ação -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="button" wire:click="closeModal" 
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        Cancelar
                    </button>
                    
                    <button type="submit" 
                            class="px-6 py-2 border border-transparent rounded-lg shadow-sm text-white {{ $editMode ? 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700' : 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        {{ $editMode ? 'Salvar Alterações' : 'Criar Produto' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
