<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-500">Bem-vindo de volta! Aqui está o resumo da sua loja.</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-admin.ui.stats-card 
            title="Vendas Hoje"
            :value="number_format($salesToday, 2, ',', '.') . ' Kz'"
            icon="banknote"
            color="primary"
            :trend="$salesTrend"
            :trendValue="$salesTrendValue"
            :href="route('admin.orders.index')" />
        
        <x-admin.ui.stats-card 
            title="Pedidos"
            :value="$ordersCount"
            icon="shopping-cart"
            color="info"
            :trend="$ordersTrend"
            :trendValue="$ordersTrendValue"
            :href="route('admin.orders.index')" />
        
        <x-admin.ui.stats-card 
            title="Produtos"
            :value="$productsCount"
            icon="package"
            color="success"
            :href="route('admin.products.index')" />
        
        <x-admin.ui.stats-card 
            title="Clientes"
            :value="$customersCount"
            icon="users"
            color="secondary"
            :href="route('admin.users.index')" />
    </div>
    
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Sales Chart -->
        <div class="lg:col-span-2">
            <x-admin.ui.card title="Vendas dos Últimos 7 Dias" icon="trending-up">
                <div class="h-72" id="sales-chart">
                    <canvas id="salesChartCanvas"></canvas>
                </div>
            </x-admin.ui.card>
        </div>
        
        <!-- Recent Activity -->
        <div>
            <x-admin.ui.card title="Atividade Recente" icon="activity" :padding="false">
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto">
                    @forelse($recentActivities as $activity)
                        <div class="px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                            {{ $activity['type'] === 'order' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                                    <i data-lucide="{{ $activity['icon'] }}" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['title'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <i data-lucide="inbox" class="w-8 h-8 mx-auto text-gray-300 mb-2"></i>
                            <p class="text-sm text-gray-500">Nenhuma atividade recente</p>
                        </div>
                    @endforelse
                </div>
            </x-admin.ui.card>
        </div>
    </div>
    
    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        
        <!-- Pending Orders -->
        <x-admin.ui.card title="Pedidos Pendentes" icon="clock" :padding="false">
            <x-slot:actions>
                <a href="{{ route('admin.orders.index') }}" wire:navigate 
                   class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                    Ver todos
                </a>
            </x-slot:actions>
            
            <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse($pendingOrders as $order)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center">
                                    <i data-lucide="package" class="w-5 h-5 text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">#{{ $order->id }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->customer_name ?? 'Cliente' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900">{{ number_format($order->total, 2, ',', '.') }} Kz</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <x-admin.ui.empty-state 
                        icon="check-circle" 
                        title="Nenhum pedido pendente"
                        description="Todos os pedidos foram processados!" />
                @endforelse
            </div>
        </x-admin.ui.card>
        
        <!-- Low Stock Products -->
        <x-admin.ui.card title="Produtos com Baixo Estoque" icon="alert-triangle" :padding="false">
            <x-slot:actions>
                <a href="{{ route('admin.products.index') }}" wire:navigate 
                   class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                    Ver todos
                </a>
            </x-slot:actions>
            
            <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse($lowStockProducts as $product)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <x-admin.ui.badge variant="danger" size="sm">
                                        {{ $product->stock }} em estoque
                                    </x-admin.ui.badge>
                                </div>
                            </div>
                            <a href="{{ route('admin.products.index') }}?edit={{ $product->id }}" wire:navigate
                               class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <x-admin.ui.empty-state 
                        icon="package-check" 
                        title="Estoque em dia"
                        description="Todos os produtos têm estoque suficiente!" />
                @endforelse
            </div>
        </x-admin.ui.card>
    </div>
    
    <!-- Quick Actions -->
    <div class="mt-6">
        <x-admin.ui.card title="Ações Rápidas" icon="zap">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('admin.products.index') }}?create=1" wire:navigate
                   class="flex flex-col items-center p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center mb-3 group-hover:bg-primary-200 transition-colors">
                        <i data-lucide="package-plus" class="w-6 h-6 text-primary-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-600">Novo Produto</span>
                </a>
                
                <a href="{{ route('admin.pos.index') }}" wire:navigate
                   class="flex flex-col items-center p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-3 group-hover:bg-green-200 transition-colors">
                        <i data-lucide="monitor" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-green-600">Abrir PDV</span>
                </a>
                
                <a href="{{ route('admin.sms.index') }}" wire:navigate
                   class="flex flex-col items-center p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                        <i data-lucide="message-square" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Enviar SMS</span>
                </a>
                
            </div>
        </x-admin.ui.card>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:navigated', () => initChart());
    document.addEventListener('DOMContentLoaded', () => initChart());
    
    function initChart() {
        const canvas = document.getElementById('salesChartCanvas');
        if (!canvas) return;
        
        // Destroy existing chart if exists
        if (window.salesChart) {
            window.salesChart.destroy();
        }
        
        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(255, 140, 0, 0.3)');
        gradient.addColorStop(1, 'rgba(255, 140, 0, 0)');
        
        window.salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Vendas (Kz)',
                    data: @json($chartData),
                    borderColor: '#FF8C00',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#FF8C00',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('pt-AO') + ' Kz';
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
</script>
@endpush
