@extends('layouts.shop')

@section('title', $product->name)

@section('content')
    <nav class="mb-4 text-sm text-slate-400">
        <a href="{{ route('shop.home') }}" class="hover:text-white">หน้าแรก</a>
        <span class="mx-1">/</span>
        <a href="{{ route('shop.category', $product->category) }}" class="hover:text-white">{{ $product->category->name }}</a>
        <span class="mx-1">/</span>
        <span class="text-slate-200">{{ $product->name }}</span>
    </nav>

    <div class="grid gap-8 lg:grid-cols-2">
        <div class="overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-night-700 to-night-900">
            <div class="flex aspect-video items-center justify-center">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <span class="text-7xl opacity-60">{{ $product->category->icon ?? '🛍️' }}</span>
                @endif
            </div>
        </div>

        <div>
            <span class="chip bg-brand-500/20 text-brand-200">{{ $product->category->name }}</span>
            <h1 class="mt-3 text-2xl font-bold text-white sm:text-3xl">{{ $product->name }}</h1>
            <div class="mt-4 flex items-center gap-4">
                <span class="text-3xl font-extrabold text-brand-300">฿{{ number_format($product->price, 2) }}</span>
                @if($product->in_stock)
                    <span class="chip bg-green-500/20 text-green-300">✓ พร้อมส่งอัตโนมัติ</span>
                @else
                    <span class="chip bg-red-500/20 text-red-300">สินค้าหมดสต็อก</span>
                @endif
            </div>

            @if($product->description)
                <div class="mt-5 rounded-xl border border-white/10 bg-night-800 p-4 text-sm leading-relaxed text-slate-300 whitespace-pre-line">{{ $product->description }}</div>
            @endif

            <div class="mt-6 rounded-2xl border border-white/10 bg-night-800 p-5">
                @auth('web')
                    @if($product->in_stock)
                        <form action="{{ route('purchase.store', $product) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex items-center gap-3">
                                <label for="quantity" class="shop-label mb-0">จำนวน</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="20" class="shop-input w-24">
                            </div>
                            <div class="flex items-center justify-between text-sm text-slate-400">
                                <span>ยอดเงินคงเหลือ</span>
                                <span class="font-semibold text-white">฿{{ number_format(auth('web')->user()->balance, 2) }}</span>
                            </div>
                            <button type="submit" class="shop-btn w-full py-3 text-base">ซื้อทันที</button>
                            <a href="{{ route('account.wallet') }}" class="block text-center text-sm text-brand-300 hover:text-brand-200">เติมเงินเข้ากระเป๋า</a>
                        </form>
                    @else
                        <p class="text-center text-sm text-slate-400">ขออภัย สินค้านี้หมดสต็อกชั่วคราว</p>
                    @endif
                @else
                    <p class="mb-3 text-center text-sm text-slate-400">เข้าสู่ระบบเพื่อสั่งซื้อสินค้า</p>
                    <div class="flex gap-3">
                        <a href="{{ route('login') }}" class="shop-btn flex-1">เข้าสู่ระบบ</a>
                        <a href="{{ route('register') }}" class="shop-btn-ghost flex-1">สมัครสมาชิก</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    @if($related->isNotEmpty())
        <section class="mt-12">
            <h2 class="mb-4 text-xl font-bold text-white">สินค้าที่เกี่ยวข้อง</h2>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($related as $item)
                    @include('shop._product_card', ['product' => $item])
                @endforeach
            </div>
        </section>
    @endif
@endsection
