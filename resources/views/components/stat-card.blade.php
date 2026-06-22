@props(['title', 'value', 'icon' => '☕', 'color' => 'coffee'])

@php
    // Literal class strings so Tailwind's JIT scanner detects them.
    $themes = [
        'coffee' => ['icon' => 'bg-coffee-100 text-coffee-700', 'bar' => 'from-coffee-400 to-coffee-700'],
        'accent' => ['icon' => 'bg-accent-100 text-accent-700', 'bar' => 'from-accent-300 to-accent-600'],
        'blue'   => ['icon' => 'bg-blue-100 text-blue-700',     'bar' => 'from-blue-300 to-blue-600'],
        'green'  => ['icon' => 'bg-green-100 text-green-700',   'bar' => 'from-green-300 to-green-600'],
        'purple' => ['icon' => 'bg-purple-100 text-purple-700', 'bar' => 'from-purple-300 to-purple-600'],
        'rose'   => ['icon' => 'bg-rose-100 text-rose-700',     'bar' => 'from-rose-300 to-rose-600'],
    ];
    $theme = $themes[$color] ?? $themes['coffee'];
@endphp

<div class="card card-interactive group relative overflow-hidden">
    <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r {{ $theme['bar'] }}"></span>
    <div class="flex items-start justify-between">
        <div class="min-w-0">
            <p class="text-sm font-medium text-coffee-500">{{ $title }}</p>
            <p class="mt-2 truncate text-2xl font-bold text-coffee-900">{{ $value }}</p>
        </div>
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-xl shadow-sm transition duration-300 group-hover:scale-110 group-hover:-rotate-6 {{ $theme['icon'] }}">
            {{ $icon }}
        </div>
    </div>
</div>
