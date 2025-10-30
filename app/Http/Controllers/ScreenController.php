<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreenRequest;
use App\Http\Requests\UpdateScreenRequest;
use App\Models\Screen;
use App\Models\Theatre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Screen::with('theatre')
            ->when($user->hasRole('Manager'), function ($q) use ($user) {
                $q->whereHas('theatre', fn($t) => $t->forManager($user->id));
            })
            ->when($request->filled('q'), function ($q) use ($request) {
                $search = $request->q;
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('theatre', fn($t) => $t->where('name', 'like', "%{$search}%"));
            })->latest();
        $screens = $query->paginate(12)->withQueryString();
        return view('pages.screens.index', compact('screens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!Gate::allows('create', Screen::class)) {
            abort(403, 'You are not authorized to add the screen.');
        }

        $theatres = Theatre::active()->get();
        return view('pages.screens.create', compact('theatres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreenRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            Screen::create($data);
            DB::commit();
            return redirect()->route('screens.index')->with('success', 'Screen created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Screen creation failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create screen: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Screen $screen)
    {
        if (!Gate::allows('view', $screen)) {
            abort(403, 'You are not authorized to view this page');
        }
        $screen->load('theatre');
        return view('pages.screens.show', compact('screen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screen $screen)
    {
        if (!Gate::allows('view', $screen)) {
            abort(403, 'You are not authorized to do this action');
        }
        $theatres = Theatre::active()->get();
        return view('pages.screens.edit', compact('screen', 'theatres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScreenRequest $request, Screen $screen)
    {
        try {
            DB::beginTransaction();
            $screen->update($request->validated());
            DB::commit();
            return redirect()->route('screens.index')->with('success', 'Screen updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Screen updated failed', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screen $screen)
    {
        if (!Gate::allows('view', $screen)) {
            abort(403, 'You are not allow to do this action');
        }
        $screen->delete();
        return redirect()->route('screens.index')->with('success', 'Screen deleted successfully.');
    }
}
