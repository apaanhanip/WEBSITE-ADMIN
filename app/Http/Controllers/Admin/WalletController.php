<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = WalletTransaction::with('user')
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totalTopup = WalletTransaction::where('type', 'topup')->where('status', 'success')->sum('amount');

        return view('admin.wallet.index', compact('transactions', 'totalTopup'));
    }
}
