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
        $date = $request->input('date');
        $query = trim((string) $request->input('q', ''));

        $movies = Movie::query()
            ->active()
            ->when($query !== '', fn($q) => $q->where('title', 'like', "%{$query}%"))
            ->when($category !== '', fn($q) => $q->where('category', $category))
            ->when($date, function ($q) use ($date) {
                $q->whereHas('shows', fn($s) => $s->whereDate('starts_at', $date));
            })
            ->with(['shows' => function ($s) use ($date) {
                $s->select('id', 'movie_id', 'screen_id', 'starts_at', 'status')
                    ->when($date, fn($ss) => $ss->whereDate('starts_at', $date))
                    ->whereIn('status', ['scheduled', 'running'])
                    ->orderBy('starts_at');
            }])
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('pages.movies.public.index', compact('movies'));
    }

    public function showtimes(Movie $movie, Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $shows = $movie->shows()
            // ->whereDate('starts_at', $date)
            // ->whereIn('status', ['scheduled', 'running'])
            // ->with('screen.theatre')
            ->orderBy('starts_at')
            ->get();

        return view('pages.movies.public.showtimes', compact('movie', 'shows', 'date'));
    }
}
