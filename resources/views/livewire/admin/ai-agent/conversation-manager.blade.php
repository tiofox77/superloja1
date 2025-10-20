<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">💬 Gerenciar Conversas</h1>
            <p class="text-gray-600 mt-1">Chat com clientes via Instagram e Facebook</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <select wire:model.live="filterPlatform" class="px-4 py-2 border rounded-lg">
                <option value="">Todas as plataformas</option>
                <option value="facebook">Facebook Messenger</option>
                <option value="instagram">Instagram</option>
            </select>
            <select wire:model.live="filterStatus" class="px-4 py-2 border rounded-lg">
                <option value="active">Ativas</option>
                <option value="closed">Fechadas</option>
                <option value="">Todas</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Lista de Conversas -->
        <div class="lg:col-span-1 bg-white rounded-lg shadow max-h-[600px] overflow-y-auto">
            <div class="p-4 border-b bg-gray-50">
                <h2 class="font-bold text-gray-800">Conversas ({{ $conversations->total() }})</h2>
            </div>
            <div class="divide-y">
                @forelse($conversations as $conv)
                    <div wire:click="selectConversation({{ $conv->id }})" 
                         class="p-4 cursor-pointer hover:bg-gray-50 {{ $selectedConversation && $selectedConversation->id === $conv->id ? 'bg-blue-50' : '' }}">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-gray-800">{{ $conv->customer_name ?? $conv->customer_identifier }}</p>
                            <span class="px-2 py-1 rounded text-xs {{ $conv->platform === 'facebook' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ $conv->platform === 'facebook' ? '📘 FB' : '📸 IG' }}
                            </span>
                        </div>
                        @if($conv->latestMessage)
                            <p class="text-sm text-gray-600 truncate">{{ $conv->latestMessage->message }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $conv->last_message_at->diffForHumans() }}</p>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        Nenhuma conversa encontrada
                    </div>
                @endforelse
            </div>
            <div class="p-4 border-t">
                {{ $conversations->links() }}
            </div>
        </div>

        <!-- Chat -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow flex flex-col h-[600px]">
            @if($selectedConversation)
                <!-- Header -->
                <div class="p-4 border-b flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-gray-800">{{ $selectedConversation->customer_name ?? $selectedConversation->customer_identifier }}</h2>
                        <p class="text-sm text-gray-600">{{ ucfirst($selectedConversation->platform) }}</p>
                    </div>
                    <button wire:click="closeConversation" 
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                        Fechar Conversa
                    </button>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                    @foreach($messages as $msg)
                        <div class="flex {{ $msg->direction === 'outgoing' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="px-4 py-2 rounded-lg {{ $msg->direction === 'outgoing' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    {{ $msg->message }}
                                </div>
                                <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                                    <span>{{ $msg->sent_at->format('H:i') }}</span>
                                    @if($msg->sender_type === 'agent')
                                        <span class="px-1 bg-purple-100 text-purple-700 rounded">🤖 Bot</span>
                                    @elseif($msg->sender_type === 'human')
                                        <span class="px-1 bg-green-100 text-green-700 rounded">👤 Humano</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Input -->
                <div class="p-4 border-t">
                    <form wire:submit="sendMessage" class="flex gap-2">
                        <input type="text" 
                               wire:model="newMessage" 
                               placeholder="Digite sua mensagem..." 
                               class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Enviar
                        </button>
                    </form>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <p class="text-4xl mb-4">💬</p>
                        <p>Selecione uma conversa para começar</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
