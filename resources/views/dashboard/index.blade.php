@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan operasional coffee shop')

@section('content')
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8 animate-fade-up">
    <x-stat-card title="Total Pendapatan" :value="'Rp '.number_format($totalRevenue, 0, ',', '.')" icon="cash" color="brand" />
    <x-stat-card title="Total Transaksi" :value="$totalTransaction" icon="card" color="blue" />
    <x-stat-card title="Total Pesanan" :value="$totalOrder" icon="clipboard" color="purple" />
    <x-stat-card title="Total Menu" :value="$totalMenu" icon="menu" color="green" />
    <x-stat-card title="Total Kategori" :value="$totalCategory" icon="tag" color="accent" />
    <x-stat-card title="Pesanan Hari Ini" :value="\App\Models\Order::whereDate('created_at', today())->count()" icon="calendar" color="rose" />
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-8">
    <div class="card lg:col-span-2">
        <h3 class="mb-4 text-lg font-semibold text-coffee-900">Tren Penjualan (Mingguan)</h3>
        <canvas id="weeklySalesChart" height="120"></canvas>
    </div>
    <div class="card">
        <h3 class="mb-4 text-lg font-semibold text-coffee-900">Status Pesanan</h3>
        @php
            $statusDots = ['pending' => 'bg-yellow-400', 'diproses' => 'bg-blue-500', 'selesai' => 'bg-emerald-500', 'dibatalkan' => 'bg-red-500'];
        @endphp
        <div class="space-y-2.5">
            @foreach(['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $key => $label)
            <div class="flex items-center justify-between rounded-xl bg-cream-50 px-4 py-3 transition hover:bg-cream-100">
                <span class="flex items-center gap-2.5 text-sm font-medium text-coffee-700">
                    <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $statusDots[$key] }}"></span>
                    {{ $label }}
                </span>
                <span class="text-lg font-bold text-coffee-900">{{ (int) ($orderStatusSummary[$key] ?? 0) }}</span>
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
        <h3 class="mb-4 text-lg font-semibold text-coffee-900">Produk Paling Laris</h3>
        @if($topMenus->isEmpty())
            <x-empty-state title="Belum ada data penjualan" />
        @else
        @php $maxQty = max(1, (int) $topMenus->max('total_qty')); @endphp
        <div class="space-y-4">
            @foreach($topMenus as $index => $menu)
            <div>
                <div class="flex items-center justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="text-sm font-bold text-coffee-400">#{{ $index + 1 }}</span>
                        <p class="truncate font-medium text-coffee-800">{{ $menu->menu_name }}</p>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-brand-600">{{ $menu->total_qty }} Porsi</span>
                </div>
                <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-cream-100">
                    <div class="h-full rounded-full bg-brand-gradient" style="width: {{ max(6, round($menu->total_qty / $maxQty * 100)) }}%"></div>
                </div>
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
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, '#f87171');
        gradient.addColorStop(1, '#dc2626');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($weeklySales['labels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($weeklySales['data']),
                    backgroundColor: gradient,
                    hoverBackgroundColor: '#dc2626',
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 38,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#eef1f6' },
                        border: { display: false },
                        ticks: {
                            color: '#94a3b8',
                            callback: (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
