<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $movies = [
            [
                'title'       => 'Interstellar',
                'category'    => 'Sci-Fi',
                'duration'    => 169,
                'language'    => 'English',
                'release_date' => Carbon::parse('2014-11-07'),
                'poster_url'  => null,
                'description' => 'A team travels through a wormhole in search of a new home for humanity.',
                'status'      => 'active',
            ],
            [
                'title'       => '3 Idiots',
                'category'    => 'Comedy-Drama',
                'duration'    => 170,
                'language'    => 'Hindi',
                'release_date' => Carbon::parse('2009-12-25'),
                'poster_url'  => null,
                'description' => 'Three friends navigate college life and the pressure to succeed.',
                'status'      => 'active',
            ],
            [
                'title'       => 'Avengers: Endgame',
                'category'    => 'Action',
                'duration'    => 181,
                'language'    => 'English',
                'release_date' => Carbon::parse('2019-04-26'),
                'poster_url'  => null,
                'description' => 'The Avengers assemble once more to reverse Thanos’s actions.',
                'status'      => 'active',
            ],
        ];

        foreach ($movies as $m) {
            Movie::updateOrCreate(
                ['title' => $m['title']],    // unique key
                array_merge($m, ['slug' => Str::slug($m['title'])])
            );
        }
    }
}
