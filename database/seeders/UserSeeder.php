<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@123'),
        ]);
        $admin->assignRole('Admin');
        $manager = User::create([
            'name' => 'Manager 1',
            'email' => 'manager@example.com',
            'password' => Hash::make('manager@123'),
        ]);
        $manager->assignRole('Manager');
        $customer = User::create([
            'name' => 'Rohan',
            'email' => 'customer@example.com',
            'password' => Hash::make('customer@123'),
        ]);
        $customer->assignRole('Customer');
    }
}
