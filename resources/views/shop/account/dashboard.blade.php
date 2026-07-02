@extends('layouts.shop')

@section('title', 'แดชบอร์ด')

@section('content')
    @include('shop.account._nav', ['active' => 'dashboard'])

    <h1 class="mb-6 text-2xl font-bold text-white">สวัสดี, {{ $user->name }} 👋</h1>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="shop-card">
            <p class="text-sm text-slate-400">ยอดเงินคงเหลือ</p>
            <p class="mt-2 text-3xl font-extrabold text-brand-300">฿{{ number_format($stats['balance'], 2) }}</p>
            <a href="{{ route('account.wallet') }}" class="mt-3 inline-block text-sm font-semibold text-brand-300 hover:text-brand-200">เติมเงิน →</a>
        </div>
        <div class="shop-card">
            <p class="text-sm text-slate-400">คำสั่งซื้อทั้งหมด</p>
            <p class="mt-2 text-3xl font-extrabold text-white">{{ number_format($stats['orders']) }}</p>
        </div>
        <div class="shop-card">
            <p class="text-sm text-slate-400">ยอดใช้จ่ายรวม</p>
            <p class="mt-2 text-3xl font-extrabold text-white">฿{{ number_format($stats['spent'], 2) }}</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="shop-card">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-bold text-white">คำสั่งซื้อล่าสุด</h2>
                <a href="{{ route('account.orders') }}" class="text-sm text-brand-300 hover:text-brand-200">ดูทั้งหมด</a>
            </div>
            @forelse($recentOrders as $order)
                <a href="{{ route('account.orders.show', $order) }}" class="flex items-center justify-between border-b border-white/5 py-3 last:border-0 hover:text-white">
                    <div>
                        <p class="text-sm font-medium text-slate-200">{{ $order->product_name }}</p>
                        <p class="text-xs text-slate-500">{{ $order->order_code }} · {{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-sm font-semibold text-brand-300">฿{{ number_format($order->total, 2) }}</span>
                </a>
            @empty
                <p class="py-6 text-center text-sm text-slate-500">ยังไม่มีคำสั่งซื้อ</p>
            @endforelse
        </div>
        <div class="shop-card">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-bold text-white">รายการเงินล่าสุด</h2>
                <a href="{{ route('account.wallet') }}" class="text-sm text-brand-300 hover:text-brand-200">ดูทั้งหมด</a>
            </div>
            @forelse($recentTransactions as $tx)
                <div class="flex items-center justify-between border-b border-white/5 py-3 last:border-0">
                    <div>
                        <p class="text-sm font-medium text-slate-200">{{ $tx->type_label }}</p>
                        <p class="text-xs text-slate-500">{{ $tx->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-sm font-semibold {{ $tx->amount >= 0 ? 'text-green-400' : 'text-red-400' }}">{{ $tx->amount >= 0 ? '+' : '' }}{{ number_format($tx->amount, 2) }}</span>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-slate-500">ยังไม่มีรายการ</p>
            @endforelse
        </div>
    </div>
@endsection
