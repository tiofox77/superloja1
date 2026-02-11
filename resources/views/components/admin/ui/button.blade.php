@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconRight' => null,
    'loading' => false,
    'disabled' => false,
    'href' => null
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-primary-500 hover:bg-primary-600 text-white focus:ring-primary-500 shadow-sm',
        'secondary' => 'bg-secondary-500 hover:bg-secondary-600 text-white focus:ring-secondary-500 shadow-sm',
        'outline' => 'border-2 border-gray-300 hover:border-gray-400 text-gray-700 hover:bg-gray-50 focus:ring-gray-500',
        'ghost' => 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:ring-gray-500',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white focus:ring-red-500 shadow-sm',
        'success' => 'bg-green-500 hover:bg-green-600 text-white focus:ring-green-500 shadow-sm',
    ];
    
    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3 text-base',
        'xl' => 'px-6 py-3.5 text-base',
    ];
    
    $iconSizes = [
        'xs' => 'w-3.5 h-3.5',
        'sm' => 'w-4 h-4',
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
        'xl' => 'w-5 h-5',
    ];
    
    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if($href)
    <a href="{{ $href }}" wire:navigate {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i data-lucide="{{ $icon }}" class="{{ $iconSizes[$size] }}"></i>
        @endif
        {{ $slot }}
        @if($iconRight)
            <i data-lucide="{{ $iconRight }}" class="{{ $iconSizes[$size] }}"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}" 
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="animate-spin {{ $iconSizes[$size] }}" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            <i data-lucide="{{ $icon }}" class="{{ $iconSizes[$size] }}"></i>
        @endif
        {{ $slot }}
        @if($iconRight && !$loading)
            <i data-lucide="{{ $iconRight }}" class="{{ $iconSizes[$size] }}"></i>
        @endif
    </button>
@endif
