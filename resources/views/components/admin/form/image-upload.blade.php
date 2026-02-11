@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'preview' => null,
    'multiple' => false,
    'accept' => 'image/*'
])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-2']) }}
     x-data="{ 
         previews: {{ $preview ? json_encode(is_array($preview) ? $preview : [$preview]) : '[]' }},
         isDragging: false
     }">
    
    @if($label)
        <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    
    <div class="relative"
         @dragover.prevent="isDragging = true"
         @dragleave.prevent="isDragging = false"
         @drop.prevent="isDragging = false">
        
        <!-- Upload Area -->
        <label :class="isDragging ? 'border-primary-500 bg-primary-50' : 'border-gray-300'"
               class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
            <div class="flex flex-col items-center justify-center py-4">
                <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mb-3">
                    <i data-lucide="upload-cloud" class="w-6 h-6 text-gray-400"></i>
                </div>
                <p class="text-sm text-gray-500">
                    <span class="font-medium text-primary-500">Clique para enviar</span> ou arraste aqui
                </p>
                <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP até 5MB</p>
            </div>
            <input type="file" 
                   class="hidden" 
                   accept="{{ $accept }}"
                   {{ $multiple ? 'multiple' : '' }}
                   {{ $attributes->except('class') }}>
        </label>
        
        <!-- Preview Grid -->
        <template x-if="previews.length > 0">
            <div class="mt-3 grid grid-cols-4 gap-3">
                <template x-for="(preview, index) in previews" :key="index">
                    <div class="relative group aspect-square rounded-lg overflow-hidden bg-gray-100">
                        <img :src="preview" class="w-full h-full object-cover">
                        <button type="button"
                                @click="previews.splice(index, 1)"
                                class="absolute top-1 right-1 p-1 rounded-full bg-red-500 text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </button>
                    </div>
                </template>
            </div>
        </template>
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
