<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Credit a user's wallet (top-up / refund) and record a transaction.
     */
    public function credit(User $user, float $amount, string $type = 'topup', ?string $method = null, ?string $description = null): WalletTransaction
    {
        return DB::transaction(function () use ($user, $amount, $type, $method, $description) {
            $user = User::whereKey($user->id)->lockForUpdate()->first();
            $user->balance = (float) $user->balance + $amount;
            $user->save();

            return WalletTransaction::create([
                'user_id' => $user->id,
                'type' => $type,
                'amount' => $amount,
                'balance_after' => $user->balance,
                'method' => $method,
                'reference' => strtoupper('TP'.now()->format('ymdHis').random_int(10, 99)),
                'description' => $description,
                'status' => 'success',
            ]);
        });
    }
}
