<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Importar Produtos</h1>
            <p class="text-gray-500">Importe produtos via arquivo CSV</p>
        </div>
        <x-admin.ui.button href="{{ route('admin.products.index') }}" variant="outline" icon="arrow-left">
            Voltar
        </x-admin.ui.button>
    </div>
    
    @if(!$showResults)
        <div class="max-w-2xl space-y-6">
            <!-- Upload -->
            <x-admin.ui.card title="Arquivo de Importação" icon="upload">
                <div class="space-y-4">
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary-400 transition-colors">
                        <input type="file" wire:model="file" class="hidden" id="file-upload" accept=".csv,.xlsx,.xls">
                        <label for="file-upload" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            @if($file)
                                <p class="text-sm font-medium text-primary-600">{{ $file->getClientOriginalName() }}</p>
                                <p class="text-xs text-gray-500 mt-1">Clique para alterar</p>
                            @else
                                <p class="text-sm font-medium text-gray-700">Clique para selecionar arquivo</p>
                                <p class="text-xs text-gray-500 mt-1">CSV, XLSX ou XLS (máx. 10MB)</p>
                            @endif
                        </label>
                    </div>
                    @error('file') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    
                    <div class="flex justify-end">
                        <x-admin.ui.button wire:click="downloadTemplate" variant="outline" icon="download" size="sm">
                            Baixar Template CSV
                        </x-admin.ui.button>
                    </div>
                </div>
            </x-admin.ui.card>
            
            <!-- Options -->
            <x-admin.ui.card title="Opções de Importação" icon="settings">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div>
                            <h4 class="font-medium text-gray-900">Atualizar Existentes</h4>
                            <p class="text-sm text-gray-500">Atualizar produtos existentes pelo SKU</p>
                        </div>
                        <x-admin.form.toggle wire:model="updateExisting" />
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <x-admin.form.select wire:model="defaultCategoryId" label="Categoria Padrão">
                            <option value="">Selecione...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-admin.form.select>
                        
                        <x-admin.form.select wire:model="defaultBrandId" label="Marca Padrão">
                            <option value="">Selecione...</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </x-admin.form.select>
                    </div>
                </div>
            </x-admin.ui.card>
            
            <!-- Format Info -->
            <x-admin.ui.card title="Formato do Arquivo" icon="info">
                <x-admin.ui.alert type="info">
                    <strong>Colunas esperadas:</strong> name, description, price, stock_quantity, sku
                    <br><small>Use ponto-e-vírgula (;) como separador</small>
                </x-admin.ui.alert>
            </x-admin.ui.card>
            
            <!-- Import Button -->
            <x-admin.ui.button wire:click="import" icon="upload" size="lg" class="w-full justify-center" :disabled="!$file">
                Importar Produtos
            </x-admin.ui.button>
        </div>
    @else
        <!-- Results -->
        <div class="max-w-2xl space-y-6">
            <x-admin.ui.card title="Resultado da Importação" icon="check-circle">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 bg-green-50 rounded-xl text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $successCount }}</p>
                        <p class="text-sm text-green-700">Importados com sucesso</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-xl text-center">
                        <p class="text-3xl font-bold text-red-600">{{ $errorCount }}</p>
                        <p class="text-sm text-red-700">Erros encontrados</p>
                    </div>
                </div>
                
                @if(count($errors) > 0)
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-2">Erros:</h4>
                        <div class="max-h-48 overflow-y-auto bg-red-50 rounded-xl p-3 space-y-1">
                            @foreach($errors as $error)
                                <p class="text-sm text-red-700">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="flex gap-3">
                    <x-admin.ui.button wire:click="resetImport" variant="outline" icon="refresh-cw">
                        Nova Importação
                    </x-admin.ui.button>
                    <x-admin.ui.button href="{{ route('admin.products.index') }}" icon="package">
                        Ver Produtos
                    </x-admin.ui.button>
                </div>
            </x-admin.ui.card>
        </div>
    @endif
</div>
