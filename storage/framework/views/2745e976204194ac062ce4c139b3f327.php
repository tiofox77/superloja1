<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'route' => null,
    'icon' => 'circle',
    'label' => '',
    'badge' => null,
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
    'route' => null,
    'icon' => 'circle',
    'label' => '',
    'badge' => null,
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
    $url = $href ?? ($route ? route($route) : '#');
    $menuPath = parse_url($url, PHP_URL_PATH) ?: '/';
?>

<a href="<?php echo e($url); ?>" 
   wire:navigate
   x-data="{ active: false, check() { this.active = window.location.pathname === '<?php echo e($menuPath); ?>' || window.location.pathname.startsWith('<?php echo e(rtrim($menuPath, '/')); ?>/' ) } }"
   x-init="check()"
   x-on:livewire:navigated.window="check()"
   x-bind:class="active 
       ? 'bg-primary-500/20 text-white border-l-3 border-primary-500' 
       : 'text-white/70 hover:text-white hover:bg-white/10'"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">
    
    <span x-bind:class="active ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'bg-white/10'"
          class="flex items-center justify-center w-8 h-8 rounded-lg">
        <i data-lucide="<?php echo e($icon); ?>" class="w-4 h-4"></i>
    </span>
    
    <span class="flex-1"><?php echo e($label); ?></span>
    
    <?php if($badge): ?>
        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-primary-500 text-white">
            <?php echo e($badge > 99 ? '99+' : $badge); ?>

        </span>
    <?php endif; ?>
</a>
<?php /**PATH C:\laragon\www\superloja\resources\views/components/admin/layouts/menu-item.blade.php ENDPATH**/ ?>