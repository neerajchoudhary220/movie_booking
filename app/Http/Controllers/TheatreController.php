<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTheatreRequest;
use App\Http\Requests\UpdateTheatreRequest;
use App\Models\Theatre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TheatreController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Theatre::query();

        // Restrict Managers to their assigned theatre only
        if ($user->hasRole('Manager')) {
            $query->where('manager_id', $user->id);
        }

        // Apply search filters (for name, city, pincode)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhere('pincode', 'like', "%{$q}%");
            });
        }

        $theatres = $query->latest()->paginate(12);

        return view('pages.theaters.index', compact('theatres'));
    }


    public function create()
    {
        $managers = User::role('Manager')->get();
        return view('pages.theaters.create', compact('managers'));
    }

    public function store(StoreTheatreRequest $request)
    {
        try {
            Theatre::create($request->validated());
            return redirect()->route('theatres.index')->with('success', 'New theater created successfully');
        } catch (\Exception $e) {
            logger()->error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Theatre $theatre)
    {
        // Authorization check (policy-based + abort fallback)
        if (!Gate::allows('update', $theatre)) {
            abort(403, 'You are not authorized to edit this theatre.');
        }

        // Fetch available managers (for dropdown)
        $managers = User::role('Manager')->get();
        return view('pages.theaters.edit', compact('theatre', 'managers'));
    }


    public function update(UpdateTheatreRequest $request, Theatre $theatre)
    {
        try {
            $theatre->update($request->validated());
            return redirect()
                ->route('theatres.index')
                ->with('success', 'Theatre updated successfully.');
        } catch (\Exception $e) {
            logger()->error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Theatre $theatre)
    {
        if (!Gate::allows('view', $theatre)) {
            abort(403, 'You are not authorized to view this theatre.');
        }
        $theatre->load('manager', 'screens');
        return view('pages.theaters.show', compact('theatre'));
    }

    public function destroy(Theatre $theatre)
    {
        if (!Gate::allows('delete', $theatre)) {
            abort(403, 'You are not authorized to delete this theatre.');
        }
        $theatre->delete();
        return redirect()
            ->route('theatres.index')
            ->with('success', 'Theatre deleted successfully.');
    }
}
