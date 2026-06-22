<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_number' => 'ORD-'.fake()->unique()->numerify('######'),
            'customer_name' => fake()->name(),
            'total' => 0,
            'status' => fake()->randomElement(Order::STATUSES),
        ];
    }
}
