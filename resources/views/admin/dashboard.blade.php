@extends('layouts.app')

@section('title', 'แดชบอร์ด')
@section('page-title', 'แดชบอร์ด')
@section('page-subtitle', 'ภาพรวมระบบ OTP24HUB')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="card"><p class="text-sm font-medium text-coffee-500">รายได้รวม</p><p class="mt-2 text-2xl font-bold text-coffee-900">฿{{ number_format($stats['revenue'], 2) }}</p></div>
        <div class="card"><p class="text-sm font-medium text-coffee-500">คำสั่งซื้อ</p><p class="mt-2 text-2xl font-bold text-coffee-900">{{ number_format($stats['orders']) }}</p></div>
        <div class="card"><p class="text-sm font-medium text-coffee-500">สมาชิก</p><p class="mt-2 text-2xl font-bold text-coffee-900">{{ number_format($stats['users']) }}</p></div>
        <div class="card"><p class="text-sm font-medium text-coffee-500">สินค้า</p><p class="mt-2 text-2xl font-bold text-coffee-900">{{ number_format($stats['products']) }}</p></div>
        <div class="card"><p class="text-sm font-medium text-coffee-500">ยอดเติมเงินรวม</p><p class="mt-2 text-2xl font-bold text-coffee-900">฿{{ number_format($stats['topup'], 2) }}</p></div>
        <div class="card"><p class="text-sm font-medium text-coffee-500">สต็อกพร้อมขาย</p><p class="mt-2 text-2xl font-bold text-coffee-900">{{ number_format($stats['stock']) }}</p></div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="card lg:col-span-2">
            <h2 class="mb-4 font-semibold text-coffee-900">ยอดขาย 7 วันล่าสุด</h2>
            <canvas id="salesChart" height="110"></canvas>
        </div>
        <div class="card">
            <h2 class="mb-4 font-semibold text-coffee-900">สินค้าขายดี</h2>
            @forelse($topProducts as $p)
                <div class="flex items-center justify-between border-b border-coffee-50 py-2 last:border-0">
                    <span class="truncate pr-2 text-sm text-coffee-800">{{ $p->name }}</span>
                    <span class="text-sm font-semibold text-coffee-600">{{ number_format($p->sold_count) }}</span>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-coffee-400">ยังไม่มีข้อมูล</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="card">
            <h2 class="mb-4 font-semibold text-coffee-900">คำสั่งซื้อล่าสุด</h2>
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead><tr><th>รหัส</th><th>สมาชิก</th><th>สินค้า</th><th class="text-right">ยอด</th></tr></thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="font-mono text-xs">{{ $order->order_code }}</td>
                                <td>{{ $order->user?->name ?? '-' }}</td>
                                <td class="max-w-[10rem] truncate">{{ $order->product_name }}</td>
                                <td class="text-right font-semibold">฿{{ number_format($order->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-coffee-400">ยังไม่มีคำสั่งซื้อ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <h2 class="mb-4 font-semibold text-coffee-900">สต็อกใกล้หมด</h2>
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead><tr><th>สินค้า</th><th class="text-right">คงเหลือ</th><th></th></tr></thead>
                    <tbody>
                        @forelse($lowStock as $p)
                            <tr>
                                <td class="max-w-[12rem] truncate">{{ $p->name }}</td>
                                <td class="text-right"><span class="{{ $p->available <= 3 ? 'badge-red' : 'badge-green' }}">{{ $p->available }}</span></td>
                                <td class="text-right"><a href="{{ route('admin.products.stock', $p) }}" class="text-sm font-semibold text-coffee-600 hover:text-coffee-800">เติมสต็อก</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-6 text-center text-coffee-400">ยังไม่มีข้อมูล</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: @json($chart['labels']),
            datasets: [{
                label: 'ยอดขาย (฿)',
                data: @json($chart['data']),
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79,70,229,0.12)',
                fill: true,
                tension: 0.35,
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
</script>
@endpush
