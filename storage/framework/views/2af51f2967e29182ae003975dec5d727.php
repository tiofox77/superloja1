<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'default',
    'size' => 'md',
    'dot' => false
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
    'variant' => 'default',
    'size' => 'md',
    'dot' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $variants = [
        'default' => 'bg-gray-100 text-gray-700',
        'primary' => 'bg-primary-100 text-primary-700',
        'secondary' => 'bg-secondary-100 text-secondary-700',
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'danger' => 'bg-red-100 text-red-700',
        'info' => 'bg-blue-100 text-blue-700',
    ];
    
    $dotColors = [
        'default' => 'bg-gray-500',
        'primary' => 'bg-primary-500',
        'secondary' => 'bg-secondary-500',
        'success' => 'bg-green-500',
        'warning' => 'bg-yellow-500',
        'danger' => 'bg-red-500',
        'info' => 'bg-blue-500',
    ];
    
    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];
?>

<span <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-1.5 font-medium rounded-full ' . $variants[$variant] . ' ' . $sizes[$size]])); ?>>
    <!--[if BLOCK]><![endif]--><?php if($dot): ?>
        <span class="w-1.5 h-1.5 rounded-full <?php echo e($dotColors[$variant]); ?>"></span>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php echo e($slot); ?>

</span>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/ui/badge.blade.php ENDPATH**/ ?>