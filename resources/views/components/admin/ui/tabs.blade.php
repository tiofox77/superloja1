@props([
    'active' => null,
    'variant' => 'default'
])

@php
    $variants = [
        'default' => [
            'wrapper' => 'border-b border-gray-200',
            'tab' => 'px-4 py-3 text-sm font-medium border-b-2 -mb-px transition-colors',
            'active' => 'text-primary-600 border-primary-500',
            'inactive' => 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300',
        ],
        'pills' => [
            'wrapper' => 'bg-gray-100 rounded-xl p-1 inline-flex gap-1',
            'tab' => 'px-4 py-2 text-sm font-medium rounded-lg transition-all',
            'active' => 'bg-white text-gray-900 shadow-sm',
            'inactive' => 'text-gray-600 hover:text-gray-900',
        ],
        'boxed' => [
            'wrapper' => 'flex gap-2',
            'tab' => 'px-4 py-2.5 text-sm font-medium rounded-xl border-2 transition-all',
            'active' => 'bg-primary-50 text-primary-700 border-primary-200',
            'inactive' => 'text-gray-600 border-transparent hover:bg-gray-50',
        ],
    ];
    $v = $variants[$variant];
@endphp

<div x-data="{ activeTab: '{{ $active }}' }" {{ $attributes }}>
    <!-- Tab Headers -->
    <div class="{{ $v['wrapper'] }}">
        {{ $tabs }}
    </div>
    
    <!-- Tab Panels -->
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
