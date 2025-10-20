<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📱 Agendador de Posts</h1>
            <p class="text-gray-600 mt-1">Publicações automáticas no Facebook e Instagram</p>
        </div>
        <button wire:click="openModal" 
                class="px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:shadow-lg">
            ➕ Novo Post
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('message') }}</div>
    @endif

    <!-- Posts List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plataforma</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agendado Para</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Erro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($posts as $post)
                    <tr>
                        <td class="px-6 py-4">
                            @if($post->product)
                                <div class="flex items-center">
                                    @if($post->product->featured_image)
                                        <img src="{{ asset('storage/' . $post->product->featured_image) }}" 
                                             class="w-10 h-10 rounded object-cover mr-3">
                                    @endif
                                    <span class="font-semibold">{{ $post->product->name }}</span>
                                </div>
                            @else
                                <span class="text-gray-500">Post genérico</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs {{ $post->platform === 'facebook' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ $post->platform === 'facebook' ? '📘 Facebook' : '📸 Instagram' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($post->scheduled_for)
                                <div class="text-gray-800 font-medium">
                                    {{ $post->scheduled_for->format('d/m/Y H:i') }}
                                </div>
                                @if($post->status === 'scheduled' && $post->scheduled_for->isFuture())
                                    <div x-data="{
                                        scheduledTime: new Date('{{ $post->scheduled_for->toIso8601String() }}'),
                                        timeLeft: '',
                                        updateCountdown() {
                                            const now = new Date();
                                            const diff = this.scheduledTime - now;
                                            
                                            if (diff <= 0) {
                                                this.timeLeft = 'Publicando...';
                                                return;
                                            }
                                            
                                            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                                            
                                            if (days > 0) {
                                                this.timeLeft = `${days}d ${hours}h ${minutes}m`;
                                            } else if (hours > 0) {
                                                this.timeLeft = `${hours}h ${minutes}m`;
                                            } else if (minutes > 0) {
                                                this.timeLeft = `${minutes}m ${seconds}s`;
                                            } else {
                                                this.timeLeft = `${seconds}s`;
                                            }
                                        }
                                    }"
                                    x-init="updateCountdown(); setInterval(() => updateCountdown(), 1000)">
                                        <div class="text-xs text-green-600 font-semibold mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            <span x-text="timeLeft"></span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusConfig = [
                                    'scheduled' => ['label' => '⏰ Agendado', 'class' => 'bg-yellow-100 text-yellow-700'],
                                    'posted' => ['label' => '✅ Publicado', 'class' => 'bg-green-100 text-green-700'],
                                    'failed' => ['label' => '❌ Falhou', 'class' => 'bg-red-100 text-red-700'],
                                ];
                                $config = $statusConfig[$post->status] ?? ['label' => 'N/A', 'class' => 'bg-gray-100'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $config['class'] }}">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($post->status === 'failed' && $post->error_message)
                                <div class="max-w-xs">
                                    <p class="text-xs text-red-600 truncate" title="{{ $post->error_message }}">
                                        {{ $post->error_message }}
                                    </p>
                                    <button wire:click="showErrorDetails({{ $post->id }})" 
                                            class="text-xs text-blue-600 hover:underline mt-1">
                                        Ver detalhes
                                    </button>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2 flex-wrap">
                                <!-- Botão Preview (para todos) -->
                                <button wire:click="showPreview({{ $post->id }})" 
                                        class="px-3 py-1.5 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 flex items-center gap-1 transition-colors">
                                    👁️ Preview
                                </button>

                                <!-- Botão Publicar (só para agendados) -->
                                @if($post->status === 'scheduled')
                                    <button wire:click="publishNow({{ $post->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="publishNow({{ $post->id }})"
                                            class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 flex items-center gap-1 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span wire:loading.remove wire:target="publishNow({{ $post->id }})" class="flex items-center gap-1">
                                            🚀 Publicar
                                        </span>
                                        <span wire:loading wire:target="publishNow({{ $post->id }})" class="flex items-center gap-1">
                                            <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Publicando...
                                        </span>
                                    </button>
                                @endif

                                <!-- Botão Ver Post (só para publicados) -->
                                @if($post->status === 'posted' && $post->post_url)
                                    <a href="{{ $post->post_url }}" 
                                       target="_blank"
                                       class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 flex items-center gap-1 transition-colors">
                                        🔗 Ver Post
                                    </a>
                                @endif

                                <!-- Botão Excluir -->
                                <button wire:click="confirmDelete({{ $post->id }})" 
                                        class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 flex items-center gap-1 transition-colors">
                                    🗑️ Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Nenhum post agendado
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Agendar Novo Post</h2>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>

                <form wire:submit="schedulePost" class="space-y-4">
                    <!-- Plataforma -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Plataforma</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" wire:model="platform" value="facebook" class="mr-2">
                                📘 Facebook
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model="platform" value="instagram" class="mr-2">
                                📸 Instagram
                            </label>
                        </div>
                        @error('platform') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Produto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Produto</label>
                        <select wire:model.live="selectedProductId" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Selecione um produto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedProductId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Preview Gerado pela IA -->
                    @if($generatedPreview)
                        <div class="p-4 bg-gradient-to-br from-purple-50 to-blue-50 border border-purple-200 rounded-lg" wire:loading.remove wire:target="selectedProductId">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 7H7v6h6V7z"/>
                                    <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd"/>
                                </svg>
                                <h3 class="font-semibold text-purple-900">✨ Preview Gerado pela IA</h3>
                                <div class="ml-auto">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">
                                        🤖 Automático
                                    </span>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Imagem do Produto com Logo -->
                                <div class="relative bg-white rounded-lg overflow-hidden shadow-md">
                                    @if(!empty($generatedPreview['media_urls']))
                                        <div class="relative">
                                            <img src="{{ $generatedPreview['media_urls'][0] }}" 
                                                 alt="{{ $generatedPreview['product']->name }}"
                                                 class="w-full h-64 object-cover">
                                            
                                            <!-- Logo Sobreposto -->
                                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-lg">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                        <span class="text-white font-bold text-sm">SL</span>
                                                    </div>
                                                    <span class="font-bold text-gray-900 text-sm">SuperLoja</span>
                                                </div>
                                            </div>

                                            <!-- Info do Produto -->
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                                <h4 class="text-white font-bold text-lg">{{ $generatedPreview['product']->name }}</h4>
                                                @if($generatedPreview['product']->is_on_sale)
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-gray-300 line-through text-sm">
                                                            {{ number_format((float)$generatedPreview['product']->price, 2, ',', '.') }} Kz
                                                        </span>
                                                        <span class="text-green-400 font-bold">
                                                            {{ number_format((float)$generatedPreview['product']->sale_price, 2, ',', '.') }} Kz
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Conteúdo Gerado -->
                                <div class="bg-white rounded-lg p-4 shadow-md">
                                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                        </svg>
                                        Conteúdo do Post
                                    </h4>
                                    <div class="text-sm text-gray-700 whitespace-pre-wrap max-h-48 overflow-y-auto p-2 bg-gray-50 rounded border">{{ $generatedPreview['content'] }}</div>
                                    
                                    @if(!empty($generatedPreview['hashtags']))
                                        <div class="mt-3 pt-3 border-t">
                                            <p class="text-xs text-gray-600 mb-1">Hashtags:</p>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($generatedPreview['hashtags'] as $hashtag)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">#{{ $hashtag }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <p class="text-xs text-purple-700 mt-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Este é o conteúdo que será publicado. Você pode personalizar abaixo se desejar.
                            </p>
                        </div>

                        <!-- Loading State -->
                        <div wire:loading wire:target="selectedProductId" class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-center gap-3">
                                <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-600">🤖 IA gerando preview...</span>
                            </div>
                        </div>
                    @endif

                    <!-- Data/Hora com Info -->
                    <div x-data="{ 
                        currentTime: new Date(),
                        scheduledTime: null,
                        updateTime() {
                            this.currentTime = new Date();
                            this.scheduledTime = $wire.scheduledFor ? new Date($wire.scheduledFor) : null;
                        },
                        getTimeDiff() {
                            if (!this.scheduledTime) return null;
                            const diff = this.scheduledTime - this.currentTime;
                            if (diff < 0) return 'Horário já passou!';
                            
                            const hours = Math.floor(diff / (1000 * 60 * 60));
                            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                            
                            if (hours > 0) return `${hours}h ${minutes}m`;
                            if (minutes > 0) return `${minutes}m ${seconds}s`;
                            return `${seconds}s`;
                        },
                        formatTime(date) {
                            return date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                        }
                    }" 
                    x-init="setInterval(() => updateTime(), 1000); updateTime();">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Agendar Para</label>
                        
                        <!-- Hora Atual e Info -->
                        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-blue-700 font-medium">🕐 Hora Atual:</span>
                                    <span class="text-blue-900 font-mono ml-1" x-text="formatTime(currentTime)"></span>
                                </div>
                                <div x-show="scheduledTime">
                                    <span class="text-green-700 font-medium">⏰ Tempo até publicar:</span>
                                    <span class="text-green-900 font-mono ml-1 font-bold" x-text="getTimeDiff()"></span>
                                </div>
                            </div>
                        </div>

                        <input type="datetime-local" 
                               wire:model="scheduledFor" 
                               @change="updateTime()"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        @error('scheduledFor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Conteúdo Customizado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Conteúdo Personalizado (opcional)
                        </label>
                        <textarea wire:model="customContent" 
                                  rows="4" 
                                  placeholder="Se deixar vazio, o AI gerará automaticamente..."
                                  class="w-full px-4 py-2 border rounded-lg"></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            💡 O AI adicionará hashtags e emojis automaticamente
                        </p>
                    </div>

                    <!-- Botões -->
                    <div class="flex gap-3">
                        <button type="submit" 
                                class="px-6 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:shadow-lg">
                            📅 Agendar Post
                        </button>
                        <button type="button" 
                                wire:click="closeModal" 
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal de Detalhes do Erro -->
    @if($showErrorModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg max-w-2xl w-full p-6 max-h-screen overflow-y-auto">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Detalhes do Erro</h3>
                            <p class="text-sm text-gray-600">Informações sobre a falha na publicação</p>
                        </div>
                    </div>
                    <button wire:click="closeErrorModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                @if($selectedError)
                    <div class="space-y-4">
                        <!-- Informações do Post -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Informações do Post</h4>
                            <dl class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <dt class="text-gray-600">Produto:</dt>
                                    <dd class="font-medium">{{ $selectedError['product_name'] }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-600">Plataforma:</dt>
                                    <dd class="font-medium">{{ ucfirst($selectedError['platform']) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-600">Status:</dt>
                                    <dd class="font-medium text-red-600">Falhou</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-600">Agendado para:</dt>
                                    <dd class="font-medium">{{ $selectedError['scheduled_for'] }}</dd>
                                </div>
                            </dl>

                            <!-- Conteúdo do Post -->
                            @if($selectedError['content'])
                                <div class="mt-3 pt-3 border-t">
                                    <dt class="text-gray-600 text-xs mb-1">Conteúdo:</dt>
                                    <dd class="text-xs bg-white p-2 rounded border max-h-24 overflow-y-auto">
                                        {{ Str::limit($selectedError['content'], 200) }}
                                    </dd>
                                </div>
                            @endif

                            <!-- URLs das Imagens -->
                            @if(!empty($selectedError['media_urls']))
                                <div class="mt-3 pt-3 border-t">
                                    <dt class="text-gray-600 text-xs mb-2">Imagens do Post:</dt>
                                    @foreach($selectedError['media_urls'] as $url)
                                        <div class="flex items-center gap-2 mb-2">
                                            <a href="{{ $url }}" 
                                               target="_blank" 
                                               class="text-xs text-blue-600 hover:underline truncate flex-1">
                                                {{ $url }}
                                            </a>
                                            <button onclick="navigator.clipboard.writeText('{{ $url }}')" 
                                                    class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-xs">
                                                📋 Copiar
                                            </button>
                                            <a href="{{ $url }}" 
                                               target="_blank"
                                               class="px-2 py-1 bg-blue-500 text-white hover:bg-blue-600 rounded text-xs">
                                                🔗 Testar
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Mensagem de Erro -->
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                            <h4 class="font-semibold text-red-900 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Mensagem de Erro
                            </h4>
                            <p class="text-sm text-red-800 font-mono bg-red-100 p-3 rounded">
                                {{ $selectedError['error'] }}
                            </p>
                        </div>

                        <!-- Possíveis Causas -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">💡 Possíveis Causas</h4>
                            <ul class="list-disc list-inside text-sm text-blue-800 space-y-1">
                                <li>Token de acesso do Facebook/Instagram expirado ou inválido</li>
                                <li>Permissões insuficientes na página/conta</li>
                                <li>URL da imagem inacessível (verificar se storage está público)</li>
                                <li>Limite de API atingido (rate limit)</li>
                                <li>Conteúdo violando políticas do Facebook/Instagram</li>
                            </ul>
                        </div>

                        <!-- Status das Configurações -->
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="font-semibold text-yellow-900 mb-3">🔍 Verificações do Sistema</h4>
                            <div class="space-y-2 text-sm">
                                @php
                                    $fbToken = \App\Models\AiIntegrationToken::getByPlatform('facebook');
                                    $igToken = \App\Models\AiIntegrationToken::getByPlatform('instagram');
                                    $storageLinked = is_link(public_path('storage'));
                                @endphp
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        @if($fbToken && !$fbToken->isExpired())
                                            <span class="text-green-600 mr-2">✅</span>
                                            <span class="text-green-800">Token do Facebook configurado e válido</span>
                                        @elseif($fbToken && $fbToken->isExpired())
                                            <span class="text-orange-600 mr-2">⚠️</span>
                                            <span class="text-orange-800 font-semibold">Token do Facebook EXPIRADO</span>
                                        @else
                                            <span class="text-red-600 mr-2">❌</span>
                                            <span class="text-red-800 font-semibold">Token do Facebook NÃO configurado</span>
                                        @endif
                                    </div>
                                    @if($fbToken)
                                        <span class="text-xs text-gray-500">Page ID: {{ $fbToken->page_id ?? 'N/A' }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        @if($igToken && !$igToken->isExpired())
                                            <span class="text-green-600 mr-2">✅</span>
                                            <span class="text-green-800">Token do Instagram configurado e válido</span>
                                        @elseif($igToken && $igToken->isExpired())
                                            <span class="text-orange-600 mr-2">⚠️</span>
                                            <span class="text-orange-800 font-semibold">Token do Instagram EXPIRADO</span>
                                        @else
                                            <span class="text-red-600 mr-2">❌</span>
                                            <span class="text-red-800 font-semibold">Token do Instagram NÃO configurado</span>
                                        @endif
                                    </div>
                                    @if($igToken)
                                        <span class="text-xs text-gray-500">Page ID: {{ $igToken->page_id ?? 'N/A' }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center">
                                    @if($storageLinked)
                                        <span class="text-green-600 mr-2">✅</span>
                                        <span class="text-green-800">Storage linkado (imagens acessíveis)</span>
                                    @else
                                        <span class="text-red-600 mr-2">❌</span>
                                        <span class="text-red-800 font-semibold">Storage NÃO linkado (execute: php artisan storage:link)</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Ações Recomendadas -->
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-semibold text-green-900 mb-2">🔧 O Que Fazer Agora</h4>
                            <ol class="list-decimal list-inside text-sm text-green-800 space-y-2">
                                @if((!$fbToken || $fbToken->isExpired()) && $selectedError['platform'] === 'facebook')
                                    <li class="font-bold text-red-700">
                                        🔴 URGENTE: Vá em <strong>Configurações → Tab "Integrações" → Facebook</strong>
                                        <br><span class="ml-6">→ Insira o <strong>Access Token</strong> + <strong>Page ID</strong></span>
                                        <br><span class="ml-6">→ Clique em "💾 Salvar Token"</span>
                                        <br><span class="ml-6">→ Clique em "🧪 Testar Conexão"</span>
                                    </li>
                                @endif
                                @if((!$igToken || $igToken->isExpired()) && $selectedError['platform'] === 'instagram')
                                    <li class="font-bold text-red-700">
                                        🔴 URGENTE: Vá em <strong>Configurações → Tab "Integrações" → Instagram</strong>
                                        <br><span class="ml-6">→ Insira o <strong>Access Token</strong> + <strong>Business Account ID</strong></span>
                                        <br><span class="ml-6">→ Clique em "💾 Salvar Token"</span>
                                        <br><span class="ml-6">→ Clique em "🧪 Testar Conexão"</span>
                                    </li>
                                @endif
                                @if(!$storageLinked)
                                    <li class="font-bold text-red-700">
                                        🔴 URGENTE: Execute no terminal: 
                                        <code class="bg-white px-2 py-1 rounded">php artisan storage:link</code>
                                    </li>
                                @endif
                                @if($fbToken && !$fbToken->isExpired() && $storageLinked)
                                    <li>✅ Configurações parecem corretas! Clique em "🔄 Tentar Novamente" abaixo</li>
                                    <li>Verifique se a URL da imagem acima está acessível (clique em "🔗 Testar")</li>
                                @endif
                            </ol>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button wire:click="retryPost({{ $selectedError['id'] }})" 
                                wire:loading.attr="disabled"
                                wire:target="retryPost"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-opacity">
                            <span wire:loading.remove wire:target="retryPost">🔄 Tentar Novamente</span>
                            <span wire:loading wire:target="retryPost" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Tentando publicar...
                            </span>
                        </button>
                        <button wire:click="closeErrorModal" 
                                wire:loading.attr="disabled"
                                wire:target="retryPost"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50">
                            Fechar
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Modal de Confirmação de Exclusão -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Confirmar Exclusão</h3>
                        <p class="text-sm text-gray-600">Esta ação não pode ser desfeita</p>
                    </div>
                </div>

                <p class="text-gray-700 mb-6">
                    Tem certeza que deseja excluir este post? Todas as informações relacionadas serão removidas permanentemente.
                </p>

                <div class="flex gap-3 justify-end">
                    <button wire:click="cancelDelete" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="deletePost" 
                            wire:loading.attr="disabled"
                            wire:target="deletePost"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50">
                        <span wire:loading.remove wire:target="deletePost">🗑️ Sim, Excluir</span>
                        <span wire:loading wire:target="deletePost">⏳ Excluindo...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Preview do Post -->
    @if($showPreviewModal && $previewPost)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Preview do Post</h3>
                        <p class="text-sm text-gray-600">
                            Como ficará no {{ ucfirst($previewPost['platform']) }} • 
                            Agendado para: {{ $previewPost['scheduled_for'] }}
                        </p>
                    </div>
                    <button wire:click="closePreview" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Facebook Mockup -->
                <div class="p-6 bg-gray-50">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Post Header (Facebook style) -->
                        <div class="p-4 flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                SL
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">SuperLoja</h4>
                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $previewPost['scheduled_for'] }}
                                    @if($previewPost['status'] === 'scheduled')
                                        <span class="text-blue-600">• Agendado</span>
                                    @elseif($previewPost['status'] === 'posted')
                                        <span class="text-green-600">• Publicado</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="px-4 pb-3">
                            <div class="text-gray-900 whitespace-pre-wrap text-sm leading-relaxed">{{ $previewPost['content'] }}</div>
                        </div>

                        <!-- Post Image -->
                        @if(!empty($previewPost['media_urls']))
                            <div class="bg-gray-900">
                                <img src="{{ $previewPost['media_urls'][0] }}" 
                                     alt="Post Image" 
                                     class="w-full h-auto object-contain max-h-96"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\'%3E%3Crect fill=\'%23ddd\' width=\'400\' height=\'300\'/%3E%3Ctext fill=\'%23999\' x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'18\'%3EImagem não disponível%3C/text%3E%3C/svg%3E'">
                            </div>
                        @endif

                        <!-- Facebook Reactions Bar -->
                        <div class="px-4 py-3 border-t border-gray-200">
                            <div class="flex items-center justify-between text-gray-500 text-sm">
                                <div class="flex items-center gap-1">
                                    <span class="flex -space-x-1">
                                        <span class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs">👍</span>
                                        <span class="w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">❤️</span>
                                    </span>
                                    <span class="ml-1">0</span>
                                </div>
                                <div class="flex gap-4">
                                    <span>0 comentários</span>
                                    <span>0 compartilhamentos</span>
                                </div>
                            </div>
                        </div>

                        <!-- Facebook Action Buttons -->
                        <div class="px-4 py-2 border-t border-gray-200 flex items-center justify-around">
                            <button class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors flex-1 justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                </svg>
                                <span class="font-medium text-sm">Gosto</span>
                            </button>
                            <button class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors flex-1 justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span class="font-medium text-sm">Comentar</span>
                            </button>
                            <button class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors flex-1 justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                <span class="font-medium text-sm">Compartilhar</span>
                            </button>
                        </div>
                    </div>

                    <!-- Info adicional -->
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h5 class="font-semibold text-blue-900 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Informações do Agendamento
                        </h5>
                        <dl class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <dt class="text-blue-700 font-medium">Produto:</dt>
                                <dd class="text-blue-900">{{ $previewPost['product_name'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-blue-700 font-medium">Plataforma:</dt>
                                <dd class="text-blue-900">{{ ucfirst($previewPost['platform']) }}</dd>
                            </div>
                            <div>
                                <dt class="text-blue-700 font-medium">Status:</dt>
                                <dd class="text-blue-900">
                                    @if($previewPost['status'] === 'scheduled')
                                        ⏰ Agendado
                                    @elseif($previewPost['status'] === 'posted')
                                        ✅ Publicado
                                    @elseif($previewPost['status'] === 'failed')
                                        ❌ Falhou
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-blue-700 font-medium">Data de Publicação:</dt>
                                <dd class="text-blue-900">{{ $previewPost['scheduled_for'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Footer -->
                <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-end gap-3">
                    @if($previewPost['status'] === 'scheduled')
                        <button wire:click="publishNow({{ $previewPost['id'] }}); closePreview();" 
                                wire:loading.attr="disabled"
                                wire:target="publishNow"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="publishNow">🚀 Publicar Agora</span>
                            <span wire:loading wire:target="publishNow">⏳ Publicando...</span>
                        </button>
                    @endif
                    <button wire:click="closePreview" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
