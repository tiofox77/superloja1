<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <?php
        $appName = \App\Models\Setting::get('app_name', 'SuperLoja');
        $seoTitle = \App\Models\Setting::get('meta_title') ?: ($appName . ' - Sua Loja Online de Confiança');
        $seoDescription = \App\Models\Setting::get('meta_description') ?: 'SuperLoja - O maior e-commerce de Angola. Produtos de qualidade, entregas rápidas e os melhores preços.';
        $seoKeywords = \App\Models\Setting::get('meta_keywords') ?: 'loja online angola, eletrônicos angola, compras online luanda';
        $ogImagePath = \App\Models\Setting::get('og_image');
        $ogImage = $ogImagePath ? asset('storage/' . $ogImagePath) : asset('images/og-image.jpg');
        $siteLogo = \App\Models\Setting::get('site_logo');
    ?>
    
    <title><?php echo $__env->yieldContent('title', $seoTitle); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', $seoDescription); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', $seoKeywords); ?>">
    <meta name="author" content="<?php echo e($appName); ?>">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e($appName); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', $seoTitle); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('description', $seoDescription); ?>">
    <meta property="og:image" content="<?php echo e($ogImage); ?>">
    <meta property="og:locale" content="pt_AO">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo e(url()->current()); ?>">
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', $seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('description', $seoDescription); ?>">
    <meta name="twitter:image" content="<?php echo e($ogImage); ?>">
    
    <!-- Favicon -->
    <?php
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
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e($faviconUrl); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e($faviconUrl); ?>">
    <link rel="apple-touch-icon" href="<?php echo e($faviconUrl); ?>">
    
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
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    
    <!-- Google Analytics -->
    <?php
        $gaId = \App\Models\Setting::get('google_analytics');
    ?>
    <?php if($gaId): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($gaId); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo e($gaId); ?>');
        </script>
    <?php endif; ?>
    
    <!-- Facebook Pixel -->
    <?php
        $fbPixelId = \App\Models\Setting::get('facebook_pixel');
    ?>
    <?php if($fbPixelId): ?>
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
            fbq('init', '<?php echo e($fbPixelId); ?>');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none" 
                 src="https://www.facebook.com/tr?id=<?php echo e($fbPixelId); ?>&ev=PageView&noscript=1"/>
        </noscript>
    <?php endif; ?>
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Header -->
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <!-- Main Content -->
    <div class="min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo e($slot ?? ''); ?>

    </div>

    <!-- Footer -->
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Toast Notifications (Livewire) -->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.toast-notifications');

$__html = app('livewire')->mount($__name, $__params, 'lw-2002190282-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    
    <!-- Product Modal -->
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.product-modal');

$__html = app('livewire')->mount($__name, $__params, 'lw-2002190282-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    
    <!-- Shopping Cart agora usa popup no header -->

    <!-- Livewire Scripts -->
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    
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
        <?php if(session()->has('success')): ?>
            toastr.success("<?php echo e(session('success')); ?>");
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
            toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>

        <?php if(session()->has('warning')): ?>
            toastr.warning("<?php echo e(session('warning')); ?>");
        <?php endif; ?>

        <?php if(session()->has('info')): ?>
            toastr.info("<?php echo e(session('info')); ?>");
        <?php endif; ?>

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

        // SPA Navigation - Reinitialize scripts after page transitions
        document.addEventListener('livewire:navigated', () => {
            console.log('Livewire navigated - reinitializing scripts');
            
            // Reinitialize toastr settings
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
            
            // Scroll to top on navigation
            window.scrollTo(0, 0);
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\superloja\resources\views/layouts/app.blade.php ENDPATH**/ ?>