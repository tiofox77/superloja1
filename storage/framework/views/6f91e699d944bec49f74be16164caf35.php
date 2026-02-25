<div>
    <!--[if BLOCK]><![endif]--><?php if($isOpen && $product): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/50 transition-opacity" wire:click="closeModal"></div>

        <!-- Modal content -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <!-- Close button -->
                <button wire:click="closeModal" 
                        class="absolute top-4 right-4 z-10 text-gray-400 hover:text-gray-600 bg-white rounded-full p-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="grid md:grid-cols-2 gap-0 max-h-[90vh] overflow-y-auto">
                    <!-- Product Image -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center min-h-[400px] md:min-h-[600px] relative">
                        <!--[if BLOCK]><![endif]--><?php if($product->featured_image): ?>
                            <img src="<?php echo e($product->featured_image); ?>" alt="<?php echo e($product->name); ?>" class="max-w-full max-h-full object-contain">
                        <?php else: ?>
                            <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!-- Discount Badge -->
                        <!--[if BLOCK]><![endif]--><?php if($product->sale_price && $product->sale_price > 0): ?>
                            <?php
                                $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                            ?>
                            <div class="absolute top-6 left-6">
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full font-bold">
                                    -<?php echo e($discount); ?>% OFF
                                </span>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!-- Category Badge -->
                        <div class="absolute top-6 right-6">
                            <span class="bg-orange-500 text-white px-3 py-1 rounded-full font-medium">
                                <?php echo e($product->category->name ?? 'Sem categoria'); ?>

                            </span>
                        </div>
                        
                        <!-- Condition Badge -->
                        <!--[if BLOCK]><![endif]--><?php if($product->condition !== 'new'): ?>
                            <div class="absolute bottom-6 left-6">
                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full font-medium capitalize">
                                    <?php echo e($product->condition === 'used' ? 'Usado' : ($product->condition === 'refurbished' ? 'Recondicionado' : $product->condition)); ?>

                                </span>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Product Details -->
                    <div class="p-6 md:p-8">
                        <!-- Header -->
                        <div class="mb-6">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">
                                <?php echo e($product->name); ?>

                            </h1>
                            
                            <!-- Brand -->
                            <!--[if BLOCK]><![endif]--><?php if($product->brand): ?>
                                <p class="text-sm text-gray-600 mb-2">
                                    <span class="font-medium">Marca:</span> <?php echo e($product->brand->name); ?>

                                </p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <!-- SKU -->
                            <p class="text-xs text-gray-500 mb-4">SKU: <?php echo e($product->sku); ?></p>
                            
                            <!-- Rating -->
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 5; $i++): ?>
                                        <!--[if BLOCK]><![endif]--><?php if($i < floor($product->rating_average)): ?>
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        <?php else: ?>
                                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <span class="text-sm text-gray-600"><?php echo e(number_format($product->rating_average, 1)); ?> (<?php echo e($product->rating_count); ?> avaliações)</span>
                            </div>
                            
                            <!-- Price -->
                            <div class="mb-6">
                                <div class="flex items-center space-x-3">
                                    <span class="text-3xl md:text-4xl font-bold text-orange-500">
                                        <?php echo e(number_format($product->sale_price ?? $product->price, 0, ',', '.')); ?> Kz
                                    </span>
                                    <!--[if BLOCK]><![endif]--><?php if($product->sale_price && $product->sale_price > 0): ?>
                                        <span class="text-lg text-gray-500 line-through">
                                            <?php echo e(number_format($product->price, 0, ',', '.')); ?> Kz
                                        </span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="flex items-center mt-2 space-x-4">
                                    <!--[if BLOCK]><![endif]--><?php if($product->stock_quantity > 0): ?>
                                        <p class="text-sm text-green-600">✓ Em stock (<?php echo e($product->stock_quantity); ?> unidades)</p>
                                    <?php else: ?>
                                        <p class="text-sm text-red-600">✗ Fora de stock</p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <!--[if BLOCK]><![endif]--><?php if($product->stock_quantity <= $product->low_stock_threshold && $product->stock_quantity > 0): ?>
                                        <p class="text-sm text-yellow-600">⚠ Últimas unidades</p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Descrição</h3>
                            <p class="text-gray-600 leading-relaxed"><?php echo e($product->description); ?></p>
                            <!--[if BLOCK]><![endif]--><?php if($product->short_description): ?>
                                <p class="text-sm text-gray-500 mt-2 italic"><?php echo e($product->short_description); ?></p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Condition Notes -->
                        <!--[if BLOCK]><![endif]--><?php if($product->condition_notes): ?>
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Observações sobre o Estado</h3>
                                <p class="text-gray-600 leading-relaxed"><?php echo e($product->condition_notes); ?></p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Attributes -->
                        <!--[if BLOCK]><![endif]--><?php if($product->attributes): ?>
                            <?php
                                $attributes = is_string($product->attributes) ? json_decode($product->attributes, true) : $product->attributes;
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if($attributes && is_array($attributes)): ?>
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Características</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="text-gray-600 capitalize"><?php echo e(str_replace('_', ' ', $key)); ?></span>
                                                <span class="font-medium text-gray-900"><?php echo e($value); ?></span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Specifications -->
                        <!--[if BLOCK]><![endif]--><?php if($product->specifications): ?>
                            <?php
                                $specifications = is_string($product->specifications) ? json_decode($product->specifications, true) : $product->specifications;
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if($specifications && is_array($specifications)): ?>
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Especificações Técnicas</h3>
                                    <div class="grid grid-cols-1 gap-3">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="text-gray-600 capitalize"><?php echo e(str_replace('_', ' ', $spec)); ?></span>
                                                <span class="font-medium text-gray-900"><?php echo e($value); ?></span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Product Variants -->
                        <!--[if BLOCK]><![endif]--><?php if($product->variants && $product->variants->count() > 0): ?>
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Variações Disponíveis</h3>
                                <div class="space-y-3">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $product->variants->groupBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variantName => $variants): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-700 mb-2"><?php echo e($variantName); ?></h4>
                                            <div class="flex flex-wrap gap-2">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                                        <?php echo e($variant->value); ?>

                                                        <!--[if BLOCK]><![endif]--><?php if($variant->price_adjustment != 0): ?>
                                                            <span class="text-orange-500">
                                                                (<?php echo e($variant->price_adjustment > 0 ? '+' : ''); ?><?php echo e(number_format($variant->price_adjustment, 0, ',', '.')); ?> Kz)
                                                            </span>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Physical Dimensions -->
                        <!--[if BLOCK]><![endif]--><?php if($product->weight || $product->length || $product->width || $product->height): ?>
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Dimensões e Peso</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <!--[if BLOCK]><![endif]--><?php if($product->weight): ?>
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Peso</span>
                                            <span class="font-medium text-gray-900"><?php echo e(number_format($product->weight / 1000, 2)); ?> kg</span>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($product->length): ?>
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Comprimento</span>
                                            <span class="font-medium text-gray-900"><?php echo e($product->length); ?> cm</span>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($product->width): ?>
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Largura</span>
                                            <span class="font-medium text-gray-900"><?php echo e($product->width); ?> cm</span>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($product->height): ?>
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Altura</span>
                                            <span class="font-medium text-gray-900"><?php echo e($product->height); ?> cm</span>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <!--[if BLOCK]><![endif]--><?php if($product->stock_quantity > 0): ?>
                                <button wire:click="addToCart" 
                                        class="w-full bg-orange-500 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:bg-orange-600 transition-colors">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7H6l-1-7z"></path>
                                    </svg>
                                    Adicionar ao Carrinho
                                </button>
                            <?php else: ?>
                                <button disabled 
                                        class="w-full bg-gray-400 text-white py-4 px-6 rounded-lg font-semibold text-lg cursor-not-allowed">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Fora de Stock
                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <button wire:click="addToWishlist" 
                                    class="w-full text-orange-500 border-2 border-orange-500 py-3 px-6 rounded-lg font-semibold hover:bg-orange-50 transition-colors">
                                💝 Adicionar aos Favoritos
                            </button>
                            
                            <!-- Additional Info -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-medium">Visualizações:</span> <?php echo e(number_format($product->view_count)); ?>

                                    </div>
                                    <div>
                                        <span class="font-medium">Vendidos:</span> <?php echo e(number_format($product->order_count)); ?>

                                    </div>
                                </div>
                                
                                <!--[if BLOCK]><![endif]--><?php if($product->is_digital): ?>
                                    <div class="mt-2 p-2 bg-blue-50 rounded-lg">
                                        <p class="text-sm text-blue-700">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                            </svg>
                                            Produto digital - Download imediato após compra
                                        </p>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\superloja\resources\views/livewire/components/product-modal.blade.php ENDPATH**/ ?>