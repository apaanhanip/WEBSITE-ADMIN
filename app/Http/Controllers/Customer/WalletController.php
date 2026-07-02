<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function index(): View
    {
        $user = Auth::guard('web')->user();
        $transactions = $user->walletTransactions()->paginate(15);

        return view('shop.account.wallet', compact('user', 'transactions'));
    }

    public function topup(Request $request, WalletService $wallet): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:10', 'max:100000'],
            'method' => ['required', 'in:promptpay,truewallet,bank'],
        ], [], [
            'amount' => 'จำนวนเงิน',
            'method' => 'ช่องทาง',
        ]);

        $user = Auth::guard('web')->user();

        // Simulated auto top-up gateway: instantly credited (demo environment).
        $wallet->credit(
            $user,
            (float) $data['amount'],
            'topup',
            $data['method'],
            'เติมเงินผ่าน '.strtoupper($data['method']),
        );

        return redirect()->route('account.wallet')
            ->with('success', 'เติมเงินสำเร็จ '.number_format($data['amount'], 2).' บาท');
    }
}
