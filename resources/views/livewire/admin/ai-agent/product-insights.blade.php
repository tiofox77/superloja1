<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📊 Insights de Produtos</h1>
            <p class="text-gray-600 mt-1">Análise inteligente de performance</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Total Analisados</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">🔥 Hot</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['hot'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">❄️ Cold</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['cold'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">📊 Steady</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['steady'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">📉 Declining</p>
            <p class="text-2xl font-bold text-orange-600">{{ $stats['declining'] }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <input type="text" wire:model.live="searchTerm" 
                       placeholder="Buscar produto..." 
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <select wire:model.live="filterStatus" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Todos os status</option>
                    <option value="hot">🔥 Hot</option>
                    <option value="cold">❄️ Cold</option>
                    <option value="steady">📊 Steady</option>
                    <option value="declining">📉 Declining</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Insights Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receita</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conversão</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($insights as $insight)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($insight->product->featured_image)
                                    <img src="{{ asset('storage/' . $insight->product->featured_image) }}" 
                                         class="w-10 h-10 rounded object-cover mr-3" 
                                         alt="{{ $insight->product->name }}">
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $insight->product->name }}</p>
                                    <p class="text-sm text-gray-500">SKU: {{ $insight->product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusConfig = [
                                    'hot' => ['label' => 'HOT 🔥', 'class' => 'bg-red-100 text-red-700'],
                                    'cold' => ['label' => 'COLD ❄️', 'class' => 'bg-blue-100 text-blue-700'],
                                    'steady' => ['label' => 'STEADY 📊', 'class' => 'bg-green-100 text-green-700'],
                                    'declining' => ['label' => 'DECLINING 📉', 'class' => 'bg-orange-100 text-orange-700'],
                                ];
                                $config = $statusConfig[$insight->performance_status] ?? ['label' => 'N/A', 'class' => 'bg-gray-100 text-gray-700'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $config['class'] }}">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $insight->total_sales }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ number_format($insight->total_revenue, 2) }} Kz</td>
                        <td class="px-6 py-4 text-gray-800">{{ $insight->conversion_rate }}%</td>
                        <td class="px-6 py-4">
                            <button wire:click="viewDetails({{ $insight->id }})" 
                                    class="text-blue-600 hover:text-blue-800">
                                Ver Detalhes
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Nenhum insight disponível. Execute a análise primeiro.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $insights->links() }}
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedInsight)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">{{ $selectedInsight->product->name }}</h2>
                    <button wire:click="closeDetailModal" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>

                <!-- Métricas -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Vendas Totais</p>
                        <p class="text-2xl font-bold">{{ $selectedInsight->total_sales }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Receita Total</p>
                        <p class="text-2xl font-bold">{{ number_format($selectedInsight->total_revenue, 2) }} Kz</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Taxa de Conversão</p>
                        <p class="text-2xl font-bold">{{ $selectedInsight->conversion_rate }}%</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Avaliação Média</p>
                        <p class="text-2xl font-bold">{{ $selectedInsight->avg_rating }} ⭐</p>
                    </div>
                </div>

                <!-- Recomendações -->
                @if($selectedInsight->ai_recommendations)
                    <div class="mb-6">
                        <h3 class="text-lg font-bold mb-3">💡 Recomendações da IA</h3>
                        <div class="space-y-2">
                            @foreach($selectedInsight->ai_recommendations as $rec)
                                <div class="p-3 rounded-lg {{ $rec['type'] === 'warning' ? 'bg-yellow-50 border-l-4 border-yellow-500' : ($rec['type'] === 'success' ? 'bg-green-50 border-l-4 border-green-500' : 'bg-blue-50 border-l-4 border-blue-500') }}">
                                    <div class="flex justify-between">
                                        <p class="font-semibold">{{ $rec['message'] }}</p>
                                        <span class="text-xs px-2 py-1 bg-white rounded">{{ strtoupper($rec['priority']) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Ações -->
                <div class="flex gap-3">
                    <button wire:click="refreshAnalysis({{ $selectedInsight->product_id }})" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        🔄 Atualizar Análise
                    </button>
                    <button wire:click="closeDetailModal" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
