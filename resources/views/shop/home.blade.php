@extends('layouts.shop')

@section('title', 'เว็บรับ OTP ออนไลน์ อันดับ 1')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-brand-950 via-night-800 to-night-900 px-6 py-12 sm:px-12 sm:py-16">
        <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-brand-500/20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 h-64 w-64 rounded-full bg-brand-600/10 blur-3xl"></div>
        <div class="relative max-w-2xl">
            <span class="chip bg-brand-500/20 text-brand-200">⚡ ระบบออโต้ 24 ชั่วโมง</span>
            <h1 class="mt-4 text-3xl font-extrabold leading-tight text-white sm:text-5xl">
                เว็บรับ OTP ออนไลน์ <span class="bg-gradient-to-r from-brand-300 to-brand-500 bg-clip-text text-transparent">อันดับ 1 ในไทย</span>
            </h1>
            <p class="mt-4 text-base text-slate-300 sm:text-lg">
                บริการรับ OTP ราคาถูก เริ่มต้น 10 บาท พร้อมแอคเคาท์พรีเมียม, AI Tools, เติมเกม และปั๊มฟอล ส่งทันทีด้วยระบบอัตโนมัติ
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#products" class="shop-btn">ดูสินค้าทั้งหมด</a>
                @guest('web')
                    <a href="{{ route('register') }}" class="shop-btn-ghost">สมัครสมาชิกฟรี</a>
                @endguest
            </div>
            <div class="mt-8 flex flex-wrap gap-8">
                <div><p class="text-2xl font-bold text-white">{{ number_format($stats['products']) }}+</p><p class="text-sm text-slate-400">สินค้า</p></div>
                <div><p class="text-2xl font-bold text-white">{{ number_format($stats['categories']) }}</p><p class="text-sm text-slate-400">หมวดหมู่บริการ</p></div>
                <div><p class="text-2xl font-bold text-white">{{ number_format($stats['sales']) }}+</p><p class="text-sm text-slate-400">ออเดอร์สำเร็จ</p></div>
            </div>
        </div>
    </section>

    {{-- Category grid --}}
    <section class="mt-10">
        <h2 class="mb-4 text-xl font-bold text-white">หมวดหมู่บริการ</h2>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            @foreach($categories as $cat)
                <a href="{{ route('shop.category', $cat) }}" class="shop-card flex flex-col items-center gap-2 py-6 text-center transition hover:border-brand-400/50 hover:bg-night-700">
                    <span class="text-3xl">{{ $cat->icon ?: '🛍️' }}</span>
                    <span class="text-sm font-semibold text-white">{{ $cat->name }}</span>
                    <span class="text-xs text-slate-500">{{ $cat->products_count }} รายการ</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Live sales feed --}}
    @if($recentSales->isNotEmpty())
        <section class="mt-6 overflow-hidden rounded-2xl border border-white/10 bg-night-800">
            <div class="flex items-center gap-2 border-b border-white/10 px-4 py-2">
                <span class="flex h-2 w-2 animate-pulse rounded-full bg-green-400"></span>
                <span class="text-sm font-semibold text-white">ขายล่าสุด</span>
            </div>
            <div class="flex flex-wrap gap-x-6 gap-y-1 px-4 py-3 text-xs text-slate-400">
                @foreach($recentSales as $sale)
                    <span><span class="text-brand-300">{{ $sale->product_name }}</span> · ขายแล้ว {{ $sale->created_at->diffForHumans() }}</span>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Product sections per category --}}
    <div id="products" class="mt-12 space-y-12">
        @forelse($sections as $section)
            <section>
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $section->icon }} {{ $section->name }}</h2>
                        @if($section->tagline)<p class="text-sm text-slate-400">{{ $section->tagline }}</p>@endif
                    </div>
                    <a href="{{ route('shop.category', $section) }}" class="text-sm font-semibold text-brand-300 hover:text-brand-200">ดูทั้งหมด →</a>
                </div>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach($section->activeProducts as $product)
                        @include('shop._product_card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @empty
            <div class="shop-card text-center text-slate-400">ยังไม่มีสินค้าในระบบ</div>
        @endforelse
    </div>
@endsection
