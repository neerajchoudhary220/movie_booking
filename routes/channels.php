<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('show.{showId}', function ($user, $showId) {
    // You can restrict to roles if you want:
    return $user !== null; // or check roles: $user->hasAnyRole(['Admin', 'Manager', 'Customer']);
});
