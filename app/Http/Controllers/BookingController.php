<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBookingStatusRequest;
use App\Models\Booking;
use App\Notifications\BookingStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        $query = trim((string) $request->input('q', ''));

        $bookings = Booking::with(['user', 'show.movie', 'show.screen.theatre', 'items.seat'])
            ->when($user->hasRole('Manager'), function ($q) use ($user) {
                // Limit to bookings for theatres managed by this manager
                $q->whereHas('show.screen.theatre', function ($t) use ($user) {
                    $t->where('manager_id', $user->id);
                });
            })
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->whereHas('user', fn($u) => $u->where('name', 'like', "%{$query}%"))
                        ->orWhereHas('show.movie', fn($m) => $m->where('title', 'like', "%{$query}%"))
                        ->orWhereHas('show.screen.theatre', fn($t) => $t->where('name', 'like', "%{$query}%"))
                        ->orWhereHas('items.seat', fn($s) => $s->where('seat_number', 'like', "%{$query}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('pages.bookings.index', compact('bookings'));
    }


    public function update(UpdateBookingStatusRequest $request, Booking $booking)
    {

        try {
            DB::beginTransaction();
            $status = $request->status;
            $booking->update(['status' => $status]);

            if ($status === 'confirmed') {
                $booking->items->each(fn($item) => $item->seat->update(['status' => 'booked']));
            } elseif ($status === 'cancelled') {
                $booking->items->each(fn($item) => $item->seat->update(['status' => 'available']));
            }
            $booking->user->notify(new BookingStatusNotification($booking, $status));
            DB::commit();
            return back()->with('success', "Booking {$status} successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Failed to update booking', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to update booking: ' . $e->getMessage());
        }
    }
}
