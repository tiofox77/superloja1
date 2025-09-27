@extends('layouts.app')

@section('title', 'Entrar - SuperLoja')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-400 via-red-500 to-pink-600 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- 3D Geometric Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating 3D Shapes -->
        <div class="shape-3d cube" style="left: 15%; top: 20%; animation-delay: 0s;"></div>
        <div class="shape-3d sphere" style="right: 20%; top: 15%; animation-delay: 2s;"></div>
        <div class="shape-3d pyramid" style="left: 70%; top: 60%; animation-delay: 4s;"></div>
        <div class="shape-3d hexagon" style="left: 25%; bottom: 25%; animation-delay: 1s;"></div>
        <div class="shape-3d octahedron" style="right: 15%; bottom: 30%; animation-delay: 3s;"></div>
        
        <!-- Gradient Orbs -->
        <div class="gradient-orb" style="left: 10%; top: 70%; animation-delay: 0.5s;"></div>
        <div class="gradient-orb" style="right: 25%; top: 45%; animation-delay: 2.5s;"></div>
        <div class="gradient-orb" style="left: 60%; top: 25%; animation-delay: 4.5s;"></div>
        
        <!-- Wireframe Grid -->
        <div class="wireframe-grid"></div>
        
        <!-- Particle System -->
        <div class="particle-system">
            <div class="particle-dot" style="left: 20%; top: 30%; animation-delay: 0s;"></div>
            <div class="particle-dot" style="left: 80%; top: 20%; animation-delay: 1s;"></div>
            <div class="particle-dot" style="left: 40%; top: 80%; animation-delay: 2s;"></div>
            <div class="particle-dot" style="left: 75%; top: 70%; animation-delay: 3s;"></div>
            <div class="particle-dot" style="left: 30%; top: 50%; animation-delay: 4s;"></div>
        </div>
    </div>
    
    <!-- Animated Background Icons -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Randomly Distributed Icons -->
        <div class="floating-icon" style="left: 25%; top: 15%; animation-delay: 0s;">
            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5H4m3 8l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="right: 22%; top: 8%; animation-delay: 2.3s;">
            <div class="w-14 h-14 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-7 h-7 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 67%; top: 22%; animation-delay: 4.7s;">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 15%; top: 45%; animation-delay: 1.8s;">
            <div class="w-11 h-11 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="right: 18%; top: 38%; animation-delay: 6.2s;">
            <div class="w-13 h-13 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-7 h-7 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 78%; top: 52%; animation-delay: 3.4s;">
            <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 32%; bottom: 22%; animation-delay: 5.6s;">
            <div class="w-12 h-12 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="right: 35%; bottom: 15%; animation-delay: 7.9s;">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 58%; bottom: 28%; animation-delay: 0.7s;">
            <div class="w-14 h-14 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-7 h-7 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 45%; top: 65%; animation-delay: 8.3s;">
            <div class="w-11 h-11 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- Floating Particles - More Random Distribution -->
        <div class="particle" style="left: 28%; top: 82%; animation-delay: 1.2s;"></div>
        <div class="particle" style="left: 62%; top: 18%; animation-delay: 3.7s;"></div>
        <div class="particle" style="left: 85%; top: 68%; animation-delay: 5.1s;"></div>
        <div class="particle" style="left: 18%; top: 28%; animation-delay: 7.4s;"></div>
        <div class="particle" style="left: 42%; top: 12%; animation-delay: 2.6s;"></div>
        <div class="particle" style="left: 88%; top: 35%; animation-delay: 4.9s;"></div>
        <div class="particle" style="left: 33%; top: 88%; animation-delay: 6.3s;"></div>
        <div class="particle" style="left: 72%; top: 42%; animation-delay: 0.8s;"></div>
        <div class="particle" style="left: 55%; top: 75%; animation-delay: 9.1s;"></div>
    </div>
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center animate-fade-in-up">
            <a href="{{ route('home') }}" class="inline-block group">
                <div class="flex items-center justify-center w-24 h-24 bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl shadow-2xl mb-8 mx-auto transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 group-hover:shadow-orange-500/25">
                    <span class="text-3xl font-bold text-white group-hover:text-yellow-100 transition-colors duration-300">SL</span>
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-yellow-400 to-orange-600 opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                </div>
            </a>
            <h2 class="text-4xl font-bold text-white mb-3 drop-shadow-lg">Bem-vindo de volta!</h2>
            <p class="text-white/80 text-lg backdrop-blur-sm">Entre na sua conta para continuar suas compras</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20 transform hover:scale-[1.02] transition-all duration-500 hover:shadow-3xl animate-slide-up">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800 text-sm">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                               placeholder="seu@email.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Palavra-passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Lembrar-me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-orange-600 hover:text-orange-500 font-medium">
                            Esqueceu a palavra-passe?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 px-4 rounded-xl font-semibold text-lg hover:from-orange-600 hover:to-red-600 focus:outline-none focus:ring-4 focus:ring-orange-500/50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Entrar
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Ou</span>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Não tem uma conta?
                    <a href="{{ route('register') }}" 
                       class="font-semibold text-orange-600 hover:text-orange-500 transition-colors">
                        Registe-se gratuitamente
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center text-gray-600 hover:text-orange-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar à página inicial
            </a>
        </div>
    </div>
