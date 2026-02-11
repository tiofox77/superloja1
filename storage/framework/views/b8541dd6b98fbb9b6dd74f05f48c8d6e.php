<!-- Sidebar Content -->
<div class="flex flex-col h-full">
    
    <!-- Logo Section -->
    <div class="flex items-center h-16 px-5 border-b border-white/10">
        <?php
            $siteLogo = \App\Models\Setting::get('site_logo');
            $appName = \App\Models\Setting::get('app_name', 'SuperLoja');
            $hasLogo = !empty($siteLogo) && $siteLogo !== '/images/logo.png';
            
            $logoUrl = null;
            if ($hasLogo) {
                if (\Illuminate\Support\Str::startsWith($siteLogo, ['http://', 'https://'])) {
                    $logoUrl = $siteLogo;
                } elseif (\Illuminate\Support\Str::startsWith($siteLogo, '/storage/')) {
                    $logoUrl = url($siteLogo);
                } elseif (\Illuminate\Support\Str::startsWith($siteLogo, 'storage/')) {
                    $logoUrl = url('/' . $siteLogo);
                } elseif (\Illuminate\Support\Str::startsWith($siteLogo, 'settings/')) {
                    $logoUrl = asset('storage/' . $siteLogo);
                } else {
                    $logoUrl = asset('storage/' . ltrim($siteLogo, '/'));
                }
            }
        ?>
        
        <a href="<?php echo e(route('admin.dashboard')); ?>" wire:navigate class="flex items-center gap-3">
            <?php if($hasLogo && $logoUrl): ?>
                <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($appName); ?>" class="h-10 w-10 rounded-xl object-contain bg-white p-1" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 items-center justify-center shadow-lg hidden">
                    <i data-lucide="store" class="w-5 h-5 text-white"></i>
                </div>
            <?php else: ?>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-lg">
                    <i data-lucide="store" class="w-5 h-5 text-white"></i>
                </div>
            <?php endif; ?>
            <div>
                <h1 class="text-lg font-bold text-white"><?php echo e($appName); ?></h1>
                <p class="text-xs text-white/60">Painel Admin</p>
            </div>
        </a>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scrollbar">
        
        <!-- Dashboard -->
        <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.dashboard','icon' => 'layout-dashboard','label' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.dashboard','icon' => 'layout-dashboard','label' => 'Dashboard']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
        
        <!-- Catálogo -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Catálogo</p>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.products.index','icon' => 'package','label' => 'Produtos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.products.index','icon' => 'package','label' => 'Produtos']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.categories.index','icon' => 'folder-tree','label' => 'Categorias']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.categories.index','icon' => 'folder-tree','label' => 'Categorias']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.brands.index','icon' => 'award','label' => 'Marcas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.brands.index','icon' => 'award','label' => 'Marcas']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
        </div>
        
        <!-- Vendas -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Vendas</p>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.orders.index','icon' => 'shopping-cart','label' => 'Pedidos','badge' => $pendingOrders ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.orders.index','icon' => 'shopping-cart','label' => 'Pedidos','badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingOrders ?? null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.pos.index','icon' => 'monitor','label' => 'PDV']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.pos.index','icon' => 'monitor','label' => 'PDV']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.auctions.index','icon' => 'gavel','label' => 'Leilões']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.auctions.index','icon' => 'gavel','label' => 'Leilões']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
        </div>
        
        <!-- Marketing -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Marketing</p>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.sms.index','icon' => 'message-square','label' => 'SMS Marketing']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.sms.index','icon' => 'message-square','label' => 'SMS Marketing']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
        </div>
        
        <!-- Sistema -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Sistema</p>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.users.index','icon' => 'users','label' => 'Usuários']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.users.index','icon' => 'users','label' => 'Usuários']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.settings.index','icon' => 'settings','label' => 'Configurações']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.settings.index','icon' => 'settings','label' => 'Configurações']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
            
            <?php if (isset($component)) { $__componentOriginaldc4cc8f93c2e981b8205808f985876c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.layouts.menu-item','data' => ['route' => 'admin.system.update','icon' => 'refresh-cw','label' => 'Atualização']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layouts.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.system.update','icon' => 'refresh-cw','label' => 'Atualização']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $attributes = $__attributesOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__attributesOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3)): ?>
<?php $component = $__componentOriginaldc4cc8f93c2e981b8205808f985876c3; ?>
<?php unset($__componentOriginaldc4cc8f93c2e981b8205808f985876c3); ?>
<?php endif; ?>
        </div>
        
    </nav>
    
    <!-- User Section -->
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 p-2 rounded-xl bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">
            <div class="w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center">
                <span class="text-sm font-semibold text-white">
                    <?php echo e(substr(auth()->user()->name ?? 'A', 0, 1)); ?>

                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                <p class="text-xs text-white/50 truncate"><?php echo e(auth()->user()->email ?? ''); ?></p>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="p-1.5 rounded-lg hover:bg-white/10 text-white/60 hover:text-white transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<?php
    // Contar pedidos pendentes
    $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
?>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/layouts/sidebar.blade.php ENDPATH**/ ?>