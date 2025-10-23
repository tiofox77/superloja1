<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">🔍 Logs de Diagnóstico da IA</h2>
        <p class="text-gray-600">Monitore problemas e melhore a IA analisando casos reais</p>
    </div>

    {{-- Estatísticas --}}
    @include('livewire.admin.ai-agent.diagnostic-logs-stats')

    {{-- Filtros --}}
    @include('livewire.admin.ai-agent.diagnostic-logs-filters')

    {{-- Tabela --}}
    @include('livewire.admin.ai-agent.diagnostic-logs-table')

    {{-- Modal --}}
    @include('livewire.admin.ai-agent.diagnostic-logs-modal')
</div>
