<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        $admin1 = User::updateOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin User 1',
                'password' => bcrypt('admin123'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $admin1->assignRole('admin');

        $admin2 = User::updateOrCreate(
            ['email' => 'admin2@gmail.com'],
            [
                'name' => 'Admin User 2',
                'password' => bcrypt('admin123'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $admin2->assignRole('admin');

        // Create customer users
        $customer1 = User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Customer User',
                'password' => bcrypt('customer123'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $customer1->assignRole('customer');

        $customer2 = User::updateOrCreate(
            ['email' => 'customer2@gmail.com'],
            [
                'name' => 'Customer User 2',
                'password' => bcrypt('customer123'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        $customer2->assignRole('customer');
    }
}
