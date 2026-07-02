<a href="{{ route('shop.product', $product) }}" class="product-card">
    <div class="relative aspect-[4/3] w-full overflow-hidden bg-gradient-to-br from-night-700 to-night-900">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-4xl opacity-60">{{ $product->category->icon ?? '🛍️' }}</div>
        @endif
        @if($product->in_stock)
            <span class="chip absolute left-2 top-2 bg-green-500/20 text-green-300">พร้อมส่ง</span>
        @else
            <span class="chip absolute left-2 top-2 bg-red-500/20 text-red-300">สินค้าหมด</span>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-4">
        <h3 class="line-clamp-2 text-sm font-semibold text-white">{{ $product->name }}</h3>
        <div class="mt-auto flex items-end justify-between pt-3">
            <span class="text-lg font-extrabold text-brand-300">฿{{ number_format($product->price, 2) }}</span>
            <span class="text-xs text-slate-500">ขายแล้ว {{ number_format($product->sold_count) }}</span>
        </div>
    </div>
</a>
