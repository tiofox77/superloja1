@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'actions' => null,
    'padding' => true,
    'hover' => false
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-200 shadow-sm ' . ($hover ? 'card-hover' : '')]) }}>
    @if($title || $icon || $actions)
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                @if($icon)
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-500">
                        <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                    </div>
                @endif
                <div>
                    @if($title)
                        <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
                    @endif
                    @if($subtitle)
                        <p class="text-sm text-gray-500">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @if($actions)
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>
</div>
