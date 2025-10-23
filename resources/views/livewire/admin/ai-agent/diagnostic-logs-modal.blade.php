{{-- Modal de Detalhes --}}
@if($showDetailModal && $selectedLog)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50" wire:click="closeModal"></div>
    
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl" 
                 wire:click.stop>
                
                {{-- Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Detalhes do Log de Diagnóstico
                        </h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Content --}}
                <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                    
                    {{-- Informações do Cliente --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">👤 Informações do Cliente</h4>
                        <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Nome</p>
                                <p class="text-sm font-medium text-gray-900">{{ $selectedLog->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Identificador</p>
                                <p class="text-sm font-medium text-gray-900">{{ $selectedLog->customer_identifier }}</p>
                            </div>
                            @if($selectedLog->customer)
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $selectedLog->customer->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Telefone</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $selectedLog->customer->phone ?? 'N/A' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Problema Detectado --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">⚠️ Problema Detectado</h4>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @php
                                        $severityIcons = [
                                            'low' => '🟢',
                                            'medium' => '🟡',
                                            'high' => '🔴'
                                        ];
                                    @endphp
                                    <span class="text-2xl">{{ $severityIcons[$selectedLog->severity] ?? '⚠️' }}</span>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900 mb-1">
                                        Tipo: 
                                        @php
                                            $typeLabels = [
                                                'unsatisfied_with_suggestions' => 'Insatisfação com Sugestões',
                                                'repetition_detected' => 'Repetição Detectada',
                                                'transfer_to_human' => 'Transferência para Humano',
                                                'no_response_found' => 'Sem Resposta Encontrada'
                                            ];
                                        @endphp
                                        <span class="font-bold">{{ $typeLabels[$selectedLog->issue_type] ?? $selectedLog->issue_type }}</span>
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        Severidade: <span class="font-semibold">{{ ucfirst($selectedLog->severity) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mensagem do Cliente --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">💬 Mensagem do Cliente</h4>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $selectedLog->customer_message }}</p>
                        </div>
                    </div>

                    {{-- Resposta da IA --}}
                    @if($selectedLog->ai_response)
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">🤖 Resposta da IA</h4>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $selectedLog->ai_response }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Contexto Adicional --}}
                    @if($selectedLog->context)
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">📋 Contexto Adicional</h4>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <pre class="text-xs text-gray-700 overflow-x-auto">{{ json_encode($selectedLog->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    @endif

                    {{-- Notas do Admin --}}
                    @if(!$selectedLog->resolved)
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">📝 Notas do Admin</h4>
                            <textarea wire:model="adminNotes" 
                                      rows="4" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Adicione suas observações sobre como este problema foi resolvido..."></textarea>
                        </div>
                    @else
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">✅ Log Resolvido</h4>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-sm text-gray-700 mb-2">
                                    <span class="font-semibold">Resolvido em:</span> {{ $selectedLog->resolved_at->format('d/m/Y H:i') }}
                                </p>
                                @if($selectedLog->admin_notes)
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Notas:</span><br>
                                        {{ $selectedLog->admin_notes }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    <button wire:click="closeModal" 
                            type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Fechar
                    </button>
                    
                    @if(!$selectedLog->resolved)
                        <button wire:click="markResolved" 
                                type="button"
                                class="px-4 py-2 bg-green-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            ✓ Marcar como Resolvido
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endif
