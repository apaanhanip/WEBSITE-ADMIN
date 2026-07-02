@extends('layouts.app')

@section('title', 'สินค้า')
@section('page-title', 'สินค้า')
@section('page-subtitle', 'จัดการสินค้าและสต็อก')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหาสินค้า..." class="form-input sm:w-56">
            <select name="category" class="form-input sm:w-48">
                <option value="">ทุกหมวดหมู่</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button class="btn-secondary">กรอง</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">+ เพิ่มสินค้า</a>
    </div>

    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="table-modern">
                <thead><tr><th>สินค้า</th><th>หมวดหมู่</th><th class="text-right">ราคา</th><th class="text-center">สต็อก</th><th class="text-center">ขายแล้ว</th><th class="text-center">สถานะ</th><th class="text-right">จัดการ</th></tr></thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="font-semibold text-coffee-900">{{ $product->name }}</td>
                            <td>{{ $product->category?->name }}</td>
                            <td class="text-right font-semibold">฿{{ number_format($product->price, 2) }}</td>
                            <td class="text-center">
                                @if($product->delivery_type === 'auto_stock')
                                    <span class="{{ $product->available_stock <= 3 ? 'badge-red' : 'badge-green' }}">{{ $product->available_stock }}</span>
                                @else
                                    <span class="badge-blue">Manual</span>
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($product->sold_count) }}</td>
                            <td class="text-center"><span class="{{ $product->is_active ? 'badge-green' : 'badge-red' }}">{{ $product->is_active ? 'เปิด' : 'ปิด' }}</span></td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.stock', $product) }}" class="btn-secondary px-3 py-1.5 text-xs">สต็อก</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-secondary px-3 py-1.5 text-xs">แก้ไข</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('ยืนยันการลบ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger px-3 py-1.5 text-xs">ลบ</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><x-empty-state title="ยังไม่มีสินค้า" description="เริ่มต้นด้วยการเพิ่มสินค้าแรก" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@endsection
