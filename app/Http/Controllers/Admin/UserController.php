<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::withCount('purchases')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%')
                ->orWhere('email', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $orders = $user->purchases()->with('product')->limit(10)->get();
        $transactions = $user->walletTransactions()->limit(10)->get();

        return view('admin.users.show', compact('user', 'orders', 'transactions'));
    }

    public function adjustBalance(Request $request, User $user, WalletService $wallet): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'not_in:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $wallet->credit(
            $user,
            (float) $data['amount'],
            $data['amount'] >= 0 ? 'topup' : 'refund',
            'admin',
            $data['note'] ?? 'ปรับยอดโดยแอดมิน',
        );

        return back()->with('success', 'ปรับยอดเงินสำเร็จ');
    }
}
