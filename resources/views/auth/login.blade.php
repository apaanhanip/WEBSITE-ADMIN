@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="min-h-screen lg:grid lg:grid-cols-2">
    {{-- Brand panel --}}
    <div class="relative hidden overflow-hidden bg-gradient-to-br from-coffee-950 via-brand-900 to-coffee-900 lg:flex lg:flex-col lg:justify-between lg:p-12">
        <div class="pointer-events-none absolute -left-24 -top-24 h-80 w-80 rounded-full bg-brand-500/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-16 h-96 w-96 rounded-full bg-accent-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.06]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

        <div class="relative z-10 flex items-center">
            <x-logo class="h-9 w-auto text-white" />
        </div>

        <div class="relative z-10 max-w-md">
            <h2 class="font-display text-4xl font-bold leading-tight text-white">Kelola coffee shop Anda dengan lebih cerdas.</h2>
            <p class="mt-4 text-base leading-relaxed text-white/70">Panel admin terpadu untuk memantau penjualan, mengelola menu, dan memproses pesanan secara real-time.</p>

            <ul class="mt-8 space-y-3">
                @foreach(['Dashboard analitik penjualan', 'Manajemen menu & kategori', 'Pemrosesan pesanan real-time'] as $feature)
                <li class="flex items-center gap-3 text-sm text-white/80">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 ring-1 ring-white/20">
                        <svg class="h-3.5 w-3.5 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    {{ $feature }}
                </li>
                @endforeach
            </ul>
        </div>

        <p class="relative z-10 text-xs text-white/40">&copy; {{ date('Y') }} CŌKO Admin. Self-Order Kiosk System.</p>
    </div>

    {{-- Form panel --}}
    <div class="flex min-h-screen items-center justify-center bg-cream-50 px-4 py-12 lg:min-h-0">
        <div class="w-full max-w-md animate-fade-up">
            <div class="mb-8 flex justify-center lg:hidden">
                <x-logo class="h-10 w-auto text-coffee-900" />
            </div>

            <div class="rounded-2xl border border-coffee-100 bg-white p-8 shadow-card">
                <h2 class="text-2xl font-bold text-coffee-900">Selamat datang kembali</h2>
                <p class="mb-6 mt-1 text-sm text-coffee-500">Masuk untuk melanjutkan ke dashboard admin.</p>

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
                               class="h-4 w-4 rounded border-coffee-300 text-brand-600 focus:ring-brand-400"
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
