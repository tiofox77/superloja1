@props([
    'icon' => 'inbox',
    'title' => 'Nenhum item encontrado',
    'description' => null,
    'action' => null,
    'actionLabel' => null,
    'actionIcon' => 'plus'
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 px-6 text-center']) }}>
    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
        <i data-lucide="{{ $icon }}" class="w-8 h-8 text-gray-400"></i>
    </div>
    
    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
    
    @if($description)
        <p class="mt-1 text-sm text-gray-500 max-w-sm">{{ $description }}</p>
    @endif
    
    @if($action)
        <a href="{{ $action }}" wire:navigate
           class="mt-4 inline-flex items-center gap-2 px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-xl transition-colors">
            <i data-lucide="{{ $actionIcon }}" class="w-4 h-4"></i>
            {{ $actionLabel ?? 'Criar novo' }}
        </a>
    @endif
    
    {{ $slot }}
</div>
