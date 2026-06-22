@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan operasional coffee shop')

@section('content')
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6 mb-8">
    <x-stat-card title="Total Menu" :value="$totalMenu" icon="🍽️" />
    <x-stat-card title="Total Kategori" :value="$totalCategory" icon="📂" />
    <x-stat-card title="Total Pesanan" :value="$totalOrder" icon="📋" />
    <x-stat-card title="Total Transaksi" :value="$totalTransaction" icon="💳" />
    <x-stat-card title="Total Pendapatan" :value="'Rp '.number_format($totalRevenue, 0, ',', '.')" icon="💰" />
    <x-stat-card title="Pesanan Hari Ini" :value="\App\Models\Order::whereDate('created_at', today())->count()" icon="📅" />
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-8">
    <div class="card lg:col-span-2">
        <h3 class="mb-4 text-lg font-semibold text-coffee-900">Penjualan Mingguan</h3>
        <canvas id="weeklySalesChart" height="120"></canvas>
    </div>
    <div class="card">
        <h3 class="mb-4 text-lg font-semibold text-coffee-900">Status Pesanan</h3>
        <div class="space-y-3">
            @foreach(['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $key => $label)
            <div class="flex items-center justify-between rounded-xl bg-cream-50 px-4 py-3">
                <span class="text-sm font-medium text-coffee-700">{{ $label }}</span>
                <x-status-badge :status="$key" />
                <span class="text-lg font-bold text-coffee-900">{{ $orderStatusSummary[$key] ?? 0 }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div class="card">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-coffee-900">Pesanan Terbaru</h3>
            <a href="{{ route('orders.index') }}" class="text-sm font-medium text-coffee-600 hover:text-coffee-800">Lihat semua →</a>
        </div>
        @if($recentOrders->isEmpty())
            <x-empty-state title="Belum ada pesanan" />
        @else
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td class="font-medium">{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><x-status-badge :status="$order->status" /></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="card">
        <h3 class="mb-4 text-lg font-semibold text-coffee-900">Menu Terlaris</h3>
        @if($topMenus->isEmpty())
            <x-empty-state title="Belum ada data penjualan" />
        @else
        <div class="space-y-3">
            @foreach($topMenus as $index => $menu)
            <div class="flex items-center gap-4 rounded-xl bg-cream-50 p-4">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-coffee-700 text-sm font-bold text-white">{{ $index + 1 }}</span>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-coffee-900 truncate">{{ $menu->menu_name }}</p>
                    <p class="text-xs text-coffee-500">{{ $menu->total_qty }} terjual</p>
                </div>
                <p class="text-sm font-semibold text-coffee-800">Rp {{ number_format($menu->total_sales, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('weeklySalesChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($weeklySales['labels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($weeklySales['data']),
                    borderColor: '#6f4a2a',
                    backgroundColor: 'rgba(111, 74, 42, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#8b5e34',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
