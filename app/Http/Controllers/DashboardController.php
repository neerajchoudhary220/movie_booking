<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Show;
use App\Models\Screen;
use App\Models\Theatre;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 🧑 ADMIN DASHBOARD
        if ($user->hasRole('Admin')) {
            $todayBookings = Booking::whereDate('created_at', Carbon::today())->count();

            $totalSeats = \App\Models\Seat::count();
            $bookedSeats = \App\Models\ShowSeat::where('status', 'booked')->count();
            $occupancy = $totalSeats ? round(($bookedSeats / $totalSeats) * 100, 1) . '%' : '0%';

            $cancelled = Booking::where('status', 'cancelled')->count();
            $confirmed = Booking::where('status', 'confirmed')->count();

            return view('pages.dashboard.admin', [
                'todayBookings' => $todayBookings,
                'occupancy'     => $occupancy,
                'cancelled'     => $cancelled,
                'confirmed'     => $confirmed,
                'theatreCount'  => Theatre::count(),
                'screenCount'   => Screen::count(),
                'showCount'     => Show::count(),
            ]);
        }

        // 👨 MANAGER DASHBOARD
        if ($user->hasRole('Manager')) {
            $theatreId = $user->theatre_id;
            $todayBookings = Booking::whereDate('created_at', Carbon::today())
                ->whereHas('show.screen', fn($q) => $q->where('theatre_id', $theatreId))
                ->count();

            $totalSeats = \App\Models\Seat::whereHas('screen', fn($q) => $q->where('theatre_id', $theatreId))->count();
            $bookedSeats = \App\Models\ShowSeat::where('status', 'booked')
                ->whereHas('seat.screen', fn($q) => $q->where('theatre_id', $theatreId))
                ->count();

            $occupancy = $totalSeats ? round(($bookedSeats / $totalSeats) * 100, 1) . '%' : '0%';

            $cancelled = Booking::where('status', 'cancelled')
                ->whereHas('show.screen', fn($q) => $q->where('theatre_id', $theatreId))
                ->count();
            $confirmed = Booking::where('status', 'confirmed')
                ->whereHas('show.screen', fn($q) => $q->where('theatre_id', $theatreId))
                ->count();

            return view('pages.dashboard.manager', [
                'todayBookings' => $todayBookings,
                'occupancy'     => $occupancy,
                'cancelled'     => $cancelled,
                'confirmed'     => $confirmed,
                'screenCount'   => Screen::where('theatre_id', $theatreId)->count(),
                'showCount'     => Show::whereHas('screen', fn($q) => $q->where('theatre_id', $theatreId))->count(),
            ]);
        }

        // 👤 CUSTOMER DASHBOARD
        if ($user->hasRole('Customer')) {
            $myBookings = Booking::where('user_id', $user->id)->count();
            $myConfirmed = Booking::where('user_id', $user->id)->where('status', 'confirmed')->count();
            $myCancelled = Booking::where('user_id', $user->id)->where('status', 'cancelled')->count();

            return view('pages.dashboard.customer', [
                'myBookings' => $myBookings,
                'myConfirmed' => $myConfirmed,
                'myCancelled' => $myCancelled,
            ]);
        }

        abort(403, 'Unauthorized.');
    }
}
