<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Show;
use App\Models\Screen;
use App\Models\Seat;
use App\Models\ShowSeat;
use App\Models\Theatre;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        //  ADMIN DASHBOARD
        if ($user->hasRole('Admin')) {
            $todayBookings = Booking::whereDate('created_at', Carbon::today())->count();

            $totalSeats = Seat::count();
            $bookedSeats = Seat::booked()->count();
            $occupancy = $totalSeats ? round(($bookedSeats / $totalSeats) * 100, 1) . '%' : '0%';

            $cancelled = Booking::cancelled()->count();
            $confirmed = Booking::confirmed()->count();

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

        // MANAGER DASHBOARD
        if ($user->hasRole('Manager')) {
            // Get all theatres managed by this manager
            $theatreIds = Theatre::forManager($user->id)->pluck('id');

            //  Aggregate statistics scoped to those theatres
            $todayBookings = Booking::whereDate('created_at', today())
                ->whereHas('show.screen', fn($q) => $q->forTheatres($theatreIds))
                ->count();

            $totalSeats = Seat::whereHas('screen', fn($q) => $q->forTheatres($theatreIds))->count();

            $bookedSeats = Seat::booked()
                ->whereHas('screen', fn($q) => $q->forTheatres($theatreIds))
                ->count();

            $occupancy = $totalSeats ? round(($bookedSeats / $totalSeats) * 100, 1) . '%' : '0%';

            $cancelled = Booking::cancelled()
                ->whereHas('show.screen', fn($q) => $q->forTheatres($theatreIds))
                ->count();

            $confirmed = Booking::confirmed()
                ->whereHas('show.screen', fn($q) => $q->forTheatres($theatreIds))
                ->count();

            $screenCount = Screen::forTheatres($theatreIds)->count();

            $showCount = Show::whereHas('screen', fn($q) => $q->forTheatres($theatreIds))->count();

            return view('pages.dashboard.manager', [
                'todayBookings' => $todayBookings,
                'occupancy'     => $occupancy,
                'cancelled'     => $cancelled,
                'confirmed'     => $confirmed,
                'screenCount'   => $screenCount,
                'showCount'     => $showCount,
            ]);
        }


        // // 👤 CUSTOMER DASHBOARD
        // if ($user->hasRole('Customer')) {
        //     $myBookings = Booking::where('user_id', $user->id)->count();
        //     $myConfirmed = Booking::where('user_id', $user->id)->where('status', 'confirmed')->count();
        //     $myCancelled = Booking::where('user_id', $user->id)->where('status', 'cancelled')->count();

        //     return view('pages.dashboard.customer', [
        //         'myBookings' => $myBookings,
        //         'myConfirmed' => $myConfirmed,
        //         'myCancelled' => $myCancelled,
        //     ]);
        // }

        abort(403, 'Unauthorized.');
    }
}
