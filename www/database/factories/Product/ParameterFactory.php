<?php

namespace Database\Factories\Product;

use Domain\Product\Models\Parameter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParameterFactory extends Factory
{
    protected $model = Parameter::class;

    public function definition(): array
    {
        return [
            'title' => 'Цвет',
        ];
    }
}
