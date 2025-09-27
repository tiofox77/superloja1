<div>
    <!-- Toast Container -->
    <div class="fixed top-4 right-4 z-50 space-y-2" id="toast-container">
        @foreach($notifications as $notification)
            <div 
                id="toast-{{ $notification['id'] }}"
                class="transform transition-all duration-300 ease-in-out max-w-xs w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden animate-slide-in-right"
                wire:key="toast-{{ $notification['id'] }}"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            @if($notification['type'] === 'success')
                                <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @elseif($notification['type'] === 'error')
                                <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @elseif($notification['type'] === 'warning')
                                <div class="w-5 h-5 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $notification['message'] }}
                            </p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button 
                                wire:click="removeNotification('{{ $notification['id'] }}')"
                                class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <span class="sr-only">Fechar</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Progress bar -->
                <div class="h-1 bg-gray-200 relative overflow-hidden">
                    <div 
                        class="h-full bg-gradient-to-r transition-all ease-linear
                        @if($notification['type'] === 'success') from-green-500 to-green-600
                        @elseif($notification['type'] === 'error') from-red-500 to-red-600
                        @elseif($notification['type'] === 'warning') from-yellow-500 to-yellow-600
                        @else from-blue-500 to-blue-600
                        @endif"
                        style="width: 100%; animation: countdown {{ $notification['duration'] }}ms linear forwards;"
                    ></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Styles and Scripts -->
    <style>
    @keyframes countdown {
        from { width: 100%; }
        to { width: 0%; }
    }

    .animate-slide-in-right {
        animation: slide-in-right 0.3s ease-out;
    }

    .animate-slide-out-right {
        animation: slide-out-right 0.3s ease-in;
    }

    @keyframes slide-in-right {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slide-out-right {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    </style>

    <script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('auto-remove-toast', (data) => {
            setTimeout(() => {
                const toast = document.getElementById('toast-' + data.id);
                if (toast) {
                    toast.classList.add('animate-slide-out-right');
                    setTimeout(() => {
                        @this.removeNotification(data.id);
                    }, 300);
                }
            }, data.duration);
        });
    });
    </script>
</div>
