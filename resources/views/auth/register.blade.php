@extends('layouts.app')

@section('title', 'Registar - SuperLoja')

@section('content')
<div id="register-page" class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Canvas Particle System -->
    <canvas id="regParticleCanvas" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index:1;"></canvas>

    <!-- Mouse Glow -->
    <div id="regMouseGlow" class="absolute w-[500px] h-[500px] rounded-full pointer-events-none opacity-0 transition-opacity duration-500" style="z-index:2; background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(120,160,255,0.06) 40%, transparent 70%); transform: translate(-50%,-50%);"></div>

    <!-- Floating Shapes (parallax) -->
    <div class="absolute inset-0 pointer-events-none" style="z-index:2;">
        <div class="reg-shape-float" data-speed="0.03" style="left:10%;top:15%;">
            <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-sm flex items-center justify-center shadow-xl">
                <svg class="w-7 h-7 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
        </div>
        <div class="reg-shape-float" data-speed="0.05" style="right:12%;top:10%;">
            <div class="w-14 h-14 rounded-full bg-white/8 border border-white/15 backdrop-blur-sm flex items-center justify-center shadow-xl">
                <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
        </div>
        <div class="reg-shape-float" data-speed="0.04" style="left:6%;bottom:20%;">
            <div class="w-12 h-12 rounded-xl bg-white/8 border border-white/15 backdrop-blur-sm flex items-center justify-center shadow-xl rotate-12">
                <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
        </div>
        <div class="reg-shape-float" data-speed="0.06" style="right:20%;bottom:15%;">
            <div class="w-10 h-10 rounded-lg bg-white/6 border border-white/10 backdrop-blur-sm flex items-center justify-center shadow-xl -rotate-6">
                <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>
        <div class="reg-shape-float" data-speed="0.02" style="left:68%;top:20%;">
            <div class="w-20 h-20 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm flex items-center justify-center shadow-xl">
                <svg class="w-9 h-9 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <div class="reg-shape-float" data-speed="0.035" style="left:78%;bottom:30%;">
            <div class="w-11 h-11 rounded-full bg-white/8 border border-white/15 backdrop-blur-sm shadow-xl"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-md w-full space-y-7 relative" style="z-index:10;">
        <!-- Logo + Header -->
        <div class="text-center reg-stagger" data-delay="0">
            <a href="{{ route('home') }}" class="inline-block group">
                <div class="relative flex items-center justify-center w-20 h-20 mx-auto mb-5">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-2xl group-hover:shadow-blue-500/40 transition-all duration-700 group-hover:scale-110 group-hover:rotate-6"></div>
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-cyan-400/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <span class="relative text-2xl font-black text-white tracking-wider">SL</span>
                    <div class="absolute -inset-1 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-600 opacity-0 group-hover:opacity-30 blur-lg transition-all duration-700"></div>
                </div>
            </a>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-2 tracking-tight">Crie sua conta</h2>
            <p class="text-white/70 text-base">Junte-se à SuperLoja e descubra ofertas incríveis</p>
        </div>

        <!-- Register Card -->
        <div class="reg-card reg-stagger" data-delay="200">
            <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="form-group reg-stagger" data-delay="300">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nome Completo</label>
                    <div class="reg-input-wrapper">
                        <div class="reg-input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="reg-auth-input" placeholder="João Silva">
                        <div class="reg-input-glow"></div>
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group reg-stagger" data-delay="400">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="reg-input-wrapper">
                        <div class="reg-input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                               class="reg-auth-input" placeholder="joao@email.com">
                        <div class="reg-input-glow"></div>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group reg-stagger" data-delay="500">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Palavra-passe</label>
                    <div class="reg-input-wrapper">
                        <div class="reg-input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="reg-auth-input pr-12" placeholder="Mínimo 8 caracteres">
                        <button type="button" onclick="regTogglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors p-1 z-10" tabindex="-1">
                            <svg class="w-5 h-5 eye-off" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            <svg class="w-5 h-5 eye-on hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <div class="reg-input-glow"></div>
                    </div>
                    <!-- Password Strength Meter -->
                    <div id="strengthMeter" class="mt-2 hidden">
                        <div class="flex gap-1 mb-1">
                            <div class="h-1.5 flex-1 rounded-full bg-gray-200 overflow-hidden"><div id="str1" class="h-full rounded-full transition-all duration-500" style="width:0"></div></div>
                            <div class="h-1.5 flex-1 rounded-full bg-gray-200 overflow-hidden"><div id="str2" class="h-full rounded-full transition-all duration-500" style="width:0"></div></div>
                            <div class="h-1.5 flex-1 rounded-full bg-gray-200 overflow-hidden"><div id="str3" class="h-full rounded-full transition-all duration-500" style="width:0"></div></div>
                            <div class="h-1.5 flex-1 rounded-full bg-gray-200 overflow-hidden"><div id="str4" class="h-full rounded-full transition-all duration-500" style="width:0"></div></div>
                        </div>
                        <p id="strengthText" class="text-xs font-medium text-gray-400"></p>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group reg-stagger" data-delay="600">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmar Palavra-passe</label>
                    <div class="reg-input-wrapper">
                        <div class="reg-input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="reg-auth-input pr-12" placeholder="••••••••">
                        <button type="button" onclick="regTogglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors p-1 z-10" tabindex="-1">
                            <svg class="w-5 h-5 eye-off" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            <svg class="w-5 h-5 eye-on hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <div class="reg-input-glow"></div>
                    </div>
                    <!-- Match indicator -->
                    <p id="matchIndicator" class="mt-1.5 text-xs font-medium hidden"></p>
                    @error('password_confirmation')
                        <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Terms -->
                <div class="flex items-start reg-stagger" data-delay="700">
                    <label class="flex items-start gap-2.5 cursor-pointer group">
                        <div class="reg-checkbox-wrapper mt-0.5">
                            <input id="terms" name="terms" type="checkbox" required class="sr-only peer">
                            <div class="w-5 h-5 rounded-md border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 transition-all duration-300 flex items-center justify-center group-hover:border-blue-400">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        <span class="text-sm text-gray-600 leading-tight">
                            Concordo com os
                            <a href="#" class="font-semibold text-blue-600 hover:text-blue-700 relative reg-link-hover">Termos de Serviço</a>
                            e
                            <a href="#" class="font-semibold text-blue-600 hover:text-blue-700 relative reg-link-hover">Política de Privacidade</a>
                        </span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="reg-stagger" data-delay="800">
                    <button type="submit" id="regSubmitBtn" class="reg-submit-btn w-full relative overflow-hidden">
                        <span class="reg-btn-content flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Criar Conta
                        </span>
                        <span class="reg-btn-loading hidden flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            Criando conta...
                        </span>
                        <div class="reg-btn-ripple"></div>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-6 reg-stagger" data-delay="850">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center"><span class="px-4 bg-white/95 text-gray-400 text-xs uppercase tracking-wider font-medium">Ou</span></div>
                </div>
            </div>

            <!-- Login Link -->
            <div class="mt-5 text-center reg-stagger" data-delay="900">
                <p class="text-gray-500 text-sm">
                    Já tem uma conta?
                    <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-colors relative reg-link-hover">
                        Entre aqui
                    </a>
                </p>
            </div>
        </div>

        <!-- Benefits -->
        <div class="benefits-card reg-stagger" data-delay="950">
            <h3 class="text-sm font-bold text-white/90 mb-3 text-center uppercase tracking-wider">Vantagens de ser membro</h3>
            <div class="grid grid-cols-3 gap-3">
                <div class="benefit-item text-center">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-xs text-white/70 leading-tight">Ofertas exclusivas</p>
                </div>
                <div class="benefit-item text-center">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <p class="text-xs text-white/70 leading-tight">Entrega rápida</p>
                </div>
                <div class="benefit-item text-center">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <p class="text-xs text-white/70 leading-tight">Suporte prioritário</p>
                </div>
            </div>
        </div>

        <!-- Back Home -->
        <div class="text-center reg-stagger" data-delay="1000">
            <a href="{{ route('home') }}" class="inline-flex items-center text-white/60 hover:text-white transition-all duration-300 text-sm group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Voltar à página inicial
            </a>
        </div>
    </div>