</div>

<style>
/* 3D Geometric Shapes */
.shape-3d {
    position: absolute;
    width: 60px;
    height: 60px;
    opacity: 0.3;
    transform-style: preserve-3d;
    animation: rotate3d 20s linear infinite;
}

.cube {
    background: linear-gradient(45deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
    box-shadow: 
        inset 0 0 20px rgba(255,255,255,0.2),
        0 0 40px rgba(255,255,255,0.1);
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.3);
}

.sphere {
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.4), rgba(255,255,255,0.1));
    border-radius: 50%;
    box-shadow: 
        inset -10px -10px 20px rgba(0,0,0,0.2),
        0 0 30px rgba(255,255,255,0.2);
}

.pyramid {
    width: 0;
    height: 0;
    border-left: 30px solid transparent;
    border-right: 30px solid transparent;
    border-bottom: 50px solid rgba(255,255,255,0.2);
    filter: drop-shadow(0 0 20px rgba(255,255,255,0.3));
}

.hexagon {
    width: 50px;
    height: 28px;
    background: rgba(255,255,255,0.2);
    position: relative;
    border-radius: 4px;
}

.hexagon:before,
.hexagon:after {
    content: "";
    position: absolute;
    width: 0;
    border-left: 25px solid transparent;
    border-right: 25px solid transparent;
}

.hexagon:before {
    bottom: 100%;
    border-bottom: 14px solid rgba(255,255,255,0.2);
}

.hexagon:after {
    top: 100%;
    border-top: 14px solid rgba(255,255,255,0.2);
}

.octahedron {
    background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
    transform: rotate(45deg);
    border-radius: 8px;
    box-shadow: 0 0 30px rgba(255,255,255,0.2);
}

/* Gradient Orbs */
.gradient-orb {
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, 
        rgba(255,255,255,0.4) 0%, 
        rgba(255,255,255,0.2) 40%,
        rgba(255,255,255,0.05) 70%,
        transparent 100%);
    filter: blur(2px);
    animation: pulse3d 6s ease-in-out infinite;
}

/* Wireframe Grid */
.wireframe-grid {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: gridMove 30s linear infinite;
    opacity: 0.2;
}

/* Particle System */
.particle-dot {
    position: absolute;
    width: 6px;
    height: 6px;
    background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(255,255,255,0.3) 70%, transparent 100%);
    border-radius: 50%;
    animation: particleFloat 8s ease-in-out infinite;
}

/* 3D Animations */
@keyframes rotate3d {
    0% { transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg); }
    33% { transform: rotateX(120deg) rotateY(120deg) rotateZ(0deg); }
    66% { transform: rotateX(240deg) rotateY(240deg) rotateZ(120deg); }
    100% { transform: rotateX(360deg) rotateY(360deg) rotateZ(360deg); }
}

@keyframes pulse3d {
    0%, 100% { transform: scale(1) rotateZ(0deg); opacity: 0.3; }
    50% { transform: scale(1.2) rotateZ(180deg); opacity: 0.6; }
}

@keyframes gridMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

@keyframes particleFloat {
    0%, 100% { transform: translateY(0px) scale(1); opacity: 0.8; }
    25% { transform: translateY(-20px) scale(1.2); opacity: 1; }
    50% { transform: translateY(-10px) scale(0.8); opacity: 0.6; }
    75% { transform: translateY(-30px) scale(1.1); opacity: 0.9; }
}

/* Floating Icons Animation */
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-30px) rotate(5deg); }
    66% { transform: translateY(-15px) rotate(-3deg); }
}

@keyframes floatReverse {
    0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
    33% { transform: translateY(25px) rotate(-5deg) scale(1.1); }
    66% { transform: translateY(10px) rotate(3deg) scale(0.95); }
}

.floating-icon {
    animation: float 8s ease-in-out infinite;
}

.floating-icon:nth-child(even) {
    animation: floatReverse 10s ease-in-out infinite;
}

/* Particles Animation */
@keyframes particle {
    0% { transform: translateY(0px) scale(0) rotate(0deg); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { transform: translateY(-100vh) scale(1) rotate(360deg); opacity: 0; }
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.2) 100%);
    border-radius: 50%;
    animation: particle 15s linear infinite;
}

/* Page Entry Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 1s ease-out 0.5s both;
}

.animate-slide-up {
    animation: slideUp 1s ease-out 0.8s both;
}

/* 3D Shadow Effects */
.hover\:shadow-3xl:hover {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25), 
                0 25px 25px -5px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.1);
}

/* Glassmorphism Enhancement */
.backdrop-blur-xl {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

/* Input Focus Enhancement */
input:focus {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Button Hover 3D Effect */
button[type="submit"]:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

/* Background Gradient Animation */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-gradient-to-br {
    background-size: 400% 400%;
    animation: gradientShift 15s ease infinite;
}
</style>

@endsection
