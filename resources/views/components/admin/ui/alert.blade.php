@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'icon' => null
])

@php
    $types = [
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'text' => 'text-blue-800',
            'icon' => 'info',
            'iconColor' => 'text-blue-500',
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'text' => 'text-green-800',
            'icon' => 'check-circle',
            'iconColor' => 'text-green-500',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200',
            'text' => 'text-yellow-800',
            'icon' => 'alert-triangle',
            'iconColor' => 'text-yellow-500',
        ],
        'danger' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-800',
            'icon' => 'alert-circle',
            'iconColor' => 'text-red-500',
        ],
    ];
    $t = $types[$type];
    $iconName = $icon ?? $t['icon'];
@endphp

<div x-data="{ show: true }" 
     x-show="show"
     x-transition
     {{ $attributes->merge(['class' => "rounded-xl border p-4 {$t['bg']} {$t['border']}"]) }}>
    <div class="flex gap-3">
        <div class="flex-shrink-0">
            <i data-lucide="{{ $iconName }}" class="w-5 h-5 {{ $t['iconColor'] }}"></i>
        </div>
        <div class="flex-1">
            @if($title)
                <h3 class="text-sm font-semibold {{ $t['text'] }}">{{ $title }}</h3>
            @endif
            <div class="text-sm {{ $t['text'] }} {{ $title ? 'mt-1' : '' }}">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <button @click="show = false" class="flex-shrink-0 {{ $t['text'] }} opacity-50 hover:opacity-100 transition-opacity">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        @endif
    </div>
</div>
