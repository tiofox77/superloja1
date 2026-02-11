@props([
    'route' => null,
    'icon' => 'circle',
    'label' => '',
    'badge' => null,
    'href' => null
])

@php
    $url = $href ?? ($route ? route($route) : '#');
    $menuPath = parse_url($url, PHP_URL_PATH) ?: '/';
@endphp

<a href="{{ $url }}" 
   wire:navigate
   x-data="{ active: false, check() { this.active = window.location.pathname === '{{ $menuPath }}' || window.location.pathname.startsWith('{{ rtrim($menuPath, '/') }}/' ) } }"
   x-init="check()"
   x-on:livewire:navigated.window="check()"
   x-bind:class="active 
       ? 'bg-primary-500/20 text-white border-l-3 border-primary-500' 
       : 'text-white/70 hover:text-white hover:bg-white/10'"
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">
    
    <span x-bind:class="active ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'bg-white/10'"
          class="flex items-center justify-center w-8 h-8 rounded-lg">
        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
    </span>
    
    <span class="flex-1">{{ $label }}</span>
    
    @if($badge)
        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-primary-500 text-white">
            {{ $badge > 99 ? '99+' : $badge }}
        </span>
    @endif
</a>
