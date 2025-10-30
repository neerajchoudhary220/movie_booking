<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShowRequest;
use App\Http\Requests\UpdateShowRequest;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Show::with(['movie', 'screen', 'theatre'])
            ->when($user->hasRole('Manager'), fn($q) => $q->byManager($user->id))
            ->when($request->filled('q'), function ($q) use ($request) {
                $search = $request->get('q');
                $q->whereHas('movie', fn($sub) => $sub->where('title', 'like', "%{$search}%"));
            })
            ->latest('starts_at');
        $shows = $query->paginate(12)->withQueryString();
        return view('pages.shows.index', compact('shows'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->can('create', Show::class)) {
            abort(403, 'You are not authorized to add a new show.');
        }
        $user = $request->user();
        $movies = Movie::active()->get();
        $screens = Screen::with('theatre')
            ->when($user->hasRole('Manager'), fn($q) => $q->forManager($user->id))->get();
        return view('pages.shows.create', compact('movies', 'screens'));
    }



    public function store(StoreShowRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $screen = Screen::findOrFail($data['screen_id']);
            $data['theatre_id'] = $screen->theatre_id;
            $startsAt = Carbon::parse($data['starts_at']);
            $data['ends_at'] = $data['ends_at']
                ? Carbon::parse($data['ends_at'])
                : $startsAt->copy()->addMinutes($data['duration'] ?? 120);
            if (isset($data['price_map']) && is_string($data['price_map'])) {
                $decoded = json_decode($data['price_map'], true);
                $data['price_map'] = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
            }

            $show = Show::create($data);
            DB::commit();

            return redirect()
                ->route('shows.index')
                ->with('success', "Show '{$show->movie->title}' created successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Show creation failed', ['error' => $e->getMessage()]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create show: ' . $e->getMessage());
        }
    }

    public function edit(Show $show, Request $request)
    {
        if (!$request->user()->can('update', $show)) {
            abort(403, 'You are not authorized to edit this show.');
        }

        $movies = Movie::active()->get();
        $screens = Screen::with('theatre')->get();
        return view('pages.shows.edit', compact('movies', 'screens', 'show'));
    }

    public function update(UpdateShowRequest $request, Show $show)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $screen = Screen::findOrFail($data['screen_id']);
            $data['theatre_id'] = $screen->theatre_id;
            $show->update($data);
            DB::commit();

            return redirect()
                ->route('shows.index')
                ->with('success', "Show '{$show->fresh()->movie->title}' updated successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Show update failed', ['error' => $e->getMessage()]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update show: ' . $e->getMessage());
        }
    }

    public function show(Show $show, Request $request)
    {
        if (!$request->user()->can('view', $show)) {
            abort(403, 'You are not authorized to view this show.');
        }
        $show->load(['movie', 'screen', 'theatre']);
        return view('pages.shows.show', compact('show'));
    }

    public function destroy(Show $show, Request $request)
    {
        if (!$request->user()->can('delete', $show)) {
            abort(403, 'You are not authorized to delete this show.');
        }
        $show->delete();
        return redirect()->route('shows.index')->with("success", "Show deleted successfully.");
    }
}
