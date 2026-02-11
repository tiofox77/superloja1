<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconRight' => null,
    'loading' => false,
    'disabled' => false,
    'href' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconRight' => null,
    'loading' => false,
    'disabled' => false,
    'href' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-primary-500 hover:bg-primary-600 text-white focus:ring-primary-500 shadow-sm',
        'secondary' => 'bg-secondary-500 hover:bg-secondary-600 text-white focus:ring-secondary-500 shadow-sm',
        'outline' => 'border-2 border-gray-300 hover:border-gray-400 text-gray-700 hover:bg-gray-50 focus:ring-gray-500',
        'ghost' => 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:ring-gray-500',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white focus:ring-red-500 shadow-sm',
        'success' => 'bg-green-500 hover:bg-green-600 text-white focus:ring-green-500 shadow-sm',
    ];
    
    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-5 py-3 text-base',
        'xl' => 'px-6 py-3.5 text-base',
    ];
    
    $iconSizes = [
        'xs' => 'w-3.5 h-3.5',
        'sm' => 'w-4 h-4',
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
        'xl' => 'w-5 h-5',
    ];
    
    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
?>

<!--[if BLOCK]><![endif]--><?php if($href): ?>
    <a href="<?php echo e($href); ?>" wire:navigate <?php echo e($attributes->merge(['class' => $classes])); ?>>
        <!--[if BLOCK]><![endif]--><?php if($icon): ?>
            <i data-lucide="<?php echo e($icon); ?>" class="<?php echo e($iconSizes[$size]); ?>"></i>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php echo e($slot); ?>

        <!--[if BLOCK]><![endif]--><?php if($iconRight): ?>
            <i data-lucide="<?php echo e($iconRight); ?>" class="<?php echo e($iconSizes[$size]); ?>"></i>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" 
            <?php echo e($disabled ? 'disabled' : ''); ?>

            <?php echo e($attributes->merge(['class' => $classes])); ?>>
        <!--[if BLOCK]><![endif]--><?php if($loading): ?>
            <svg class="animate-spin <?php echo e($iconSizes[$size]); ?>" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        <?php elseif($icon): ?>
            <i data-lucide="<?php echo e($icon); ?>" class="<?php echo e($iconSizes[$size]); ?>"></i>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php echo e($slot); ?>

        <!--[if BLOCK]><![endif]--><?php if($iconRight && !$loading): ?>
            <i data-lucide="<?php echo e($iconRight); ?>" class="<?php echo e($iconSizes[$size]); ?>"></i>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </button>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/ui/button.blade.php ENDPATH**/ ?>