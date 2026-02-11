@props([
    'name' => 'confirm',
    'title' => 'Confirmar Ação',
    'message' => 'Tem certeza que deseja continuar?',
    'confirmText' => 'Confirmar',
    'cancelText' => 'Cancelar',
    'type' => 'danger',
    'icon' => null
])

@php
    $types = [
        'danger' => [
            'iconBg' => 'bg-red-100',
            'iconColor' => 'text-red-600',
            'buttonClass' => 'bg-red-500 hover:bg-red-600 focus:ring-red-500',
            'defaultIcon' => 'alert-triangle',
        ],
        'warning' => [
            'iconBg' => 'bg-yellow-100',
            'iconColor' => 'text-yellow-600',
            'buttonClass' => 'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-500',
            'defaultIcon' => 'alert-circle',
        ],
        'info' => [
            'iconBg' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'buttonClass' => 'bg-blue-500 hover:bg-blue-600 focus:ring-blue-500',
            'defaultIcon' => 'info',
        ],
        'success' => [
            'iconBg' => 'bg-green-100',
            'iconColor' => 'text-green-600',
            'buttonClass' => 'bg-green-500 hover:bg-green-600 focus:ring-green-500',
            'defaultIcon' => 'check-circle',
        ],
    ];
    $t = $types[$type];
    $iconName = $icon ?? $t['defaultIcon'];
@endphp

<div x-data="{ 
        show: false, 
        callback: null,
        open(cb) { 
            this.callback = cb; 
            this.show = true; 
        },
        confirm() {
            if (this.callback) this.callback();
            this.show = false;
        }
     }"
     x-on:open-confirm.window="if ($event.detail.name === '{{ $name }}') open($event.detail.callback)"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     x-cloak
     class="fixed inset-0 z-[9999] overflow-y-auto">
    
    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm">
    </div>
    
    <!-- Modal -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <div class="p-6 text-center">
                <!-- Icon -->
                <div class="mx-auto w-14 h-14 rounded-full {{ $t['iconBg'] }} flex items-center justify-center mb-4">
                    <i data-lucide="{{ $iconName }}" class="w-7 h-7 {{ $t['iconColor'] }}"></i>
                </div>
                
                <!-- Title -->
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                
                <!-- Message -->
                <p class="text-sm text-gray-500 mb-6">{{ $message }}</p>
                
                <!-- Actions -->
                <div class="flex gap-3 justify-center">
                    <button @click="show = false" 
                            class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        {{ $cancelText }}
                    </button>
                    <button @click="confirm()" 
                            class="px-4 py-2.5 text-sm font-medium text-white {{ $t['buttonClass'] }} rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">
                        {{ $confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
