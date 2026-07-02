@extends('layouts.app')

@section('title', 'หมวดหมู่')
@section('page-title', 'หมวดหมู่บริการ')
@section('page-subtitle', 'จัดการหมวดหมู่สินค้า')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหาหมวดหมู่..." class="form-input sm:w-64">
            <button class="btn-secondary">ค้นหา</button>
        </form>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ เพิ่มหมวดหมู่</a>
    </div>

    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead><tr><th>ไอคอน</th><th>ชื่อ</th><th>Slug</th><th class="text-center">สินค้า</th><th class="text-center">ลำดับ</th><th class="text-center">สถานะ</th><th class="text-right">จัดการ</th></tr></thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td class="text-xl">{{ $cat->icon }}</td>
                            <td class="font-semibold text-coffee-900">{{ $cat->name }}</td>
                            <td class="font-mono text-xs text-coffee-400">{{ $cat->slug }}</td>
                            <td class="text-center">{{ $cat->products_count }}</td>
                            <td class="text-center">{{ $cat->sort_order }}</td>
                            <td class="text-center">
                                <span class="{{ $cat->is_active ? 'badge-green' : 'badge-red' }}">{{ $cat->is_active ? 'เปิด' : 'ปิด' }}</span>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-secondary px-3 py-1.5 text-xs">แก้ไข</a>
                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('ยืนยันการลบ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger px-3 py-1.5 text-xs">ลบ</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><x-empty-state title="ยังไม่มีหมวดหมู่" description="เริ่มต้นด้วยการเพิ่มหมวดหมู่แรก" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $categories->links() }}</div>
@endsection
