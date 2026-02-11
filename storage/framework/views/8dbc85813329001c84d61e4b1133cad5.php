<!-- Header -->
<header class="sticky top-0 z-30 h-16 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between h-full px-4 lg:px-6">
        
        <!-- Left: Mobile menu + Breadcrumb -->
        <div class="flex items-center gap-4">
            <!-- Mobile Menu Toggle -->
            <button @click="mobileSidebar = !mobileSidebar" 
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            
            <!-- Breadcrumb -->
            <nav class="hidden sm:flex items-center gap-2 text-sm">
                <a href="<?php echo e(route('admin.dashboard')); ?>" wire:navigate class="text-gray-400 hover:text-primary-500 transition-colors">
                    <i data-lucide="home" class="w-4 h-4"></i>
                </a>
                <?php if(isset($breadcrumb)): ?>
                    <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300"></i>
                        <?php if($loop->last): ?>
                            <span class="text-gray-700 font-medium"><?php echo e($item['label']); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($item['url']); ?>" wire:navigate class="text-gray-500 hover:text-primary-500 transition-colors">
                                <?php echo e($item['label']); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </nav>
        </div>
        
        <!-- Right: Actions -->
        <div class="flex items-center gap-2">
            
            <!-- Search -->
            <div class="hidden md:block relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="p-2.5 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>
                
                <!-- Search Modal -->
                <div x-show="open" 
                     x-transition
                     @click.away="open = false"
                     class="absolute right-0 top-12 w-80 bg-white rounded-xl shadow-xl border border-gray-200 p-3">
                    <input type="text" 
                           placeholder="Buscar produtos, pedidos..." 
                           class="w-full px-4 py-2.5 bg-gray-50 border-0 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:bg-white transition-all"
                           autofocus>
                    <div class="mt-2 text-xs text-gray-400">
                        <kbd class="px-1.5 py-0.5 bg-gray-100 rounded">⌘K</kbd> para busca rápida
                    </div>
                </div>
            </div>
            
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="relative p-2.5 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <!-- Notifications Dropdown -->
                <div x-show="open" 
                     x-transition
                     @click.away="open = false"
                     class="absolute right-0 top-12 w-80 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Notificações</h3>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <div class="p-4 text-center text-gray-500 text-sm">
                            <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                            Nenhuma notificação
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="hidden sm:block relative" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-3 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-xl text-sm font-medium transition-colors shadow-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Novo</span>
                </button>
                
                <!-- Quick Actions Dropdown -->
                <div x-show="open" 
                     x-transition
                     @click.away="open = false"
                     class="absolute right-0 top-12 w-48 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden py-1">
                    <a href="<?php echo e(route('admin.products.index')); ?>" wire:navigate
                       class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 text-gray-700 text-sm transition-colors">
                        <i data-lucide="package-plus" class="w-4 h-4 text-gray-400"></i>
                        Novo Produto
                    </a>
                    <a href="<?php echo e(route('admin.orders.create')); ?>" wire:navigate
                       class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 text-gray-700 text-sm transition-colors">
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-gray-400"></i>
                        Novo Pedido
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" wire:navigate
                       class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 text-gray-700 text-sm transition-colors">
                        <i data-lucide="folder-plus" class="w-4 h-4 text-gray-400"></i>
                        Nova Categoria
                    </a>
                </div>
            </div>
            
            <!-- Visit Site -->
            <a href="<?php echo e(url('/')); ?>" target="_blank"
               class="hidden lg:flex items-center gap-2 px-3 py-2 text-gray-500 hover:text-primary-500 hover:bg-gray-100 rounded-xl text-sm transition-colors">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Ver Loja</span>
            </a>
        </div>
    </div>
</header>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/layouts/header.blade.php ENDPATH**/ ?>