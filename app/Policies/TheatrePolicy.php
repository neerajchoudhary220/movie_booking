<?php

namespace App\Policies;

use App\Models\Theatre;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TheatrePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Manager', 'Customer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Theatre $theatre): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Theatre $theatre): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Theatre $theatre): bool
    {
        return $user->hasRole('Admin');
    }
}
