@extends('layouts.app')

@section('title', 'สต็อก')
@section('page-title', 'จัดการสต็อก')
@section('page-subtitle', $product->name)

@section('content')
    <div class="mb-4 flex gap-3">
        <div class="card flex-1 py-4"><p class="text-sm text-coffee-500">พร้อมขาย</p><p class="text-2xl font-bold text-green-700">{{ $availableCount }}</p></div>
        <div class="card flex-1 py-4"><p class="text-sm text-coffee-500">ขายแล้ว</p><p class="text-2xl font-bold text-coffee-900">{{ $soldCount }}</p></div>
        <div class="card flex-1 py-4"><p class="text-sm text-coffee-500">การจัดส่ง</p><p class="text-lg font-bold text-coffee-900">{{ $product->delivery_type === 'auto_stock' ? 'อัตโนมัติ' : 'Manual' }}</p></div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="card lg:col-span-1">
            <h2 class="mb-3 font-semibold text-coffee-900">เพิ่มสต็อก</h2>
            @include('components.alert')
            <form action="{{ route('admin.products.stock.store', $product) }}" method="POST">
                @csrf
                <label class="form-label">ข้อมูลสินค้า (1 บรรทัด = 1 ชิ้น)</label>
                <textarea name="items" rows="8" class="form-input font-mono text-xs" placeholder="user1@mail.com|pass123&#10;user2@mail.com|pass456&#10;CODE-XXXX-YYYY"></textarea>
                <button type="submit" class="btn-primary mt-3 w-full">เพิ่มสต็อก</button>
            </form>
        </div>

        <div class="card lg:col-span-2 p-0 overflow-hidden">
            <div class="border-b border-coffee-100 px-4 py-3"><h2 class="font-semibold text-coffee-900">รายการสต็อก</h2></div>
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead><tr><th>#</th><th>ข้อมูล</th><th class="text-center">สถานะ</th><th>ขายเมื่อ</th><th class="text-right"></th></tr></thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td class="text-coffee-400">{{ $item->id }}</td>
                                <td class="max-w-[16rem] truncate font-mono text-xs">{{ $item->content }}</td>
                                <td class="text-center"><span class="{{ $item->status === 'available' ? 'badge-green' : 'badge-red' }}">{{ $item->status === 'available' ? 'พร้อมขาย' : 'ขายแล้ว' }}</span></td>
                                <td class="text-xs text-coffee-500">{{ $item->sold_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="text-right">
                                    @if($item->status === 'available')
                                        <form action="{{ route('admin.products.stock.destroy', [$product, $item]) }}" method="POST" onsubmit="return confirm('ลบสต็อกนี้?')">
                                            @csrf @method('DELETE')
                                            <button class="btn-danger px-2.5 py-1 text-xs">ลบ</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-8 text-center text-coffee-400">ยังไม่มีสต็อก</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>

    <a href="{{ route('admin.products.index') }}" class="mt-4 inline-block text-sm text-coffee-600 hover:text-coffee-800">← กลับไปรายการสินค้า</a>
@endsection
