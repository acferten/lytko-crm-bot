<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OrderStatusSeeder::class,
            RolesAndPermissionsSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            OrderHistorySeeder::class,
        ]);
    }
}
