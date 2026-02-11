<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'Admin'); ?> - SuperLoja</title>
    
    <!-- Favicon -->
    <?php
        $favicon = \App\Models\Setting::get('site_favicon', '/favicon.ico');
        $faviconUrl = Str::startsWith($favicon, ['http://', 'https://']) ? $favicon : asset('storage/' . ltrim($favicon, '/'));
    ?>
    <link rel="icon" href="<?php echo e($faviconUrl); ?>">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#FFF7ED',
                            100: '#FFEDD5',
                            200: '#FED7AA',
                            300: '#FDBA74',
                            400: '#FB923C',
                            500: '#FF8C00',
                            600: '#EA580C',
                            700: '#C2410C',
                            800: '#9A3412',
                            900: '#7C2D12',
                        },
                        secondary: {
                            50: '#FDF2F8',
                            100: '#FCE7F3',
                            200: '#FBCFE8',
                            300: '#F9A8D4',
                            400: '#EC4899',
                            500: '#8B1E5C',
                            600: '#7A1850',
                            700: '#6D1848',
                            800: '#5A1239',
                            900: '#470E2D',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Scrollbar personalizada */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.3);
        }
        
        /* Loading bar */
        .loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #FF8C00, #8B1E5C, #FF8C00);
            background-size: 200% 100%;
            animation: loading 1.5s ease-in-out infinite;
            z-index: 9999;
        }
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Transições SPA */
        .page-enter {
            opacity: 0;
            transform: translateY(10px);
        }
        .page-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.2s ease-out;
        }
        
        /* Sidebar gradient */
        .sidebar-gradient {
            background: linear-gradient(180deg, #8B1E5C 0%, #6D1848 50%, #5A1239 100%);
        }
        
        /* Active menu item */
        .menu-item-active {
            background: rgba(255, 140, 0, 0.2);
            border-left: 3px solid #FF8C00;
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    <!-- Loading Bar (SPA) -->
    <div x-data="{ loading: false }"
         x-on:livewire:navigating.window="loading = true"
         x-on:livewire:navigated.window="loading = false">
        <div x-show="loading" x-transition class="loading-bar"></div>
    </div>

    <!-- Toast Notifications -->
    <?php if (isset($component)) { $__componentOriginal5a79ae81f4986e32ebda05b84401de9f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a79ae81f4986e32ebda05b84401de9f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.toast','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a79ae81f4986e32ebda05b84401de9f)): ?>
<?php $attributes = $__attributesOriginal5a79ae81f4986e32ebda05b84401de9f; ?>
<?php unset($__attributesOriginal5a79ae81f4986e32ebda05b84401de9f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a79ae81f4986e32ebda05b84401de9f)): ?>
<?php $component = $__componentOriginal5a79ae81f4986e32ebda05b84401de9f; ?>
<?php unset($__componentOriginal5a79ae81f4986e32ebda05b84401de9f); ?>
<?php endif; ?>

    <div class="flex h-full" x-data="{ sidebarOpen: true, mobileSidebar: false }">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileSidebar" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebar = false"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden">
        </div>

        <!-- Sidebar -->
        <?php app("livewire")->forceAssetInjection(); ?><div x-persist="<?php echo e('admin-sidebar'); ?>">
        <aside :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:static inset-y-0 left-0 z-50 w-[280px] sidebar-gradient shadow-xl transition-transform duration-300 flex flex-col">
            <?php if (isset($component)) { $__componentOriginalfd8443a1544feeb51a5f83be9e5e06e5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfd8443a1544feeb51a5f83be9e5e06e5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfd8443a1544feeb51a5f83be9e5e06e5)): ?>
<?php $attributes = $__attributesOriginalfd8443a1544feeb51a5f83be9e5e06e5; ?>
<?php unset($__attributesOriginalfd8443a1544feeb51a5f83be9e5e06e5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfd8443a1544feeb51a5f83be9e5e06e5)): ?>
<?php $component = $__componentOriginalfd8443a1544feeb51a5f83be9e5e06e5; ?>
<?php unset($__componentOriginalfd8443a1544feeb51a5f83be9e5e06e5); ?>
<?php endif; ?>
        </aside>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
            <!-- Header -->
            <?php if (isset($component)) { $__componentOriginal709b46194ab5d7225a0352d4fe10b431 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal709b46194ab5d7225a0352d4fe10b431 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal709b46194ab5d7225a0352d4fe10b431)): ?>
<?php $attributes = $__attributesOriginal709b46194ab5d7225a0352d4fe10b431; ?>
<?php unset($__attributesOriginal709b46194ab5d7225a0352d4fe10b431); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal709b46194ab5d7225a0352d4fe10b431)): ?>
<?php $component = $__componentOriginal709b46194ab5d7225a0352d4fe10b431; ?>
<?php unset($__componentOriginal709b46194ab5d7225a0352d4fe10b431); ?>
<?php endif; ?>
            
            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-6 overflow-auto">
                <?php echo e($slot); ?>

            </main>
            
            <!-- Footer -->
            <footer class="border-t border-gray-200 bg-white px-6 py-3">
                <p class="text-sm text-gray-500 text-center">
                    &copy; <?php echo e(date('Y')); ?> SuperLoja. Todos os direitos reservados.
                </p>
            </footer>
        </div>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    
    <!-- Alpine.js (já incluído no Livewire v3) -->
    
    <!-- Initialize Lucide Icons -->
    <script>
        // Função para inicializar ícones
        function initIcons() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
        
        // Inicializar no carregamento
        document.addEventListener('DOMContentLoaded', initIcons);
        
        // Reinicializar após navegação SPA
        document.addEventListener('livewire:navigated', initIcons);
        
        // Reinicializar após atualizações do Livewire (mudança de abas, etc)
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', ({ el, component }) => {
                initIcons();
            });
        });
    </script>
    
    <!-- Toast Events - Livewire to Window -->
    <script>
        (function() {
            if (window.toastListenerRegistered) return;
            window.toastListenerRegistered = true;
            
            document.addEventListener('livewire:init', () => {
                Livewire.on('toast', (data) => {
                    // Verificar se há dados válidos
                    const toastData = Array.isArray(data) ? data[0] : data;
                    if (toastData && toastData.message) {
                        window.dispatchEvent(new CustomEvent('toast', { detail: toastData }));
                    }
                });
            });
        })();
    </script>
    
    <!-- Lucide Icons Initialization -->
    <script>
        // Inicializar ícones Lucide
        function initLucideIcons() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
        
        // Inicializar após carregamento da página
        document.addEventListener('DOMContentLoaded', initLucideIcons);
        
        // Reinicializar após updates do Livewire
        document.addEventListener('livewire:navigated', initLucideIcons);
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', () => {
                initLucideIcons();
            });
            Livewire.hook('commit', ({ component, commit, respond }) => {
                // Inicializar ícones após qualquer update do Livewire
                queueMicrotask(() => {
                    initLucideIcons();
                });
            });
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/layouts/app.blade.php ENDPATH**/ ?>