<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create Roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $customer = Role::firstOrCreate(['name' => 'Customer']);

        // Create permissions
        $permissions = [
            'manage theatres',
            'manage screens',
            'manage shows',
            'manage seats',
            'view dashboard',
            'book seats'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo(['manage screens', 'manage shows', 'manage seats', 'view dashboard']);
        $customer->givePermissionTo(['book seats']);
    }
}
