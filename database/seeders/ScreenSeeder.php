<?php

namespace Database\Seeders;

use App\Models\Screen;
use App\Models\Theatre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Map of theatre name => screens to seed
        $data = [
            'INOX City Mall' => [
                ['name' => 'Screen 1', 'capacity' => 120, 'rows' => 12, 'cols' => 10, 'status' => 'active'],
                ['name' => 'Screen 2', 'capacity' => 150, 'rows' => 15, 'cols' => 10, 'status' => 'active'],
            ],
            'PVR Central Mall' => [
                ['name' => 'Audi 1', 'capacity' => 100, 'rows' => 10, 'cols' => 10, 'status' => 'active'],
                ['name' => 'Audi 2', 'capacity' => 180, 'rows' => 12, 'cols' => 15, 'status' => 'active'],
            ],
        ];

        foreach ($data as $theatreName => $screens) {
            $theatre = Theatre::where('name', $theatreName)->first();

            if (! $theatre) {
                // Skip silently if theatre not found; or you can create/log.
                continue;
            }

            foreach ($screens as $s) {
                Screen::updateOrCreate(
                    [
                        'theatre_id' => $theatre->id,
                        'name'       => $s['name'],  // unique per theatre
                    ],
                    [
                        'capacity' => $s['capacity'],
                        'rows'     => $s['rows'],
                        'cols'     => $s['cols'],
                        'status'   => $s['status'],
                    ]
                );
            }
        }
    }
}
