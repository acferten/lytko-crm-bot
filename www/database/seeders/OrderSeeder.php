<?php

namespace Database\Seeders;

use Domain\Order\Enums\OrderStatusEnum;
use Domain\Order\Models\Address;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Domain\Product\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        foreach (OrderStatusEnum::cases() as $status) {
            OrderStatus::factory()->count(1)
                ->state(['name' => $status],)->create();
        }
        Address::factory()->count(5)->create();
        Order::factory()->count(5)->afterCreating(function (Order $order) {
            $order->products()->attach(Product::all()->random(3), ['value_id' => 1]);
        })->create();
    }
}
