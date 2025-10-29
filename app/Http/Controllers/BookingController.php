<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService) {}

    public function index()
    {
        // Fetch all bookings with related models
        $bookings = Booking::with(['user', 'show.movie', 'show.screen'])
            ->latest()
            ->paginate(10);

        // Return to view
        return view('pages.bookings.index', compact('bookings'));
    }


    public function reserve(Request $request)
    {
        $request->validate([
            'show_id' => 'required|exists:shows,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'integer|exists:seats,id',
        ]);

        $booking = $this->bookingService->reserveSeats(
            auth()->id(),
            $request->show_id,
            $request->seats
        );

        return response()->json([
            'message' => 'Seats reserved successfully',
            'booking' => $booking
        ]);
    }

    public function confirm(Request $request, $bookingId)
    {
        $this->bookingService->confirmBooking($bookingId, $request->payment_ref ?? null);

        return response()->json([
            'message' => 'Booking confirmed successfully',
        ]);
    }
}
