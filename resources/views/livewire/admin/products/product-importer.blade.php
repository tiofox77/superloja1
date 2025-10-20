<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-2xl">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">📊 Importar Produtos via Excel</h1>
                        <p class="text-sm text-gray-600">Importe produtos em massa com download automático de imagens</p>
                    </div>
                </div>
                
                @if(!$importing && count($logs) > 0)
                    <button wire:click="resetImport" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        🔄 Nova Importação
                    </button>
                @endif
            </div>
        </div>

        <div class="p-6 space-y-6">
            
            @if(!$importing && count($logs) === 0)
                <!-- Upload Form -->
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Selecione o arquivo Excel/CSV</h3>
                    <p class="text-gray-600 mb-6">Formatos aceitos: .xlsx, .xls, .csv (máx. 10MB)</p>
                    
                    <div class="space-y-4">
                        <input type="file" 
                               wire:model="file" 
                               accept=".xlsx,.xls,.csv"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:transition-colors file:duration-200">
                        
                        @error('file')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                        
                        @if($file)
                            <div class="flex items-center justify-center space-x-4 mt-4">
                                <div class="flex items-center text-green-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Arquivo selecionado: {{ $file->getClientOriginalName() }}
                                </div>
                                
                                <button wire:click="import" 
                                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    🚀 Iniciar Importação
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Instruções -->
                <div class="bg-blue-50 rounded-xl p-6">
                    <h4 class="font-semibold text-blue-900 mb-3">📋 Formato do Arquivo Excel/CSV:</h4>
                    <div class="text-sm text-blue-800 space-y-2">
                        <p><strong>Colunas obrigatórias:</strong></p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 ml-4">
                            <div>• <code class="bg-blue-100 px-2 py-1 rounded">title</code> - Nome do produto</div>
                            <div>• <code class="bg-blue-100 px-2 py-1 rounded">description</code> - Descrição</div>
                            <div>• <code class="bg-blue-100 px-2 py-1 rounded">price</code> - Preço (formato: 5900.00)</div>
                            <div>• <code class="bg-blue-100 px-2 py-1 rounded">brand</code> - Marca do produto</div>
                            <div>• <code class="bg-blue-100 px-2 py-1 rounded">image_link</code> - URL da imagem</div>
                            <div>• <code class="bg-blue-100 px-2 py-1 rounded">availability</code> - in stock / out of stock</div>
                        </div>
                        <p class="mt-3"><strong>⚡ Funcionalidades automáticas:</strong></p>
                        <div class="ml-4 space-y-1">
                            <div>✅ Download automático de imagens dos links fornecidos</div>
                            <div>✅ Geração automática de SKUs únicos</div>
                            <div>✅ Criação de marcas automaticamente se não existirem</div>
                            <div>✅ Preços promocionais (10% desconto automático)</div>
                        </div>
                    </div>
                </div>
            @endif

            @if($importing)
                <!-- Progress Bar -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-blue-900">🔄 Importando produtos...</h4>
                        <span class="text-sm text-blue-700">{{ $currentRow }}/{{ $totalRows }} produtos</span>
                    </div>
                    
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-300" 
                             style="width: {{ $progress }}%"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div class="bg-white rounded-lg p-3 border">
                            <div class="text-lg font-bold text-green-600">{{ $importedCount }}</div>
                            <div class="text-sm text-gray-600">Importados</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 border">
                            <div class="text-lg font-bold text-red-600">{{ $errorCount }}</div>
                            <div class="text-sm text-gray-600">Erros</div>
                        </div>
                        <div class="bg-white rounded-lg p-3 border">
                            <div class="text-lg font-bold text-blue-600">{{ round($progress, 1) }}%</div>
                            <div class="text-sm text-gray-600">Progresso</div>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($logs) > 0)
                <!-- Logs -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">📋 Log de Importação:</h4>
                    <div class="max-h-96 overflow-y-auto space-y-2">
                        @foreach($logs as $log)
                            <div class="flex items-start space-x-3 text-sm p-2 rounded-lg 
                                @if($log['type'] === 'error') bg-red-100 text-red-800
                                @elseif($log['type'] === 'warning') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                
                                @if($log['type'] === 'error')
                                    <span class="text-red-500">❌</span>
                                @elseif($log['type'] === 'warning')
                                    <span class="text-yellow-500">⚠️</span>
                                @else
                                    <span class="text-green-500">✅</span>
                                @endif
                                
                                <div class="flex-1">
                                    <span class="font-mono text-xs text-gray-500">[{{ $log['time'] }}]</span>
                                    {{ $log['message'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(count($errors) > 0)
                <!-- Errors Summary -->
                <div class="bg-red-50 rounded-xl p-6">
                    <h4 class="font-semibold text-red-900 mb-4">❌ Resumo de Erros ({{ count($errors) }}):</h4>
                    <div class="max-h-64 overflow-y-auto space-y-1">
                        @foreach($errors as $error)
                            <div class="text-sm text-red-700 p-2 bg-red-100 rounded border-l-4 border-red-400">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('importProgress', (data) => {
        // Atualizar progresso em tempo real se necessário
        console.log('Progresso:', data.progress + '%');
    });
});
</script>
