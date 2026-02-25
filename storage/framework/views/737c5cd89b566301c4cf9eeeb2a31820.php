<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Produtos</h1>
            <p class="text-gray-500">Gerencie o catálogo de produtos da loja</p>
        </div>
        <div class="flex items-center gap-3">
            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['href' => ''.e(route('admin.products.import')).'','variant' => 'outline','icon' => 'upload']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.products.import')).'','variant' => 'outline','icon' => 'upload']); ?>
                Importar
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'openCreateModal','icon' => 'plus-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openCreateModal','icon' => 'plus-circle']); ?>
                Novo Produto
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($totalProducts)); ?></p>
                <p class="text-sm text-gray-500">Total de Produtos</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($activeProducts)); ?></p>
                <p class="text-sm text-gray-500">Produtos Ativos</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($lowStockProducts)); ?></p>
                <p class="text-sm text-gray-500">Estoque Baixo</p>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['class' => 'mb-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-6']); ?>
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <?php if (isset($component)) { $__componentOriginald346427bda1d19c52f33593a6d706b3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald346427bda1d19c52f33593a6d706b3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.search','data' => ['wire:model.live.debounce.300ms' => 'search','placeholder' => 'Buscar produtos...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live.debounce.300ms' => 'search','placeholder' => 'Buscar produtos...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald346427bda1d19c52f33593a6d706b3d)): ?>
<?php $attributes = $__attributesOriginald346427bda1d19c52f33593a6d706b3d; ?>
<?php unset($__attributesOriginald346427bda1d19c52f33593a6d706b3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald346427bda1d19c52f33593a6d706b3d)): ?>
<?php $component = $__componentOriginald346427bda1d19c52f33593a6d706b3d; ?>
<?php unset($__componentOriginald346427bda1d19c52f33593a6d706b3d); ?>
<?php endif; ?>
            </div>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-3">
                <select wire:model.live="category" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todas Categorias</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
                
                <select wire:model.live="brand" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todas Marcas</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b->id); ?>"><?php echo e($b->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
                
                <select wire:model.live="status" 
                        class="rounded-xl border-gray-300 text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos Status</option>
                    <option value="active">Ativos</option>
                    <option value="inactive">Inativos</option>
                </select>
                
                <!--[if BLOCK]><![endif]--><?php if($search || $category || $brand || $status): ?>
                    <button wire:click="clearFilters" 
                            class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            
            <!-- View Toggle -->
            <div class="flex items-center gap-1 bg-gray-100 rounded-xl p-1">
                <button wire:click="$set('viewMode', 'grid')" 
                        class="p-2 rounded-lg transition-colors <?php echo e($viewMode === 'grid' ? 'bg-white shadow-sm text-primary-600' : 'text-gray-500 hover:text-gray-700'); ?>">
                    <i data-lucide="grid-3x3" class="w-4 h-4"></i>
                </button>
                <button wire:click="$set('viewMode', 'list')" 
                        class="p-2 rounded-lg transition-colors <?php echo e($viewMode === 'list' ? 'bg-white shadow-sm text-primary-600' : 'text-gray-500 hover:text-gray-700'); ?>">
                    <i data-lucide="list" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <!-- Bulk Actions -->
        <!--[if BLOCK]><![endif]--><?php if(count($selected) > 0): ?>
            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-4">
                <span class="text-sm text-gray-600"><?php echo e(count($selected)); ?> selecionados</span>
                <button wire:click="deleteSelected" 
                        wire:confirm="Tem certeza que deseja excluir os produtos selecionados?"
                        class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Excluir selecionados
                </button>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
    
    <!-- Products Grid -->
    <!--[if BLOCK]><![endif]--><?php if($viewMode === 'grid'): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden card-hover group">
                    <!-- Image -->
                    <div class="aspect-square relative bg-gray-100">
                        <!--[if BLOCK]><![endif]--><?php if($product->featured_image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->featured_image)); ?>" 
                                 alt="<?php echo e($product->name); ?>"
                                 class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center">
                                <i data-lucide="image" class="w-12 h-12 text-gray-300"></i>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!-- Checkbox -->
                        <div class="absolute top-3 left-3">
                            <input type="checkbox" 
                                   wire:model.live="selected" 
                                   value="<?php echo e($product->id); ?>"
                                   class="w-5 h-5 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <?php if (isset($component)) { $__componentOriginal7fa95ce53b108be002cc50811befd399 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fa95ce53b108be002cc50811befd399 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.badge','data' => ['variant' => $product->is_active ? 'success' : 'danger','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'success' : 'danger'),'size' => 'sm']); ?>
                                <?php echo e($product->is_active ? 'Ativo' : 'Inativo'); ?>

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
                        
                        <!-- Quick Actions -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <button wire:click="openEditModal(<?php echo e($product->id); ?>)"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                                <i data-lucide="edit-2" class="w-5 h-5"></i>
                            </button>
                            <button wire:click="toggleStatus(<?php echo e($product->id); ?>)"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-primary-600 transition-colors">
                                <i data-lucide="<?php echo e($product->is_active ? 'eye-off' : 'eye'); ?>" class="w-5 h-5"></i>
                            </button>
                            <button wire:click="deleteProduct(<?php echo e($product->id); ?>)"
                                    wire:confirm="Tem certeza que deseja excluir este produto?"
                                    class="p-2 bg-white rounded-lg text-gray-700 hover:text-red-600 transition-colors">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="p-4">
                        <p class="text-xs text-gray-500 mb-1"><?php echo e($product->category?->name ?? 'Sem categoria'); ?></p>
                        <h3 class="font-medium text-gray-900 truncate"><?php echo e($product->name); ?></h3>
                        <div class="mt-2 flex items-center justify-between">
                            <div>
                                <!--[if BLOCK]><![endif]--><?php if($product->is_on_sale): ?>
                                    <span class="text-lg font-bold text-primary-600"><?php echo e(number_format($product->sale_price, 2, ',', '.')); ?> Kz</span>
                                    <span class="text-sm text-gray-400 line-through ml-1"><?php echo e(number_format($product->price, 2, ',', '.')); ?></span>
                                <?php else: ?>
                                    <span class="text-lg font-bold text-gray-900"><?php echo e(number_format($product->price, 2, ',', '.')); ?> Kz</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <span class="text-sm <?php echo e($product->stock_quantity <= 10 ? 'text-red-600' : 'text-gray-500'); ?>">
                                <?php echo e($product->stock_quantity); ?> un.
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full">
                    <?php if (isset($component)) { $__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.empty-state','data' => ['icon' => 'package','title' => 'Nenhum produto encontrado','description' => 'Não encontramos produtos com os filtros aplicados.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'package','title' => 'Nenhum produto encontrado','description' => 'Não encontramos produtos com os filtros aplicados.']); ?>
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
                    <div class="text-center mt-4">
                        <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'openCreateModal','icon' => 'plus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openCreateModal','icon' => 'plus']); ?>
                            Criar Primeiro Produto
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php else: ?>
        <!-- Products Table -->
        <?php if (isset($component)) { $__componentOriginal722fc7edbde74caa9ff525bc9925b331 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal722fc7edbde74caa9ff525bc9925b331 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
             <?php $__env->slot('head', null, []); ?> 
                <tr>
                    <th class="px-4 py-3 w-12">
                        <input type="checkbox" 
                               wire:model.live="selectAll"
                               wire:click="toggleSelectAll"
                               class="w-4 h-4 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produto</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Categoria</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Preço</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Estoque</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
                </tr>
             <?php $__env->endSlot(); ?>
            
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <input type="checkbox" 
                               wire:model.live="selected" 
                               value="<?php echo e($product->id); ?>"
                               class="w-4 h-4 rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
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
                            <div>
                                <p class="font-medium text-gray-900"><?php echo e($product->name); ?></p>
                                <p class="text-xs text-gray-500">SKU: <?php echo e($product->sku ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($product->category?->name ?? '-'); ?></td>
                    <td class="px-4 py-3">
                        <!--[if BLOCK]><![endif]--><?php if($product->is_on_sale): ?>
                            <span class="text-sm font-semibold text-primary-600"><?php echo e(number_format($product->sale_price, 2, ',', '.')); ?> Kz</span>
                            <span class="text-xs text-gray-400 line-through block"><?php echo e(number_format($product->price, 2, ',', '.')); ?></span>
                        <?php else: ?>
                            <span class="text-sm font-semibold text-gray-900"><?php echo e(number_format($product->price, 2, ',', '.')); ?> Kz</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-sm <?php echo e($product->stock_quantity <= 10 ? 'text-red-600 font-medium' : 'text-gray-600'); ?>">
                            <?php echo e($product->stock_quantity); ?> un.
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <?php if (isset($component)) { $__componentOriginal7fa95ce53b108be002cc50811befd399 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fa95ce53b108be002cc50811befd399 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.badge','data' => ['variant' => $product->is_active ? 'success' : 'danger','size' => 'sm','dot' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->is_active ? 'success' : 'danger'),'size' => 'sm','dot' => true]); ?>
                            <?php echo e($product->is_active ? 'Ativo' : 'Inativo'); ?>

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
                    </td>
                    <td class="px-4 py-3 text-right">
                        <?php if (isset($component)) { $__componentOriginala4b338472bd65a0afffadcf8306c65f1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4b338472bd65a0afffadcf8306c65f1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.dropdown','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginalbd963e89651253dbdf1380a0c98fdba7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd963e89651253dbdf1380a0c98fdba7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.dropdown-item','data' => ['wire:click' => 'openEditModal('.e($product->id).')','icon' => 'edit-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.dropdown-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openEditModal('.e($product->id).')','icon' => 'edit-2']); ?>
                                Editar
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd963e89651253dbdf1380a0c98fdba7)): ?>
<?php $attributes = $__attributesOriginalbd963e89651253dbdf1380a0c98fdba7; ?>
<?php unset($__attributesOriginalbd963e89651253dbdf1380a0c98fdba7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd963e89651253dbdf1380a0c98fdba7)): ?>
<?php $component = $__componentOriginalbd963e89651253dbdf1380a0c98fdba7; ?>
<?php unset($__componentOriginalbd963e89651253dbdf1380a0c98fdba7); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalbd963e89651253dbdf1380a0c98fdba7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd963e89651253dbdf1380a0c98fdba7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.dropdown-item','data' => ['wire:click' => 'toggleStatus('.e($product->id).')','icon' => ''.e($product->is_active ? 'eye-off' : 'eye').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.dropdown-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'toggleStatus('.e($product->id).')','icon' => ''.e($product->is_active ? 'eye-off' : 'eye').'']); ?>
                                <?php echo e($product->is_active ? 'Desativar' : 'Ativar'); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd963e89651253dbdf1380a0c98fdba7)): ?>
