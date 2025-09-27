<div class="fixed top-4 right-4 z-50 space-y-2" 
     x-data="{}" 
     @set-auto-remove.window="setTimeout(() => { $wire.call('removeNotification', $event.detail.id) }, 5000)">
    @foreach($notifications as $notification)
        <div class="bg-white border-l-4 {{ $notification['type'] === 'success' ? 'border-green-500' : 'border-red-500' }} rounded-lg shadow-lg p-4 max-w-sm transform transition-all duration-300"
             x-data="{ show: true }" 
             x-show="show" 
             x-transition>
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    @if($notification['type'] === 'success')
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    @endif
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $notification['message'] }}
                    </p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button wire:click="removeNotification('{{ $notification['id'] }}')" 
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
