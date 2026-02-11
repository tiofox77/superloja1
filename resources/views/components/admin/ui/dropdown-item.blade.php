@props([
    'href' => null,
    'icon' => null,
    'danger' => false,
    'disabled' => false
])

@php
    $classes = 'flex items-center gap-3 w-full px-4 py-2.5 text-sm transition-colors ' . 
               ($danger 
                   ? 'text-red-600 hover:bg-red-50' 
                   : 'text-gray-700 hover:bg-gray-50') .
               ($disabled ? ' opacity-50 cursor-not-allowed' : '');
@endphp

@if($href)
    <a href="{{ $href }}" wire:navigate {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $danger ? 'text-red-500' : 'text-gray-400' }}"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="button" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $danger ? 'text-red-500' : 'text-gray-400' }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif
