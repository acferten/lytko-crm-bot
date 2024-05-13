<?php

namespace Database\Factories\Order;

use Domain\Order\Models\Address;
use Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'status_id' => 1,
            'address_id' => Address::all()->random()->id,
            'employee_id' => 1,
        ];
    }
}
