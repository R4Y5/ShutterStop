<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist (Spatie Permission)
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'first_name'        => 'Admin',
                'last_name'         => 'User',
                'contact_no'        => '09171234567',
                'address'           => '123 Admin Street, Parañaque',
                'email_verified_at' => Carbon::now(),
                'password'          => Hash::make('admin123'),
                'is_active'         => true,
                'role'              => 'admin', // optional if you keep column
                'photo'             => null,
                'remember_token'    => null,
                'phone'             => '09171234567',
            ]
        );
        $admin->assignRole('admin');

        // Customer user
        $customer = User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'first_name'        => 'Customer',
                'last_name'         => 'User',
                'contact_no'        => '09981234567',
                'address'           => '456 Customer Avenue, Parañaque',
                'email_verified_at' => Carbon::now(),
                'password'          => Hash::make('customer123'),
                'is_active'         => true,
                'role'              => 'customer', // optional if you keep column
                'photo'             => null,
                'remember_token'    => null,
                'phone'             => '09981234567',
            ]
        );
        $customer->assignRole('customer');
    }
}
