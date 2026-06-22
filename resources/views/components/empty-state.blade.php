@props(['title' => 'Belum ada data', 'description' => 'Data akan muncul di sini setelah ditambahkan.'])

<div class="flex flex-col items-center justify-center py-16 text-center">
    <div class="mb-4 text-5xl opacity-40">☕</div>
    <h3 class="text-lg font-semibold text-coffee-800">{{ $title }}</h3>
    <p class="mt-1 max-w-sm text-sm text-coffee-500">{{ $description }}</p>
    @if(isset($action))
        <div class="mt-6">{{ $action }}</div>
    @endif
</div>
