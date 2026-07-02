@extends('layouts.app')

@section('title', 'กระเป๋าเงิน')
@section('page-title', 'รายการเงิน')
@section('page-subtitle', 'ประวัติการเติมเงินและการใช้จ่ายทั้งหมด')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="card py-3"><span class="text-sm text-coffee-500">ยอดเติมเงินรวม: </span><span class="font-bold text-coffee-900">฿{{ number_format($totalTopup, 2) }}</span></div>
        <form method="GET" class="flex gap-2">
            <select name="type" class="form-input sm:w-44">
                <option value="">ทุกประเภท</option>
                <option value="topup" {{ request('type') === 'topup' ? 'selected' : '' }}>เติมเงิน</option>
                <option value="purchase" {{ request('type') === 'purchase' ? 'selected' : '' }}>ซื้อสินค้า</option>
                <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>คืนเงิน</option>
            </select>
            <button class="btn-secondary">กรอง</button>
        </form>
    </div>

    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead><tr><th>สมาชิก</th><th>ประเภท</th><th>รายละเอียด</th><th>ช่องทาง</th><th class="text-right">จำนวน</th><th class="text-right">คงเหลือ</th><th>วันที่</th></tr></thead>
                <tbody>
                    @forelse($transactions as $tx)
                        <tr>
                            <td class="font-semibold text-coffee-900">{{ $tx->user?->name ?? '-' }}</td>
                            <td>{{ $tx->type_label }}</td>
                            <td class="max-w-[14rem] truncate text-coffee-500">{{ $tx->description }}</td>
                            <td class="text-xs uppercase text-coffee-400">{{ $tx->method ?? '-' }}</td>
                            <td class="text-right font-semibold {{ $tx->amount >= 0 ? 'text-green-700' : 'text-red-600' }}">{{ $tx->amount >= 0 ? '+' : '' }}{{ number_format($tx->amount, 2) }}</td>
                            <td class="text-right">฿{{ number_format($tx->balance_after, 2) }}</td>
                            <td class="text-xs text-coffee-500">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><x-empty-state title="ยังไม่มีรายการเงิน" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $transactions->links() }}</div>
@endsection
