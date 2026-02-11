<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => null,
    'hint' => null,
    'error' => null,
    'rows' => 4
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
    'rows' => 4
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
    
    <textarea rows="<?php echo e($rows); ?>" <?php echo e($attributes->except('class')->merge([
        'class' => 'block w-full rounded-lg border-gray-300 shadow-sm 
                   focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20
                   transition-all text-sm resize-none py-2.5 px-3.5
                   placeholder:text-gray-400
                   disabled:bg-gray-50 disabled:text-gray-500
                   ' . ($error ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '')
    ])); ?>><?php echo e($slot); ?></textarea>
    
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
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/form/textarea.blade.php ENDPATH**/ ?>