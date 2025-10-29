<?php

namespace App\Policies;

use App\Models\Show;
use App\Models\User;

class ShowPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Show $show): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
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
    public function update(User $user, Show $show)
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $show->theatre->manager_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Show $show)
    {
        return $user->hasRole('Admin') ||
            ($user->hasRole('Manager') && $show->theatre->manager_id === $user->id);
    }
}
