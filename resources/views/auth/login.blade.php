@extends('layouts.app')

@section('title', 'Entrar - SuperLoja')

@section('content')
<div id="login-page" class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Canvas Particle System -->
    <canvas id="particleCanvas" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index:1;"></canvas>

    <!-- Mouse Glow -->
    <div id="mouseGlow" class="absolute w-[500px] h-[500px] rounded-full pointer-events-none opacity-0 transition-opacity duration-500" style="z-index:2; background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,200,100,0.06) 40%, transparent 70%); transform: translate(-50%,-50%);"></div>

    <!-- Floating Shapes (parallax) -->
    <div id="parallaxLayer" class="absolute inset-0 pointer-events-none" style="z-index:2;">
        <div class="shape-float" data-speed="0.03" style="left:12%;top:18%;">
            <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-sm flex items-center justify-center shadow-xl">
                <svg class="w-7 h-7 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            </div>
        </div>
        <div class="shape-float" data-speed="0.05" style="right:15%;top:12%;">
            <div class="w-14 h-14 rounded-full bg-white/8 border border-white/15 backdrop-blur-sm flex items-center justify-center shadow-xl">
                <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
        </div>
        <div class="shape-float" data-speed="0.04" style="left:8%;bottom:25%;">
            <div class="w-12 h-12 rounded-xl bg-white/8 border border-white/15 backdrop-blur-sm flex items-center justify-center shadow-xl rotate-12">
                <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>
        <div class="shape-float" data-speed="0.06" style="right:22%;bottom:18%;">
            <div class="w-10 h-10 rounded-lg bg-white/6 border border-white/10 backdrop-blur-sm flex items-center justify-center shadow-xl -rotate-6">
                <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
        </div>
        <div class="shape-float" data-speed="0.02" style="left:65%;top:22%;">
            <div class="w-20 h-20 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm flex items-center justify-center shadow-xl">
                <svg class="w-9 h-9 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <div class="shape-float" data-speed="0.035" style="left:75%;bottom:35%;">
            <div class="w-11 h-11 rounded-full bg-white/8 border border-white/15 backdrop-blur-sm shadow-xl"></div>
        </div>
        <div class="shape-float" data-speed="0.045" style="left:35%;top:8%;">
            <div class="w-8 h-8 rounded-md bg-white/6 border border-white/10 rotate-45 shadow-xl"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-md w-full space-y-8 relative" style="z-index:10;">
        <!-- Logo + Header -->
        <div class="text-center stagger-item" data-delay="0">
            <a href="{{ route('home') }}" class="inline-block group">
                <div class="relative flex items-center justify-center w-20 h-20 mx-auto mb-6">
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-orange-400 to-red-600 shadow-2xl group-hover:shadow-orange-500/40 transition-all duration-700 group-hover:scale-110 group-hover:rotate-6"></div>
                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-yellow-400/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <span class="relative text-2xl font-black text-white tracking-wider">SL</span>
                    <div class="absolute -inset-1 rounded-2xl bg-gradient-to-br from-orange-400 to-red-600 opacity-0 group-hover:opacity-30 blur-lg transition-all duration-700"></div>
                </div>
            </a>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-2 tracking-tight">Bem-vindo de volta!</h2>
            <p class="text-white/70 text-base">Entre na sua conta para continuar suas compras</p>
        </div>

        <!-- Login Card -->
        <div class="login-card stagger-item" data-delay="200">
            @if (session('status'))
                <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl animate-pulse-once">
                    <p class="text-green-800 text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="form-group stagger-item" data-delay="350">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="auth-input" placeholder="seu@email.com">
                        <div class="input-border-glow"></div>
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group stagger-item" data-delay="450">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Palavra-passe</label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="auth-input pr-12" placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500 transition-colors p-1 z-10" tabindex="-1">
                            <svg class="w-5 h-5 eye-off" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            <svg class="w-5 h-5 eye-on hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <div class="input-border-glow"></div>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between stagger-item" data-delay="550">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="checkbox-wrapper">
                            <input id="remember_me" name="remember" type="checkbox" class="sr-only peer">
                            <div class="w-5 h-5 rounded-md border-2 border-gray-300 peer-checked:border-orange-500 peer-checked:bg-orange-500 transition-all duration-300 flex items-center justify-center group-hover:border-orange-400">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        <span class="text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Lembrar-me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium relative link-hover-effect">
                            Esqueceu a palavra-passe?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div class="stagger-item" data-delay="650">
                    <button type="submit" id="submitBtn" class="submit-btn w-full relative overflow-hidden">
                        <span class="btn-content flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Entrar
                        </span>
                        <span class="btn-loading hidden flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                            Entrando...
                        </span>
                        <div class="btn-ripple"></div>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-7 stagger-item" data-delay="700">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center"><span class="px-4 bg-white/95 text-gray-400 text-xs uppercase tracking-wider font-medium">Ou</span></div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-5 text-center stagger-item" data-delay="750">
                <p class="text-gray-500 text-sm">
                    Não tem uma conta?
                    <a href="{{ route('register') }}" class="font-bold text-orange-600 hover:text-orange-700 transition-colors relative link-hover-effect">
                        Registe-se gratuitamente
                    </a>
                </p>
            </div>
        </div>

        <!-- Back Home -->
        <div class="text-center stagger-item" data-delay="850">
            <a href="{{ route('home') }}" class="inline-flex items-center text-white/60 hover:text-white transition-all duration-300 text-sm group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Voltar à página inicial
            </a>
        </div>
    </div>
