<?php

namespace Database\Seeders;

use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->afterCreating(function (User $user) {
                $user->assignRole('administrator');
            })->state(new Sequence(
                ['telegram_username' => 'grepnam3',
                    'telegram_id' => 472041603,
                    'login' => 'grepnam3',
                ]))->create();
    }
}
