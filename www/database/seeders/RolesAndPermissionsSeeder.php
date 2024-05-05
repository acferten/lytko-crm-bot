<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'administrator']);
        Role::create(['name' => 'shop_manager']);
        Role::create(['name' => 'customer']);
        Role::create(['name' => 'order collector']);
        Role::create(['name' => 'tester']);
    }
}
