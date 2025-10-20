<div class="relative">
    @auth
    <div x-data="{ open: @entangle('showDropdown') }">
    <!-- Notification Bell -->
    <button 
        wire:click="toggleDropdown" 
        @click="open = !open"
        class="relative p-3 text-gray-600 hover:text-blue-500 hover:bg-blue-50 rounded-2xl transition-all duration-300 group"
    >
        <div class="relative">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            
            @if($unreadCount > 0)
                <!-- Bell ring animation -->
                <div class="absolute top-0 right-0 w-2 h-2 bg-blue-400 rounded-full animate-ping opacity-75"></div>
            @endif
        </div>
        
        <!-- Notification Badge -->
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold shadow-md ring-2 ring-white">
                <span class="relative z-10">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
            </span>
        @endif
        
        <!-- Tooltip -->
        <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg">
            <span class="font-medium">Notificações</span>
            <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
        </div>
    </button>
    
    <!-- Dropdown -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.away="open = false"
        class="absolute right-0 mt-2 w-80 sm:w-96 max-w-[90vw] bg-white rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 z-50 border border-gray-100"
        style="display: none;"
    >
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                    <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    Notificações
                </h3>
                @if($unreadCount > 0)
                    <button 
                        wire:click="markAllAsRead"
                        class="text-xs text-blue-600 hover:text-blue-800 font-medium px-2 py-1 rounded-md hover:bg-blue-100 transition-colors duration-200"
                    >
                        Marcar todas como lidas
                    </button>
                @endif
            </div>
        </div>
        
        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @if($notifications && $notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div 
                        class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ $notification->isUnread() ? 'bg-blue-50' : '' }}"
                        wire:click="markAsRead({{ $notification->id }})"
                    >
                        <div class="flex items-start space-x-3">
                            <!-- Icon based on notification type -->
                            <div class="flex-shrink-0 mt-1">
                                @switch($notification->type)
                                    @case('order_status')
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                        @break
                                    @case('auction_status')
                                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                        @break
                                    @case('product_request')
                                    @case('product_request_status')
                                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        @break
                                    @default
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                @endswitch
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $notification->title }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if($notification->isUnread())
                                        <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1"></div>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                    {{ Str::limit($notification->message, 100) }}
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $notification->getTypeLabel() }}
                                    </span>
                                    @if($notification->isUnread())
                                        <span class="text-xs text-blue-600 font-medium">Nova</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="px-4 py-12 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 mb-1">Nenhuma notificação</h4>
                    <p class="text-xs text-gray-500">Você está em dia! Não há notificações pendentes.</p>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        @if($notifications && $notifications->count() > 0)
            <div class="px-4 py-3 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50 rounded-b-2xl">
                <div class="flex items-center justify-between">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                        <span>Ver todas as notificações</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <span class="text-xs text-gray-500">{{ $notifications->count() }} de {{ $notifications->count() }}</span>
                </div>
            </div>
        @endif
    </div>
    </div>
    @else
    <!-- Placeholder vazio para usuários não autenticados -->
    <div></div>
    @endauth
</div>
