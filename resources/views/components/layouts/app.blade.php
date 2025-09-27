<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SuperLoja' }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <style>
        /* Custom styles here */
    </style>
    
    @livewireStyles
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
