@extends('layouts.shop')

@section('title', 'กระเป๋าเงิน')

@section('content')
    @include('shop.account._nav', ['active' => 'wallet'])

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <div class="shop-card bg-gradient-to-br from-brand-700 to-brand-900">
                <p class="text-sm text-brand-100">ยอดเงินคงเหลือ</p>
                <p class="mt-2 text-4xl font-extrabold text-white">฿{{ number_format($user->balance, 2) }}</p>
            </div>

            <div class="shop-card mt-4">
                <h2 class="mb-4 font-bold text-white">เติมเงินเข้ากระเป๋า</h2>
                @if($errors->any())
                    <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                @endif
                <form action="{{ route('account.wallet.topup') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="shop-label">จำนวนเงิน (บาท)</label>
                        <input type="number" name="amount" min="10" max="100000" step="1" value="{{ old('amount', 100) }}" class="shop-input" required>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach([50, 100, 300, 500, 1000] as $preset)
                                <button type="button" onclick="document.getElementsByName('amount')[0].value={{ $preset }}" class="chip bg-white/5 text-slate-300 hover:bg-white/10">฿{{ $preset }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="shop-label">ช่องทางชำระเงิน</label>
                        <select name="method" class="shop-input" required>
                            <option value="promptpay">PromptPay / QR พร้อมเพย์</option>
                            <option value="truewallet">TrueMoney Wallet</option>
                            <option value="bank">โอนผ่านธนาคาร</option>
                        </select>
                    </div>
                    <button type="submit" class="shop-btn w-full py-3">เติมเงิน</button>
                    <p class="text-center text-xs text-slate-500">ระบบเดโม: เติมเงินอัตโนมัติทันที</p>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="shop-card">
                <h2 class="mb-4 font-bold text-white">ประวัติรายการเงิน</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-white/10 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="py-2 pr-4">รายการ</th>
                                <th class="py-2 pr-4">วันที่</th>
                                <th class="py-2 pr-4 text-right">จำนวน</th>
                                <th class="py-2 text-right">คงเหลือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr class="border-b border-white/5">
                                    <td class="py-3 pr-4">
                                        <p class="font-medium text-slate-200">{{ $tx->type_label }}</p>
                                        <p class="text-xs text-slate-500">{{ $tx->description }}</p>
                                    </td>
                                    <td class="py-3 pr-4 text-slate-400">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 pr-4 text-right font-semibold {{ $tx->amount >= 0 ? 'text-green-400' : 'text-red-400' }}">{{ $tx->amount >= 0 ? '+' : '' }}{{ number_format($tx->amount, 2) }}</td>
                                    <td class="py-3 text-right text-slate-300">฿{{ number_format($tx->balance_after, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-8 text-center text-slate-500">ยังไม่มีรายการ</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $transactions->links() }}</div>
            </div>
        </div>
    </div>
@endsection
