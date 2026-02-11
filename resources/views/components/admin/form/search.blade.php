@props([
    'placeholder' => 'Buscar...',
    'autofocus' => false
])

<div class="relative">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
    </div>
    <input type="search" 
           {{ $autofocus ? 'autofocus' : '' }}
           placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => 'block w-full pl-10 pr-4 py-2.5 bg-gray-50 border-0 rounded-xl text-sm placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-primary-500 transition-all']) }}>
    
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center" wire:loading wire:target="{{ $attributes->get('wire:model') ?? $attributes->get('wire:model.live') }}">
        <svg class="animate-spin w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>
