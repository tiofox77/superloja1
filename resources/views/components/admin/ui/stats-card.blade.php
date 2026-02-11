@props([
    'title' => '',
    'value' => '0',
    'icon' => 'activity',
    'trend' => null,
    'trendValue' => null,
    'color' => 'primary',
    'href' => null
])

@php
    $colors = [
        'primary' => [
            'bg' => 'bg-primary-50',
            'icon' => 'text-primary-500',
            'gradient' => 'from-primary-500 to-primary-600'
        ],
        'secondary' => [
            'bg' => 'bg-secondary-50',
            'icon' => 'text-secondary-500',
            'gradient' => 'from-secondary-500 to-secondary-600'
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'icon' => 'text-green-500',
            'gradient' => 'from-green-500 to-green-600'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'icon' => 'text-yellow-500',
            'gradient' => 'from-yellow-500 to-yellow-600'
        ],
        'danger' => [
            'bg' => 'bg-red-50',
            'icon' => 'text-red-500',
            'gradient' => 'from-red-500 to-red-600'
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'icon' => 'text-blue-500',
            'gradient' => 'from-blue-500 to-blue-600'
        ],
    ];
    $c = $colors[$color] ?? $colors['primary'];
@endphp

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 card-hover">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $value }}</p>
            
            @if($trend !== null && $trendValue !== null)
                <div class="mt-2 flex items-center gap-1.5">
                    @if($trend === 'up')
                        <span class="flex items-center text-sm font-medium text-green-600">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                            {{ $trendValue }}
                        </span>
                    @elseif($trend === 'down')
                        <span class="flex items-center text-sm font-medium text-red-600">
                            <i data-lucide="trending-down" class="w-4 h-4 mr-1"></i>
                            {{ $trendValue }}
                        </span>
                    @else
                        <span class="flex items-center text-sm font-medium text-gray-500">
                            <i data-lucide="minus" class="w-4 h-4 mr-1"></i>
                            {{ $trendValue }}
                        </span>
                    @endif
                    <span class="text-sm text-gray-400">vs mês anterior</span>
                </div>
            @endif
        </div>
        
        <div class="w-14 h-14 rounded-2xl {{ $c['bg'] }} flex items-center justify-center">
            <i data-lucide="{{ $icon }}" class="w-7 h-7 {{ $c['icon'] }}"></i>
        </div>
    </div>
    
    @if($href)
        <a href="{{ $href }}" wire:navigate class="mt-4 flex items-center text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors">
            Ver detalhes
            <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
        </a>
    @endif
</div>
