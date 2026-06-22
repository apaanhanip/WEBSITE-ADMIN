@extends('layouts.app')

@section('title', 'Menu')
@section('page-title', 'Manajemen Menu')
@section('page-subtitle', 'Kelola menu dan harga produk')

@section('content')
<div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
    <form action="{{ route('menus.index') }}" method="GET" class="flex flex-wrap gap-2 flex-1">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu..." class="form-input max-w-xs">
        <select name="category_id" class="form-input max-w-xs">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
    </form>
    <a href="{{ route('menus.create') }}" class="btn-primary shrink-0">+ Tambah Menu</a>
</div>

@if($menus->isEmpty())
<div class="card">
    <x-empty-state title="Belum ada menu">
        <x-slot:action><a href="{{ route('menus.create') }}" class="btn-primary">Tambah Menu</a></x-slot:action>
    </x-empty-state>
</div>
@else
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6">
    @foreach($menus as $menu)
    <div class="card p-0 overflow-hidden group hover:shadow-lg transition">
        <div class="relative h-40 bg-cream-200 overflow-hidden">
            @if($menu->image)
                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="flex h-full items-center justify-center text-5xl opacity-30">☕</div>
            @endif
            <span class="absolute top-3 right-3 badge {{ $menu->is_available ? 'badge-green' : 'badge-red' }}">
                {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
            </span>
        </div>
        <div class="p-4">
            <span class="text-xs font-medium text-coffee-500">{{ $menu->category->name }}</span>
            <h3 class="mt-1 font-semibold text-coffee-900">{{ $menu->name }}</h3>
            <p class="mt-1 text-lg font-bold text-coffee-700">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
            <p class="mt-2 text-xs text-coffee-500 line-clamp-2">{{ $menu->description }}</p>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('menus.edit', $menu) }}" class="btn-secondary flex-1 py-2 text-xs justify-center">Edit</a>
                <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="delete-form flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger w-full py-2 text-xs">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="card p-4">{{ $menus->links() }}</div>
@endif
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus menu ini?',
                text: 'Menu yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6f4a2a',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush
