@props(['title', 'value', 'icon' => '☕', 'color' => 'coffee'])

<div class="card group transition hover:shadow-lg">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-coffee-500">{{ $title }}</p>
            <p class="mt-2 text-2xl font-bold text-coffee-900">{{ $value }}</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-{{ $color }}-100 text-xl group-hover:scale-110 transition">
            {{ $icon }}
        </div>
    </div>
</div>
