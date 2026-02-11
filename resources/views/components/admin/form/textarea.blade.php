@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'rows' => 4
])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif
    
    <textarea rows="{{ $rows }}" {{ $attributes->except('class')->merge([
        'class' => 'block w-full rounded-lg border-gray-300 shadow-sm 
                   focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20
                   transition-all text-sm resize-none py-2.5 px-3.5
                   placeholder:text-gray-400
                   disabled:bg-gray-50 disabled:text-gray-500
                   ' . ($error ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '')
    ]) }}>{{ $slot }}</textarea>
    
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
