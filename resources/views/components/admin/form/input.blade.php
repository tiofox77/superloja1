@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'icon' => null,
    'iconRight' => null,
    'prefix' => null,
    'suffix' => null
])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i data-lucide="{{ $icon }}" class="w-4.5 h-4.5 text-gray-500"></i>
            </div>
        @endif
        
        @if($prefix)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $prefix }}</span>
            </div>
        @endif
        
        <input {{ $attributes->except('class')->merge([
            'class' => 'block w-full rounded-lg border-gray-300 shadow-sm 
                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20
                       transition-all text-sm py-2.5
                       placeholder:text-gray-400
                       disabled:bg-gray-50 disabled:text-gray-500
                       ' . ($icon ? 'pl-11' : 'pl-3.5') . ' ' . ($prefix ? 'pl-12' : '') . '
                       ' . ($iconRight ? 'pr-10' : 'pr-3.5') . ' ' . ($suffix ? 'pr-12' : '') . '
                       ' . ($error ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '')
        ]) }}>
        
        @if($iconRight)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i data-lucide="{{ $iconRight }}" class="w-5 h-5 text-gray-400"></i>
            </div>
        @endif
        
        @if($suffix)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $suffix }}</span>
            </div>
        @endif
    </div>
    
    @if($hint && !$error)
        <p class="text-xs text-gray-500">{{ $hint }}</p>
    @endif
    
    @if($error)
        <p class="text-xs text-red-600 flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
            {{ $error }}
        </p>
    @endif
</div>
