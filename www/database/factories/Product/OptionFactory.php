<?php

namespace Database\Factories\Product;

use Domain\Product\Models\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition(): array
    {
        return [
            'name' => 'Белый',
            'parameter_id' => 1,
        ];
    }
}
