<?php

namespace App\Http\Controllers;

use App\Events\BookingUpdatedEvent;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Seat;
use App\Models\Show;
use App\Models\User;
use App\Notifications\SeatBookedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerBookingController extends Controller
{
    public function create(Show $show)
    {
        $show->load('movie', 'screen.theatre');
        $seats = $show->screen->seats()->orderBy('row_index')->orderBy('col_number')->get();
        return view('pages.bookings.customer.create', compact('seats', 'show'));
    }

    public function store(StoreBookingRequest $request)
    {
        $request->validated();
        $user = $request->user();
        $show = Show::with(['movie', 'screen.theatre'])->findOrFail($request->show_id);
        try {
            DB::beginTransaction();
            // Lock available seats
            $seats = Seat::whereIn('id', $request->seats)
                ->where('status', 'available')
                ->lockForUpdate()
                ->get();

            if ($seats->count() !== count($request->seats)) {
                return back()->with('error', 'Some seats are already booked or locked.');
            }

            $total = $seats->sum(fn($seat) => $seat->price_override ?? $show->base_price);
            $booking = Booking::create([
                'user_id' => $user->id,
                'show_id' => $show->id,
                'status' => Booking::STATUS_PENDING,
                'total_amount' => $total,
                'expires_at' => Carbon::now()->addMinutes(5),
            ]);

            foreach ($seats as $seat) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'show_id' => $show->id,
                    'seat_id' => $seat->id,
                    'price' => $seat->price_override ?? $show->base_price,
                ]);
                $seat->update(['status' => 'pending']);
            }
            DB::commit();
            //Notifications (Admin + Manager)
            $admin = User::role('Admin')->first();
            $manager = optional($show->screen->theatre)->manager;
            $admin->notify(new SeatBookedNotification($booking));
            if ($manager) {
                $manager->notify(new SeatBookedNotification($booking));
            }
            // Broadcast seat changes
            broadcast(new BookingUpdatedEvent($booking, 'pending'))->toOthers();
            return redirect()->route('customer.bookings.create', $show)
                ->with('success', 'Seats reserved! Waiting for manager confirmation.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Failed to customer booking', ['error' => $e->getMessage()]);
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }
}
