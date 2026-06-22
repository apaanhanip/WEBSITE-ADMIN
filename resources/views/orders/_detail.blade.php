<div>
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-lg font-bold text-coffee-900">{{ $order->order_number }}</h3>
            <p class="text-sm text-coffee-500">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
        </div>
        <x-status-badge :status="$order->status" />
    </div>

    <div class="rounded-xl bg-cream-50 p-4 mb-4">
        <p class="text-sm text-coffee-500">Customer</p>
        <p class="font-semibold text-coffee-900">{{ $order->customer_name }}</p>
    </div>

    <h4 class="text-sm font-semibold text-coffee-800 mb-2">Item Pesanan</h4>
    <div class="space-y-2 mb-4">
        @foreach($order->items as $item)
        <div class="flex justify-between rounded-lg border border-coffee-100 px-3 py-2 text-sm">
            <div>
                <span class="font-medium">{{ $item->menu_name }}</span>
                <span class="text-coffee-500"> x{{ $item->quantity }}</span>
            </div>
            <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
        @endforeach
    </div>

    <div class="flex justify-between border-t border-coffee-200 pt-4 font-bold text-coffee-900">
        <span>Total</span>
        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
    </div>

    @if($order->transaction)
    <div class="mt-4 rounded-xl bg-green-50 p-4 text-sm">
        <p class="font-semibold text-green-800">Transaksi: {{ $order->transaction->transaction_code }}</p>
        <p class="text-green-700">{{ $order->transaction->payment_method_label }} — {{ $order->transaction->transaction_date->format('d/m/Y H:i') }}</p>
    </div>
    @endif
</div>
