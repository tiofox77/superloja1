@props([
    'label' => null,
    'hint' => null,
    'checked' => false
])

<label class="flex items-center gap-3 cursor-pointer">
    <div class="relative">
        <input type="checkbox" 
               {{ $checked ? 'checked' : '' }}
               {{ $attributes->merge(['class' => 'sr-only peer']) }}>
        
        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-500/20 
                    rounded-full peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white after:content-[''] after:absolute 
                    after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-5 after:w-5 after:transition-all 
                    peer-checked:bg-primary-500 transition-colors"></div>
    </div>
    
    @if($label)
        <div>
            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
            @if($hint)
                <p class="text-xs text-gray-500">{{ $hint }}</p>
            @endif
        </div>
    @endif
</label>
