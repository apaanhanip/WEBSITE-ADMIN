<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $menus = Menu::all();
        if ($menus->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'diproses', 'selesai', 'selesai', 'selesai', 'dibatalkan'];
        $payments = array_keys(Transaction::PAYMENT_METHODS);

        for ($i = 0; $i < 50; $i++) {
            $daysAgo = rand(0, 14);
            $createdAt = Carbon::now()->subDays($daysAgo)->subHours(rand(0, 12));
            $status = $statuses[array_rand($statuses)];

            $order = Order::create([
                'order_number' => 'ORD-'.$createdAt->format('Ymd').'-'.str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'customer_name' => fake()->name(),
                'total' => 0,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $itemCount = rand(1, 4);
            $total = 0;
            $selectedMenus = $menus->random(min($itemCount, $menus->count()));

            foreach ($selectedMenus as $menu) {
                $qty = rand(1, 2);
                $subtotal = $menu->price * $qty;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'quantity' => $qty,
                    'price' => $menu->price,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total' => $total]);

            if (in_array($status, ['selesai', 'diproses'])) {
                Transaction::create([
                    'order_id' => $order->id,
                    'transaction_code' => 'TRX-'.$createdAt->format('Ymd').'-'.str_pad((string) ($order->id), 5, '0', STR_PAD_LEFT),
                    'payment_method' => $payments[array_rand($payments)],
                    'amount' => $total,
                    'transaction_date' => $createdAt->copy()->addMinutes(rand(5, 30)),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
