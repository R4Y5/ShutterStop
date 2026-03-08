<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $customer = Role::create(['name' => 'customer']);

        // Create permissions
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'place orders']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage products', 'manage orders', 'view products']);
        $customer->givePermissionTo(['view products', 'place orders']);
    }
}