</div>

<style>
/* ═══ Background ═══ */
#register-page {
    background: linear-gradient(-45deg, #3b82f6, #6366f1, #8b5cf6, #06b6d4, #3b82f6);
    background-size: 400% 400%;
    animation: regGradient 16s ease infinite;
}

@keyframes regGradient {
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
    100% { background-position: 0% 50%; }
}

/* ═══ Floating Shapes ═══ */
.reg-shape-float {
    position: absolute;
    animation: regShapeFloat 12s ease-in-out infinite;
    transition: transform 0.15s ease-out;
}
.reg-shape-float:nth-child(even) { animation-duration: 15s; animation-direction: reverse; }
.reg-shape-float:nth-child(3n) { animation-duration: 18s; }

@keyframes regShapeFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-20px) rotate(3deg); }
    50% { transform: translateY(-8px) rotate(-2deg); }
    75% { transform: translateY(-25px) rotate(4deg); }
}

/* ═══ Register Card ═══ */
.reg-card {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-radius: 1.5rem;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15), 0 0 0 1px rgba(255,255,255,0.1), inset 0 1px 0 rgba(255,255,255,0.5);
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.4s ease;
}
.reg-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 35px 60px -15px rgba(0,0,0,0.2), 0 0 0 1px rgba(255,255,255,0.15), inset 0 1px 0 rgba(255,255,255,0.6);
}

