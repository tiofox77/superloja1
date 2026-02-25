<div class="min-h-screen bg-gradient-to-br from-green-50 via-pink-50 to-emerald-50">
    <!-- Hero Section with Enhanced Design -->
    <div class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="wellness-pattern" patternUnits="userSpaceOnUse" width="80" height="80">
                        <circle cx="40" cy="40" r="2" fill="currentColor" opacity="0.3"/>
                        <path d="M20,40 Q40,20 60,40 Q40,60 20,40" fill="none" stroke="currentColor" stroke-width="1" opacity="0.2"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#wellness-pattern)" class="text-green-600"/>
            </svg>
        </div>
        
        <!-- Gradient Background -->
        <div class="bg-gradient-to-br from-green-400 via-emerald-500 to-teal-500 text-white py-20 relative">
            <!-- Floating Elements -->
            <div class="absolute top-10 left-10 animate-bounce delay-1000">
                <div class="w-4 h-4 bg-pink-300 rounded-full opacity-60"></div>
            </div>
            <div class="absolute top-20 right-20 animate-pulse">
                <div class="w-3 h-3 bg-green-300 rounded-full opacity-70"></div>
            </div>
            <div class="absolute bottom-20 left-1/4 animate-bounce delay-500">
                <div class="w-2 h-2 bg-emerald-300 rounded-full opacity-50"></div>
            </div>
            
            <div class="container mx-auto px-4 text-center relative z-10">
                <!-- Icon with Animation -->
                <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm animate-pulse">
                    <span class="text-4xl">🌿</span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-white to-green-100 bg-clip-text text-transparent">
                    Saúde & Bem-estar
                </h1>
                
                <p class="text-xl md:text-2xl text-green-50 max-w-4xl mx-auto mb-8 leading-relaxed">
                    ✨ Descubra o poder da natureza para o seu bem-estar ✨<br>
                    <span class="text-lg opacity-90">Produtos naturais, aromaterapia, suplementos e cuidados holísticos para uma vida mais saudável</span>
                </p>
                
                <!-- Wellness Icons -->
                <div class="flex justify-center space-x-8 text-2xl opacity-80">
                    <span class="animate-bounce delay-100">🌸</span>
                    <span class="animate-bounce delay-200">🍃</span>
                    <span class="animate-bounce delay-300">💆‍♀️</span>
                    <span class="animate-bounce delay-400">🧘‍♀️</span>
                    <span class="animate-bounce delay-500">🌿</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filters Section -->
    <div class="bg-gradient-to-r from-white via-green-50 to-pink-50 shadow-xl border-t-4 border-green-300 sticky top-0 z-40 backdrop-blur-sm">
        <div class="container mx-auto px-4 py-6">
            <!-- Filters Header -->
            <div class="flex items-center justify-center mb-4">
                <div class="flex items-center space-x-2 text-green-700">
                    <span class="text-lg">🔍</span>
                    <h3 class="font-semibold text-lg">Encontre o produto perfeito para você</h3>
                    <span class="text-lg">🌿</span>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-4 justify-center">
                
                <!-- Enhanced Category Filter -->
                <div class="flex items-center space-x-3 bg-gradient-to-r from-white to-green-50 rounded-full px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-green-200 hover:border-green-300">
                    <span class="text-green-600 text-lg">📋</span>
                    <label class="text-sm font-semibold text-green-700">Categoria:</label>
                    <div class="relative">
                        <select wire:model.live="selectedCategory" class="appearance-none bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl px-4 py-2 pr-8 text-sm font-medium text-gray-800 cursor-pointer focus:ring-2 focus:ring-green-400 focus:border-green-400 hover:bg-green-100 transition-all duration-200 min-w-[140px]">
                            <option value="">✨ Todas</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subcategory->id); ?>"><?php echo e($subcategory->name); ?> (<?php echo e($subcategory->products_count); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!-- Custom Arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Brand Filter -->
                <div class="flex items-center space-x-3 bg-gradient-to-r from-white to-pink-50 rounded-full px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-pink-200 hover:border-pink-300">
                    <span class="text-pink-600 text-lg">🏷️</span>
                    <label class="text-sm font-semibold text-green-700">Marca:</label>
                    <div class="relative">
                        <select wire:model.live="selectedBrand" class="appearance-none bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-300 rounded-xl px-4 py-2 pr-8 text-sm font-medium text-gray-800 cursor-pointer focus:ring-2 focus:ring-pink-400 focus:border-pink-400 hover:bg-pink-100 transition-all duration-200 min-w-[120px]">
                            <option value="">🌟 Todas</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!-- Custom Arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sort Filter -->
                <div class="flex items-center space-x-3 bg-gradient-to-r from-white to-emerald-50 rounded-full px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-emerald-200 hover:border-emerald-300">
                    <span class="text-emerald-600 text-lg">⚡</span>
                    <label class="text-sm font-semibold text-green-700">Ordenar:</label>
                    <div class="relative">
                        <select wire:model.live="sortBy" class="appearance-none bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-300 rounded-xl px-4 py-2 pr-8 text-sm font-medium text-gray-800 cursor-pointer focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 hover:bg-emerald-100 transition-all duration-200 min-w-[130px]">
                            <option value="name">🔤 Nome (A-Z)</option>
                            <option value="price-low">💰 Menor preço</option>
                            <option value="price-high">💎 Maior preço</option>
                            <option value="newest">🆕 Mais recentes</option>
                        </select>
                        <!-- Custom Arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 rounded-full shadow-lg">
                    <div class="flex items-center space-x-2 text-sm font-medium">
                        <span>✨</span>
                        <span><?php echo e($products->total()); ?> produtos encontrados</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="container mx-auto px-4 py-8">
        <!--[if BLOCK]><![endif]--><?php if($products && $products->count() > 0): ?>
            <!-- Enhanced Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group relative bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-green-100">
                        <!-- Decorative Top Border -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-400 via-pink-400 to-emerald-400"></div>
                        
                        <!-- Product Image -->
                        <div class="relative group/image">
                            <!--[if BLOCK]><![endif]--><?php if($product->featured_image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->featured_image)); ?>" 
                                     alt="<?php echo e($product->name); ?>" 
                                     class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-52 bg-gradient-to-br from-green-100 to-pink-100 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-4xl mb-2">🌿</div>
                                        <svg class="w-12 h-12 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Floating Wishlist Button -->
                            <button wire:click="toggleWishlist(<?php echo e($product->id); ?>)" 
                                    class="absolute top-4 right-4 p-3 rounded-full backdrop-blur-md transition-all duration-300 <?php echo e($this->isInWishlist($product->id) ? 'bg-pink-500/90 text-white shadow-pink-200' : 'bg-white/90 text-pink-500 hover:bg-pink-50 hover:text-pink-600'); ?> shadow-lg hover:shadow-xl transform hover:scale-110">
                                <svg class="w-5 h-5" fill="<?php echo e($this->isInWishlist($product->id) ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>

                            <!-- Overlay with Aromathic Effect -->
                            <div class="absolute inset-0 bg-gradient-to-t from-green-600/20 via-transparent to-pink-400/10 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                                <button wire:click="viewProduct(<?php echo e($product->id); ?>)" 
                                        class="bg-white/95 text-green-700 px-6 py-3 rounded-full hover:bg-white transition-colors shadow-lg backdrop-blur-sm font-medium flex items-center space-x-2 transform scale-95 group-hover:scale-100 transition-transform duration-300">
                                    <span>✨</span>
                                    <span>Ver detalhes</span>
                                    <span>🌿</span>
                                </button>
                            </div>

                            <!-- Enhanced Sale Badge -->
                            <!--[if BLOCK]><![endif]--><?php if($product->sale_price && $product->sale_price < $product->price): ?>
                                <?php
                                    $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                                ?>
                                <div class="absolute top-4 left-4 bg-gradient-to-r from-pink-500 to-red-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
                                    <span class="flex items-center space-x-1">
                                        <span>🔥</span>
                                        <span>-<?php echo e($discount); ?>%</span>
                                    </span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Enhanced Product Info -->
                        <div class="p-6 bg-gradient-to-br from-white via-green-50/30 to-pink-50/20">
                            <!-- Category with Icon -->
                            <!--[if BLOCK]><![endif]--><?php if($product->category): ?>
                                <div class="flex items-center space-x-1 mb-3">
                                    <span class="text-xs">🏷️</span>
                                    <span class="text-xs text-green-700 font-semibold bg-green-100 px-2 py-1 rounded-full">
                                        <?php echo e($product->category->name); ?>

                                    </span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Product Name with Emphasis -->
                            <h3 class="font-bold text-gray-800 mt-1 mb-3 line-clamp-2 text-lg leading-tight group-hover:text-green-700 transition-colors duration-300">
                                <?php echo e($product->name); ?>

                            </h3>

                            <!-- Brand with Styling -->
                            <!--[if BLOCK]><![endif]--><?php if($product->brand): ?>
                                <div class="flex items-center space-x-1 mb-4">
                                    <span class="text-xs">✨</span>
                                    <p class="text-sm text-gray-600 font-medium"><?php echo e($product->brand->name); ?></p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Enhanced Price Section -->
                            <div class="mb-4">
                                <!--[if BLOCK]><![endif]--><?php if($product->sale_price && $product->sale_price < $product->price): ?>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xl font-bold text-green-600 flex items-center">
                                            💰 <?php echo e(number_format($product->sale_price, 2, ',', '.')); ?> AOA
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-500 line-through">
                                        Era <?php echo e(number_format($product->price, 2, ',', '.')); ?> AOA
                                    </span>
                                <?php else: ?>
                                    <span class="text-xl font-bold text-gray-800 flex items-center">
                                        💰 <?php echo e(number_format($product->price, 2, ',', '.')); ?> AOA
                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Enhanced Add to Cart Button -->
                            <button wire:click="addToCart(<?php echo e($product->id); ?>)" 
                                    class="w-full bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 text-white py-3 px-4 rounded-2xl hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center space-x-2 group/cart">
                                <span class="group-hover/cart:animate-bounce">🛒</span>
                                <span>Adicionar ao Carrinho</span>
                                <span class="group-hover/cart:animate-pulse">✨</span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($products->links()); ?>

            </div>
        <?php else: ?>
            <!-- Enhanced No Products Found -->
            <div class="text-center py-20">
                <!-- Aromathic Background -->
                <div class="relative">
                    <!-- Floating Aromathic Elements -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 flex space-x-8 animate-pulse">
                        <span class="text-2xl opacity-60 animate-bounce delay-100">🌸</span>
                        <span class="text-2xl opacity-70 animate-bounce delay-200">🍃</span>
                        <span class="text-2xl opacity-60 animate-bounce delay-300">🌿</span>
                    </div>
                    
                    <!-- Main Icon -->
                    <div class="w-32 h-32 bg-gradient-to-br from-green-100 via-pink-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl border-4 border-green-200 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-200/30 to-pink-200/30 animate-pulse"></div>
                        <div class="relative text-center">
                            <div class="text-4xl mb-2">🔍</div>
                            <div class="text-2xl">🌿</div>
                        </div>
                    </div>
                </div>
                
                <h3 class="text-3xl font-bold text-gray-800 mb-4">✨ Produto não encontrado ✨</h3>
                <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
                    🌸 Que tal ajustar os filtros ou solicitar um produto especial para você? 🌸
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button wire:click="$set('selectedCategory', '')" 
                            class="bg-gradient-to-r from-pink-400 to-rose-400 text-white px-8 py-4 rounded-2xl hover:from-pink-500 hover:to-rose-500 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center space-x-2">
                        <span>🔄</span>
                        <span>Limpar Filtros</span>
                        <span>✨</span>
                    </button>
                    
                    <a href="<?php echo e(route('product-request')); ?>" 
                       class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-8 py-4 rounded-2xl hover:from-green-600 hover:to-emerald-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 inline-flex items-center justify-center space-x-2">
                        <span>🌿</span>
                        <span>Solicitar Produto</span>
                        <span>💫</span>
                    </a>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Enhanced Aromathic Product Detail Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showModal && $selectedProduct): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show">
            <!-- Enhanced Background with Aromathic Effect -->
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gradient-to-br from-green-900/80 via-emerald-900/80 to-teal-900/80 backdrop-blur-sm" wire:click="closeModal"></div>

                <!-- Compact Modal Content -->
                <div class="inline-block w-full max-w-3xl p-0 my-4 overflow-hidden text-left align-middle transition-all transform bg-gradient-to-br from-white via-green-50/30 to-pink-50/20 shadow-2xl rounded-2xl border-2 border-green-200">
                    <!-- Decorative Top Border -->
                    <div class="h-1 bg-gradient-to-r from-green-400 via-emerald-400 via-pink-400 to-teal-400"></div>
                    
                    <!-- Enhanced Close Button -->
                    <button wire:click="closeModal" class="absolute top-3 right-3 p-1.5 bg-white/90 backdrop-blur-sm text-gray-600 hover:text-gray-800 hover:bg-white rounded-full shadow-md transition-all duration-200 z-10 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    <!-- Compact Floating Elements -->
                    <div class="absolute top-2 left-2 animate-pulse opacity-20">
                        <span class="text-lg">🌸</span>
                    </div>
                    <div class="absolute top-3 right-12 animate-pulse delay-500 opacity-20">
                        <span class="text-sm">✨</span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 p-4">
                        <!-- Compact Product Images Section -->
                        <div class="relative">
                            <!--[if BLOCK]><![endif]--><?php if(count($currentImages) > 0): ?>
                                <div class="mb-3 relative group">
                                    <img src="<?php echo e(asset('storage/' . $currentImages[$mainImageIndex])); ?>" 
                                         alt="<?php echo e($selectedProduct->name); ?>" 
                                         class="w-full h-64 object-cover rounded-xl shadow-lg border-2 border-green-100 group-hover:shadow-xl transition-all duration-300">
                                    <!-- Image Overlay Effect -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-green-600/5 via-transparent to-pink-400/5 rounded-xl"></div>
                                </div>
                                <?php if(count($currentImages) > 1): ?>
                                    <div class="flex space-x-2 overflow-x-auto pb-1">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $currentImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button wire:click="setMainImage(<?php echo e($index); ?>)" 
                                                    class="flex-shrink-0 w-12 h-12 rounded-lg overflow-hidden border-2 transition-all duration-200 <?php echo e($index === $mainImageIndex ? 'border-green-400 shadow-md scale-105' : 'border-green-200 hover:border-green-300'); ?>">
                                                <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Imagem <?php echo e($index + 1); ?>" class="w-full h-full object-cover">
                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                <div class="w-full h-64 bg-gradient-to-br from-green-100 via-pink-100 to-emerald-100 rounded-xl flex items-center justify-center shadow-lg border-2 border-green-100">
                                    <div class="text-center">
                                        <div class="text-3xl mb-2">🌿</div>
                                        <svg class="w-12 h-12 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Compact Product Details Section -->
                        <div class="space-y-3">
                            <!-- Compact Header Section -->
                            <div class="bg-gradient-to-r from-green-50 to-pink-50 rounded-xl p-3 border border-green-200">
                                <!--[if BLOCK]><![endif]--><?php if($selectedProduct->category): ?>
                                    <div class="flex items-center space-x-1 mb-2">
                                        <span class="text-xs">🏷️</span>
                                        <span class="text-xs text-green-700 font-semibold bg-green-100 px-2 py-0.5 rounded-full">
                                            <?php echo e($selectedProduct->category->name); ?>

                                        </span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                
                                <h2 class="text-xl font-bold text-gray-800 leading-tight mb-1">
                                    <?php echo e($selectedProduct->name); ?>

                                </h2>
                                
                                <!--[if BLOCK]><![endif]--><?php if($selectedProduct->brand): ?>
                                    <div class="flex items-center space-x-1">
                                        <span class="text-sm">✨</span>
                                        <p class="text-sm text-gray-600 font-medium"><?php echo e($selectedProduct->brand->name); ?></p>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Compact Price Section -->
                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-3 border border-emerald-200">
                                <div class="flex items-center space-x-2 mb-1">
                                    <span class="text-lg">💰</span>
                                    <h3 class="text-sm font-semibold text-gray-800">Preço</h3>
                                </div>
                                
                                <!--[if BLOCK]><![endif]--><?php if($selectedProduct->sale_price && $selectedProduct->sale_price < $selectedProduct->price): ?>
                                    <div class="space-y-1">
                                        <span class="text-2xl font-bold text-green-600 block">
                                            <?php echo e(number_format($this->finalPrice, 2, ',', '.')); ?> AOA
                                        </span>
                                        <span class="text-sm text-gray-500 line-through">
                                            Era <?php echo e(number_format($selectedProduct->price, 2, ',', '.')); ?> AOA
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-2xl font-bold text-gray-800 block">
                                        <?php echo e(number_format($this->finalPrice, 2, ',', '.')); ?> AOA
                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Compact Description -->
                            <!--[if BLOCK]><![endif]--><?php if($selectedProduct->description): ?>
                                <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-3 border border-pink-200">
                                    <div class="flex items-center space-x-1 mb-2">
                                        <span class="text-sm">📝</span>
                                        <h3 class="font-bold text-gray-800 text-sm">Descrição</h3>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed text-sm"><?php echo e(Str::limit($selectedProduct->description, 120)); ?></p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Compact Specifications -->
                            <!--[if BLOCK]><![endif]--><?php if($selectedProduct->specifications): ?>
                                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl p-3 border border-teal-200">
                                    <div class="flex items-center space-x-1 mb-2">
                                        <span class="text-sm">⚙️</span>
                                        <h3 class="font-bold text-gray-800 text-sm">Especificações</h3>
                                    </div>
                                    <div class="space-y-1">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = array_slice($selectedProduct->specifications, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex justify-between items-center py-1 px-2 bg-white/60 rounded-lg border border-teal-100">
                                                <span class="text-xs font-medium text-gray-700"><?php echo e($key); ?>:</span>
                                                <span class="text-xs font-bold text-gray-900"><?php echo e($value); ?></span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <!-- Compact Action Buttons -->
                            <div class="flex space-x-2 pt-2">
                                <button wire:click="addToCart(<?php echo e($selectedProduct->id); ?>)" 
                                        class="flex-1 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 text-white py-2 px-4 rounded-xl hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 transition-all duration-300 font-semibold text-sm shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center space-x-1">
                                    <span>🛒</span>
                                    <span>Carrinho</span>
                                    <span>✨</span>
                                </button>
                                
                                <button wire:click="toggleWishlist(<?php echo e($selectedProduct->id); ?>)" 
                                        class="p-2 rounded-xl border-2 transition-all duration-300 <?php echo e($this->isInWishlist($selectedProduct->id) ? 'border-pink-500 bg-pink-100 text-pink-600 shadow-pink-200' : 'border-pink-300 hover:border-pink-500 hover:bg-pink-50 hover:text-pink-600'); ?> shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="<?php echo e($this->isInWishlist($selectedProduct->id) ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\superloja\resources\views/livewire/pages/health-wellness.blade.php ENDPATH**/ ?>