</div>

<style>
/* ═══ Background ═══ */
#login-page {
    background: linear-gradient(-45deg, #f97316, #ef4444, #ec4899, #f59e0b, #f97316);
    background-size: 400% 400%;
    animation: aurGradient 16s ease infinite;
}

@keyframes aurGradient {
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
    100% { background-position: 0% 50%; }
}

/* ═══ Floating Shapes ═══ */
.shape-float {
    position: absolute;
    animation: shapeFloat 12s ease-in-out infinite;
    transition: transform 0.15s ease-out;
}

.shape-float:nth-child(even) { animation-duration: 15s; animation-direction: reverse; }
.shape-float:nth-child(3n) { animation-duration: 18s; }

@keyframes shapeFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-20px) rotate(3deg); }
    50% { transform: translateY(-8px) rotate(-2deg); }
    75% { transform: translateY(-25px) rotate(4deg); }
}

/* ═══ Login Card ═══ */
.login-card {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-radius: 1.5rem;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow:
        0 25px 50px -12px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
}

.login-card:hover {
    transform: translateY(-4px);
    box-shadow:
        0 35px 60px -15px rgba(0, 0, 0, 0.2),
        0 0 0 1px rgba(255, 255, 255, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
}

/* ═══ Input Styles ═══ */
.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    transition: color 0.3s ease;
    z-index: 5;
    pointer-events: none;
}

.auth-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.875rem;
    font-size: 0.9375rem;
    background: rgba(249, 250, 251, 0.8);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    outline: none;
    position: relative;
    z-index: 2;
}

.auth-input:focus {
    border-color: #f97316;
    background: white;
    box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1), 0 4px 12px rgba(0, 0, 0, 0.05);
    transform: translateY(-1px);
}

.auth-input:focus ~ .input-border-glow {
    opacity: 1;
}

.input-wrapper:focus-within .input-icon {
    color: #f97316;
}

.input-border-glow {
    position: absolute;
    inset: -2px;
    border-radius: 1rem;
    background: linear-gradient(135deg, #f97316, #ef4444, #f59e0b);
    opacity: 0;
    z-index: 1;
    transition: opacity 0.3s ease;
    filter: blur(6px);
}

/* ═══ Checkbox ═══ */
.checkbox-wrapper .peer:checked ~ div {
    border-color: #f97316;
    background: linear-gradient(135deg, #f97316, #ea580c);
}
.checkbox-wrapper .peer:checked ~ div svg { opacity: 1; }

/* ═══ Submit Button ═══ */
.submit-btn {
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, #f97316, #ef4444);
    color: white;
    border: none;
    border-radius: 0.875rem;
    font-weight: 700;
    font-size: 1.0625rem;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 8px 25px rgba(249, 115, 22, 0.35);
}

.submit-btn:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 14px 35px rgba(249, 115, 22, 0.45);
    background: linear-gradient(135deg, #ea580c, #dc2626);
}

.submit-btn:active {
    transform: translateY(-1px) scale(0.99);
    box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
}

.btn-ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    transform: scale(0);
    pointer-events: none;
}

.btn-ripple.active {
    animation: ripple 0.6s ease-out forwards;
}

@keyframes ripple {
    to { transform: scale(4); opacity: 0; }
}

/* ═══ Link Hover Effect ═══ */
.link-hover-effect::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #f97316, #ef4444);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.link-hover-effect:hover::after {
    width: 100%;
}

