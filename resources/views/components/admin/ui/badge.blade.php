@props([
    'variant' => 'default',
    'size' => 'md',
    'dot' => false
])

@php
    $variants = [
        'default' => 'bg-gray-100 text-gray-700',
        'primary' => 'bg-primary-100 text-primary-700',
        'secondary' => 'bg-secondary-100 text-secondary-700',
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'danger' => 'bg-red-100 text-red-700',
        'info' => 'bg-blue-100 text-blue-700',
    ];
    
    $dotColors = [
        'default' => 'bg-gray-500',
        'primary' => 'bg-primary-500',
        'secondary' => 'bg-secondary-500',
        'success' => 'bg-green-500',
        'warning' => 'bg-yellow-500',
        'danger' => 'bg-red-500',
        'info' => 'bg-blue-500',
    ];
    
    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 font-medium rounded-full ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors[$variant] }}"></span>
    @endif
    {{ $slot }}
</span>
