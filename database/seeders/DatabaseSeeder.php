<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Roles & Permissions
        $this->call(RolesAndPermissionsSeeder::class);
        //Theatres
        $this->call(TheatreSeeder::class);
        //Users
        $this->call(UserSeeder::class);
        //Screens
        $this->call(ScreenSeeder::class);

        //Seats
        $this->call(SeatSeeder::class);

        //Movies
        $this->call(MovieSeeder::class);

        $this->call(ShowSeeder::class);
    }
}
