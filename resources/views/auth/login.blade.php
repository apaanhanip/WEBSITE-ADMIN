@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-700 via-brand-600 to-brand-400"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.08\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative z-10 w-full max-w-md animate-fade-up px-4">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 animate-float items-center justify-center rounded-2xl bg-accent-gradient text-white shadow-glow">
                <x-icon name="cup" class="h-8 w-8" />
            </div>
            <h1 class="font-display text-3xl font-bold text-white">SelfBrew Admin</h1>
            <p class="mt-2 text-white/85">Panel pengelola coffee shop</p>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/95 p-8 shadow-2xl backdrop-blur">
            <h2 class="mb-1 text-xl font-semibold text-coffee-900">Masuk ke Akun Admin</h2>
            <p class="mb-6 text-sm text-coffee-500">Silakan login untuk melanjutkan ke dashboard.</p>

            @include('components.alert')

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="form-input" placeholder="admin@selfbrew.coko" required autofocus>
                </div>
                <div>
                    <label for="password" class="form-label">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                               class="form-input pr-12" placeholder="••••••••" required>
                        <button type="button" id="togglePassword" aria-label="Tampilkan password"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-coffee-400 transition hover:text-coffee-700">
                            <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" value="1"
                           class="h-4 w-4 rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 text-sm text-coffee-700">Ingat saya</label>
                </div>
                <button type="submit" class="btn-primary w-full py-3">
                    Masuk Dashboard
                </button>
            </form>

            <p class="mt-6 rounded-xl bg-cream-100 py-2 text-center text-xs text-coffee-500">
                Demo: <span class="font-semibold text-coffee-700">admin@selfbrew.coko</span> / <span class="font-semibold text-coffee-700">password</span>
            </p>
        </div>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('togglePassword');
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (toggle && pwd) {
                toggle.addEventListener('click', function () {
                    const show = pwd.type === 'password';
                    pwd.type = show ? 'text' : 'password';
                    eye.innerHTML = show
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
                });
            }
        })();
    </script>
</div>
@endsection