/* ═══ Input Styles ═══ */
.reg-input-wrapper { position: relative; }

.reg-input-icon {
    position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%);
    color: #9ca3af; transition: color 0.3s ease; z-index: 5; pointer-events: none;
}

.reg-auth-input {
    width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e5e7eb; border-radius: 0.875rem; font-size: 0.9375rem;
    background: rgba(249,250,251,0.8); transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    outline: none; position: relative; z-index: 2;
}

.reg-auth-input:focus {
    border-color: #3b82f6; background: white;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.1), 0 4px 12px rgba(0,0,0,0.05);
    transform: translateY(-1px);
}

.reg-auth-input:focus ~ .reg-input-glow { opacity: 1; }
.reg-input-wrapper:focus-within .reg-input-icon { color: #3b82f6; }

.reg-input-glow {
    position: absolute; inset: -2px; border-radius: 1rem;
    background: linear-gradient(135deg, #3b82f6, #6366f1, #06b6d4);
    opacity: 0; z-index: 1; transition: opacity 0.3s ease; filter: blur(6px);
}

/* ═══ Checkbox ═══ */
.reg-checkbox-wrapper .peer:checked ~ div {
    border-color: #3b82f6; background: linear-gradient(135deg, #3b82f6, #4f46e5);
}
.reg-checkbox-wrapper .peer:checked ~ div svg { opacity: 1; }

/* ═══ Submit Button ═══ */
.reg-submit-btn {
    padding: 0.875rem 1.5rem; background: linear-gradient(135deg, #3b82f6, #6366f1);
    color: white; border: none; border-radius: 0.875rem; font-weight: 700; font-size: 1.0625rem;
    cursor: pointer; transition: all 0.4s cubic-bezier(0.34,1.56,0.64,1);
    box-shadow: 0 8px 25px rgba(59,130,246,0.35);
}
.reg-submit-btn:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 14px 35px rgba(59,130,246,0.45);
    background: linear-gradient(135deg, #2563eb, #4f46e5);
}
.reg-submit-btn:active {
    transform: translateY(-1px) scale(0.99);
    box-shadow: 0 6px 20px rgba(59,130,246,0.3);
}

.reg-btn-ripple {
    position: absolute; border-radius: 50%; background: rgba(255,255,255,0.4);
    transform: scale(0); pointer-events: none;
}
.reg-btn-ripple.active { animation: regRipple 0.6s ease-out forwards; }
@keyframes regRipple { to { transform: scale(4); opacity: 0; } }

/* ═══ Link Hover ═══ */
.reg-link-hover::after {
    content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px;
    background: linear-gradient(90deg, #3b82f6, #6366f1); border-radius: 2px;
    transition: width 0.3s ease;
}
.reg-link-hover:hover::after { width: 100%; }

/* ═══ Benefits Card ═══ */
.benefits-card {
    background: rgba(255,255,255,0.08); backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15); border-radius: 1.25rem; padding: 1.25rem;
}
.benefit-item { transition: transform 0.3s ease; }
.benefit-item:hover { transform: translateY(-4px); }

/* ═══ Stagger Entrance ═══ */
.reg-stagger {
    opacity: 0; transform: translateY(25px);
    animation: regStaggerIn 0.7s cubic-bezier(0.22,1,0.36,1) forwards;
}
@keyframes regStaggerIn { to { opacity: 1; transform: translateY(0); } }

/* ═══ Password Strength Colors ═══ */
.str-weak { background: #ef4444; }
.str-fair { background: #f59e0b; }
.str-good { background: #22c55e; }
.str-strong { background: #3b82f6; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // ═══ Stagger ═══
    document.querySelectorAll('.reg-stagger').forEach(el => {
        el.style.animationDelay = `${parseInt(el.dataset.delay || 0)}ms`;
    });

    // ═══ Canvas Particles ═══
    const canvas = document.getElementById('regParticleCanvas');
    const ctx = canvas.getContext('2d');
    let particles = [], mouseX = 0, mouseY = 0;

    function resize() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
    resize(); window.addEventListener('resize', resize);

    class P {
        constructor() { this.reset(); }
        reset() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 3 + 1;
            this.sx = (Math.random() - 0.5) * 0.7;
            this.sy = (Math.random() - 0.5) * 0.7;
            this.o = Math.random() * 0.5 + 0.2;
            this.pulse = Math.random() * Math.PI * 2;
        }
        update() {
            this.x += this.sx; this.y += this.sy; this.pulse += 0.02;
            const dx = mouseX - this.x, dy = mouseY - this.y;
            const d = Math.sqrt(dx*dx + dy*dy);
            if (d < 150) { const f = (150-d)/150*0.3; this.x -= dx*f*0.02; this.y -= dy*f*0.02; }
            if (this.x < 0 || this.x > canvas.width) this.sx *= -1;
            if (this.y < 0 || this.y > canvas.height) this.sy *= -1;
        }
        draw() {
            const g = Math.sin(this.pulse)*0.15+0.85;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size*g, 0, Math.PI*2);
            ctx.fillStyle = `rgba(255,255,255,${this.o*g})`;
            ctx.fill();
        }
    }

    for (let i = 0; i < 70; i++) particles.push(new P());

    function drawLines() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i+1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x, dy = particles[i].y - particles[j].y;
                const d = Math.sqrt(dx*dx + dy*dy);
                if (d < 110) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(255,255,255,${0.07*(1-d/110)})`;
                    ctx.lineWidth = 0.5;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
    }

    (function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw(); });
        drawLines();
        requestAnimationFrame(animate);
    })();

    // ═══ Mouse Effects ═══
    const glow = document.getElementById('regMouseGlow');
    const shapes = document.querySelectorAll('.reg-shape-float');

    document.addEventListener('mousemove', e => {
        mouseX = e.clientX; mouseY = e.clientY;
        glow.style.left = e.clientX + 'px';
        glow.style.top = e.clientY + 'px';
        glow.style.opacity = '1';
        shapes.forEach(s => {
            const sp = parseFloat(s.dataset.speed || 0.03);
            const cx = window.innerWidth/2, cy = window.innerHeight/2;
            s.style.transform = `translate(${(e.clientX-cx)*sp}px, ${(e.clientY-cy)*sp}px)`;
        });
    });
    document.addEventListener('mouseleave', () => { glow.style.opacity = '0'; });

    // ═══ Ripple Button ═══
    const btn = document.getElementById('regSubmitBtn');
    btn.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const rp = this.querySelector('.reg-btn-ripple');
        const size = Math.max(rect.width, rect.height);
        rp.style.width = rp.style.height = size + 'px';
        rp.style.left = (e.clientX - rect.left - size/2) + 'px';
        rp.style.top = (e.clientY - rect.top - size/2) + 'px';
        rp.classList.remove('active'); void rp.offsetWidth; rp.classList.add('active');
    });

    // ═══ Form Submit Loading ═══
    document.getElementById('registerForm').addEventListener('submit', function() {
        const b = document.getElementById('regSubmitBtn');
        b.querySelector('.reg-btn-content').classList.add('hidden');
        b.querySelector('.reg-btn-loading').classList.remove('hidden');
        b.disabled = true; b.style.opacity = '0.85';
    });

    // ═══ Password Strength Meter ═══
    const pwInput = document.getElementById('password');
    const meter = document.getElementById('strengthMeter');
    const bars = [document.getElementById('str1'), document.getElementById('str2'), document.getElementById('str3'), document.getElementById('str4')];
    const txt = document.getElementById('strengthText');
    const levels = [
        { label: 'Muito fraca', color: 'str-weak', textColor: 'text-red-500' },
        { label: 'Fraca', color: 'str-weak', textColor: 'text-red-500' },
        { label: 'Razoável', color: 'str-fair', textColor: 'text-yellow-600' },
        { label: 'Boa', color: 'str-good', textColor: 'text-green-600' },
        { label: 'Forte', color: 'str-strong', textColor: 'text-blue-600' },
    ];

    pwInput.addEventListener('input', function() {
        const v = this.value;
        if (!v) { meter.classList.add('hidden'); return; }
        meter.classList.remove('hidden');
        let score = 0;
        if (v.length >= 8) score++;
        if (/[a-z]/.test(v) && /[A-Z]/.test(v)) score++;
        if (/\d/.test(v)) score++;
        if (/[^a-zA-Z0-9]/.test(v)) score++;
        const lvl = levels[score];
        bars.forEach((b, i) => {
            b.style.width = i < score ? '100%' : '0';
            b.className = `h-full rounded-full transition-all duration-500 ${i < score ? lvl.color : ''}`;
        });
        txt.textContent = lvl.label;
        txt.className = `text-xs font-medium ${lvl.textColor}`;
    });

    // ═══ Password Match Indicator ═══
    const confInput = document.getElementById('password_confirmation');
    const matchEl = document.getElementById('matchIndicator');

    confInput.addEventListener('input', function() {
        const v = this.value;
        if (!v) { matchEl.classList.add('hidden'); return; }
        matchEl.classList.remove('hidden');
        if (v === pwInput.value) {
            matchEl.textContent = '✓ As senhas coincidem';
            matchEl.className = 'mt-1.5 text-xs font-medium text-green-600';
        } else {
            matchEl.textContent = '✗ As senhas não coincidem';
            matchEl.className = 'mt-1.5 text-xs font-medium text-red-500';
        }
    });
});

function regTogglePassword(id, btn) {
    const input = document.getElementById(id);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    btn.querySelector('.eye-off').classList.toggle('hidden', isPassword);
    btn.querySelector('.eye-on').classList.toggle('hidden', !isPassword);
}
</script>

@endsection
