<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        $appName = \App\Models\Setting::get('app_name', 'SuperLoja');
        $seoTitle = \App\Models\Setting::get('meta_title') ?: ($appName . ' - Sua Loja Online de Confiança');
        $seoDescription = \App\Models\Setting::get('meta_description') ?: 'SuperLoja - O maior e-commerce de Angola. Produtos de qualidade, entregas rápidas e os melhores preços.';
        $seoKeywords = \App\Models\Setting::get('meta_keywords') ?: 'loja online angola, eletrônicos angola, compras online luanda';
        $ogImagePath = \App\Models\Setting::get('og_image');
        $ogImage = $ogImagePath ? asset('storage/' . $ogImagePath) : asset('images/og-image.jpg');
    @endphp
    
    <title>{{ $title ?? $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="{{ $appName }}">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $appName }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="pt_AO">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    
    <!-- Favicon -->
    @php
        $siteFavicon = \App\Models\Setting::get('site_favicon');
        $faviconUrl = asset('favicon.ico');
        if ($siteFavicon && $siteFavicon !== '/favicon.ico') {
            if (\Illuminate\Support\Str::startsWith($siteFavicon, ['http://', 'https://'])) {
                $faviconUrl = $siteFavicon;
            } elseif (\Illuminate\Support\Str::startsWith($siteFavicon, 'storage/') || \Illuminate\Support\Str::startsWith($siteFavicon, 'settings/')) {
                $faviconUrl = asset('storage/' . $siteFavicon);
            } else {
                $faviconUrl = asset(ltrim($siteFavicon, '/'));
            }
        }
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @livewireStyles
    
    <!-- Google Analytics -->
    @php $gaId = \App\Models\Setting::get('google_analytics'); @endphp
    @if($gaId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif
    
    <!-- Facebook Pixel -->
    @php $fbPixelId = \App\Models\Setting::get('facebook_pixel'); @endphp
    @if($fbPixelId)
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $fbPixelId }}');
            fbq('track', 'PageView');
        </script>
    @endif
</head>

<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Check if user is admin and show admin layout -->
    @if(auth()->check() && auth()->user()->role === 'admin' && request()->is('admin*'))
        <x-layouts.admin :title="$title ?? 'Admin Panel'">
            {{ $slot }}
        </x-layouts.admin>
    @else
        <!-- Regular layout for non-admin users -->
        <div class="min-h-screen flex flex-col">
            <!-- Include header if not on auth pages -->
            @unless(request()->is('login') || request()->is('register'))
                @include('layouts.header')
            @endunless
            
            <!-- Main Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>
            
            <!-- Include footer if not on auth pages -->
            @unless(request()->is('login') || request()->is('register'))
                @include('layouts.footer')
            @endunless
        </div>
    @endif

    @livewireScripts
    
    <!-- Custom Scripts for Non-Admin -->
    @unless(auth()->check() && auth()->user()->role === 'admin' && request()->is('admin*'))
        <script>
            // Cart functionality
            function toggleCart() {
                console.log('Cart toggled');
                // Cart implementation will go here
            }
            
            // Wishlist functionality
            function toggleWishlist() {
                console.log('Wishlist toggled');
                // Wishlist implementation will go here
            }
            
            // Notifications functionality
            function toggleNotifications() {
                console.log('Notifications toggled');
                // Notifications implementation will go here
            }
        </script>
    @endunless
</body>
</html>
