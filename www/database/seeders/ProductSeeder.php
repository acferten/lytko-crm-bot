<?php

namespace Database\Seeders;

use Domain\Product\Models\Option;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Domain\Product\Models\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        ProductStatus::factory()
            ->has(Product::factory()->has(Option::factory()->has(OptionValue::factory(), 'values'))->count(5))
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Доступно для заказа'],
                ['name' => 'Доступно для предзаказа'],
            ))
            ->create();
    }
}
