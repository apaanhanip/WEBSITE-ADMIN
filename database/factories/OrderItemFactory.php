<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $price = fake()->numberBetween(15000, 55000);
        $qty = fake()->numberBetween(1, 3);

        return [
            'order_id' => Order::factory(),
            'menu_id' => Menu::factory(),
            'menu_name' => fake()->words(3, true),
            'quantity' => $qty,
            'price' => $price,
            'subtotal' => $price * $qty,
        ];
    }
}
