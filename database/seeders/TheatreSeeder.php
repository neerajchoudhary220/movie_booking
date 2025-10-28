<?php

namespace Database\Seeders;

use App\Models\Theatre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TheatreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Using updateOrCreate to avoid duplicates
        Theatre::updateOrCreate(
            ['name' => 'INOX City Mall'], // unique key
            [
                'location' => 'MG Road, Jaipur',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'pincode' => '302001',
                'contact_number' => '9999999999',
                'status' => 'active',
            ]
        );

        Theatre::updateOrCreate(
            ['name' => 'PVR Central Mall'],
            [
                'location' => 'Tonk Road, Jaipur',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'pincode' => '302015',
                'contact_number' => '8888888888',
                'status' => 'active',
            ]
        );
    }
}
