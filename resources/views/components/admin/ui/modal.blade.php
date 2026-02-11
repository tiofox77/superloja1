@props([
    'name' => 'modal',
    'title' => null,
    'subtitle' => null,
    'maxWidth' => 'lg',
    'closeable' => true
])

@php
    $maxWidthClasses = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        'full' => 'sm:max-w-full sm:mx-4',
    ];
@endphp

<div x-data="{ show: false }"
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
     x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     x-cloak
     class="fixed inset-0 z-[9998] overflow-y-auto">
    
    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="{{ $closeable ? 'show = false' : '' }}"
         class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm">
    </div>
    
    <!-- Modal -->
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full {{ $maxWidthClasses[$maxWidth] }} bg-white rounded-2xl shadow-2xl overflow-hidden">
                
                <!-- Header -->
                @if($title)
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                            @if($subtitle)
                                <p class="text-sm text-gray-500 mt-0.5">{{ $subtitle }}</p>
                            @endif
                        </div>
                        @if($closeable)
                            <button @click="show = false" 
                                    class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        @endif
                    </div>
                @endif
                
                <!-- Content -->
                <div class="p-6">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                @if(isset($footer))
                    <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
