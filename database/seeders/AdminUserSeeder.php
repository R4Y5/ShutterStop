<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'new admin',
            'email' => 'newadmin@gmail.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');
    }
}
