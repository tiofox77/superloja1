@props([
    'align' => 'right',
    'width' => '48',
    'trigger' => null
])

@php
    $alignmentClasses = [
        'left' => 'left-0',
        'right' => 'right-0',
        'center' => 'left-1/2 -translate-x-1/2',
    ];
    
    $widthClasses = [
        '48' => 'w-48',
        '56' => 'w-56',
        '64' => 'w-64',
        '72' => 'w-72',
        'auto' => 'w-auto',
    ];
@endphp

<div x-data="{ open: false }" @click.away="open = false" class="relative inline-block text-left">
    <!-- Trigger -->
    <div @click="open = !open">
        @if($trigger)
            {{ $trigger }}
        @else
            <button type="button" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition-colors">
                <i data-lucide="more-vertical" class="w-5 h-5"></i>
            </button>
        @endif
    </div>
    
    <!-- Dropdown Content -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-2 {{ $alignmentClasses[$align] }} {{ $widthClasses[$width] }} rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
         @click="open = false">
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
