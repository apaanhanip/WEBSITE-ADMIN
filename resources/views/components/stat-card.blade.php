@props(['title', 'value', 'icon' => 'cup', 'color' => 'brand', 'subtitle' => null])

@php
    // Literal class strings so Tailwind's JIT scanner detects them.
    $themes = [
        'brand'  => 'bg-brand-100 text-brand-600',
        'coffee' => 'bg-brand-100 text-brand-600',
        'accent' => 'bg-amber-100 text-amber-600',
        'blue'   => 'bg-blue-100 text-blue-600',
        'green'  => 'bg-emerald-100 text-emerald-600',
        'purple' => 'bg-violet-100 text-violet-600',
        'rose'   => 'bg-rose-100 text-rose-600',
    ];
    $iconClass = $themes[$color] ?? $themes['brand'];
@endphp

<div class="card card-interactive flex items-center gap-4">
    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl {{ $iconClass }}">
        <x-icon :name="$icon" class="h-7 w-7" />
    </div>
    <div class="min-w-0">
        <p class="text-xs font-semibold uppercase tracking-wide text-coffee-400">{{ $title }}</p>
        <p class="mt-1 truncate text-2xl font-bold text-coffee-900">{{ $value }}</p>
        @if($subtitle)
            <p class="mt-0.5 text-xs font-medium text-emerald-600">{{ $subtitle }}</p>
        @endif
    </div>
</div>
