<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected Collection $transactions
    ) {}

    public function collection(): Collection
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'No. Order',
            'Customer',
            'Metode Pembayaran',
            'Jumlah',
            'Tanggal Transaksi',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_code,
            $transaction->order?->order_number,
            $transaction->order?->customer_name,
            $transaction->payment_method_label,
            $transaction->amount,
            $transaction->transaction_date?->format('d/m/Y H:i'),
        ];
    }
}
