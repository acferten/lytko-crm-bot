<?php

namespace Database\Factories;

use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'login' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'name' => $this->faker->firstName('female'),
            'surname' => $this->faker->lastName('female'),
            'patronymic' => $this->faker->lastName('female'),
            'telegram_id' => $this->faker->numberBetween(1000, 99999),
            'telegram_username' => $this->faker->userName(),
        ];
    }
}
