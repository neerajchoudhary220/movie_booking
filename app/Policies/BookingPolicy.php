<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager', 'Customer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
        // Customers can view their own; Admin/Manager can view all
        return $user->id === $booking->user_id || $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Customers can create bookings
        return $user->hasRole('Customer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function confirm(User $user, Booking $booking): bool
    {
        // Only Admin or Manager can confirm pending bookings
        return $booking->status === Booking::STATUS_PENDING && $user->hasAnyRole(['Admin', 'Manager']);
    }


    public function cancel(User $user, Booking $booking): bool
    {
        if ($user->hasAnyRole(['Admin', 'Manager'])) {
            return true; // Can cancel any
        }

        // Customer can cancel only their pending booking
        return $user->id === $booking->user_id && $booking->status === Booking::STATUS_PENDING;
    }
}
