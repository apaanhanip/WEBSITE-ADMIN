@extends('layouts.shop')

@section('title', 'เข้าสู่ระบบ')

@section('content')
<div class="mx-auto max-w-md py-8">
    <div class="shop-card">
        <h1 class="text-2xl font-bold text-white">เข้าสู่ระบบ</h1>
        <p class="mt-1 text-sm text-slate-400">ยินดีต้อนรับกลับมา</p>

        @if($errors->any())
            <div class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="shop-label">อีเมล</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="shop-input" required autofocus>
            </div>
            <div>
                <label for="password" class="shop-label">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="shop-input" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-400">
                <input type="checkbox" name="remember" value="1" class="rounded border-white/20 bg-night-900 text-brand-500 focus:ring-brand-500">
                จดจำฉันไว้
            </label>
            <button type="submit" class="shop-btn w-full py-3">เข้าสู่ระบบ</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            ยังไม่มีบัญชี? <a href="{{ route('register') }}" class="font-semibold text-brand-300 hover:text-brand-200">สมัครสมาชิก</a>
        </p>
        <p class="mt-3 rounded-lg bg-night-900 px-3 py-2 text-center text-xs text-slate-500">
            บัญชีทดลอง: demo@otp24hub.test / password
        </p>
    </div>
</div>
@endsection
