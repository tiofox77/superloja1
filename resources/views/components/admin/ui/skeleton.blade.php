@props([
    'type' => 'line',
    'count' => 1,
    'height' => null
])

@php
    $types = [
        'line' => 'h-4 rounded',
        'title' => 'h-6 w-3/4 rounded',
        'text' => 'h-4 rounded',
        'avatar' => 'h-10 w-10 rounded-full',
        'thumbnail' => 'h-20 w-20 rounded-lg',
        'card' => 'h-32 rounded-xl',
        'button' => 'h-10 w-24 rounded-lg',
    ];
    
    $baseClass = $types[$type] ?? $types['line'];
    $heightClass = $height ? "h-{$height}" : '';
@endphp

@for($i = 0; $i < $count; $i++)
    <div {{ $attributes->merge(['class' => "animate-pulse bg-gray-200 {$baseClass} {$heightClass}"]) }}></div>
@endfor
