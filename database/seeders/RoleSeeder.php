<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        DB::table('roles')->insert([
            [
                'name'       => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'name'       => 'customer',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}