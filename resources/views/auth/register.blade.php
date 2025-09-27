@extends('layouts.app')

@section('title', 'Registar - SuperLoja')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- 3D Geometric Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating 3D Shapes -->
        <div class="shape-3d cube" style="left: 20%; top: 25%; animation-delay: 1s;"></div>
        <div class="shape-3d sphere" style="right: 25%; top: 20%; animation-delay: 3s;"></div>
        <div class="shape-3d pyramid" style="left: 65%; top: 55%; animation-delay: 5s;"></div>
        <div class="shape-3d hexagon" style="left: 30%; bottom: 30%; animation-delay: 2s;"></div>
        <div class="shape-3d octahedron" style="right: 20%; bottom: 35%; animation-delay: 4s;"></div>
        
        <!-- Gradient Orbs -->
        <div class="gradient-orb-blue" style="left: 15%; top: 65%; animation-delay: 1.5s;"></div>
        <div class="gradient-orb-blue" style="right: 30%; top: 50%; animation-delay: 3.5s;"></div>
        <div class="gradient-orb-blue" style="left: 55%; top: 30%; animation-delay: 5.5s;"></div>
        
        <!-- Wireframe Grid -->
        <div class="wireframe-grid-blue"></div>
        
        <!-- Particle System -->
        <div class="particle-system">
            <div class="particle-dot-blue" style="left: 25%; top: 35%; animation-delay: 0s;"></div>
            <div class="particle-dot-blue" style="left: 75%; top: 25%; animation-delay: 1.5s;"></div>
            <div class="particle-dot-blue" style="left: 45%; top: 75%; animation-delay: 3s;"></div>
            <div class="particle-dot-blue" style="left: 70%; top: 65%; animation-delay: 4.5s;"></div>
            <div class="particle-dot-blue" style="left: 35%; top: 55%; animation-delay: 6s;"></div>
        </div>
    </div>
    
    <!-- Animated Background Icons -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Randomly Distributed Icons -->
        <div class="floating-icon" style="left: 22%; top: 12%; animation-delay: 0.5s;">
            <div class="w-13 h-13 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-7 h-7 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="right: 28%; top: 9%; animation-delay: 2.8s;">
            <div class="w-11 h-11 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5H4m3 8l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 63%; top: 18%; animation-delay: 4.1s;">
            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 38%; top: 6%; animation-delay: 7.3s;">
            <div class="w-10 h-10 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 18%; top: 48%; animation-delay: 5.7s;">
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-7 h-7 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="right: 23%; top: 44%; animation-delay: 8.9s;">
            <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 74%; top: 55%; animation-delay: 3.2s;">
            <div class="w-12 h-12 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 29%; bottom: 18%; animation-delay: 1.4s;">
            <div class="w-15 h-15 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-8 h-8 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="right: 38%; bottom: 24%; animation-delay: 6.6s;">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 52%; bottom: 32%; animation-delay: 9.8s;">
            <div class="w-11 h-11 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
        </div>
        
        <div class="floating-icon" style="left: 47%; top: 68%; animation-delay: 2.1s;">
            <div class="w-13 h-13 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-lg">
                <svg class="w-7 h-7 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- Floating Particles - Maximum Random Distribution -->
        <div class="particle" style="left: 31%; top: 85%; animation-delay: 1.7s;"></div>
        <div class="particle" style="left: 71%; top: 31%; animation-delay: 3.9s;"></div>
        <div class="particle" style="left: 84%; top: 71%; animation-delay: 5.3s;"></div>
        <div class="particle" style="left: 16%; top: 26%; animation-delay: 7.8s;"></div>
        <div class="particle" style="left: 57%; top: 14%; animation-delay: 2.4s;"></div>
        <div class="particle" style="left: 41%; top: 91%; animation-delay: 4.2s;"></div>
        <div class="particle" style="left: 89%; top: 48%; animation-delay: 6.9s;"></div>
        <div class="particle" style="left: 13%; top: 79%; animation-delay: 8.1s;"></div>
        <div class="particle" style="left: 66%; top: 63%; animation-delay: 0.6s;"></div>
        <div class="particle" style="left: 24%; top: 52%; animation-delay: 9.4s;"></div>
    </div>
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center animate-fade-in-up">
            <a href="{{ route('home') }}" class="inline-block group">
                <div class="flex items-center justify-center w-24 h-24 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-3xl shadow-2xl mb-8 mx-auto transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 group-hover:shadow-blue-500/25">
                    <span class="text-3xl font-bold text-white group-hover:text-blue-100 transition-colors duration-300">SL</span>
                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-cyan-400 to-blue-600 opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                </div>
            </a>
            <h2 class="text-4xl font-bold text-white mb-3 drop-shadow-lg">Crie sua conta</h2>
            <p class="text-white/80 text-lg backdrop-blur-sm">Junte-se à SuperLoja e descubra ofertas incríveis</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20 transform hover:scale-[1.02] transition-all duration-500 hover:shadow-3xl animate-slide-up">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nome Completo
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="João Silva">
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

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
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="joao@email.com">
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
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmar Palavra-passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="••••••••">
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        Concordo com os 
                        <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Termos de Serviço</a>
                        e 
                        <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Política de Privacidade</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-3 px-4 rounded-xl font-semibold text-lg hover:from-blue-600 hover:to-indigo-600 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Criar Conta
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

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Já tem uma conta?
                    <a href="{{ route('login') }}" 
                       class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                        Entre aqui
                    </a>
                </p>
            </div>
        </div>

        <!-- Benefits -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Vantagens de ser membro</h3>
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Ofertas exclusivas para membros</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Entrega rápida e gratuita</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 0v2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Suporte prioritário</span>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar à página inicial
            </a>
        </div>
    </div>
