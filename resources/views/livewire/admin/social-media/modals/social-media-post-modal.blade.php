<!-- Social Media Post Modal -->
<div class="fixed inset-0 modal-overlay overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
    <div class="relative w-full max-w-5xl mx-auto modal-3d animate-fade-in-scale" wire:click.stop>
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r {{ $editMode ? 'from-blue-50 to-indigo-50' : 'from-orange-50 to-red-50' }} rounded-t-3xl">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $editMode ? 'from-blue-500 to-indigo-600' : 'from-orange-500 to-red-600' }} flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($editMode)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v3M7 4H5a1 1 0 00-1 1v3m0 0v8a2 2 0 002 2h8a2 2 0 002-2V8m0 0V5a1 1 0 00-1-1H9a1 1 0 00-1 1v3"></path>
                        @endif
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold {{ $editMode ? 'text-blue-900' : 'text-orange-900' }}">
                        {{ $editMode ? 'Editar Post' : 'Novo Post' }}
                    </h3>
                    <p class="text-sm {{ $editMode ? 'text-blue-600' : 'text-orange-600' }}">
                        {{ $editMode ? 'Atualize o conteúdo do post' : 'Crie um novo post para redes sociais' }}
                    </p>
                </div>
            </div>
            <button wire:click="closeModal" class="p-2 rounded-xl hover:bg-white/50 text-gray-500 hover:text-gray-700 transition-all duration-200 group">
                <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form wire:submit.prevent="savePost" class="p-6">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- Left Column - Content -->
                <div class="xl:col-span-2 space-y-6">
                    <!-- Platform Selection -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Plataforma & Conteúdo</h4>
                        </div>

                        <!-- Platform -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Plataforma *</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="platform" value="facebook" class="sr-only">
                                    <div class="p-4 border-2 rounded-xl transition-all duration-200 {{ $platform === 'facebook' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                        <div class="text-center">
                                            <div class="w-8 h-8 mx-auto bg-blue-600 rounded-lg flex items-center justify-center mb-2">
                                                <span class="text-white text-sm font-bold">f</span>
                                            </div>
                                            <span class="text-sm font-medium">Facebook</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="platform" value="instagram" class="sr-only">
                                    <div class="p-4 border-2 rounded-xl transition-all duration-200 {{ $platform === 'instagram' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-gray-300' }}">
                                        <div class="text-center">
                                            <div class="w-8 h-8 mx-auto bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center mb-2">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12.017 0C8.396 0 7.989.016 6.756.072 5.526.128 4.718.336 4.012.628c-.72.304-1.335.742-1.942 1.349-.607.607-1.045 1.222-1.349 1.942-.292.706-.5 1.514-.556 2.744C.016 7.989 0 8.396 0 12.017c0 3.621.016 4.028.072 5.261.056 1.23.264 2.038.556 2.744.304.72.742 1.335 1.349 1.942.607.607 1.222 1.045 1.942 1.349.706.292 1.514.5 2.744.556 1.233.056 1.64.072 5.261.072 3.621 0 4.028-.016 5.261-.072 1.23-.056 2.038-.264 2.744-.556.72-.304 1.335-.742 1.942-1.349.607-.607 1.045-1.222 1.349-1.942.292-.706.5-1.514.556-2.744.056-1.233.072-1.64.072-5.261 0-3.621-.016-4.028-.072-5.261-.056-1.23-.264-2.038-.556-2.744-.304-.72-.742-1.335-1.349-1.942C17.337 1.368 16.722.93 16.002.628c-.706-.292-1.514-.5-2.744-.556C12.028.016 11.621 0 8.017 0h4zm-.152 2.197c.63-.003 1.218-.006 2.131-.006 3.562 0 3.988.013 5.39.066 1.3.059 2.006.274 2.477.456.622.243 1.066.535 1.532 1.001.466.466.758.91 1.001 1.532.182.471.397 1.177.456 2.477.053 1.402.066 1.828.066 5.39 0 3.562-.013 3.988-.066 5.39-.059 1.3-.274 2.006-.456 2.477-.243.622-.535 1.066-1.001 1.532-.466.466-.91.758-1.532 1.001-.471.182-1.177.397-2.477.456-1.402.053-1.828.066-5.39.066-3.562 0-3.988-.013-5.39-.066-1.3-.059-2.006-.274-2.477-.456-.622-.243-1.066-.535-1.532-1.001-.466-.466-.758-.91-1.001-1.532-.182-.471-.397-1.177-.456-2.477-.053-1.402-.066-1.828-.066-5.39 0-3.562.013-3.988.066-5.39.059-1.3.274-2.006.456-2.477.243-.622.535-1.066 1.001-1.532.466-.466.91-.758 1.532-1.001.471-.182 1.177-.397 2.477-.456 1.226-.056 1.702-.067 4.238-.07v.001zm5.478 2.874a1.094 1.094 0 1 0 0 2.187 1.094 1.094 0 0 0 0-2.187zM12.017 7.87a4.147 4.147 0 1 0 0 8.294 4.147 4.147 0 0 0 0-8.294zm0 2.05a2.097 2.097 0 1 1 0 4.193 2.097 2.097 0 0 1 0-4.193z"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium">Instagram</span>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="platform" value="both" class="sr-only">
                                    <div class="p-4 border-2 rounded-xl transition-all duration-200 {{ $platform === 'both' ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-gray-300' }}">
                                        <div class="text-center">
                                            <div class="w-8 h-8 mx-auto bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mb-2">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium">Ambas</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-sm font-semibold text-gray-700 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Conteúdo do Post *
                                </label>
                                <div class="flex items-center space-x-2">
                                    <button type="button" wire:click="generateAIContent" 
                                            class="btn-3d bg-gradient-to-r from-purple-500 to-pink-600 text-white px-3 py-1 text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Gerar com IA
                                    </button>
                                    <span class="text-xs text-gray-500">{{ strlen($content) }}/2200</span>
                                </div>
                            </div>
                            <textarea wire:model="content" rows="8"
                                      class="input-3d w-full px-4 py-3 text-gray-900 placeholder-gray-500"
                                      placeholder="Escreva o conteúdo do seu post..."></textarea>
                            @error('content') <span class="text-red-500 text-sm mt-2 flex items-center">{{ $message }}</span> @enderror
                        </div>

                        <!-- AI Settings Toggle -->
                        @if($use_ai_content)
                            <div class="mb-6 p-4 bg-purple-50 rounded-xl border border-purple-200">
                                <h5 class="font-semibold text-purple-900 mb-3">Configurações da IA</h5>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-purple-700 mb-1">Tom</label>
                                        <select wire:model="ai_tone" class="input-3d w-full px-3 py-2 text-sm">
                                            <option value="friendly">Amigável</option>
                                            <option value="professional">Profissional</option>
                                            <option value="casual">Casual</option>
                                            <option value="enthusiastic">Entusiasmado</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-purple-700 mb-1">Estilo</label>
                                        <select wire:model="ai_style" class="input-3d w-full px-3 py-2 text-sm">
                                            <option value="promotional">Promocional</option>
                                            <option value="informative">Informativo</option>
                                            <option value="storytelling">Narrativo</option>
                                            <option value="minimalist">Minimalista</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-purple-700 mb-1">Idioma</label>
                                        <select wire:model="ai_language" class="input-3d w-full px-3 py-2 text-sm">
                                            <option value="portuguese">Português</option>
                                            <option value="english">Inglês</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Produtos Relacionados</label>
                            <div class="max-h-32 overflow-y-auto border border-gray-200 rounded-lg p-3">
                                @foreach($products->take(10) as $product)
                                    <label class="flex items-center space-x-2 py-1 cursor-pointer">
                                        <input type="checkbox" wire:model="product_ids" value="{{ $product->id }}" 
                                               class="w-4 h-4 text-purple-600 rounded">
                                        <span class="text-sm text-gray-700">{{ $product->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Settings -->
                <div class="space-y-6">
                    <!-- Scheduling -->
                    <div class="card-3d p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900">Agendamento</h4>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select wire:model="status" class="input-3d w-full px-4 py-3 text-gray-900">
                                <option value="draft">Rascunho</option>
                                <option value="scheduled">Agendado</option>
                                <option value="published">Publicado</option>
                            </select>
                        </div>

                        <!-- Scheduled Date -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Data/Hora de Publicação</label>
                            <input type="datetime-local" wire:model="scheduled_at" 
                                   class="input-3d w-full px-4 py-3 text-gray-900">
                        </div>

                        <!-- Options -->
                        <div class="space-y-3">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" wire:model="auto_hashtags" 
                                       class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-700">Hashtags automáticas</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" wire:model="use_ai_content" 
                                       class="w-4 h-4 text-purple-600 rounded">
                                <span class="text-sm text-gray-700">Usar IA para conteúdo</span>
                            </label>
                        </div>
                    </div>

                    <!-- Statistics (Edit Mode Only) -->
                    @if($editMode && $selectedPost)
                        <div class="card-3d p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Estatísticas</h4>
                            </div>
                            @if($selectedPost->engagement_stats)
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Curtidas:</span>
                                        <span class="font-semibold">{{ $selectedPost->engagement_stats['likes'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Comentários:</span>
                                        <span class="font-semibold">{{ $selectedPost->engagement_stats['comments'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Partilhas:</span>
                                        <span class="font-semibold">{{ $selectedPost->engagement_stats['shares'] ?? 0 }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Alcance:</span>
                                        <span class="font-semibold">{{ $selectedPost->engagement_stats['reach'] ?? 0 }}</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Dados não disponíveis</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 mt-8">
                <button type="button" wire:click="closeModal" 
                        class="px-6 py-3 border border-gray-300 rounded-2xl text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                    Cancelar
                </button>
                
                <button type="submit" 
                        class="btn-3d px-8 py-3 text-white font-semibold rounded-2xl {{ $editMode ? 'bg-gradient-to-r from-blue-500 to-indigo-600' : 'bg-gradient-to-r from-orange-500 to-red-600' }}">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($editMode)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        @endif
                    </svg>
                    {{ $editMode ? 'Atualizar Post' : 'Criar Post' }}
                </button>
            </div>
        </form>
    </div>
</div>
