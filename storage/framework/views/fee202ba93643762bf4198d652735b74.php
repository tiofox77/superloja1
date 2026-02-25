<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-500">Bem-vindo de volta! Aqui está o resumo da sua loja.</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <?php if (isset($component)) { $__componentOriginal2ecef3de8af70632d6a65b398670d0bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.stats-card','data' => ['title' => 'Vendas Hoje','value' => number_format($salesToday, 2, ',', '.') . ' Kz','icon' => 'banknote','color' => 'primary','trend' => $salesTrend,'trendValue' => $salesTrendValue,'href' => route('admin.orders.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Vendas Hoje','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($salesToday, 2, ',', '.') . ' Kz'),'icon' => 'banknote','color' => 'primary','trend' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($salesTrend),'trendValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($salesTrendValue),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.orders.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $attributes = $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $component = $__componentOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
        
        <?php if (isset($component)) { $__componentOriginal2ecef3de8af70632d6a65b398670d0bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.stats-card','data' => ['title' => 'Pedidos','value' => $ordersCount,'icon' => 'shopping-cart','color' => 'info','trend' => $ordersTrend,'trendValue' => $ordersTrendValue,'href' => route('admin.orders.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pedidos','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ordersCount),'icon' => 'shopping-cart','color' => 'info','trend' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ordersTrend),'trendValue' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ordersTrendValue),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.orders.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $attributes = $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $component = $__componentOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
        
        <?php if (isset($component)) { $__componentOriginal2ecef3de8af70632d6a65b398670d0bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.stats-card','data' => ['title' => 'Produtos','value' => $productsCount,'icon' => 'package','color' => 'success','href' => route('admin.products.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Produtos','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($productsCount),'icon' => 'package','color' => 'success','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.products.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $attributes = $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $component = $__componentOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
        
        <?php if (isset($component)) { $__componentOriginal2ecef3de8af70632d6a65b398670d0bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.stats-card','data' => ['title' => 'Clientes','value' => $customersCount,'icon' => 'users','color' => 'secondary','href' => route('admin.users.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Clientes','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($customersCount),'icon' => 'users','color' => 'secondary','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.users.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $attributes = $__attributesOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__attributesOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf)): ?>
<?php $component = $__componentOriginal2ecef3de8af70632d6a65b398670d0bf; ?>
<?php unset($__componentOriginal2ecef3de8af70632d6a65b398670d0bf); ?>
<?php endif; ?>
    </div>
    
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Sales Chart -->
        <div class="lg:col-span-2">
            <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Vendas dos Últimos 7 Dias','icon' => 'trending-up']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Vendas dos Últimos 7 Dias','icon' => 'trending-up']); ?>
                <div class="h-72" id="sales-chart">
                    <canvas id="salesChartCanvas"></canvas>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
        </div>
        
        <!-- Recent Activity -->
        <div>
            <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Atividade Recente','icon' => 'activity','padding' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Atividade Recente','icon' => 'activity','padding' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                            <?php echo e($activity['type'] === 'order' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600'); ?>">
                                    <i data-lucide="<?php echo e($activity['icon']); ?>" class="w-4 h-4"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($activity['title']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($activity['time']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-6 py-8 text-center">
                            <i data-lucide="inbox" class="w-8 h-8 mx-auto text-gray-300 mb-2"></i>
                            <p class="text-sm text-gray-500">Nenhuma atividade recente</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
        </div>
    </div>
    
    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        
        <!-- Pending Orders -->
        <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Pedidos Pendentes','icon' => 'clock','padding' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pedidos Pendentes','icon' => 'clock','padding' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
             <?php $__env->slot('actions', null, []); ?> 
                <a href="<?php echo e(route('admin.orders.index')); ?>" wire:navigate 
                   class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                    Ver todos
                </a>
             <?php $__env->endSlot(); ?>
            
            <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $pendingOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center">
                                    <i data-lucide="package" class="w-5 h-5 text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">#<?php echo e($order->id); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($order->customer_name ?? 'Cliente'); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900"><?php echo e(number_format($order->total, 2, ',', '.')); ?> Kz</p>
                                <p class="text-xs text-gray-500"><?php echo e($order->created_at->diffForHumans()); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if (isset($component)) { $__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.empty-state','data' => ['icon' => 'check-circle','title' => 'Nenhum pedido pendente','description' => 'Todos os pedidos foram processados!']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'check-circle','title' => 'Nenhum pedido pendente','description' => 'Todos os pedidos foram processados!']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c)): ?>
<?php $attributes = $__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c; ?>
<?php unset($__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c)): ?>
<?php $component = $__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c; ?>
<?php unset($__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
        
        <!-- Low Stock Products -->
        <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Produtos com Baixo Estoque','icon' => 'alert-triangle','padding' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Produtos com Baixo Estoque','icon' => 'alert-triangle','padding' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
             <?php $__env->slot('actions', null, []); ?> 
                <a href="<?php echo e(route('admin.products.index')); ?>" wire:navigate 
                   class="text-sm text-primary-500 hover:text-primary-600 font-medium">
                    Ver todos
                </a>
             <?php $__env->endSlot(); ?>
            
            <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                                <!--[if BLOCK]><![endif]--><?php if($product->featured_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->featured_image)); ?>" 
                                         alt="<?php echo e($product->name); ?>"
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate"><?php echo e($product->name); ?></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <?php if (isset($component)) { $__componentOriginal7fa95ce53b108be002cc50811befd399 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fa95ce53b108be002cc50811befd399 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.badge','data' => ['variant' => 'danger','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'danger','size' => 'sm']); ?>
                                        <?php echo e($product->stock); ?> em estoque
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7fa95ce53b108be002cc50811befd399)): ?>
<?php $attributes = $__attributesOriginal7fa95ce53b108be002cc50811befd399; ?>
<?php unset($__attributesOriginal7fa95ce53b108be002cc50811befd399); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7fa95ce53b108be002cc50811befd399)): ?>
<?php $component = $__componentOriginal7fa95ce53b108be002cc50811befd399; ?>
<?php unset($__componentOriginal7fa95ce53b108be002cc50811befd399); ?>
<?php endif; ?>
                                </div>
                            </div>
                            <a href="<?php echo e(route('admin.products.index')); ?>?edit=<?php echo e($product->id); ?>" wire:navigate
                               class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if (isset($component)) { $__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.empty-state','data' => ['icon' => 'package-check','title' => 'Estoque em dia','description' => 'Todos os produtos têm estoque suficiente!']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'package-check','title' => 'Estoque em dia','description' => 'Todos os produtos têm estoque suficiente!']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c)): ?>
<?php $attributes = $__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c; ?>
<?php unset($__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c)): ?>
<?php $component = $__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c; ?>
<?php unset($__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
    </div>
    
    <!-- Quick Actions -->
    <div class="mt-6">
        <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Ações Rápidas','icon' => 'zap']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Ações Rápidas','icon' => 'zap']); ?>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="<?php echo e(route('admin.products.index')); ?>?create=1" wire:navigate
                   class="flex flex-col items-center p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center mb-3 group-hover:bg-primary-200 transition-colors">
                        <i data-lucide="package-plus" class="w-6 h-6 text-primary-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-600">Novo Produto</span>
                </a>
                
                <a href="<?php echo e(route('admin.pos.index')); ?>" wire:navigate
                   class="flex flex-col items-center p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mb-3 group-hover:bg-green-200 transition-colors">
                        <i data-lucide="monitor" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-green-600">Abrir PDV</span>
                </a>
                
                <a href="<?php echo e(route('admin.sms.index')); ?>" wire:navigate
                   class="flex flex-col items-center p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                        <i data-lucide="message-square" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Enviar SMS</span>
                </a>
                
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:navigated', () => initChart());
    document.addEventListener('DOMContentLoaded', () => initChart());
    
    function initChart() {
        const canvas = document.getElementById('salesChartCanvas');
        if (!canvas) return;
        
        // Destroy existing chart if exists
        if (window.salesChart) {
            window.salesChart.destroy();
        }
        
        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(255, 140, 0, 0.3)');
        gradient.addColorStop(1, 'rgba(255, 140, 0, 0)');
        
        window.salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chartLabels, 15, 512) ?>,
                datasets: [{
                    label: 'Vendas (Kz)',
                    data: <?php echo json_encode($chartData, 15, 512) ?>,
                    borderColor: '#FF8C00',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#FF8C00',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('pt-AO') + ' Kz';
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\superloja\resources\views/livewire/admin/dashboard/index.blade.php ENDPATH**/ ?>