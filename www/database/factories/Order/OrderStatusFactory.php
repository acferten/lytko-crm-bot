<?php

namespace Database\Factories\Order;

use Domain\Order\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusFactory extends Factory
{
    protected $model = OrderStatus::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
