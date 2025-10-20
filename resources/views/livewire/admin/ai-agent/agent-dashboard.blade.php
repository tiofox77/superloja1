<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🤖 AI Agent Dashboard</h1>
            <p class="text-gray-600 mt-1">Sistema Inteligente de Gestão e Automação</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="runAnalysis" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                🔄 Executar Análise
            </button>
            <button wire:click="toggleAgent" 
                    class="px-4 py-2 rounded-lg {{ $config->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white">
                {{ $config->is_active ? '⏸️ Desativar' : '▶️ Ativar' }} Agent
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Agent Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Status do Agent</p>
                    <p class="text-2xl font-bold mt-1">
                        {{ $config->is_active ? '✅ Ativo' : '⏸️ Inativo' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-2xl">🤖</span>
                </div>
            </div>
        </div>

        <!-- Conversas -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Conversas Ativas</p>
                    <p class="text-2xl font-bold mt-1">{{ $stats['active_conversations'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Total: {{ $stats['total_conversations'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-2xl">💬</span>
                </div>
            </div>
        </div>

        <!-- Insights -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Insights Gerados</p>
                    <p class="text-2xl font-bold mt-1">{{ $stats['insights_generated'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <span class="text-2xl">📊</span>
                </div>
            </div>
        </div>

        <!-- Posts Publicados -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Posts Publicados</p>
                    <p class="text-2xl font-bold mt-1">{{ $stats['posts_published'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <span class="text-2xl">📱</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">🔥 Produtos em Alta</h2>
            </div>
            <div class="p-6">
                @if($topProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($topProducts as $insight)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $insight->product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $insight->total_sales }} vendas | {{ number_format($insight->total_revenue, 2) }} Kz</p>
                                </div>
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                    HOT 🔥
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Nenhum dado disponível. Execute a análise primeiro.</p>
                @endif
            </div>
        </div>

        <!-- Cold Products -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">❄️ Produtos que Precisam Atenção</h2>
            </div>
            <div class="p-6">
                @if($coldProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($coldProducts as $insight)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $insight->product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $insight->total_sales }} vendas | {{ number_format($insight->total_revenue, 2) }} Kz</p>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                    COLD ❄️
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Nenhum dado disponível.</p>
                @endif
            </div>
        </div>

        <!-- Recent Conversations -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">💬 Conversas Recentes</h2>
                <a href="{{ route('admin.ai-agent.conversations') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                    Ver todas →
                </a>
            </div>
            <div class="p-6">
                @if($recentConversations->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentConversations->take(5) as $conv)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $conv->customer_name ?? $conv->customer_identifier }}</p>
                                    <p class="text-sm text-gray-600 truncate">
                                        {{ $conv->latestMessage->message ?? 'Sem mensagens' }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-{{ $conv->platform === 'facebook' ? 'blue' : 'pink' }}-100 text-{{ $conv->platform === 'facebook' ? 'blue' : 'pink' }}-700 rounded text-xs">
                                    {{ ucfirst($conv->platform) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Nenhuma conversa ainda.</p>
                @endif
            </div>
        </div>

        <!-- Scheduled Posts -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">📅 Posts Agendados</h2>
                <a href="{{ route('admin.ai-agent.posts') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                    Ver todos →
                </a>
            </div>
            <div class="p-6">
                @if($scheduledPosts->count() > 0)
                    <div class="space-y-3">
                        @foreach($scheduledPosts as $post)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $post->product->name ?? 'Post genérico' }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $post->scheduled_for->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                    {{ ucfirst($post->platform) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Nenhum post agendado.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.ai-agent.insights') }}" 
           class="p-6 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow text-white hover:shadow-lg transition">
            <div class="text-center">
                <span class="text-4xl">📊</span>
                <p class="mt-2 font-semibold">Insights de Produtos</p>
            </div>
        </a>
        
        <a href="{{ route('admin.ai-agent.conversations') }}" 
           class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow text-white hover:shadow-lg transition">
            <div class="text-center">
                <span class="text-4xl">💬</span>
                <p class="mt-2 font-semibold">Gerenciar Conversas</p>
            </div>
        </a>
        
        <a href="{{ route('admin.ai-agent.posts') }}" 
           class="p-6 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow text-white hover:shadow-lg transition">
            <div class="text-center">
                <span class="text-4xl">📱</span>
                <p class="mt-2 font-semibold">Agendar Posts</p>
            </div>
        </a>
        
        <a href="{{ route('admin.ai-agent.settings') }}" 
           class="p-6 bg-gradient-to-r from-gray-500 to-gray-600 rounded-lg shadow text-white hover:shadow-lg transition">
            <div class="text-center">
                <span class="text-4xl">⚙️</span>
                <p class="mt-2 font-semibold">Configurações</p>
            </div>
        </a>
    </div>
</div>
