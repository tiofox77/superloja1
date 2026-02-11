<!-- Sidebar Content -->
<div class="flex flex-col h-full">
    
    <!-- Logo Section -->
    <div class="flex items-center h-16 px-5 border-b border-white/10">
        @php
            $siteLogo = \App\Models\Setting::get('site_logo');
            $appName = \App\Models\Setting::get('app_name', 'SuperLoja');
            $hasLogo = !empty($siteLogo) && $siteLogo !== '/images/logo.png';
            
            $logoUrl = null;
            if ($hasLogo) {
                if (\Illuminate\Support\Str::startsWith($siteLogo, ['http://', 'https://'])) {
                    $logoUrl = $siteLogo;
                } elseif (\Illuminate\Support\Str::startsWith($siteLogo, '/storage/')) {
                    $logoUrl = url($siteLogo);
                } elseif (\Illuminate\Support\Str::startsWith($siteLogo, 'storage/')) {
                    $logoUrl = url('/' . $siteLogo);
                } elseif (\Illuminate\Support\Str::startsWith($siteLogo, 'settings/')) {
                    $logoUrl = asset('storage/' . $siteLogo);
                } else {
                    $logoUrl = asset('storage/' . ltrim($siteLogo, '/'));
                }
            }
        @endphp
        
        <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3">
            @if($hasLogo && $logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $appName }}" class="h-10 w-10 rounded-xl object-contain bg-white p-1" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 items-center justify-center shadow-lg hidden">
                    <i data-lucide="store" class="w-5 h-5 text-white"></i>
                </div>
            @else
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-lg">
                    <i data-lucide="store" class="w-5 h-5 text-white"></i>
                </div>
            @endif
            <div>
                <h1 class="text-lg font-bold text-white">{{ $appName }}</h1>
                <p class="text-xs text-white/60">Painel Admin</p>
            </div>
        </a>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scrollbar">
        
        <!-- Dashboard -->
        <x-admin.layouts.menu-item 
            route="admin.dashboard" 
            icon="layout-dashboard" 
            label="Dashboard" />
        
        <!-- Catálogo -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Catálogo</p>
            
            <x-admin.layouts.menu-item 
                route="admin.products.index" 
                icon="package" 
                label="Produtos" />
            
            <x-admin.layouts.menu-item 
                route="admin.categories.index" 
                icon="folder-tree" 
                label="Categorias" />
            
            <x-admin.layouts.menu-item 
                route="admin.brands.index" 
                icon="award" 
                label="Marcas" />
        </div>
        
        <!-- Vendas -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Vendas</p>
            
            <x-admin.layouts.menu-item 
                route="admin.orders.index" 
                icon="shopping-cart" 
                label="Pedidos" 
                :badge="$pendingOrders ?? null" />
            
            <x-admin.layouts.menu-item 
                route="admin.pos.index" 
                icon="monitor" 
                label="PDV" />
            
            <x-admin.layouts.menu-item 
                route="admin.auctions.index" 
                icon="gavel" 
                label="Leilões" />
        </div>
        
        <!-- Marketing -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Marketing</p>
            
            <x-admin.layouts.menu-item 
                route="admin.sms.index" 
                icon="message-square" 
                label="SMS Marketing" />
        </div>
        
        <!-- Sistema -->
        <div class="pt-4">
            <p class="px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Sistema</p>
            
            <x-admin.layouts.menu-item 
                route="admin.users.index" 
                icon="users" 
                label="Usuários" />
            
            <x-admin.layouts.menu-item 
                route="admin.settings.index" 
                icon="settings" 
                label="Configurações" />
            
            <x-admin.layouts.menu-item 
                route="admin.system.update" 
                icon="refresh-cw" 
                label="Atualização" />
        </div>
        
    </nav>
    
    <!-- User Section -->
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 p-2 rounded-xl bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">
            <div class="w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center">
                <span class="text-sm font-semibold text-white">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-white/50 truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-1.5 rounded-lg hover:bg-white/10 text-white/60 hover:text-white transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@php
    // Contar pedidos pendentes
    $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
@endphp
