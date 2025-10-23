{{-- Tabela de Logs --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cliente
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tipo de Problema
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Severidade
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Mensagem
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Data
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        {{-- Cliente --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($log->customer_name, 0, 2)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $log->customer_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $log->customer_identifier }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Tipo de Problema --}}
                        <td class="px-6 py-4">
                            @php
                                $typeLabels = [
                                    'unsatisfied_with_suggestions' => 'Insatisfação',
                                    'repetition_detected' => 'Repetição',
                                    'transfer_to_human' => 'Transferência',
                                    'no_response_found' => 'Sem Resposta'
                                ];
                                $typeColors = [
                                    'unsatisfied_with_suggestions' => 'bg-red-100 text-red-800',
                                    'repetition_detected' => 'bg-yellow-100 text-yellow-800',
                                    'transfer_to_human' => 'bg-blue-100 text-blue-800',
                                    'no_response_found' => 'bg-gray-100 text-gray-800'
                                ];
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeColors[$log->issue_type] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $typeLabels[$log->issue_type] ?? $log->issue_type }}
                            </span>
                        </td>

                        {{-- Severidade --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $severityColors = [
                                    'low' => 'text-green-600',
                                    'medium' => 'text-yellow-600',
                                    'high' => 'text-red-600'
                                ];
                                $severityIcons = [
                                    'low' => '●',
                                    'medium' => '●●',
                                    'high' => '●●●'
                                ];
                            @endphp
                            <span class="text-sm font-medium {{ $severityColors[$log->severity] ?? 'text-gray-600' }}">
                                {{ $severityIcons[$log->severity] ?? '●' }} {{ ucfirst($log->severity) }}
                            </span>
                        </td>

                        {{-- Mensagem do Cliente --}}
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                {{ $log->customer_message }}
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($log->resolved)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ✓ Resolvido
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                    Pendente
                                </span>
                            @endif
                        </td>

                        {{-- Data --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>

                        {{-- Ações --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="viewDetails({{ $log->id }})" 
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                👁️ Ver Detalhes
                            </button>
                            
                            <button wire:click="deleteLog({{ $log->id }})" 
                                    wire:confirm="Tem certeza que deseja excluir este log?"
                                    class="text-red-600 hover:text-red-900">
                                🗑️ Excluir
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg font-medium">Nenhum log encontrado</p>
                                <p class="text-gray-400 text-sm mt-1">Ajuste os filtros ou aguarde novos logs</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    @if($logs->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $logs->links() }}
        </div>
    @endif
</div>
