<?php

namespace App\Policies;

use App\Models\Screen;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScreenPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Screen $screen): bool
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $screen->theatre->manager_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Screen $screen): bool
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $screen->theatre->manager_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Screen $screen): bool
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $screen->theatre->manager_id === $user->id);
    }
}
