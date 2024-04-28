<?php

namespace Database\Factories\Product;

use Domain\Product\Models\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductStatusFactory extends Factory
{
    protected $model = ProductStatus::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->title(),
        ];
    }
}