</div>

<style>
/* Floating Icons Animation */
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-35px) rotate(5deg); }
    66% { transform: translateY(-18px) rotate(-3deg); }
}

@keyframes floatReverse {
    0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
    33% { transform: translateY(28px) rotate(-5deg) scale(1.1); }
    66% { transform: translateY(12px) rotate(3deg) scale(0.95); }
}

.floating-icon {
    animation: float 9s ease-in-out infinite;
}

.floating-icon:nth-child(even) {
    animation: floatReverse 11s ease-in-out infinite;
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
    width: 5px;
    height: 5px;
    background: radial-gradient(circle, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.3) 100%);
    border-radius: 50%;
    animation: particle 18s linear infinite;
}

/* Page Entry Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(60px) scale(0.85);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 1.2s ease-out 0.3s both;
}

.animate-slide-up {
    animation: slideUp 1.2s ease-out 0.6s both;
}

/* 3D Shadow Effects */
.hover\:shadow-3xl:hover {
    box-shadow: 0 40px 70px -15px rgba(0, 0, 0, 0.25), 
                0 30px 30px -5px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.1);
}

/* Glassmorphism Enhancement */
.backdrop-blur-xl {
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
}

/* Input Focus Enhancement */
input:focus {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
}

/* Button Hover 3D Effect */
button[type="submit"]:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.25);
}

/* Background Gradient Animation */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.bg-gradient-to-br {
    background-size: 400% 400%;
    animation: gradientShift 18s ease infinite;
}

/* Blue Theme Variants for Register Page */
.gradient-orb-blue {
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, 
        rgba(99, 179, 237, 0.4) 0%, 
        rgba(139, 92, 246, 0.2) 40%,
        rgba(79, 70, 229, 0.05) 70%,
        transparent 100%);
    filter: blur(2px);
    animation: pulse3d 6s ease-in-out infinite;
}

.wireframe-grid-blue {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(rgba(99, 179, 237, 0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99, 179, 237, 0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: gridMove 30s linear infinite;
    opacity: 0.2;
}

.particle-dot-blue {
    position: absolute;
    width: 6px;
    height: 6px;
    background: radial-gradient(circle, rgba(99, 179, 237, 1) 0%, rgba(139, 92, 246, 0.3) 70%, transparent 100%);
    border-radius: 50%;
    animation: particleFloat 8s ease-in-out infinite;
}

/* 3D Shape Animations (same as login but with slight variations) */
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

/* Benefits Card Enhancement */
.bg-white.rounded-xl.shadow-lg:last-child {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Checkbox and Links Glow */
input[type="checkbox"]:checked {
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
}

a:hover {
    text-shadow: 0 0 8px rgba(59, 130, 246, 0.6);
}

/* Form Labels Enhancement */
label {
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}
</style>

@endsection
