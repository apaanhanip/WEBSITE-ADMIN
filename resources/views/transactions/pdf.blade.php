<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - SelfBrew Admin</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #3d2919; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { color: #6f4a2a; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e0cdb3; padding: 8px; text-align: left; }
        th { background: #f0e6d8; }
        .total { margin-top: 16px; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <h1>SelfBrew Admin — Laporan Transaksi</h1>
    <p class="meta">Dicetak: {{ now()->format('d/m/Y H:i') }} | Total: {{ $transactions->count() }} transaksi</p>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>No. Order</th>
                <th>Customer</th>
                <th>Metode</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $trx->transaction_code }}</td>
                <td>{{ $trx->order?->order_number }}</td>
                <td>{{ $trx->order?->customer_name }}</td>
                <td>{{ $trx->payment_method_label }}</td>
                <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                <td>{{ $trx->transaction_date?->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total Pendapatan: Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
</body>
</html>
