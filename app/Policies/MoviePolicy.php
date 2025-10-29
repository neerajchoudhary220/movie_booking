<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Movie $movie): bool
    {
        return $user->hasRole('Admin') ||
            $user->hasRole('Manager') && $movie->shows()->byManger($user->id)->exists();
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
    public function update(User $user, Movie $movie): bool
    {
        return $user->hasRole('Admin') ||
            $user->hasRole('Manager') && $movie->shows()->byManger($user->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Movie $movie): bool
    {
        return $user->hasRole('Admin') ||
            $user->hasRole('Manager') && $movie->shows()->byManger($user->id)->exists();
    }
}
