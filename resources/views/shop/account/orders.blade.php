@extends('layouts.shop')

@section('title', 'ประวัติสั่งซื้อ')

@section('content')
    @include('shop.account._nav', ['active' => 'orders'])

    <div class="shop-card">
        <h2 class="mb-4 font-bold text-white">ประวัติการสั่งซื้อ</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/10 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="py-2 pr-4">รหัสออเดอร์</th>
                        <th class="py-2 pr-4">สินค้า</th>
                        <th class="py-2 pr-4">วันที่</th>
                        <th class="py-2 pr-4 text-right">ยอดรวม</th>
                        <th class="py-2 pr-4">สถานะ</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b border-white/5">
                            <td class="py-3 pr-4 font-mono text-xs text-slate-400">{{ $order->order_code }}</td>
                            <td class="py-3 pr-4 font-medium text-slate-200">{{ $order->product_name }} <span class="text-slate-500">x{{ $order->quantity }}</span></td>
                            <td class="py-3 pr-4 text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 pr-4 text-right font-semibold text-brand-300">฿{{ number_format($order->total, 2) }}</td>
                            <td class="py-3 pr-4">
                                <span class="chip bg-{{ $order->status_color }}-500/20 text-{{ $order->status_color }}-300">{{ $order->status_label }}</span>
                            </td>
                            <td class="py-3 text-right"><a href="{{ route('account.orders.show', $order) }}" class="text-sm font-semibold text-brand-300 hover:text-brand-200">ดู</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-slate-500">ยังไม่มีคำสั่งซื้อ · <a href="{{ route('shop.home') }}" class="text-brand-300">เลือกซื้อสินค้า</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
@endsection
