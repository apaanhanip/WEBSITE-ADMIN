@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')
@section('page-subtitle', 'Kelola kategori menu coffee shop')

@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <form action="{{ route('categories.index') }}" method="GET" class="flex gap-2 flex-1 max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
               class="form-input">
        <button type="submit" class="btn-secondary">Cari</button>
    </form>
    <a href="{{ route('categories.create') }}" class="btn-primary">+ Tambah Kategori</a>
</div>

<div class="card overflow-hidden p-0">
    @if($categories->isEmpty())
        <x-empty-state title="Belum ada kategori">
            <x-slot:action>
                <a href="{{ route('categories.create') }}" class="btn-primary">Tambah Kategori</a>
            </x-slot:action>
        </x-empty-state>
    @else
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Menu</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                    <td class="font-semibold text-coffee-900">{{ $category->name }}</td>
                    <td class="text-coffee-600 max-w-xs truncate">{{ $category->description ?? '-' }}</td>
                    <td><span class="badge bg-coffee-100 text-coffee-800">{{ $category->menus_count }} menu</span></td>
                    <td class="text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('categories.edit', $category) }}" class="btn-secondary py-1.5 px-3 text-xs">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger py-1.5 px-3 text-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="border-t border-coffee-100 px-4 py-3">{{ $categories->links() }}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus kategori?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(r => { if (r.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush
