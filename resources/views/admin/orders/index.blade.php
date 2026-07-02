@extends('layouts.app')

@section('title', 'คำสั่งซื้อ')
@section('page-title', 'คำสั่งซื้อ')
@section('page-subtitle', 'รายการสั่งซื้อทั้งหมด')

@section('content')
    <form method="GET" class="mb-4 flex flex-wrap gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหารหัส/สินค้า..." class="form-input sm:w-56">
        <select name="status" class="form-input sm:w-40">
            <option value="">ทุกสถานะ</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>สำเร็จ</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ไม่สำเร็จ</option>
        </select>
        <button class="btn-secondary">กรอง</button>
    </form>

    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead><tr><th>รหัส</th><th>สมาชิก</th><th>สินค้า</th><th class="text-center">จำนวน</th><th class="text-right">ยอด</th><th class="text-center">สถานะ</th><th>วันที่</th><th class="text-right"></th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="font-mono text-xs">{{ $order->order_code }}</td>
                            <td>{{ $order->user?->name ?? '-' }}</td>
                            <td class="max-w-[12rem] truncate">{{ $order->product_name }}</td>
                            <td class="text-center">{{ $order->quantity }}</td>
                            <td class="text-right font-semibold">฿{{ number_format($order->total, 2) }}</td>
                            <td class="text-center"><span class="badge-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                            <td class="text-xs text-coffee-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-right"><a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-coffee-600 hover:text-coffee-800">ดู</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8"><x-empty-state title="ยังไม่มีคำสั่งซื้อ" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
