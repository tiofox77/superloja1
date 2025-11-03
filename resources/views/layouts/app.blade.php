<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        $seoTitle = \App\Models\Setting::get('seo_title', 'SuperLoja Angola - Sua Loja Online de Confiança');
        $seoDescription = \App\Models\Setting::get('seo_description', 'SuperLoja - O maior e-commerce de Angola. Produtos de qualidade, entregas rápidas e os melhores preços.');
        $seoKeywords = \App\Models\Setting::get('seo_keywords', 'loja online angola, eletrônicos angola, compras online luanda');
        $ogImage = \App\Models\Setting::get('og_image', asset('images/og-image.jpg'));
    @endphp
    
    <title>@yield('title', $seoTitle)</title>
    <meta name="description" content="@yield('description', $seoDescription)">
    <meta name="keywords" content="{{ $seoKeywords }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $seoTitle)">
    <meta property="og:description" content="@yield('description', $seoDescription)">
    <meta property="og:image" content="{{ $ogImage }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', $seoTitle)">
    <meta property="twitter:description" content="@yield('description', $seoDescription)">
    <meta property="twitter:image" content="{{ $ogImage }}">
    
    <!-- Favicon -->
    @php
        $siteFavicon = \App\Models\Setting::get('site_favicon');
        if ($siteFavicon && $siteFavicon !== '/favicon.ico') {
            if (\Illuminate\Support\Str::startsWith($siteFavicon, ['http://', 'https://'])) {
                $faviconUrl = $siteFavicon;
            } elseif (\Illuminate\Support\Str::startsWith($siteFavicon, '/storage/')) {
                $faviconUrl = url($siteFavicon);
            } elseif (\Illuminate\Support\Str::startsWith($siteFavicon, 'storage/')) {
                $faviconUrl = url('/' . $siteFavicon);
            } else {
                $faviconUrl = asset(ltrim($siteFavicon, '/'));
            }
        } else {
            $faviconUrl = asset('favicon.ico');
        }
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- jQuery (needed for toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Header shadow on scroll */
        .header-shadow {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Google Analytics -->
    @php
        $gaId = \App\Models\Setting::get('google_analytics_id');
    @endphp
    @if($gaId)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif
    
    <!-- Facebook Pixel -->
    @php
        $fbPixelId = \App\Models\Setting::get('facebook_pixel_id');
    @endphp
    @if($fbPixelId)
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $fbPixelId }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none" 
                 src="https://www.facebook.com/tr?id={{ $fbPixelId }}&ev=PageView&noscript=1"/>
        </noscript>
    @endif
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Header -->
    @include('layouts.header')
    
    <!-- Main Content -->
    <div class="min-h-screen">
        @yield('content')
        {{ $slot ?? '' }}
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Toast Notifications (Livewire) -->
    @livewire('components.toast-notifications')
    
    <!-- Product Modal -->
    @livewire('components.product-modal')
    
    <!-- Shopping Cart agora usa popup no header -->

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Alpine.js (loaded only once) -->
    <script>
        // Load Alpine.js only if not already loaded
        if (!window.Alpine) {
            const script = document.createElement('script');
            script.defer = true;
            script.src = 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js';
            document.head.appendChild(script);
        }
    </script>
    
    <!-- Global JavaScript -->
    <script>
        
        // Global notification system
        window.showNotification = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `px-6 py-4 rounded-lg shadow-lg text-white max-w-sm fade-in ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                type === 'warning' ? 'bg-yellow-500' : 
                'bg-blue-500'
            }`;
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
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        };

        // Global cart functions
        window.getCartItemCount = function() {
            const cartItems = JSON.parse(sessionStorage.getItem('cart_items') || '[]');
            return cartItems.reduce((total, item) => total + item.quantity, 0);
        };

        // Listen for Livewire notifications
        document.addEventListener('livewire:init', () => {
            Livewire.on('notify', (event) => {
                showNotification(event.message, event.type);
            });
            
            // Unified notification system
            Livewire.on('show-notification', (data) => {
                const notification = Array.isArray(data) ? data[0] : data;
                const type = notification.type || 'info';
                const message = notification.message || '';
                
                if (typeof toastr !== 'undefined') {
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
                } else {
                    showNotification(message, type);
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (header) {
                if (window.scrollY > 10) {
                    header.classList.add('header-shadow');
                } else {
                    header.classList.remove('header-shadow');
                }
            }
        });

        // Toastr configuration
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

        // Flash message toastr
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

        // Debug console log
        console.log('Layout script loaded');
        console.log('jQuery version:', typeof jQuery !== 'undefined' ? jQuery.fn.jquery : 'not loaded');
        console.log('Toastr loaded:', typeof toastr !== 'undefined');

        // Simple toastr test
        setTimeout(() => {
            if (typeof toastr !== 'undefined') {
                console.log('Testing toastr...');
                // toastr.info('Sistema de notificações carregado!');
            }
        }, 2000);

        // Livewire event listeners
        document.addEventListener('livewire:init', () => {
            console.log('Livewire initialized');
            
            // Cart events
            Livewire.on('cart-updated', () => {
                // Atualizar contador do carrinho no header
                const cartBadge = document.querySelector('button[onclick="toggleCart()"] span span');
                if (cartBadge && window.getCartItemCount) {
                    cartBadge.textContent = window.getCartItemCount();
                }
            });

            // Toast notifications - showAlert listener (ÚNICO GLOBAL)
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

            Livewire.on('productCreated', () => {
                toastr.success('Produto criado com sucesso!');
            });

            Livewire.on('productUpdated', () => {
                toastr.success('Produto atualizado com sucesso!');
            });

            Livewire.on('productDeleted', () => {
                toastr.success('Produto excluído com sucesso!');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
