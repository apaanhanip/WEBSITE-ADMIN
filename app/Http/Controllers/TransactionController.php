<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = $this->filteredQuery($request)
            ->with('order')
            ->latest('transaction_date')
            ->paginate(15)
            ->withQueryString();

        $totalAmount = (clone $this->filteredQuery($request))->sum('amount');

        return view('transactions.index', compact('transactions', 'totalAmount'));
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['order.items']);

        return view('transactions.show', compact('transaction'));
    }

    public function exportPdf(Request $request)
    {
        $transactions = $this->filteredQuery($request)
            ->with('order')
            ->latest('transaction_date')
            ->get();

        $totalAmount = $transactions->sum('amount');

        $pdf = Pdf::loadView('transactions.pdf', compact('transactions', 'totalAmount'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi-'.now()->format('Ymd-His').'.pdf');
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        $transactions = $this->filteredQuery($request)
            ->with('order')
            ->latest('transaction_date')
            ->get();

        return Excel::download(
            new TransactionsExport($transactions),
            'laporan-transaksi-'.now()->format('Ymd-His').'.xlsx'
        );
    }

    protected function filteredQuery(Request $request)
    {
        return Transaction::query()
            ->when($request->search, function ($query, $search) {
                $query->where('transaction_code', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($q) use ($search) {
                        $q->where('order_number', 'like', "%{$search}%")
                            ->orWhere('customer_name', 'like', "%{$search}%");
                    });
            })
            ->when($request->date_from, function ($query, $dateFrom) {
                $query->whereDate('transaction_date', '>=', Carbon::parse($dateFrom)->toDateString());
            })
            ->when($request->date_to, function ($query, $dateTo) {
                $query->whereDate('transaction_date', '<=', Carbon::parse($dateTo)->toDateString());
            })
            ->when($request->payment_method, fn ($q) => $q->where('payment_method', $request->payment_method));
    }
}
