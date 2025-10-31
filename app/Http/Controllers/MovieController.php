<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Movie::with('shows.theatre')
            ->when($user->hasRole('Manager'), function ($q) use ($user) {
                //Restrict to movies having shows in manager's theatre
                $q->whereHas('shows', function ($sub) use ($user) {
                    $sub->byManager($user->id);
                });
            })
            ->when($request->filled('q'), function ($q) use ($request) {
                $search = $request->get('q');
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('language', 'like', "%{$search}%");
                });
            })->latest();
        $movies = $query->paginate(12)->withQueryString();
        return view('pages.movies.admin_and_manger.index', compact('movies'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->can('create', Movie::class)) {
            abort(403, 'You are not authorized to add a new movie.');
        }

        $languages = ['Hindi', 'English', 'Tamil', 'Telugu', 'Kannada', 'Malayalam', 'Bengali', 'Marathi', 'Gujarati'];
        return view('pages.movies.admin_and_manger.create', compact('languages'));
    }

    public function store(StoreMovieRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('posters', 'public');
                $data['poster_url'] = $posterPath;
            }
            // Auto-generate slug if not provided
            $data['slug'] = $data['slug'] ?? str()->slug($data['title']);
            Movie::create($data);
            return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
        } catch (\Exception $e) {
            logger()->error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function edit(Movie $movie, Request $request)
    {
        // Authorization check (policy-based + abort fallback)
        if (!$request->user()->can('update', $movie)) {
            abort(403, 'You are not authorized to edit this movie.');
        }
        $languages = ['Hindi', 'English', 'Tamil', 'Telugu', 'Kannada', 'Malayalam', 'Bengali', 'Marathi', 'Gujarati'];

        return view('pages.movies.admin_and_manger.edit', compact('movie', 'languages'));
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('poster')) {
                // Delete old one if exists
                if ($movie->poster_url && Storage::disk('public')->exists($movie->poster_url)) {
                    Storage::disk('public')->delete($movie->poster_url);
                }

                $movie->poster_url = $request->file('poster')->store('posters', 'public');
            }

            $data['slug'] = $data['slug'] ?? str()->slug($data['title']);
            $movie->update($data);
            return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
        } catch (\Exception $e) {
            logger()->info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Movie $movie, Request $request)
    {
        if (!$request->user()->can('view', $movie)) {
            abort(403, "You are not authorized to view this movie");
        }
        return view('pages.movies.admin_and_manger.show', compact('movie'));
    }

    public function destroy(Movie $movie, Request $request)
    {
        // Authorization check (policy-based + abort fallback)
        if (!$request->user()->can('delete', $movie)) {
            abort(403, 'You are not authorized to delete this movie.');
        }
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
    }
}
