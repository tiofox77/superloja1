<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => null,
    'hint' => null,
    'error' => null,
    'icon' => null,
    'iconRight' => null,
    'prefix' => null,
    'suffix' => null
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
    'label' => null,
    'hint' => null,
    'error' => null,
    'icon' => null,
    'iconRight' => null,
    'prefix' => null,
    'suffix' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->only('class')->merge(['class' => 'space-y-2'])); ?>>
    <!--[if BLOCK]><![endif]--><?php if($label): ?>
        <label class="block text-sm font-semibold text-gray-700">
            <?php echo e($label); ?>

        </label>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <div class="relative">
        <!--[if BLOCK]><![endif]--><?php if($icon): ?>
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i data-lucide="<?php echo e($icon); ?>" class="w-4.5 h-4.5 text-gray-500"></i>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        
        <!--[if BLOCK]><![endif]--><?php if($prefix): ?>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm"><?php echo e($prefix); ?></span>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        
        <input <?php echo e($attributes->except('class')->merge([
            'class' => 'block w-full rounded-lg border-gray-300 shadow-sm 
                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20
                       transition-all text-sm py-2.5
                       placeholder:text-gray-400
                       disabled:bg-gray-50 disabled:text-gray-500
                       ' . ($icon ? 'pl-11' : 'pl-3.5') . ' ' . ($prefix ? 'pl-12' : '') . '
                       ' . ($iconRight ? 'pr-10' : 'pr-3.5') . ' ' . ($suffix ? 'pr-12' : '') . '
                       ' . ($error ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '')
        ])); ?>>
        
        <!--[if BLOCK]><![endif]--><?php if($iconRight): ?>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i data-lucide="<?php echo e($iconRight); ?>" class="w-5 h-5 text-gray-400"></i>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        
        <!--[if BLOCK]><![endif]--><?php if($suffix): ?>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm"><?php echo e($suffix); ?></span>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    
    <!--[if BLOCK]><![endif]--><?php if($hint && !$error): ?>
        <p class="text-xs text-gray-500"><?php echo e($hint); ?></p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <!--[if BLOCK]><![endif]--><?php if($error): ?>
        <p class="text-xs text-red-600 flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
            <?php echo e($error); ?>

        </p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/form/input.blade.php ENDPATH**/ ?>