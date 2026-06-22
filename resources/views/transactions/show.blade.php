@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', $transaction->transaction_code)

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="card">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <p class="text-sm text-coffee-500">Kode Transaksi</p>
                <p class="font-bold text-coffee-900">{{ $transaction->transaction_code }}</p>
            </div>
            <div>
                <p class="text-sm text-coffee-500">Metode Pembayaran</p>
                <p class="font-bold text-coffee-900">{{ $transaction->payment_method_label }}</p>
            </div>
            <div>
                <p class="text-sm text-coffee-500">No. Order</p>
                <p class="font-bold text-coffee-900">{{ $transaction->order->order_number }}</p>
            </div>
            <div>
                <p class="text-sm text-coffee-500">Customer</p>
                <p class="font-bold text-coffee-900">{{ $transaction->order->customer_name }}</p>
            </div>
            <div>
                <p class="text-sm text-coffee-500">Jumlah Pembayaran</p>
                <p class="text-2xl font-bold text-coffee-700">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-coffee-500">Tanggal Transaksi</p>
                <p class="font-bold text-coffee-900">{{ $transaction->transaction_date->translatedFormat('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="mb-4 font-semibold text-coffee-900">Detail Item Pesanan</h3>
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->order->items as $item)
                <tr>
                    <td>{{ $item->menu_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('transactions.index') }}" class="btn-secondary">← Kembali</a>
</div>
@endsection
