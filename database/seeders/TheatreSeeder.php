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

        $theatres = [
            [
                'name' => 'Inox City Mall',
                'location' => 'City Mall, Ajmer Road',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'pincode' => '302019',
                'status' => 'active',
            ],
            [
                'name' => 'PVR Crown Plaza',
                'location' => 'Crown Plaza, Vaishali Nagar',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'pincode' => '302021',
                'status' => 'active',
            ],
            [
                'name' => 'Carnival Cinemas',
                'location' => 'GT Road, Alwar',
                'city' => 'Alwar',
                'state' => 'Rajasthan',
                'pincode' => '301001',
                'status' => 'inactive',
            ],
            [
                'name' => 'Rajmandir Cinema',
                'location' => 'MI Road',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'pincode' => '302001',
                'status' => 'active',
            ],
            [
                'name' => 'Wave Multiplex',
                'location' => 'Pacific Mall, Vaibhav Nagar',
                'city' => 'Udaipur',
                'state' => 'Rajasthan',
                'pincode' => '313001',
                'status' => 'active',
            ],
        ];

        foreach ($theatres as $data) {
            Theatre::updateOrCreate(
                [
                    'name' => $data['name'],
                    'location' => $data['location'],
                ],
                $data
            );
        }
    }
}
