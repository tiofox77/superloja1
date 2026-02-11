@props([
    'src' => null,
    'alt' => '',
    'size' => 'md',
    'initials' => null,
    'status' => null
])

@php
    $sizes = [
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
        'xl' => 'w-16 h-16 text-lg',
        '2xl' => 'w-20 h-20 text-xl',
    ];
    
    $statusColors = [
        'online' => 'bg-green-500',
        'offline' => 'bg-gray-400',
        'busy' => 'bg-red-500',
        'away' => 'bg-yellow-500',
    ];
    
    $statusSizes = [
        'xs' => 'w-1.5 h-1.5',
        'sm' => 'w-2 h-2',
        'md' => 'w-2.5 h-2.5',
        'lg' => 'w-3 h-3',
        'xl' => 'w-3.5 h-3.5',
        '2xl' => 'w-4 h-4',
    ];
    
    $displayInitials = $initials ?? strtoupper(substr($alt, 0, 2));
@endphp

<div class="relative inline-flex">
    @if($src)
        <img src="{{ $src }}" 
             alt="{{ $alt }}"
             {{ $attributes->merge(['class' => "rounded-full object-cover {$sizes[$size]}"]) }}>
    @else
        <div {{ $attributes->merge(['class' => "rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center font-semibold text-white {$sizes[$size]}"]) }}>
            {{ $displayInitials }}
        </div>
    @endif
    
    @if($status)
        <span class="absolute bottom-0 right-0 block rounded-full ring-2 ring-white {{ $statusColors[$status] }} {{ $statusSizes[$size] }}"></span>
    @endif
</div>