<?php $attributes = $__attributesOriginalbd963e89651253dbdf1380a0c98fdba7; ?>
<?php unset($__attributesOriginalbd963e89651253dbdf1380a0c98fdba7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd963e89651253dbdf1380a0c98fdba7)): ?>
<?php $component = $__componentOriginalbd963e89651253dbdf1380a0c98fdba7; ?>
<?php unset($__componentOriginalbd963e89651253dbdf1380a0c98fdba7); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalbd963e89651253dbdf1380a0c98fdba7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd963e89651253dbdf1380a0c98fdba7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.dropdown-item','data' => ['wire:click' => 'deleteProduct('.e($product->id).')','wire:confirm' => 'Tem certeza?','icon' => 'trash-2','danger' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.dropdown-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'deleteProduct('.e($product->id).')','wire:confirm' => 'Tem certeza?','icon' => 'trash-2','danger' => true]); ?>
                                Excluir
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd963e89651253dbdf1380a0c98fdba7)): ?>
<?php $attributes = $__attributesOriginalbd963e89651253dbdf1380a0c98fdba7; ?>
<?php unset($__attributesOriginalbd963e89651253dbdf1380a0c98fdba7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd963e89651253dbdf1380a0c98fdba7)): ?>
<?php $component = $__componentOriginalbd963e89651253dbdf1380a0c98fdba7; ?>
<?php unset($__componentOriginalbd963e89651253dbdf1380a0c98fdba7); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4b338472bd65a0afffadcf8306c65f1)): ?>
<?php $attributes = $__attributesOriginala4b338472bd65a0afffadcf8306c65f1; ?>
<?php unset($__attributesOriginala4b338472bd65a0afffadcf8306c65f1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4b338472bd65a0afffadcf8306c65f1)): ?>
<?php $component = $__componentOriginala4b338472bd65a0afffadcf8306c65f1; ?>
<?php unset($__componentOriginala4b338472bd65a0afffadcf8306c65f1); ?>
<?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">
                        <?php if (isset($component)) { $__componentOriginal4207dcdb1965d73eb83cec7dd98fd83c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4207dcdb1965d73eb83cec7dd98fd83c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.empty-state','data' => ['icon' => 'package','title' => 'Nenhum produto encontrado','description' => 'Não encontramos produtos com os filtros aplicados.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'package','title' => 'Nenhum produto encontrado','description' => 'Não encontramos produtos com os filtros aplicados.']); ?>
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
                    </td>
                </tr>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal722fc7edbde74caa9ff525bc9925b331)): ?>
