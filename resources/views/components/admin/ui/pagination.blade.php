@props([
    'paginator' => null
])

@if($paginator && $paginator->hasPages())
<nav class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700">
                Mostrando
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                a
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                de
                <span class="font-medium">{{ $paginator->total() }}</span>
                resultados
            </p>
        </div>
        <div>
            <span class="isolate inline-flex rounded-lg shadow-sm">
                {{-- Previous --}}
                @if($paginator->onFirstPage())
                    <span class="relative inline-flex items-center rounded-l-lg px-3 py-2 text-gray-300 bg-white border border-gray-300 cursor-not-allowed">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </span>
                @else
                    <button wire:click="previousPage" class="relative inline-flex items-center rounded-l-lg px-3 py-2 text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                @endif

                {{-- Pages --}}
                @foreach($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-primary-500 border border-primary-500">
                            {{ $page }}
                        </span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($paginator->hasMorePages())
                    <button wire:click="nextPage" class="relative inline-flex items-center rounded-r-lg px-3 py-2 text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                @else
                    <span class="relative inline-flex items-center rounded-r-lg px-3 py-2 text-gray-300 bg-white border border-gray-300 cursor-not-allowed">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </span>
                @endif
            </span>
        </div>
    </div>
    
    {{-- Mobile --}}
    <div class="flex flex-1 justify-between sm:hidden">
        @if($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                Anterior
            </span>
        @else
            <button wire:click="previousPage" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Anterior
            </button>
        @endif

        @if($paginator->hasMorePages())
            <button wire:click="nextPage" class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Próximo
            </button>
        @else
            <span class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                Próximo
            </span>
        @endif
    </div>
</nav>
@endif
