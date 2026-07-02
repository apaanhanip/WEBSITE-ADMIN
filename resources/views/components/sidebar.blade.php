@php
    $navItems = [
        ['route' => 'admin.dashboard', 'label' => 'แดชบอร์ด', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'admin.categories.index', 'label' => 'หมวดหมู่', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z'],
        ['route' => 'admin.products.index', 'label' => 'สินค้า', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['route' => 'admin.orders.index', 'label' => 'คำสั่งซื้อ', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['route' => 'admin.users.index', 'label' => 'สมาชิก', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z'],
        ['route' => 'admin.wallet.index', 'label' => 'กระเป๋าเงิน', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
    ];
@endphp

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full transform bg-night-950 shadow-sidebar transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-full flex-col">
        <div class="flex items-center gap-3 border-b border-white/10 px-6 py-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 text-lg font-black text-white">O</div>
            <div>
                <h1 class="text-lg font-bold text-white">OTP24HUB</h1>
                <p class="text-xs text-slate-500">Admin Panel</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            @foreach($navItems as $item)
                @php
                    $pattern = $item['route'] === 'admin.dashboard' ? 'admin.dashboard' : str_replace('.index', '.*', $item['route']);
                    $isActive = request()->routeIs($pattern);
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ $isActive ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <a href="{{ route('shop.home') }}" target="_blank"
               class="mt-4 flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-400 transition hover:bg-white/5 hover:text-white">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                เปิดหน้าร้าน
            </a>
        </nav>

        <div class="border-t border-white/10 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-white/5 px-3 py-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-sm font-bold text-white">
                    {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-white">{{ auth('admin')->user()->name }}</p>
                    <p class="truncate text-xs text-slate-500">{{ auth('admin')->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>

<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/50 lg:hidden" onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"></div>
