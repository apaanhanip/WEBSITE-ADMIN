@extends('layouts.app')

@section('title', 'Pesanan')
@section('page-title', 'Manajemen Pesanan')
@section('page-subtitle', 'Kelola dan update status pesanan kiosk')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <form action="{{ route('orders.index') }}" method="GET" class="flex flex-wrap gap-2 flex-1">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. order / customer..." class="form-input max-w-xs">
        <select name="status" class="form-input max-w-[180px]">
            <option value="">Semua Status</option>
            @foreach(\App\Models\Order::STATUSES as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status === 'diproses' ? 'Diproses' : $status) }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
    </form>
</div>

<div class="card overflow-hidden p-0">
    @if($orders->isEmpty())
        <x-empty-state title="Belum ada pesanan" description="Pesanan dari kiosk akan muncul di sini." />
    @else
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>No. Order</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="font-semibold text-coffee-900">{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        <span class="text-sm text-coffee-600">{{ $order->items->count() }} item</span>
                        <p class="text-xs text-coffee-400 truncate max-w-[150px]">
                            {{ $order->items->pluck('menu_name')->take(2)->join(', ') }}{{ $order->items->count() > 2 ? '...' : '' }}
                        </p>
                    </td>
                    <td class="font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                        <x-status-badge :status="$order->status" :id="'status-badge-'.$order->id" />
                    </td>
                    <td class="text-sm text-coffee-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-right">
                        <div class="flex flex-col sm:flex-row items-end sm:items-center gap-2 justify-end">
                            <select class="order-status-select form-input py-1.5 text-xs max-w-[130px]"
                                    data-order-id="{{ $order->id }}"
                                    data-url="{{ route('orders.update-status', $order) }}"
                                    data-original="{{ $order->status }}">
                                @foreach(\App\Models\Order::STATUSES as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ match($status) { 'pending'=>'Pending','diproses'=>'Diproses','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan', default=>ucfirst($status)} }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn-secondary py-1.5 px-3 text-xs btn-order-detail"
                                    data-url="{{ route('orders.show', $order) }}">
                                Detail
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="border-t border-coffee-100 px-4 py-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection

@push('modals')
<div id="order-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" data-close-modal></div>
    <div class="relative z-10 w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-coffee-900">Detail Pesanan</h3>
            <button type="button" data-close-modal class="rounded-lg p-1 hover:bg-cream-100 text-coffee-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="order-modal-content"></div>
    </div>
</div>
@endpush
