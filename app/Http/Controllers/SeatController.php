<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeatRequest;
use App\Http\Requests\UpdateSeatRequest;
use App\Models\Screen;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Screen $screen)
    {
        if (!Gate::allows('viewAny', [Seat::class, $screen])) {
            abort(403, 'You are not authorized for this action');
        }
        // $seats = $screen->seats()->orderBy('row_index')->orderBy('col_number')->get();
        $seats = $screen->seats()
            ->orderBy('row_index')
            ->orderBy('col_number')
            ->get();

        $totalSeats = $screen->seats()->count();
        $availableCount = $screen->seats()->available()->count();
        $pendingCount   = $screen->seats()->pending()->count();
        $bookedCount    = $screen->seats()->booked()->count();
        $blockedCount   = $screen->seats()->blocked()->count();

        return view('pages.seats.index', compact(
            'screen',
            'seats',
            'totalSeats',
            'availableCount',
            'pendingCount',
            'bookedCount',
            'blockedCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Screen $screen)
    {
        if (!Gate::allows('create', [Seat::class, $screen])) {
            abort(403, 'You are not authorized for this action');
        }
        return view('pages.seats.create', compact('screen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeatRequest $request, Screen $screen)
    {
        if (!Gate::allows('create', [Seat::class, $screen])) {
            abort(403, 'You are not authorized for this action');
        }
        DB::transaction(function () use ($screen, $request) {
            $data = $request->validated();
            $data['screen_id'] = $screen->id;
            Seat::create($data);
        });
        return redirect()->route('screens.seats.index', $screen)
            ->with('success', 'Seat created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screen $screen, Seat $seat)
    {
        if (!Gate::allows('update', $seat)) {
            abort(403, 'You are not authorized for this action');
        }
        return view('pages.seats.edit', compact('screen', 'seat'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeatRequest $request, Screen $screen, Seat $seat)
    {
        if (!Gate::allows('update', $seat)) {
            abort(403, 'You are not authorized for this action');
        }
        $seat->update($request->validated());
        return redirect()->route('screens.seats.index', $screen)
            ->with('success', 'Seat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screen $screen, Seat $seat)
    {
        if (!Gate::allows('delete', $seat)) {
            abort(403, 'You are not authorized for this action');
        }
        $seat->delete();
        return redirect()->route('screens.seats.index', $screen)
            ->with('success', 'Seat deleted successfully.');
    }

    public function generateLayout(Screen $screen)
    {
        if (!Gate::allows('create', [Seat::class, $screen])) {
            abort(403, 'You are not authorized for this action');
        }
        DB::transaction(function () use ($screen) {
            $rows = range('A', chr(64 + $screen->rows));
            $cols = $screen->cols;

            foreach ($rows as $rIndex => $rowLabel) {
                for ($c = 1; $c <= $cols; $c++) {
                    $seatNumber = sprintf('%s%02d', $rowLabel, $c);
                    Seat::firstOrCreate([
                        'screen_id' => $screen->id,
                        'seat_number' => $seatNumber,
                    ], [
                        'row_label' => $rowLabel,
                        'row_index' => $rIndex + 1,
                        'col_number' => $c,
                        'type' => 'regular',
                        'status' => Seat::STATUS_AVAILABLE,
                    ]);
                }
            }
        });

        return back()->with('success', 'Seat layout generated successfully.');
    }

    public function toggleStatus(Request $request, $screenId, Seat $seat)
    {
        if (!Gate::allows('update', $seat)) {
            abort(403, 'You are not authorized for this action.');
        }

        // Ensure the seat belongs to this screen
        if ($seat->screen_id != $screenId) {
            abort(403, 'Unauthorized seat access.');
        }

        // Toggle between available and blocked
        $statusCycle = [
            Seat::STATUS_AVAILABLE => Seat::STATUS_BLOCKED,
            Seat::STATUS_BLOCKED   => Seat::STATUS_AVAILABLE,
        ];

        $newStatus = $statusCycle[$seat->status] ?? Seat::STATUS_AVAILABLE;
        $seat->update(['status' => $newStatus]);

        // 🧮 Get updated counts (using scopes)
        $screen = $seat->screen;
        $counts = [
            'total'     => $screen->seats()->count(),
            'available' => $screen->seats()->available()->count(),
            'pending'   => $screen->seats()->pending()->count(),
            'booked'    => $screen->seats()->booked()->count(),
            'blocked'   => $screen->seats()->blocked()->count(),
        ];

        return response()->json([
            'success' => true,
            'new_status' => $newStatus,
            'counts' => $counts,
        ]);
    }
}
