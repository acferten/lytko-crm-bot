<?php

namespace Database\Factories\Product;

use Domain\Product\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionValueFactory extends Factory
{
    protected $model = OptionValue::class;

    public function definition(): array
    {
        return [
            'name' => 'Белый',
            'option_id' => 1,
        ];
    }
}
