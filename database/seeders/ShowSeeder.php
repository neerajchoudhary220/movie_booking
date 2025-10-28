<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use App\Models\Show;
// use App\Models\Movie;
use App\Models\Screen;
use App\Models\ShowSeat;
use Carbon\Carbon;

class ShowSeeder extends Seeder
{
    public function run()
    {
        $movie = Movie::firstOrCreate(
            ['title' => 'Interstellar'],
            ['description' => 'Space epic', 'category' => 'Sci-Fi', 'duration' => 169, 'poster_url' => null]
        );

        $screen = Screen::first(); // pick one for demo
        if (! $screen) return;

        $startsAt = Carbon::today()->addHours(18); // today 6 PM
        $show = Show::updateOrCreate(
            ['screen_id' => $screen->id, 'starts_at' => $startsAt],
            [
                'movie_id'    => $movie->id,
                'ends_at'     => $startsAt->copy()->addMinutes($movie->duration ?? 150),
                'base_price'  => 150.00,
                'price_map'   => ['regular' => 150, 'premium' => 220, 'vip' => 300],
                'status'      => Show::STATUS_SCHEDULED,
                'lock_minutes' => 5,
            ]
        );

        // Generate ShowSeat for each Seat on that Screen (idempotent)
        $screen->seats()->get()->each(function ($seat) use ($show) {
            ShowSeat::firstOrCreate([
                'show_id' => $show->id,
                'seat_id' => $seat->id,
            ]);
        });
    }
}
