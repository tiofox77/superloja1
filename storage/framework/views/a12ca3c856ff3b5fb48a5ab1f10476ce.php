<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => '',
    'value' => '0',
    'icon' => 'activity',
    'trend' => null,
    'trendValue' => null,
    'color' => 'primary',
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
    'title' => '',
    'value' => '0',
    'icon' => 'activity',
    'trend' => null,
    'trendValue' => null,
    'color' => 'primary',
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
    $colors = [
        'primary' => [
            'bg' => 'bg-primary-50',
            'icon' => 'text-primary-500',
            'gradient' => 'from-primary-500 to-primary-600'
        ],
        'secondary' => [
            'bg' => 'bg-secondary-50',
            'icon' => 'text-secondary-500',
            'gradient' => 'from-secondary-500 to-secondary-600'
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'icon' => 'text-green-500',
            'gradient' => 'from-green-500 to-green-600'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'icon' => 'text-yellow-500',
            'gradient' => 'from-yellow-500 to-yellow-600'
        ],
        'danger' => [
            'bg' => 'bg-red-50',
            'icon' => 'text-red-500',
            'gradient' => 'from-red-500 to-red-600'
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'icon' => 'text-blue-500',
            'gradient' => 'from-blue-500 to-blue-600'
        ],
    ];
    $c = $colors[$color] ?? $colors['primary'];
?>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 card-hover">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500"><?php echo e($title); ?></p>
            <p class="mt-2 text-3xl font-bold text-gray-900"><?php echo e($value); ?></p>
            
            <!--[if BLOCK]><![endif]--><?php if($trend !== null && $trendValue !== null): ?>
                <div class="mt-2 flex items-center gap-1.5">
                    <!--[if BLOCK]><![endif]--><?php if($trend === 'up'): ?>
                        <span class="flex items-center text-sm font-medium text-green-600">
                            <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                            <?php echo e($trendValue); ?>

                        </span>
                    <?php elseif($trend === 'down'): ?>
                        <span class="flex items-center text-sm font-medium text-red-600">
                            <i data-lucide="trending-down" class="w-4 h-4 mr-1"></i>
                            <?php echo e($trendValue); ?>

                        </span>
                    <?php else: ?>
                        <span class="flex items-center text-sm font-medium text-gray-500">
                            <i data-lucide="minus" class="w-4 h-4 mr-1"></i>
                            <?php echo e($trendValue); ?>

                        </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <span class="text-sm text-gray-400">vs mês anterior</span>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        
        <div class="w-14 h-14 rounded-2xl <?php echo e($c['bg']); ?> flex items-center justify-center">
            <i data-lucide="<?php echo e($icon); ?>" class="w-7 h-7 <?php echo e($c['icon']); ?>"></i>
        </div>
    </div>
    
    <!--[if BLOCK]><![endif]--><?php if($href): ?>
        <a href="<?php echo e($href); ?>" wire:navigate class="mt-4 flex items-center text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors">
            Ver detalhes
            <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
        </a>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/ui/stats-card.blade.php ENDPATH**/ ?>