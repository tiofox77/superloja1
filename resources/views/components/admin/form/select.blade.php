@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'icon' => null,
    'placeholder' => 'Selecione...',
    'options' => []
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
        
        <select {{ $attributes->except('class')->merge([
            'class' => 'block w-full rounded-lg border-gray-300 shadow-sm 
                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20
                       transition-all text-sm py-2.5 pr-10
                       disabled:bg-gray-50 disabled:text-gray-500
                       ' . ($icon ? 'pl-11' : 'pl-3.5') . '
                       ' . ($error ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '')
        ]) }}>
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            
            @if(is_array($options) && count($options) > 0)
                @foreach($options as $value => $optionLabel)
                    <option value="{{ $value }}">{{ $optionLabel }}</option>
                @endforeach
            @endif
            
            {{ $slot }}
        </select>
        
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
        </div>
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
