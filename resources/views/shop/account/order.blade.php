@extends('layouts.shop')

@section('title', 'รายละเอียดคำสั่งซื้อ')

@section('content')
<div class="mx-auto max-w-2xl">
    <a href="{{ route('account.orders') }}" class="mb-4 inline-block text-sm text-slate-400 hover:text-white">← กลับไปประวัติสั่งซื้อ</a>

    <div class="shop-card">
        <div class="flex items-start justify-between border-b border-white/10 pb-4">
            <div>
                <h1 class="text-xl font-bold text-white">{{ $purchase->product_name }}</h1>
                <p class="mt-1 font-mono text-sm text-slate-400">{{ $purchase->order_code }}</p>
            </div>
            <span class="chip bg-{{ $purchase->status_color }}-500/20 text-{{ $purchase->status_color }}-300">{{ $purchase->status_label }}</span>
        </div>

        <dl class="grid grid-cols-2 gap-4 py-4 text-sm">
            <div><dt class="text-slate-500">ราคาต่อหน่วย</dt><dd class="font-semibold text-slate-200">฿{{ number_format($purchase->unit_price, 2) }}</dd></div>
            <div><dt class="text-slate-500">จำนวน</dt><dd class="font-semibold text-slate-200">{{ $purchase->quantity }}</dd></div>
            <div><dt class="text-slate-500">ยอดชำระ</dt><dd class="font-semibold text-brand-300">฿{{ number_format($purchase->total, 2) }}</dd></div>
            <div><dt class="text-slate-500">วันที่</dt><dd class="font-semibold text-slate-200">{{ $purchase->created_at->format('d/m/Y H:i') }}</dd></div>
        </dl>

        @if($purchase->status === 'completed' && $purchase->delivered_content)
            <div class="rounded-xl border border-green-500/30 bg-green-500/10 p-4">
                <p class="mb-2 flex items-center gap-2 text-sm font-semibold text-green-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    ข้อมูลสินค้า (จัดส่งอัตโนมัติ)
                </p>
                <pre id="delivered" class="overflow-x-auto whitespace-pre-wrap break-words rounded-lg bg-night-950 p-3 font-mono text-sm text-slate-100">{{ $purchase->delivered_content }}</pre>
                <button type="button" onclick="copyDelivered()" class="shop-btn-ghost mt-3 text-xs">คัดลอกข้อมูล</button>
            </div>
        @elseif($purchase->status === 'pending')
            <div class="rounded-xl border border-yellow-500/30 bg-yellow-500/10 p-4 text-sm text-yellow-200">
                คำสั่งซื้อนี้อยู่ระหว่างดำเนินการ ทีมงานจะจัดส่งให้โดยเร็วที่สุด
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function copyDelivered() {
        const el = document.getElementById('delivered');
        navigator.clipboard.writeText(el.innerText).then(() => ShopToast.fire({ icon: 'success', title: 'คัดลอกแล้ว' }));
    }
</script>
@endpush
@endsection
