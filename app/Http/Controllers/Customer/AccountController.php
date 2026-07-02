<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::guard('web')->user();

        $recentOrders = $user->purchases()->limit(5)->get();
        $recentTransactions = $user->walletTransactions()->limit(5)->get();

        $stats = [
            'balance' => $user->balance,
            'orders' => $user->purchases()->count(),
            'spent' => $user->purchases()->where('status', 'completed')->sum('total'),
        ];

        return view('shop.account.dashboard', compact('user', 'recentOrders', 'recentTransactions', 'stats'));
    }
}
