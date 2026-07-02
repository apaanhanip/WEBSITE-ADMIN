@extends('layouts.shop')

@section('title', 'สมัครสมาชิก')

@section('content')
<div class="mx-auto max-w-md py-8">
    <div class="shop-card">
        <h1 class="text-2xl font-bold text-white">สมัครสมาชิก</h1>
        <p class="mt-1 text-sm text-slate-400">สร้างบัญชีใหม่ ใช้งานได้ทันที</p>

        @if($errors->any())
            <div class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="name" class="shop-label">ชื่อ</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="shop-input" required autofocus>
            </div>
            <div>
                <label for="email" class="shop-label">อีเมล</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="shop-input" required>
            </div>
            <div>
                <label for="phone" class="shop-label">เบอร์โทร (ไม่บังคับ)</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="shop-input">
            </div>
            <div>
                <label for="password" class="shop-label">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="shop-input" required>
            </div>
            <div>
                <label for="password_confirmation" class="shop-label">ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shop-input" required>
            </div>
            <button type="submit" class="shop-btn w-full py-3">สมัครสมาชิก</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}" class="font-semibold text-brand-300 hover:text-brand-200">เข้าสู่ระบบ</a>
        </p>
    </div>
</div>
@endsection