/* ═══ Stagger Entrance ═══ */
.stagger-item {
    opacity: 0;
    transform: translateY(25px);
    animation: staggerIn 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}

@keyframes staggerIn {
    to { opacity: 1; transform: translateY(0); }
}

/* ═══ Pulse Once ═══ */
.animate-pulse-once {
    animation: pulseOnce 0.5s ease;
}

@keyframes pulseOnce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // ═══ Stagger Entrance ═══
    document.querySelectorAll('.stagger-item').forEach(el => {
        const delay = parseInt(el.dataset.delay || 0);
        el.style.animationDelay = `${delay}ms`;
    });

    // ═══ Canvas Particle System ═══
    const canvas = document.getElementById('particleCanvas');
    const ctx = canvas.getContext('2d');
    let particles = [];
    let mouseX = 0, mouseY = 0;

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    class Particle {
        constructor() { this.reset(); }
        reset() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 3 + 1;
            this.speedX = (Math.random() - 0.5) * 0.8;
            this.speedY = (Math.random() - 0.5) * 0.8;
            this.opacity = Math.random() * 0.5 + 0.2;
            this.pulse = Math.random() * Math.PI * 2;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            this.pulse += 0.02;
            const dx = mouseX - this.x, dy = mouseY - this.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 150) {
                const force = (150 - dist) / 150 * 0.3;
                this.x -= dx * force * 0.02;
                this.y -= dy * force * 0.02;
            }
            if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
            if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
        }
        draw() {
            const glow = Math.sin(this.pulse) * 0.15 + 0.85;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size * glow, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255, 255, 255, ${this.opacity * glow})`;
            ctx.fill();
        }
    }

    for (let i = 0; i < 80; i++) particles.push(new Particle());

    function drawConnections() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(255,255,255,${0.08 * (1 - dist / 120)})`;
                    ctx.lineWidth = 0.5;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw(); });
        drawConnections();
        requestAnimationFrame(animate);
    }
    animate();

    // ═══ Mouse Effects ═══
    const glow = document.getElementById('mouseGlow');
    const shapes = document.querySelectorAll('.shape-float');

    document.addEventListener('mousemove', e => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        glow.style.left = e.clientX + 'px';
        glow.style.top = e.clientY + 'px';
        glow.style.opacity = '1';

        shapes.forEach(shape => {
            const speed = parseFloat(shape.dataset.speed || 0.03);
            const cx = window.innerWidth / 2, cy = window.innerHeight / 2;
            const dx = (e.clientX - cx) * speed;
            const dy = (e.clientY - cy) * speed;
            shape.style.transform = `translate(${dx}px, ${dy}px)`;
        });
    });

    document.addEventListener('mouseleave', () => { glow.style.opacity = '0'; });

    // ═══ Ripple Button ═══
    const btn = document.getElementById('submitBtn');
    btn.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const ripple = this.querySelector('.btn-ripple');
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
        ripple.classList.remove('active');
        void ripple.offsetWidth;
        ripple.classList.add('active');
    });

    // ═══ Form Submit Loading ═══
    document.getElementById('loginForm').addEventListener('submit', function() {
        const b = document.getElementById('submitBtn');
        b.querySelector('.btn-content').classList.add('hidden');
        b.querySelector('.btn-loading').classList.remove('hidden');
        b.disabled = true;
        b.style.opacity = '0.85';
    });
});

// ═══ Toggle Password ═══
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    btn.querySelector('.eye-off').classList.toggle('hidden', isPassword);
    btn.querySelector('.eye-on').classList.toggle('hidden', !isPassword);
}
</script>

@endsection
