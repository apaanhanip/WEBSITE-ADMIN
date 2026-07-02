@php($tabs = [
    'dashboard' => ['label' => 'แดชบอร์ด', 'route' => 'account.dashboard'],
    'orders' => ['label' => 'ประวัติสั่งซื้อ', 'route' => 'account.orders'],
    'wallet' => ['label' => 'กระเป๋าเงิน', 'route' => 'account.wallet'],
])
<div class="mb-6 flex gap-2 overflow-x-auto border-b border-white/10 pb-px">
    @foreach($tabs as $key => $tab)
        <a href="{{ route($tab['route']) }}"
           class="whitespace-nowrap rounded-t-lg px-4 py-2.5 text-sm font-semibold transition {{ ($active ?? '') === $key ? 'border-b-2 border-brand-400 text-white' : 'text-slate-400 hover:text-white' }}">
            {{ $tab['label'] }}
        </a>
    @endforeach
</div>
