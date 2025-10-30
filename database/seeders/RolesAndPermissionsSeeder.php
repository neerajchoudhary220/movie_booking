<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Create Roles ---
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $customer = Role::firstOrCreate(['name' => 'Customer']);

        // --- Define Permissions (according to the assessment) ---
        $permissions = [

            //Movies
            'view movies',
            'create movies',
            'edit movies',
            'delete movies',

            //Theatres
            'view theatres',
            'create theatres',
            'edit theatres',
            'delete theatres',

            //Screens
            'view screens',
            'create screens',
            'edit screens',
            'delete screens',

            //Shows
            'view shows',
            'create shows',
            'edit shows',
            'delete shows',

            //Seats
            'view seats',
            'create seats',
            'edit seats',
            'delete seats',

            //Bookings
            'view bookings',
            'create bookings',
            'cancel bookings',

            //Dashboard & Reports
            'view dashboard',
            'view reports',

            //Notifications
            'send notifications',
            //users
            'view users',
            'edit users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ===========================================================
        //  ADMIN → Full Access
        // ===========================================================
        $admin->syncPermissions(Permission::all());

        // ===========================================================
        // MANAGER → Manage only within their Theatre
        // ===========================================================
        $manager->syncPermissions([
            // Movies (manage only movies linked to their theatre)
            'view movies',
            'create movies',
            'edit movies',
            'delete movies',

            // Theatres (view-only)
            'view theatres',

            // Screens (full CRUD)
            'view screens',
            'create screens',
            'edit screens',
            'delete screens',

            // Shows (full CRUD)
            'view shows',
            'create shows',
            'edit shows',
            'delete shows',

            // Seats (full CRUD)
            'view seats',
            'create seats',
            'edit seats',
            'delete seats',

            // Bookings
            'create bookings',
            'view bookings',

            // Dashboard & Notifications
            'view dashboard',
            'send notifications',
        ]);

        // ===========================================================
        // CUSTOMER → Frontend Access Only
        // ===========================================================
        $customer->syncPermissions([
            'view movies',
            'view theatres',
            'view screens',
            'view shows',
            'view seats',
            'create bookings',
            'cancel bookings',
        ]);
    }
}
