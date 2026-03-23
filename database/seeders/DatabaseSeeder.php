<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles safely (no duplicates)
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Call other seeders
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(UserSeeder::class);
    }
}
