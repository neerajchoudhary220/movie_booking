<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Screen;
use App\Models\Show;
use App\Models\ShowSeat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShowSeeder extends Seeder
{
    public function run(): void
    {
        // 🎥 Seed some demo movies (if not already)
        $movies = [
            ['title' => 'Interstellar', 'category' => 'Sci-Fi', 'duration' => 169, 'language' => 'English', 'description' => 'A journey through space and time.'],
            ['title' => 'Inception', 'category' => 'Action', 'duration' => 148, 'language' => 'English', 'description' => 'Dreams within dreams.'],
            ['title' => 'Dangal', 'category' => 'Drama', 'duration' => 161, 'language' => 'Hindi', 'description' => 'A story of strength and determination.'],
        ];

        foreach ($movies as $data) {
            Movie::updateOrCreate(['title' => $data['title']], $data);
        }

        // Pick all available screens (each linked to a theatre)
        $screens = Screen::with('theatre')->get();

        if ($screens->isEmpty()) {
            $this->command->warn('⚠️ No screens found. Please seed theatres and screens first.');
            return;
        }

        // Create a few shows per screen
        foreach ($screens as $screen) {
            $theatre = $screen->theatre;

            if (! $theatre) {
                $this->command->warn("⚠️ Screen ID {$screen->id} has no theatre linked. Skipping...");
                continue;
            }

            // pick random movie
            $movie = Movie::inRandomOrder()->first();
            $startsAt = Carbon::today()->addHours(rand(10, 22)); // between 10 AM and 10 PM

            $show = Show::updateOrCreate(
                [
                    'screen_id' => $screen->id,
                    'starts_at' => $startsAt,
                ],
                [
                    'movie_id'     => $movie->id,
                    'theatre_id'   => $theatre->id,
                    'ends_at'      => $startsAt->copy()->addMinutes($movie->duration ?? 150),
                    'base_price'   => 150.00,
                    'price_map'    => ['regular' => 150, 'premium' => 220, 'vip' => 300],
                    'status'       => Show::STATUS_SCHEDULED,
                    'lock_minutes' => 5,
                ]
            );

            // Generate ShowSeat records (if not already)
            $screen->seats()->each(function ($seat) use ($show) {
                ShowSeat::firstOrCreate([
                    'show_id' => $show->id,
                    'seat_id' => $seat->id,
                ]);
            });

            $this->command->info("Show created for '{$movie->title}' on Screen {$screen->id} ({$theatre->name})");
        }
    }
}
