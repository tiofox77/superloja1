<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - SuperLoja Admin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- jQuery (needed for toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        .glass-morphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        /* Custom Modern Checkbox Styles */
        .checkbox-modern {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            cursor: pointer;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.05),
                inset 0 1px 2px rgba(255, 255, 255, 0.8);
        }

        .checkbox-modern:hover {
            border-color: #6366f1;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            transform: translateY(-1px);
            box-shadow: 
                0 4px 8px rgba(99, 102, 241, 0.15),
                inset 0 1px 2px rgba(255, 255, 255, 0.9);
        }

        .checkbox-modern:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 
                0 0 0 3px rgba(99, 102, 241, 0.1),
                0 4px 8px rgba(99, 102, 241, 0.15);
        }

        .checkbox-modern:checked {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-color: #4f46e5;
            animation: checkboxPulse 0.3s ease-out;
        }

        .checkbox-modern:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 6px;
            width: 6px;
            height: 10px;
            border: 2px solid white;
            border-top: 0;
            border-left: 0;
            transform: rotate(45deg);
            animation: checkmarkAppear 0.3s ease-out 0.1s both;
        }

        .checkbox-modern:indeterminate {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-color: #d97706;
        }

        .checkbox-modern:indeterminate::after {
            content: '';
            position: absolute;
            top: 8px;
            left: 4px;
            width: 10px;
            height: 2px;
            background: white;
            border-radius: 1px;
            animation: checkmarkAppear 0.3s ease-out both;
        }

        /* Animations */
        @keyframes checkboxPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes checkmarkAppear {
            0% { 
                opacity: 0; 
                transform: rotate(45deg) scale(0.5);
            }
            100% { 
                opacity: 1; 
                transform: rotate(45deg) scale(1);
            }
        }

        /* Color variants */
        .checkbox-success:checked {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #059669;
        }

        .checkbox-success:hover {
            border-color: #10b981;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        }

        .checkbox-danger:checked {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-color: #dc2626;
        }

        .checkbox-danger:hover {
            border-color: #ef4444;
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
        }

        /* Custom CSS variables support */
        .checkbox-modern[style*="--checkbox-color"]:checked {
            background: var(--checkbox-color, linear-gradient(135deg, #6366f1 0%, #4f46e5 100%));
            border-color: var(--checkbox-border, #4f46e5);
        }

        /* Enhanced focus states */
        .checkbox-modern:focus-visible {
            outline: none;
            border-color: #6366f1;
            box-shadow: 
                0 0 0 3px rgba(99, 102, 241, 0.2),
                0 4px 12px rgba(99, 102, 241, 0.25);
        }

        /* Improved transitions for better feel */
        .checkbox-modern {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .checkbox-modern:active {
            transform: translateY(0px) scale(0.95);
        }
        
        .card-3d:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 
                25px 25px 80px #d1d5db,
                -25px -25px 80px #ffffff,
                0 10px 30px rgba(0,0,0,0.1);
        }
        
        .sidebar-3d {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 
                inset 0 1px 0 rgba(255,255,255,0.1),
                0 20px 40px rgba(0,0,0,0.1);
        }
        
        .nav-item-3d {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        
        .nav-item-3d:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(10px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .nav-item-active {
            background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
            border-left: 4px solid #fbbf24;
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.3);
        }
        
        .header-3d {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            box-shadow: 
                0 4px 20px rgba(0,0,0,0.1),
                inset 0 1px 0 rgba(255,255,255,0.8);
        }
        
        .btn-3d {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 
                0 4px 15px rgba(59, 130, 246, 0.4),
                inset 0 1px 0 rgba(255,255,255,0.2);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .btn-3d:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 8px 25px rgba(59, 130, 246, 0.5),
                inset 0 1px 0 rgba(255,255,255,0.3);
        }
        
        .btn-3d:active {
            transform: translateY(0px);
            box-shadow: 
                0 2px 8px rgba(59, 130, 246, 0.3),
                inset 0 1px 3px rgba(0,0,0,0.2);
        }
        
        /* Modal 3D Effects */
        .modal-3d {
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            box-shadow: 
                0 25px 50px rgba(0,0,0,0.15),
                0 0 0 1px rgba(255,255,255,0.05),
                inset 0 1px 0 rgba(255,255,255,0.8);
            border-radius: 24px;
            backdrop-filter: blur(20px);
        }
        
        .modal-overlay {
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(8px);
        }
        
        /* Input 3D Effects */
        .input-3d {
            background: linear-gradient(145deg, #ffffff, #f1f5f9);
            box-shadow: 
                inset 3px 3px 8px rgba(0,0,0,0.1),
                inset -3px -3px 8px rgba(255,255,255,0.9),
                0 1px 3px rgba(0,0,0,0.1);
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .input-3d:focus {
            box-shadow: 
                inset 3px 3px 8px rgba(59, 130, 246, 0.2),
                inset -3px -3px 8px rgba(255,255,255,0.9),
                0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        /* Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }
        
        .animate-fade-in-scale {
            animation: fadeInScale 0.4s ease-out;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(255,255,255,0.4), rgba(255,255,255,0.2));
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .card-3d {
                border-radius: 16px;
                box-shadow: 15px 15px 40px #d1d5db, -15px -15px 40px #ffffff;
            }
        }
    </style>
    
    @livewireStyles
</head>

<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="fixed inset-0 flex z-40 lg:hidden hidden">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="closeMobileSidebar()"></div>
        
        <!-- Mobile Sidebar -->
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button onclick="closeMobileSidebar()" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Sidebar Content -->
            @include('components.layouts.partials.admin-sidebar')
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
        @include('components.layouts.partials.admin-sidebar')
    </div>

    <!-- Main Content Area -->
    <div class="lg:pl-64 flex flex-col min-h-screen">
        
        <!-- Top Navigation -->
        <div class="relative z-10 flex-shrink-0 flex h-20 header-3d">
            
            <!-- Mobile menu button -->
            <button onclick="openMobileSidebar()" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 lg:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
            </button>
            
            <!-- Header Content -->
            <div class="flex-1 px-4 flex justify-between items-center">
                <!-- Page Title -->
                <div class="flex-1">
                    <h1 class="text-xl font-semibold text-gray-900">
                        {{ $pageTitle ?? 'Dashboard' }}
                    </h1>
                </div>
                
                <!-- Right Header Items -->
                <div class="ml-4 flex items-center space-x-4">
                    
                    <!-- Notifications -->
                    <button class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="relative">
                        <button onclick="toggleUserMenu()" 
                                class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <img class="h-8 w-8 rounded-full" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" 
                                 alt="{{ auth()->user()->name }}">
                            <span class="ml-3 text-gray-700 text-sm font-medium hidden md:block">{{ auth()->user()->name }}</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="user-menu-dropdown" 
                             class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden">
                            <div class="py-1">
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                    <p class="text-xs text-blue-600 font-medium mt-1">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                                
                                <!-- Menu Items -->
                                <a href="{{ route('home') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Ver Loja
                                </a>
                                
                                <a href="#" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Meu Perfil
                                </a>
                                
                                <a href="#" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Configurações
                                </a>
                                
                                <div class="border-t border-gray-100"></div>
                                
                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left block px-4 py-2 text-sm text-red-700 hover:bg-red-50 flex items-center">
                                        <svg class="mr-3 h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Terminar Sessão
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none">
            <div class="py-6">
                {{ $slot }}
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        © {{ date('Y') }} SuperLoja. Todos os direitos reservados.
                    </div>
                    <div class="text-sm text-gray-500">
                        Versão 1.0.0
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Toast Notifications -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">
        <!-- Toasts will be added here via JavaScript -->
    </div>

    @livewireScripts
    
    <!-- Custom Scripts -->
    <script>
        // Mobile sidebar functions
        function openMobileSidebar() {
            document.getElementById('mobile-sidebar-overlay').classList.remove('hidden');
        }
        
        function closeMobileSidebar() {
            document.getElementById('mobile-sidebar-overlay').classList.add('hidden');
        }
        
        // User menu functions
        function toggleUserMenu() {
            const dropdown = document.getElementById('user-menu-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu-dropdown');
            const userButton = event.target.closest('button[onclick="toggleUserMenu()"]');
            
            if (!userButton && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
        
        // Toast notifications
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            toast.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 max-w-sm`;
            toast.innerHTML = `
                <div class="flex items-center justify-between">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            container.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
        }
        
        // Listen for Livewire events
        window.addEventListener('success', event => {
            showToast(event.detail[0].message || event.detail.message || 'Operação realizada com sucesso!', 'success');
        });
        
        window.addEventListener('error', event => {
            showToast(event.detail[0].message || event.detail.message || 'Ocorreu um erro!', 'error');
        });
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Alt + D = Dashboard
            if (e.altKey && e.key === 'd') {
                e.preventDefault();
                window.location.href = '{{ route("admin.dashboard") }}';
            }
            
            // Alt + P = Products
            if (e.altKey && e.key === 'p') {
                e.preventDefault();
                window.location.href = '{{ route("admin.products.index") }}';
            }
            
            // Alt + C = Categories
            if (e.altKey && e.key === 'c') {
                e.preventDefault();
                window.location.href = '{{ route("admin.categories.index") }}';
            }
        });
        
        // Toastr configuration
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            
            // Listen for Livewire showAlert events (ADMIN LAYOUT ONLY)
            Livewire.on('showAlert', (event) => {
                const data = event[0] || event;
                const type = data.type || 'info';
                const message = data.message || '';
                
                switch(type) {
                    case 'success':
                        toastr.success(message);
                        break;
                    case 'error':
                        toastr.error(message);
                        break;
                    case 'warning':
                        toastr.warning(message);
                        break;
                    case 'info':
                        toastr.info(message);
                        break;
                    default:
                        toastr.info(message);
                }
            });
            
            // Listen for URL opening events
            Livewire.on('openUrl', (event) => {
                const data = event[0] || event;
                const url = data.url;
                window.open(url, '_blank');
            });
            
            // Flash messages
            @if(session()->has('success'))
                toastr.success("{{ session('success') }}");
            @endif
            
            @if(session()->has('error'))
                toastr.error("{{ session('error') }}");
            @endif
            
            @if(session()->has('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif
            
            @if(session()->has('info'))
                toastr.info("{{ session('info') }}");
            @endif
        }
    </script>
</body>
</html>
