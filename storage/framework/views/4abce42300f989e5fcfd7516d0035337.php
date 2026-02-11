<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'actions' => null,
    'padding' => true,
    'hover' => false
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
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'actions' => null,
    'padding' => true,
    'hover' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-200 shadow-sm ' . ($hover ? 'card-hover' : '')])); ?>>
    <!--[if BLOCK]><![endif]--><?php if($title || $icon || $actions): ?>
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <!--[if BLOCK]><![endif]--><?php if($icon): ?>
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-500">
                        <i data-lucide="<?php echo e($icon); ?>" class="w-5 h-5"></i>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div>
                    <!--[if BLOCK]><![endif]--><?php if($title): ?>
                        <h3 class="text-base font-semibold text-gray-900"><?php echo e($title); ?></h3>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($subtitle): ?>
                        <p class="text-sm text-gray-500"><?php echo e($subtitle); ?></p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <!--[if BLOCK]><![endif]--><?php if($actions): ?>
                <div class="flex items-center gap-2">
                    <?php echo e($actions); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <div class="<?php echo e($padding ? 'p-6' : ''); ?>">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/ui/card.blade.php ENDPATH**/ ?>