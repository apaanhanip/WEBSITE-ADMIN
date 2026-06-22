@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Manajemen Transaksi')
@section('page-subtitle', 'Riwayat pembayaran dan laporan transaksi')

@section('content')
<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
    <div class="card bg-gradient-to-r from-coffee-700 to-coffee-900 text-white">
        <p class="text-coffee-200 text-sm">Total Transaksi (Filter)</p>
        <p class="mt-1 text-3xl font-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 justify-end">
        <a href="{{ route('transactions.export-pdf', request()->query()) }}" class="btn-secondary">
            <x-icon name="download" class="h-4 w-4" /> Export PDF
        </a>
        <a href="{{ route('transactions.export-excel', request()->query()) }}" class="btn-primary">
            <x-icon name="download" class="h-4 w-4" /> Export Excel
        </a>
    </div>
</div>

<div class="card mb-6">
    <form action="{{ route('transactions.index') }}" method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi..." class="form-input">
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input" placeholder="Dari tanggal">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input" placeholder="Sampai tanggal">
        <select name="payment_method" class="form-input">
            <option value="">Semua Metode</option>
            @foreach(\App\Models\Transaction::PAYMENT_METHODS as $key => $label)
                <option value="{{ $key }}" {{ request('payment_method') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Terapkan Filter</button>
    </form>
</div>

<div class="card overflow-hidden p-0">
    @if($transactions->isEmpty())
        <x-empty-state title="Belum ada transaksi" />
    @else
    <div class="overflow-x-auto">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>No. Order</th>
                    <th>Customer</th>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td class="font-semibold text-coffee-900">{{ $trx->transaction_code }}</td>
                    <td>{{ $trx->order?->order_number }}</td>
                    <td>{{ $trx->order?->customer_name }}</td>
                    <td><span class="badge bg-coffee-100 text-coffee-800">{{ $trx->payment_method_label }}</span></td>
                    <td class="font-semibold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td class="text-sm text-coffee-600">{{ $trx->transaction_date->format('d/m/Y H:i') }}</td>
                    <td class="text-right">
                        <a href="{{ route('transactions.show', $trx) }}" class="btn-secondary py-1.5 px-3 text-xs">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="border-t border-coffee-100 px-4 py-3">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
