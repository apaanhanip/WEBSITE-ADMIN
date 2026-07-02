@extends('layouts.guest')

@section('title', 'Admin Login')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-night-900">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-950 via-night-800 to-night-950"></div>
    <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-brand-500/20 blur-3xl"></div>
    <div class="absolute -bottom-20 -left-10 h-72 w-72 rounded-full bg-brand-600/10 blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 text-3xl font-black text-white shadow-lg">O</div>
            <h1 class="text-3xl font-bold text-white">OTP24HUB Admin</h1>
            <p class="mt-2 text-slate-400">ระบบจัดการหลังบ้าน</p>
        </div>

        <div class="rounded-2xl border border-white/10 bg-night-800/95 p-8 shadow-2xl backdrop-blur">
            <h2 class="mb-6 text-xl font-semibold text-white">เข้าสู่ระบบผู้ดูแล</h2>

            @if($errors->any())
                <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="shop-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="shop-input" placeholder="admin@otp24hub.test" required autofocus>
                </div>
                <div>
                    <label for="password" class="shop-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="shop-input" placeholder="••••••••" required>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-400">
                    <input type="checkbox" name="remember" value="1" class="rounded border-white/20 bg-night-900 text-brand-500 focus:ring-brand-500" {{ old('remember') ? 'checked' : '' }}>
                    จดจำการเข้าสู่ระบบ
                </label>
                <button type="submit" class="shop-btn w-full py-3">เข้าสู่ระบบ</button>
            </form>

            <p class="mt-6 text-center text-xs text-slate-500">
                Demo: admin@otp24hub.test / password
            </p>
            <p class="mt-2 text-center text-xs text-slate-600">
                <a href="{{ route('shop.home') }}" class="hover:text-brand-300">← กลับหน้าร้าน</a>
            </p>
        </div>
    </div>
</div>
@endsection
