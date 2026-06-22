@if ($paginator->hasPages())
<nav class="flex items-center justify-between gap-2">
    <p class="text-sm text-coffee-500">
        Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
    </p>
    <div class="flex gap-1">
        @if ($paginator->onFirstPage())
            <span class="rounded-lg px-3 py-2 text-sm text-coffee-300 bg-cream-100">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-lg px-3 py-2 text-sm text-coffee-700 bg-white border border-coffee-200 hover:bg-cream-100">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="rounded-lg px-3 py-2 text-sm text-coffee-400">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="rounded-lg px-3 py-2 text-sm font-semibold text-white bg-coffee-700">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="rounded-lg px-3 py-2 text-sm text-coffee-700 bg-white border border-coffee-200 hover:bg-cream-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-lg px-3 py-2 text-sm text-coffee-700 bg-white border border-coffee-200 hover:bg-cream-100">→</a>
        @else
            <span class="rounded-lg px-3 py-2 text-sm text-coffee-300 bg-cream-100">→</span>
        @endif
    </div>
</nav>
@endif
