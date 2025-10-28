<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieBrowseController extends Controller
{
    public function index(Request $request)
    {
        $category = trim((string) $request->input('category', ''));
        $date     = $request->input('date'); // YYYY-MM-DD

        $movies = Movie::query()
            // filter by category
            ->when($category !== '', fn($q) => $q->where('category', $category))
            // filter by show date (only show movies that have a show on that day)
            ->when($date, function ($q) use ($date) {
                $q->whereHas('shows', fn($s) => $s->whereDate('starts_at', $date));
            })
            // eager load upcoming/same-day shows (optional, useful for cards)
            ->with(['shows' => function ($s) use ($date) {
                $s->select('id', 'movie_id', 'screen_id', 'starts_at', 'status')
                    ->when($date, fn($ss) => $ss->whereDate('starts_at', $date))
                    ->whereIn('status', ['scheduled', 'running'])
                    ->orderBy('starts_at');
            }])
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString(); // keep filters in pagination links

        return view('pages.movies.public', compact('movies'));
    }

    // (Optional) showtimes page if your blade links to it
    public function showtimes(Movie $movie, Request $request)
    {
        $date = $request->input('date');
        $shows = $movie->shows()
            ->when($date, fn($q) => $q->whereDate('starts_at', $date))
            ->whereIn('status', ['scheduled', 'running'])
            ->orderBy('starts_at')
            ->with('screen.theatre')
            ->get();

        return view('pages.movies.showtimes', compact('movie', 'shows', 'date'));
    }
}
