<?php

namespace Database\Factories\Product;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'short_description' => $this->faker->text(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'status_id' => 1,
        ];
    }
}
