@extends('layouts.app')

@section('title', 'รายละเอียดคำสั่งซื้อ')
@section('page-title', 'คำสั่งซื้อ ' . $purchase->order_code)

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="card lg:col-span-2">
        <h2 class="mb-4 font-semibold text-coffee-900">รายละเอียด</h2>
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div><dt class="text-coffee-500">รหัสออเดอร์</dt><dd class="font-mono font-semibold text-coffee-900">{{ $purchase->order_code }}</dd></div>
            <div><dt class="text-coffee-500">สถานะ</dt><dd><span class="badge-{{ $purchase->status_color }}">{{ $purchase->status_label }}</span></dd></div>
            <div><dt class="text-coffee-500">สินค้า</dt><dd class="font-semibold text-coffee-900">{{ $purchase->product_name }}</dd></div>
            <div><dt class="text-coffee-500">จำนวน</dt><dd class="font-semibold text-coffee-900">{{ $purchase->quantity }}</dd></div>
            <div><dt class="text-coffee-500">ราคาต่อหน่วย</dt><dd class="font-semibold text-coffee-900">฿{{ number_format($purchase->unit_price, 2) }}</dd></div>
            <div><dt class="text-coffee-500">ยอดรวม</dt><dd class="font-semibold text-coffee-900">฿{{ number_format($purchase->total, 2) }}</dd></div>
            <div><dt class="text-coffee-500">วันที่</dt><dd class="font-semibold text-coffee-900">{{ $purchase->created_at->format('d/m/Y H:i') }}</dd></div>
        </dl>

        @if($purchase->delivered_content)
            <div class="mt-6">
                <p class="mb-2 text-sm font-semibold text-coffee-700">ข้อมูลที่จัดส่ง</p>
                <pre class="overflow-x-auto whitespace-pre-wrap break-words rounded-xl bg-coffee-950 p-4 font-mono text-xs text-cream-100">{{ $purchase->delivered_content }}</pre>
            </div>
        @endif
    </div>

    <div class="card">
        <h2 class="mb-4 font-semibold text-coffee-900">ลูกค้า</h2>
        @if($purchase->user)
            <p class="font-semibold text-coffee-900">{{ $purchase->user->name }}</p>
            <p class="text-sm text-coffee-500">{{ $purchase->user->email }}</p>
            @if($purchase->user->phone)<p class="text-sm text-coffee-500">{{ $purchase->user->phone }}</p>@endif
            <a href="{{ route('admin.users.show', $purchase->user) }}" class="btn-secondary mt-4 w-full text-sm">ดูโปรไฟล์</a>
        @else
            <p class="text-sm text-coffee-400">ไม่พบข้อมูลลูกค้า</p>
        @endif
    </div>
</div>

<a href="{{ route('admin.orders.index') }}" class="mt-4 inline-block text-sm text-coffee-600 hover:text-coffee-800">← กลับไปรายการคำสั่งซื้อ</a>
@endsection
