@props([
    'name' => 'drawer',
    'title' => null,
    'subtitle' => null,
    'position' => 'right',
    'maxWidth' => 'md'
])

@php
    $positions = [
        'right' => [
            'container' => 'right-0',
            'enter' => 'translate-x-full',
            'leave' => 'translate-x-0',
        ],
        'left' => [
            'container' => 'left-0',
            'enter' => '-translate-x-full',
            'leave' => 'translate-x-0',
        ],
    ];
    
    $widths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        'full' => 'max-w-full',
    ];
    
    $p = $positions[$position];
@endphp

<div x-data="{ show: false }"
     x-on:open-drawer.window="if (($event.detail?.name || $event.detail) === '{{ $name }}') show = true"
     x-on:close-drawer.window="if (($event.detail?.name || $event.detail) === '{{ $name }}') show = false"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     x-cloak
     class="fixed inset-0 z-[9998] overflow-hidden">
    
    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false"
         class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm">
    </div>
    
    <!-- Drawer Panel -->
    <div class="fixed inset-y-0 {{ $p['container'] }} flex max-w-full">
        <div x-show="show"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="{{ $p['enter'] }}"
             x-transition:enter-end="{{ $p['leave'] }}"
             x-transition:leave="transform transition ease-in-out duration-200"
             x-transition:leave-start="{{ $p['leave'] }}"
             x-transition:leave-end="{{ $p['enter'] }}"
             class="w-screen {{ $widths[$maxWidth] }}">
            
            <div class="flex h-full flex-col bg-white shadow-2xl">
                <!-- Header -->
                @if($title)
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
                            @if($subtitle)
                                <p class="text-sm text-gray-500 mt-0.5">{{ $subtitle }}</p>
                            @endif
                        </div>
                        <button @click="show = false" 
                                class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                @endif
                
                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                @if(isset($footer))
                    <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
