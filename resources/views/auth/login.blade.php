@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-coffee-950 via-coffee-800 to-coffee-600"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.08\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-cream-100 text-3xl shadow-lg">☕</div>
            <h1 class="font-display text-3xl font-bold text-white">SelfBrew Admin</h1>
            <p class="mt-2 text-coffee-200">Panel pengelola coffee shop</p>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/95 p-8 shadow-2xl backdrop-blur">
            <h2 class="mb-6 text-xl font-semibold text-coffee-900">Masuk ke Akun Admin</h2>

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
                    <input type="password" name="password" id="password"
                           class="form-input" placeholder="••••••••" required>
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

            <p class="mt-6 text-center text-xs text-coffee-500">
                Demo: admin@selfbrew.coko / password
            </p>
        </div>
    </div>
</div>
@endsection
