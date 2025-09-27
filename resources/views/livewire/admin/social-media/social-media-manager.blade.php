<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-pink-600 to-purple-600 text-white">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v3M7 4H5a1 1 0 00-1 1v3m0 0v8a2 2 0 002 2h8a2 2 0 002-2V8m0 0V5a1 1 0 00-1-1H9a1 1 0 00-1 1v3"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Redes Sociais</h1>
                    <p class="text-pink-100 mt-1">Gerencie posts automáticos com IA para Facebook e Instagram</p>
                </div>
            </div>
            <button wire:click="openModal" 
                    class="btn-3d bg-gradient-to-r from-orange-500 to-red-600 text-white px-6 py-3 font-semibold flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Novo Post</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Posts</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>

        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Publicados</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['published']) }}</p>
        </div>

        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Agendados</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['scheduled']) }}</p>
        </div>

        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Falharam</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['failed']) }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-3d p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pesquisar</label>
                <input type="text" wire:model.live="search" placeholder="Conteúdo do post..." 
                       class="input-3d w-full px-4 py-2 text-gray-900">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plataforma</label>
                <select wire:model.live="filterPlatform" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="">Todas as plataformas</option>
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                    <option value="both">Ambas</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="filterStatus" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="">Todos os status</option>
                    <option value="draft">Rascunho</option>
                    <option value="scheduled">Agendado</option>
                    <option value="published">Publicado</option>
                    <option value="failed">Falhado</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                <select wire:model.live="sortBy" class="input-3d w-full px-4 py-2 text-gray-900">
                    <option value="created_at">Data de criação</option>
                    <option value="scheduled_at">Data agendada</option>
                    <option value="published_at">Data de publicação</option>
                    <option value="status">Status</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="card-3d overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Post</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plataforma</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agendamento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engagement</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-start space-x-3">
                                    @if($post->images && is_array($post->images) && count($post->images) > 0)
                                        <img src="{{ $post->images[0] }}" alt="Post image" 
                                             class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 line-clamp-2">
                                            {{ Str::limit($post->content, 60) }}
                                        </p>
                                        <div class="flex items-center mt-1 space-x-2">
                                            @if($post->ai_generated)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    IA
                                                </span>
                                            @endif
                                            @if($post->product_ids && count($post->product_ids) > 0)
                                                <span class="text-xs text-gray-500">{{ count($post->product_ids) }} produtos</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-2xl mr-2">{{ $post->platform_icon }}</span>
                                    <span class="text-sm capitalize">{{ $post->platform }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 
                                       ($post->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                                        ($post->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ match($post->status) {
                                        'published' => 'Publicado',
                                        'scheduled' => 'Agendado',
                                        'draft' => 'Rascunho',
                                        'failed' => 'Falhado',
                                        default => ucfirst($post->status)
                                    } }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($post->scheduled_at)
                                    <div class="text-sm text-gray-900">{{ $post->scheduled_at->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $post->scheduled_at->format('H:i') }}</div>
                                @elseif($post->published_at)
                                    <div class="text-sm text-gray-900">{{ $post->published_at->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $post->published_at->format('H:i') }}</div>
                                @else
                                    <span class="text-sm text-gray-400">Não agendado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($post->engagement_stats)
                                    <div class="text-sm text-gray-900">{{ $post->engagement_rate }}% engagement</div>
                                    <div class="text-xs text-gray-500">
                                        {{ ($post->engagement_stats['likes'] ?? 0) }} likes, 
                                        {{ ($post->engagement_stats['comments'] ?? 0) }} comments
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">Sem dados</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($post->status === 'draft' || $post->status === 'scheduled')
                                        <button wire:click="publishNow({{ $post->id }})" 
                                                class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                                title="Publicar agora">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    
                                    <button wire:click="duplicatePost({{ $post->id }})" 
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                            title="Duplicar post">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="openModal({{ $post->id }})" 
                                            class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="deletePost({{ $post->id }})" 
                                            onclick="return confirm('Tem certeza que deseja eliminar este post?')"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v3M7 4H5a1 1 0 00-1 1v3m0 0v8a2 2 0 002 2h8a2 2 0 002-2V8m0 0V5a1 1 0 00-1-1H9a1 1 0 00-1 1v3"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum post encontrado</h3>
                                <p class="mt-1 text-sm text-gray-500">Comece criando um novo post para as redes sociais.</p>
                                <div class="mt-6">
                                    <button wire:click="openModal" class="btn-3d bg-gradient-to-r from-orange-500 to-red-600 text-white px-4 py-2 text-sm">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Novo Post
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200">
            {{ $posts->links() }}
        </div>
    </div>

    <!-- Include Modals -->
    @if($showModal)
        @include('livewire.admin.social-media.modals.social-media-post-modal')
    @endif
</div>
