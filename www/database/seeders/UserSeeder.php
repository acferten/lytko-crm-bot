<?php

namespace Database\Seeders;

use Domain\Shared\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->count(2)->afterCreating(function (User $user) {
                $user->assignRole('administrator');
            })
            ->create();

        User::factory()
            ->count(2)->afterCreating(function (User $user) {
                $user->assignRole('manager');
            })
            ->create();
    }
}
