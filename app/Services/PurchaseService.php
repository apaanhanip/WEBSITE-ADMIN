<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockItem;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PurchaseService
{
    /**
     * Process a purchase: validate balance & stock, deduct wallet, deliver stock, record order.
     *
     * @throws RuntimeException
     */
    public function purchase(User $user, Product $product, int $quantity = 1): Purchase
    {
        if ($quantity < 1) {
            throw new RuntimeException('จำนวนไม่ถูกต้อง');
        }

        if (! $product->is_active) {
            throw new RuntimeException('สินค้านี้ไม่พร้อมจำหน่าย');
        }

        $total = (float) $product->price * $quantity;

        return DB::transaction(function () use ($user, $product, $quantity, $total) {
            $user = User::whereKey($user->id)->lockForUpdate()->first();

            if ((float) $user->balance < $total) {
                throw new RuntimeException('ยอดเงินไม่เพียงพอ กรุณาเติมเงิน');
            }

            $isAuto = $product->delivery_type === 'auto_stock';
            $stockItems = collect();

            if ($isAuto) {
                $stockItems = StockItem::where('product_id', $product->id)
                    ->where('status', 'available')
                    ->lockForUpdate()
                    ->limit($quantity)
                    ->get();

                if ($stockItems->count() < $quantity) {
                    throw new RuntimeException('สินค้าหมดสต็อก');
                }
            }

            $user->balance = (float) $user->balance - $total;
            $user->save();

            $purchase = Purchase::create([
                'order_code' => strtoupper('OTP'.now()->format('ymd').random_int(100000, 999999)),
                'user_id' => $user->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => $quantity,
                'total' => $total,
                'status' => $isAuto ? 'completed' : 'pending',
                'delivered_content' => $isAuto
                    ? $stockItems->pluck('content')->implode("\n----------\n")
                    : null,
            ]);

            if ($isAuto) {
                foreach ($stockItems as $item) {
                    $item->update([
                        'status' => 'sold',
                        'purchase_id' => $purchase->id,
                        'sold_at' => now(),
                    ]);
                }
            }

            $product->increment('sold_count', $quantity);

            WalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => -$total,
                'balance_after' => $user->balance,
                'reference' => $purchase->order_code,
                'description' => $product->name.' x'.$quantity,
                'status' => 'success',
            ]);

            return $purchase;
        });
    }
}
