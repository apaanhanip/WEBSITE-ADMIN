@extends('layouts.shop')

@section('title', $serviceCategory->name)

@section('content')
    <nav class="mb-4 text-sm text-slate-400">
        <a href="{{ route('shop.home') }}" class="hover:text-white">หน้าแรก</a>
        <span class="mx-1">/</span>
        <span class="text-slate-200">{{ $serviceCategory->name }}</span>
    </nav>

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ $serviceCategory->icon }} {{ $serviceCategory->name }}</h1>
            @if($serviceCategory->description)<p class="mt-1 text-sm text-slate-400">{{ $serviceCategory->description }}</p>@endif
        </div>
        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหาสินค้า..." class="shop-input sm:w-64">
            <button class="shop-btn">ค้นหา</button>
        </form>
    </div>

    @if($products->isEmpty())
        <div class="shop-card text-center text-slate-400">ไม่พบสินค้าในหมวดหมู่นี้</div>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($products as $product)
                @include('shop._product_card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @endif
@endsection
