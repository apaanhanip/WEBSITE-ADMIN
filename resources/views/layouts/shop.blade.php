<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'รับ OTP • แอปพรีเมียม • เติมเกม') — OTP24HUB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body{font-family:'Inter',system-ui,sans-serif}</style>
</head>
<body class="min-h-screen bg-night-900 text-slate-200 antialiased">
    @php($navCategories = \App\Models\ServiceCategory::where('is_active', true)->orderBy('sort_order')->limit(8)->get())
    <header class="sticky top-0 z-40 border-b border-white/10 bg-night-950/85 backdrop-blur-lg">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6">
            <a href="{{ route('shop.home') }}" class="flex items-center gap-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 text-lg font-black text-white">O</span>
                <span class="text-lg font-extrabold tracking-tight text-white">OTP24<span class="text-brand-400">HUB</span></span>
            </a>

            <nav class="hidden items-center gap-1 lg:flex">
                @foreach($navCategories as $cat)
                    <a href="{{ route('shop.category', $cat) }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('shop.category') && request()->route('serviceCategory')?->id === $cat->id ? 'bg-white/5 text-white' : '' }}">
                        {{ $cat->icon }} {{ $cat->name }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                @auth('web')
                    <a href="{{ route('account.wallet') }}" class="hidden items-center gap-2 rounded-xl border border-brand-400/40 bg-brand-500/10 px-3 py-2 text-sm font-semibold text-brand-200 sm:flex">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2v-2M17 9h2a2 2 0 012 2v2a2 2 0 01-2 2h-2m0-6a2 2 0 00-2 2v0a2 2 0 002 2"/></svg>
                        ฿{{ number_format(auth('web')->user()->balance, 2) }}
                    </a>
                    <div class="group relative">
                        <button class="flex items-center gap-2 rounded-xl bg-white/5 px-3 py-2 text-sm font-semibold text-white">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-600 text-xs">{{ strtoupper(substr(auth('web')->user()->name, 0, 1)) }}</span>
                            <span class="hidden max-w-[8rem] truncate sm:inline">{{ auth('web')->user()->name }}</span>
                        </button>
                        <div class="invisible absolute right-0 mt-1 w-48 rounded-xl border border-white/10 bg-night-800 py-1 opacity-0 shadow-2xl transition group-hover:visible group-hover:opacity-100">
                            <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">แดชบอร์ด</a>
                            <a href="{{ route('account.orders') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">ประวัติสั่งซื้อ</a>
                            <a href="{{ route('account.wallet') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5 hover:text-white">กระเป๋าเงิน</a>
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-white/10">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-300 hover:bg-white/5">ออกจากระบบ</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="shop-btn-ghost">เข้าสู่ระบบ</a>
                    <a href="{{ route('register') }}" class="shop-btn hidden sm:inline-flex">สมัครสมาชิก</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
        @yield('content')
    </main>

    <footer class="mt-16 border-t border-white/10 bg-night-950">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <div class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 text-sm font-black text-white">O</span>
                    <span class="font-bold text-white">OTP24HUB</span>
                </div>
                <p class="text-sm text-slate-500">เว็บรับ OTP • แอคเคาท์พรีเมียม • เติมเกม • ระบบออโต้ 24 ชม.</p>
            </div>
            <p class="mt-6 text-center text-xs text-slate-600">© {{ date('Y') }} OTP24HUB — Demo project. เพื่อการเรียนรู้เท่านั้น</p>
        </div>
    </footer>

    @stack('scripts')
    <script>
        const ShopToast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500, timerProgressBar: true, background: '#161832', color: '#e2e8f0' });
    </script>
    @if(session('success'))<script>ShopToast.fire({ icon: 'success', title: @json(session('success')) });</script>@endif
    @if(session('error'))<script>ShopToast.fire({ icon: 'error', title: @json(session('error')) });</script>@endif
</body>
</html>
