@props([
    'label' => null,
    'hint' => null,
    'checked' => false
])

<label class="flex items-start gap-3 cursor-pointer group">
    <div class="relative flex items-center justify-center mt-0.5">
        <input type="checkbox" 
               {{ $checked ? 'checked' : '' }}
               {{ $attributes->merge(['class' => 'peer sr-only']) }}>
        
        <div class="w-5 h-5 border-2 border-gray-300 rounded-md bg-white 
                    peer-checked:bg-primary-500 peer-checked:border-primary-500
                    peer-focus:ring-2 peer-focus:ring-primary-500/20
                    group-hover:border-primary-400
                    transition-all flex items-center justify-center">
            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
    </div>
    
    @if($label)
        <div>
            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">{{ $label }}</span>
            @if($hint)
                <p class="text-xs text-gray-500 mt-0.5">{{ $hint }}</p>
            @endif
        </div>
    @endif
</label>
