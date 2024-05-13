<?php

namespace Database\Seeders;

use Domain\Order\Models\Address;
use Domain\Order\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Address::factory()->count(5)->create();

        Order::factory()->count(5)->afterCreating(function (Order $order) {
            $order->products()->attach(1, ['quantity' => 1]);
            $product = $order->products()->find(1);
            $product->pivot->options()->attach(1);
        })->create();
    }
}
