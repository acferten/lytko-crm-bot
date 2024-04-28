<?php

namespace Database\Seeders;

use Domain\Product\Models\Product;
use Domain\Product\Models\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        ProductStatus::factory()
            ->has(Product::factory()->count(5))
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Доступно для заказа'],
                ['name' => 'Доступно для предзаказа'],
            ))
            ->create();
    }
}
