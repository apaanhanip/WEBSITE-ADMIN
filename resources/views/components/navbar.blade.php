<header class="sticky top-0 z-20 border-b border-coffee-100 bg-white/80 backdrop-blur-md">
    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4">
            <button type="button" class="rounded-lg p-2 text-coffee-700 hover:bg-cream-100 lg:hidden"
                    onclick="document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('hidden');">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div>
                <h2 class="text-lg font-semibold text-coffee-900">@yield('page-title', 'Dashboard')</h2>
                @hasSection('page-subtitle')
                    <p class="text-sm text-coffee-500">@yield('page-subtitle')</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="hidden text-sm text-coffee-500 sm:inline">{{ now()->translatedFormat('l, d F Y') }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-secondary text-red-700 hover:bg-red-50 hover:border-red-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>
