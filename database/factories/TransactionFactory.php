<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'transaction_code' => 'TRX-'.fake()->unique()->numerify('########'),
            'payment_method' => fake()->randomElement(array_keys(Transaction::PAYMENT_METHODS)),
            'amount' => fake()->numberBetween(25000, 200000),
            'transaction_date' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
