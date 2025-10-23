{{-- Filtros --}}
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Busca --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Buscar</label>
            <input type="text" wire:model.live="search" placeholder="Cliente, mensagem, ID..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        {{-- Tipo de Problema --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">📋 Tipo de Problema</label>
            <select wire:model.live="filterIssueType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todos</option>
                <option value="unsatisfied_with_suggestions">Insatisfação</option>
                <option value="repetition_detected">Repetição</option>
                <option value="transfer_to_human">Transferência</option>
                <option value="no_response_found">Sem Resposta</option>
            </select>
        </div>

        {{-- Severidade --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">⚠️ Severidade</label>
            <select wire:model.live="filterSeverity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Todas</option>
                <option value="low">Baixa</option>
                <option value="medium">Média</option>
                <option value="high">Alta</option>
            </select>
        </div>
    </div>

    <div class="mt-4 flex items-center space-x-2">
        <label class="block text-sm font-medium text-gray-700">Status:</label>
        <button wire:click="$set('filterResolved', '')" 
            class="px-3 py-1 rounded-lg transition {{ $filterResolved === '' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Todos
        </button>
        <button wire:click="$set('filterResolved', 'unresolved')" 
            class="px-3 py-1 rounded-lg transition {{ $filterResolved === 'unresolved' ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Não Resolvidos
        </button>
        <button wire:click="$set('filterResolved', 'resolved')" 
            class="px-3 py-1 rounded-lg transition {{ $filterResolved === 'resolved' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Resolvidos
        </button>
    </div>
</div>
