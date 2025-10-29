<?php

namespace App\Policies;

use App\Models\Screen;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeatPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Screen $screen)
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $screen->theatre->manager_id === $user->id);
    }

    public function view(User $user, Seat $seat)
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $seat->screen->theatre->manager_id === $user->id);
    }


    public function create(User $user, Screen $screen)
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $screen->theatre->manager_id === $user->id);
    }

    public function update(User $user, Seat $seat)
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $seat->screen->theatre->manager_id === $user->id);
    }

    public function delete(User $user, Seat $seat)
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $seat->screen->theatre->manager_id === $user->id);
    }
}
