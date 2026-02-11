@props([
    'name' => '',
    'icon' => null,
    'badge' => null
])

<button type="button"
        @click="activeTab = '{{ $name }}'"
        :class="activeTab === '{{ $name }}' 
            ? 'text-primary-600 border-primary-500' 
            : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300'"
        class="px-4 py-3 text-sm font-medium border-b-2 -mb-px transition-colors inline-flex items-center gap-2">
    @if($icon)
        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
    @endif
    {{ $slot }}
    @if($badge)
        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-100"
              :class="activeTab === '{{ $name }}' ? 'bg-primary-100 text-primary-700' : ''">
            {{ $badge }}
        </span>
    @endif
</button>
