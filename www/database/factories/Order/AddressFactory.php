<?php

namespace Database\Factories\Order;

use Domain\Order\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'company_name' => $this->faker->company(),
            'country' => $this->faker->country(),
            'state' => $this->faker->city(),
            'city' => $this->faker->city(),
            'address' => $this->faker->streetName(),
            'zip_code' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'telegram_username' => $this->faker->userName(),
            'note' => $this->faker->text(),
        ];
    }
}
