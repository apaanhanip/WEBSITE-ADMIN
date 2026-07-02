@extends('layouts.app')

@section('title', 'โปรไฟล์สมาชิก')
@section('page-title', $user->name)

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6">
        <div class="card">
            <h2 class="mb-3 font-semibold text-coffee-900">ข้อมูลสมาชิก</h2>
            <p class="font-semibold text-coffee-900">{{ $user->name }}</p>
            <p class="text-sm text-coffee-500">{{ $user->email }}</p>
            @if($user->phone)<p class="text-sm text-coffee-500">{{ $user->phone }}</p>@endif
            <div class="mt-4 rounded-xl bg-cream-100 p-4">
                <p class="text-sm text-coffee-500">ยอดเงินคงเหลือ</p>
                <p class="text-2xl font-bold text-coffee-900">฿{{ number_format($user->balance, 2) }}</p>
            </div>
        </div>

        <div class="card">
            <h2 class="mb-3 font-semibold text-coffee-900">ปรับยอดเงิน</h2>
            @include('components.alert')
            <form action="{{ route('admin.users.balance', $user) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="form-label">จำนวน (+ เพิ่ม / - ลด)</label>
                    <input type="number" name="amount" step="0.01" class="form-input" placeholder="100 หรือ -50" required>
                </div>
                <div>
                    <label class="form-label">หมายเหตุ</label>
                    <input type="text" name="note" class="form-input" placeholder="เช่น โบนัส/คืนเงิน">
                </div>
                <button type="submit" class="btn-primary w-full">บันทึก</button>
            </form>
        </div>
    </div>

    <div class="space-y-6 lg:col-span-2">
        <div class="card">
            <h2 class="mb-3 font-semibold text-coffee-900">คำสั่งซื้อล่าสุด</h2>
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead><tr><th>รหัส</th><th>สินค้า</th><th class="text-right">ยอด</th><th class="text-center">สถานะ</th></tr></thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="font-mono text-xs">{{ $order->order_code }}</td>
                                <td class="max-w-[12rem] truncate">{{ $order->product_name }}</td>
                                <td class="text-right font-semibold">฿{{ number_format($order->total, 2) }}</td>
                                <td class="text-center"><span class="badge-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-coffee-400">ยังไม่มีคำสั่งซื้อ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h2 class="mb-3 font-semibold text-coffee-900">รายการเงินล่าสุด</h2>
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead><tr><th>ประเภท</th><th>รายละเอียด</th><th class="text-right">จำนวน</th><th class="text-right">คงเหลือ</th></tr></thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td>{{ $tx->type_label }}</td>
                                <td class="text-coffee-500">{{ $tx->description }}</td>
                                <td class="text-right font-semibold {{ $tx->amount >= 0 ? 'text-green-700' : 'text-red-600' }}">{{ $tx->amount >= 0 ? '+' : '' }}{{ number_format($tx->amount, 2) }}</td>
                                <td class="text-right">฿{{ number_format($tx->balance_after, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-coffee-400">ยังไม่มีรายการ</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.users.index') }}" class="mt-4 inline-block text-sm text-coffee-600 hover:text-coffee-800">← กลับไปรายการสมาชิก</a>
@endsection
