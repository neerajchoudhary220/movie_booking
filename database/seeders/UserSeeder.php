<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'password' => 'admin@123',
        ]);
        $admin->assignRole('Admin');
        $manager = User::create([
            'name' => 'Manager 1',
            'email' => 'manager@example.com',
            'password' => 'manager@123',
            'theatre_id' => 1,
        ]);
        $manager->assignRole('Manager');
        $customer = User::create([
            'name' => 'Rohan',
            'email' => 'customer@example.com',
            'password' => 'customer@123',
        ]);
        $customer->assignRole('Customer');
    }
}
