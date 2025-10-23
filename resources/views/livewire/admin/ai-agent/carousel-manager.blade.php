<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header Section -->
    <div class="card-3d p-6 mb-6 bg-gradient-to-r from-purple-600 to-pink-600 text-white">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">🎨 Carrosséis de Produtos</h1>
                    <p class="text-purple-100 mt-1">Gerencie posts com múltiplos produtos</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <!-- Botão Criar Carrossel -->
                <button wire:click="$set('showCreateModal', true)" 
                        class="btn-3d bg-gradient-to-r from-orange-500 to-red-600 text-white px-6 py-3 font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Criar Carrossel</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Carousels Card -->
        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="w-3 h-3 bg-purple-400 rounded-full animate-pulse"></div>
            </div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Total de Carrosséis</h3>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $carousels->total() }}</p>
            <div class="flex items-center text-xs text-purple-600">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Posts com múltiplas imagens</span>
            </div>
        </div>

        <!-- Available Products Card -->
        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
            </div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Produtos Disponíveis</h3>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ $availableProducts }}</p>
            <div class="flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>Prontos para carrossel</span>
            </div>
        </div>

        <!-- Active Platform Card -->
        <div class="card-3d p-6 group hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        @if($platform === 'facebook')
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        @else
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        @endif
                    </svg>
                </div>
                <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
            </div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Plataforma Ativa</h3>
            <p class="text-3xl font-bold text-gray-900 mb-2">{{ ucfirst($platform) }}</p>
            <div class="flex items-center text-xs text-blue-600">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>Publicações em {{ $platform }}</span>
            </div>
        </div>
    </div>

    <!-- Platform Tabs -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button wire:click="$set('platform', 'facebook')"
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $platform === 'facebook' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </span>
                </button>
                
                <button wire:click="$set('platform', 'instagram')"
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $platform === 'instagram' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        Instagram
                    </span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Carousels List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produtos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agendado Para</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Criado Em</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($carousels as $carousel)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                #{{ $carousel->id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ count($carousel->product_ids ?? []) }} produtos
                                </div>
                                <div class="text-xs text-gray-500">
                                    IDs: {{ implode(', ', array_slice($carousel->product_ids ?? [], 0, 5)) }}{{ count($carousel->product_ids ?? []) > 5 ? '...' : '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($carousel->status === 'scheduled')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        ⏰ Agendado
                                    </span>
                                @elseif($carousel->status === 'posted')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✅ Publicado
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        ❌ Falhou
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $carousel->scheduled_for->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $carousel->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Preview -->
                                    <button wire:click="previewCarousel({{ $carousel->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="previewCarousel({{ $carousel->id }})"
                                            title="Visualizar Conteúdo"
                                            class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition disabled:opacity-50">
                                        <svg wire:loading.remove wire:target="previewCarousel({{ $carousel->id }})" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg wire:loading wire:target="previewCarousel({{ $carousel->id }})" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </button>

                                    @if($carousel->status === 'scheduled')
                                        <!-- Publicar Agora -->
                                        <button wire:click="showPublishConfirmation({{ $carousel->id }})"
                                                title="Publicar Agora"
                                                class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded-lg transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </button>

                                        <!-- Cancelar -->
                                        <button wire:click="deletePost({{ $carousel->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="deletePost({{ $carousel->id }})"
                                                wire:confirm="Tem certeza que deseja cancelar este carrossel?"
                                                title="Cancelar Carrossel"
                                                class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition disabled:opacity-50">
                                            <svg wire:loading.remove wire:target="deletePost({{ $carousel->id }})" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <svg wire:loading wire:target="deletePost({{ $carousel->id }})" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <span class="text-6xl mb-4">🎨</span>
                                    <p class="text-lg font-medium">Nenhum carrossel encontrado</p>
                                    <p class="text-sm mt-2">Crie seu primeiro carrossel de produtos!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($carousels->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $carousels->links() }}
            </div>
        @endif
    </div>

    <!-- Publish Confirmation Modal -->
    @if($showPublishModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-[9999] flex items-center justify-center p-4">
            <div class="relative mx-auto p-0 border w-full max-w-4xl shadow-2xl rounded-lg bg-white my-8">
                <!-- Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b bg-white sticky top-0 z-[100] rounded-t-lg">
                    <h3 class="text-xl font-bold text-gray-900">
                        🚀 Publicar Carrossel Agora
                    </h3>
                    <button wire:click="$set('showPublishModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Facebook Post Preview -->
                <div class="p-6 max-h-[70vh] overflow-y-auto">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm">
                        <!-- Facebook Header -->
                        <div class="flex items-center gap-3 p-4 border-b">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">SuperLoja Angola</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                    Agora
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"/>
                                    </svg>
                                </p>
                            </div>
                        </div>

                        <!-- Facebook Content -->
                        <div class="p-4">
                            <div class="prose max-w-none mb-4">
                                <pre class="whitespace-pre-wrap text-sm text-gray-800 font-sans leading-relaxed">{{ $postToPublish['content'] ?? '' }}</pre>
                            </div>

                            <!-- Product Images Gallery -->
                            @php
                                $productIds = \App\Models\AiAutoPost::find($postToPublish['id'] ?? 0)?->product_ids ?? [];
                                $carouselProducts = \App\Models\Product::whereIn('id', $productIds)->get();
                            @endphp
                            @if($carouselProducts->isNotEmpty())
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 mt-4">
                                    @foreach($carouselProducts as $index => $product)
                                        <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-200 bg-gradient-to-br from-gray-50 to-gray-100">
                                            @if($product->featured_image)
                                                <img src="{{ Storage::url($product->featured_image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
                                                     loading="lazy">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded">
                                                {{ $index + 1 }}/{{ $carouselProducts->count() }}
                                            </div>
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-2">
                                                <p class="text-white text-xs truncate">{{ $product->name }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 mt-2 text-center">
                                    📸 {{ $carouselProducts->count() }} {{ $carouselProducts->count() == 1 ? 'produto' : 'produtos' }} no carrossel
                                </p>
                            @endif
                        </div>

                        <!-- Facebook Footer -->
                        <div class="border-t px-4 py-2">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>👍 Curtir</span>
                                <span>💬 Comentar</span>
                                <span>↗️ Compartilhar</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Alert -->
                    <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Este carrossel será publicado imediatamente</strong> no {{ ucfirst($postToPublish['platform'] ?? 'facebook') }}.
                                    <br>
                                    <span class="text-xs">📦 {{ $postToPublish['products_count'] ?? 0 }} produtos · Agendado original: {{ $postToPublish['scheduled_for'] ?? '' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 px-6 py-4 bg-gray-50 rounded-b-lg">
                    <button wire:click="$set('showPublishModal', false)"
                            class="flex-1 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancelar
                    </button>
                    <button wire:click="confirmPublish"
                            wire:loading.attr="disabled"
                            wire:target="confirmPublish"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50 flex items-center justify-center gap-2">
                        <svg wire:loading.remove wire:target="confirmPublish" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <svg wire:loading wire:target="confirmPublish" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="confirmPublish">Publicar Agora</span>
                        <span wire:loading wire:target="confirmPublish">Publicando...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Preview Modal -->
    @if($showPreviewModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-[9999] flex items-center justify-center p-4">
            <div class="relative mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white my-8 max-h-[90vh] overflow-y-auto">
                <div class="mt-3">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            👁️ Preview do Carrossel
                        </h3>
                        <button wire:click="$set('showPreviewModal', false)" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Info Cards -->
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <p class="text-xs text-blue-600 font-medium">Plataforma</p>
                            <p class="text-sm font-bold text-blue-900">{{ ucfirst($selectedCarousel['platform'] ?? '') }}</p>
                        </div>
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                            <p class="text-xs text-purple-600 font-medium">Produtos</p>
                            <p class="text-sm font-bold text-purple-900">{{ $selectedCarousel['products_count'] ?? 0 }}</p>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                            <p class="text-xs text-green-600 font-medium">Status</p>
                            <p class="text-sm font-bold text-green-900">{{ $selectedCarousel['status'] ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Content Preview -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                        <p class="text-xs text-gray-500 mb-2 font-medium">📝 Conteúdo do Post:</p>
                        <div class="bg-white p-4 rounded border border-gray-300 max-h-96 overflow-y-auto">
                            <pre class="whitespace-pre-wrap text-sm text-gray-800 font-sans">{{ $selectedCarousel['content'] ?? '' }}</pre>
                        </div>
                    </div>

                    <!-- Product Images -->
                    @php
                        $previewProductIds = \App\Models\AiAutoPost::find($selectedCarousel['id'] ?? 0)?->product_ids ?? [];
                        $previewProducts = \App\Models\Product::whereIn('id', $previewProductIds)->get();
                    @endphp
                    @if($previewProducts->isNotEmpty())
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                            <p class="text-xs text-gray-500 mb-2 font-medium">📸 Imagens dos Produtos:</p>
                            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                                @foreach($previewProducts as $index => $product)
                                    <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-300 bg-gradient-to-br from-gray-50 to-gray-100">
                                        @if($product->featured_image)
                                            <img src="{{ Storage::url($product->featured_image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover"
                                                 loading="lazy">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="absolute bottom-1 right-1 bg-black bg-opacity-70 text-white text-xs px-1.5 py-0.5 rounded">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Total: {{ $previewProducts->count() }} {{ $previewProducts->count() == 1 ? 'produto' : 'produtos' }}
                            </p>
                        </div>
                    @endif

                    <!-- Scheduled Info -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-yellow-700 font-medium">Agendado para:</p>
                                <p class="text-sm font-bold text-yellow-900">{{ $selectedCarousel['scheduled_for'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button wire:click="$set('showPreviewModal', false)"
                                class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Create Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 modal-overlay overflow-y-auto h-full w-full z-[9999] flex items-center justify-center p-4" wire:click="$set('showCreateModal', false)">
            <div class="relative w-full max-w-2xl mx-auto modal-3d animate-fade-in-scale" @click.stop>
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50 rounded-t-3xl">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-purple-900">
                                Criar Novo Carrossel
                            </h3>
                            <p class="text-sm text-purple-600">
                                Configure seu carrossel de produtos
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('showCreateModal', false)" class="p-2 rounded-xl hover:bg-white/50 text-gray-500 hover:text-gray-700 transition-all duration-200 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-8">
                    <form wire:submit.prevent="createCarousel">
                        <div class="space-y-6">
                            <!-- Platform Selection -->
                            <div class="card-3d p-6">
                                <div class="flex items-center mb-5">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">Plataforma</h4>
                                </div>
                                
                                <div class="relative">
                                    <select wire:model="platform" class="input-3d w-full px-4 py-3 pr-10 appearance-none">
                                        <option value="facebook">🔵 Facebook</option>
                                        <option value="instagram">🟣 Instagram</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Count -->
                            <div class="card-3d p-6">
                                <div class="flex items-center mb-5">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">Quantidade de Produtos</h4>
                                </div>
                                
                                <div>
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                        </svg>
                                        Entre 3 e 10 produtos
                                    </label>
                                    <input type="number" 
                                           wire:model="productsCount" 
                                           min="3" 
                                           max="10"
                                           class="input-3d w-full px-4 py-3"
                                           placeholder="Ex: 5">
                                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                        <p class="text-sm text-green-700 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <strong>{{ $availableProducts }}</strong>&nbsp;produtos disponíveis com imagem
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex gap-4">
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    class="flex-1 btn-3d bg-gradient-to-r from-purple-500 to-pink-600 text-white px-6 py-3 font-semibold flex items-center justify-center space-x-2 hover:shadow-lg transition-all duration-200 disabled:opacity-50">
                                <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <svg wire:loading class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove>Criar Carrossel</span>
                                <span wire:loading>Criando...</span>
                            </button>
                            <button type="button"
                                    wire:click="$set('showCreateModal', false)"
                                    class="btn-3d bg-gray-100 text-gray-700 px-6 py-3 font-semibold hover:bg-gray-200 transition-all duration-200">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
