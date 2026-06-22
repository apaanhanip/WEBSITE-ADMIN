@php
    $navItems = [
        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'categories.index', 'label' => 'Kategori', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z'],
        ['route' => 'menus.index', 'label' => 'Menu', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['route' => 'orders.index', 'label' => 'Pesanan', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['route' => 'transactions.index', 'label' => 'Transaksi', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
    ];
@endphp

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full transform bg-coffee-900 shadow-sidebar transition-transform duration-300 lg:translate-x-0">
    <div class="flex h-full flex-col">
        <div class="flex items-center gap-3 border-b border-coffee-800/70 px-6 py-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-accent-gradient text-lg shadow-glow">☕</div>
            <div>
                <h1 class="font-display text-lg font-bold text-white">SelfBrew</h1>
                <p class="text-xs font-medium uppercase tracking-wider text-accent-300">Admin Panel</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            @foreach($navItems as $item)
                @php
                    $pattern = $item['route'] === 'dashboard' ? 'dashboard' : str_replace('.index', '.*', $item['route']);
                    $isActive = request()->routeIs($pattern);
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="nav-link {{ $isActive ? 'active' : '' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="border-t border-coffee-800 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-coffee-800/50 px-3 py-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-accent-gradient text-sm font-bold text-white shadow-sm">
                    {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-white">{{ auth('admin')->user()->name }}</p>
                    <p class="truncate text-xs text-coffee-400">{{ auth('admin')->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>

<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-black/50 lg:hidden" onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"></div>