<?php $attributes = $__attributesOriginal722fc7edbde74caa9ff525bc9925b331; ?>
<?php unset($__attributesOriginal722fc7edbde74caa9ff525bc9925b331); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal722fc7edbde74caa9ff525bc9925b331)): ?>
<?php $component = $__componentOriginal722fc7edbde74caa9ff525bc9925b331; ?>
<?php unset($__componentOriginal722fc7edbde74caa9ff525bc9925b331); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($products->links()); ?>

    </div>

    <!-- Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div class="fixed inset-0 z-[9998] overflow-y-auto" x-data x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="fixed inset-0 flex items-center justify-center p-4 overflow-y-auto">
                <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl my-8" @click.stop>
                    <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center">
                                <i data-lucide="<?php echo e($editingId ? 'edit-3' : 'plus-circle'); ?>" class="w-5 h-5 text-primary-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">
                                <?php echo e($editingId ? 'Editar Produto' : 'Novo Produto'); ?>

                            </h3>
                        </div>
                        <button wire:click="closeModal" class="p-2 rounded-xl hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-all active:scale-95">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <form wire:submit="saveProduct" class="p-6 space-y-6 max-h-[calc(100vh-12rem)] overflow-y-auto">
                        <!-- Informações Básicas -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="info" class="w-4 h-4 text-gray-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Informações Básicas</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'name','label' => 'Nome do Produto','placeholder' => 'Ex: Fone Bluetooth Premium','icon' => 'package','error' => $errors->first('name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'name','label' => 'Nome do Produto','placeholder' => 'Ex: Fone Bluetooth Premium','icon' => 'package','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>

                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'sku','label' => 'SKU / Código','placeholder' => 'Deixe vazio para gerar automaticamente','icon' => 'hash','error' => $errors->first('sku')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'sku','label' => 'SKU / Código','placeholder' => 'Deixe vazio para gerar automaticamente','icon' => 'hash','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('sku'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                <p class="text-xs text-gray-500 -mt-2">Opcional: será gerado automaticamente se não fornecido</p>
                            </div>
                        </div>

                        <!-- Categorização -->
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="folder-tree" class="w-4 h-4 text-indigo-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Categorização</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Categoria Principal -->
                                <div>
                                    <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'parent_category_id','label' => 'Categoria Principal','icon' => 'folder','error' => $errors->first('parent_category_id')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'parent_category_id','label' => 'Categoria Principal','icon' => 'folder','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('parent_category_id'))]); ?>
                                        <option value="">📁 Selecione a categoria principal</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                                    <p class="mt-1.5 text-xs text-gray-500 flex items-center gap-1">
                                        <i data-lucide="info" class="w-3 h-3"></i>
                                        Primeiro, escolha a categoria principal
                                    </p>
                                </div>

                                <!-- Subcategoria -->
                                <div>
                                    <!--[if BLOCK]><![endif]--><?php if(empty($parent_category_id)): ?>
                                        <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'category_id','label' => 'Subcategoria','icon' => 'folder-open','disabled' => true,'error' => $errors->first('category_id')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'category_id','label' => 'Subcategoria','icon' => 'folder-open','disabled' => true,'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('category_id'))]); ?>
                                            <option value="">📂 Selecione uma categoria principal primeiro</option>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                                        <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                            Desabilitada até selecionar categoria principal
                                        </p>
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'category_id','label' => 'Subcategoria','icon' => 'folder-open','error' => $errors->first('category_id')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'category_id','label' => 'Subcategoria','icon' => 'folder-open','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('category_id'))]); ?>
                                            <option value="">📂 Nenhuma subcategoria (opcional)</option>
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($parent_category_id)): ?>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->subcategories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($subcat->id); ?>"><?php echo e($subcat->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                                        <p class="mt-1.5 text-xs text-gray-500 flex items-center gap-1">
                                            <i data-lucide="info" class="w-3 h-3"></i>
                                            Opcional: refine com uma subcategoria
                                        </p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                
                                <!-- Marca -->
                                <div class="md:col-span-2">
                                    <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'brand_id','label' => 'Marca / Fabricante','icon' => 'tag']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'brand_id','label' => 'Marca / Fabricante','icon' => 'tag']); ?>
                                        <option value="">🏷️ Sem marca</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($b->id); ?>"><?php echo e($b->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                                    <p class="mt-1.5 text-xs text-gray-500 flex items-center gap-1">
                                        <i data-lucide="info" class="w-3 h-3"></i>
                                        Opcional: adicione a marca do produto
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Preços -->
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="dollar-sign" class="w-4 h-4 text-green-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Preços</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'price','type' => 'number','step' => '0.01','label' => 'Preço de Venda','placeholder' => '0,00','icon' => 'coins','error' => $errors->first('price')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'price','type' => 'number','step' => '0.01','label' => 'Preço de Venda','placeholder' => '0,00','icon' => 'coins','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('price'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>

                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'sale_price','type' => 'number','step' => '0.01','label' => 'Preço Promocional','placeholder' => '0,00','icon' => 'badge-percent','error' => $errors->first('sale_price')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'sale_price','type' => 'number','step' => '0.01','label' => 'Preço Promocional','placeholder' => '0,00','icon' => 'badge-percent','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('sale_price'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>

                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'cost_price','type' => 'number','step' => '0.01','label' => 'Preço de Custo','placeholder' => '0,00','icon' => 'calculator','error' => $errors->first('cost_price')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'cost_price','type' => 'number','step' => '0.01','label' => 'Preço de Custo','placeholder' => '0,00','icon' => 'calculator','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('cost_price'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <!-- Estoque -->
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="package-check" class="w-4 h-4 text-blue-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Controle de Estoque</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'stock_quantity','type' => 'number','min' => '0','label' => 'Quantidade em Estoque','placeholder' => '0','icon' => 'boxes','error' => $errors->first('stock_quantity')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'stock_quantity','type' => 'number','min' => '0','label' => 'Quantidade em Estoque','placeholder' => '0','icon' => 'boxes','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('stock_quantity'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>

                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'low_stock_threshold','type' => 'number','min' => '0','label' => 'Alerta de Estoque Baixo','placeholder' => '10','icon' => 'alert-triangle','error' => $errors->first('low_stock_threshold')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'low_stock_threshold','type' => 'number','min' => '0','label' => 'Alerta de Estoque Baixo','placeholder' => '10','icon' => 'alert-triangle','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('low_stock_threshold'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>

                                <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'stock_status','label' => 'Status de Disponibilidade','icon' => 'activity','error' => $errors->first('stock_status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'stock_status','label' => 'Status de Disponibilidade','icon' => 'activity','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('stock_status'))]); ?>
                                    <option value="in_stock">✅ Em estoque</option>
                                    <option value="out_of_stock">❌ Sem estoque</option>
                                    <option value="on_backorder">⏳ Sob encomenda</option>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'condition','label' => 'Condição','error' => $errors->first('condition')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'condition','label' => 'Condição','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('condition'))]); ?>
                                <option value="new">Novo</option>
                                <option value="used">Usado</option>
                                <option value="refurbished">Recondicionado</option>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'barcode','label' => 'Código de Barras','placeholder' => 'Opcional','error' => $errors->first('barcode')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'barcode','label' => 'Código de Barras','placeholder' => 'Opcional','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('barcode'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal5f8711bac92b9cbfae758724ea0086d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.textarea','data' => ['wire:model' => 'short_description','label' => 'Descrição curta','rows' => '2','placeholder' => 'Resumo do produto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'short_description','label' => 'Descrição curta','rows' => '2','placeholder' => 'Resumo do produto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $attributes = $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $component = $__componentOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal5f8711bac92b9cbfae758724ea0086d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.textarea','data' => ['wire:model' => 'description','label' => 'Descrição','rows' => '5','placeholder' => 'Descrição completa','error' => $errors->first('description')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'description','label' => 'Descrição','rows' => '5','placeholder' => 'Descrição completa','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('description'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $attributes = $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $component = $__componentOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal5f8711bac92b9cbfae758724ea0086d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.textarea','data' => ['wire:model' => 'condition_notes','label' => 'Notas da condição','rows' => '2','placeholder' => 'Opcional']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'condition_notes','label' => 'Notas da condição','rows' => '2','placeholder' => 'Opcional']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $attributes = $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $component = $__componentOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'weight','type' => 'number','step' => '0.01','label' => 'Peso','placeholder' => '0','error' => $errors->first('weight')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'weight','type' => 'number','step' => '0.01','label' => 'Peso','placeholder' => '0','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('weight'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'length','type' => 'number','step' => '0.01','label' => 'Comprimento','placeholder' => '0','error' => $errors->first('length')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'length','type' => 'number','step' => '0.01','label' => 'Comprimento','placeholder' => '0','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('length'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'width','type' => 'number','step' => '0.01','label' => 'Largura','placeholder' => '0','error' => $errors->first('width')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'width','type' => 'number','step' => '0.01','label' => 'Largura','placeholder' => '0','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('width'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'height','type' => 'number','step' => '0.01','label' => 'Altura','placeholder' => '0','error' => $errors->first('height')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'height','type' => 'number','step' => '0.01','label' => 'Altura','placeholder' => '0','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('height'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                        </div>

                        <!-- Imagens e Toggles -->
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="images" class="w-4 h-4 text-purple-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Imagens do Produto</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Imagem Principal</label>
                                    
                                    <!-- Preview da Imagem Atual -->
                                    <!--[if BLOCK]><![endif]--><?php if($currentFeaturedImage): ?>
                                        <div class="mb-4 relative group">
                                            <img src="<?php echo e(asset('storage/' . $currentFeaturedImage)); ?>" 
                                                 class="w-full h-48 rounded-xl object-cover border-2 border-gray-200" 
                                                 alt="Imagem atual">
                                            <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-lg flex items-center gap-1">
                                                <i data-lucide="check" class="w-3 h-3"></i>
                                                Atual
                                            </div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <!-- Upload Area -->
                                    <div class="relative">
                                        <input type="file" 
                                               wire:model="featuredImageUpload" 
                                               accept="image/*" 
                                               id="featured-image-upload"
                                               class="hidden">
                                        <label for="featured-image-upload" 
                                               class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-white hover:bg-gray-50 transition-all group">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i data-lucide="upload-cloud" class="w-10 h-10 text-gray-400 group-hover:text-primary-500 transition-colors mb-2"></i>
                                                <p class="mb-1 text-sm text-gray-600 font-medium">
                                                    <span class="text-primary-600">Clique para escolher</span> ou arraste aqui
                                                </p>
                                                <p class="text-xs text-gray-500">PNG, JPG, WEBP (max. 2MB)</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['featuredImageUpload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <p class="text-xs text-red-600 mt-2 flex items-center gap-1">
                                            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                            <?php echo e($message); ?>

                                        </p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <div wire:loading wire:target="featuredImageUpload" class="mt-2 flex items-center gap-2 text-sm text-primary-600">
                                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                        Carregando imagem...
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                        <p class="text-xs font-semibold text-gray-700 mb-3 flex items-center gap-1">
                                            <i data-lucide="settings-2" class="w-3.5 h-3.5"></i>
                                            Configurações
                                        </p>
                                        <div class="space-y-3">
                                            <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'is_active','label' => 'Ativo','hint' => 'Exibir na loja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'is_active','label' => 'Ativo','hint' => 'Exibir na loja']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'is_featured','label' => 'Destaque','hint' => 'Aparece em seções especiais']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'is_featured','label' => 'Destaque','hint' => 'Aparece em seções especiais']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'manage_stock','label' => 'Gerir estoque','hint' => 'Controlar estoque automaticamente']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'manage_stock','label' => 'Gerir estoque','hint' => 'Controlar estoque automaticamente']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Galeria -->
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-200">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="image-plus" class="w-4 h-4 text-orange-600"></i>
                                <h4 class="text-sm font-semibold text-gray-900">Galeria de Imagens <span class="text-gray-500 font-normal">(opcional)</span></h4>
                            </div>
                            
                            <!-- Preview das Imagens Atuais -->
                            <!--[if BLOCK]><![endif]--><?php if(!empty($currentImages)): ?>
                                <div class="mb-4 grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="relative group">
                                            <img src="<?php echo e(asset('storage/' . $img)); ?>" 
                                                 class="w-full h-20 rounded-lg object-cover border-2 border-gray-200 group-hover:border-primary-400 transition-colors" 
                                                 alt="Galeria">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 rounded-lg transition-opacity flex items-center justify-center">
                                                <i data-lucide="eye" class="w-5 h-5 text-white"></i>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <!-- Upload Area -->
                            <div class="relative">
                                <input type="file" 
                                       wire:model="galleryUploads" 
                                       accept="image/*" 
                                       multiple
                                       id="gallery-upload"
                                       class="hidden">
                                <label for="gallery-upload" 
                                       class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-white hover:bg-gray-50 transition-all group">
                                    <div class="flex flex-col items-center justify-center">
                                        <i data-lucide="images" class="w-8 h-8 text-gray-400 group-hover:text-orange-500 transition-colors mb-2"></i>
                                        <p class="mb-1 text-sm text-gray-600 font-medium">
                                            <span class="text-orange-600">Adicionar múltiplas imagens</span>
                                        </p>
                                        <p class="text-xs text-gray-500">Clique ou arraste várias imagens aqui</p>
                                    </div>
                                </label>
                            </div>
                            
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['galleryUploads.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <p class="text-xs text-red-600 mt-2 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                    <?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <div wire:loading wire:target="galleryUploads" class="mt-2 flex items-center gap-2 text-sm text-orange-600">
                                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                Carregando imagens da galeria...
                            </div>
                        </div>

                        <div class="sticky bottom-0 -mx-6 -mb-6 px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl flex justify-between items-center">
                            <div wire:loading wire:target="saveProduct" class="text-sm text-primary-600 flex items-center gap-2">
                                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                Salvando...
                            </div>
                            <div class="flex gap-3">
                                <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'button','variant' => 'outline','wire:click' => 'closeModal','icon' => 'x']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'outline','wire:click' => 'closeModal','icon' => 'x']); ?>
                                    Cancelar
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => ''.e($editingId ? 'check' : 'plus').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => ''.e($editingId ? 'check' : 'plus').'']); ?>
                                    <?php echo e($editingId ? 'Atualizar Produto' : 'Criar Produto'); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\superloja\resources\views/livewire/admin/products/index-spa.blade.php ENDPATH**/ ?>