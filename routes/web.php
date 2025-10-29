
<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\MovieBrowseController;
use App\Http\Controllers\TheatreController;
use Illuminate\Support\Facades\Route;


Route::controller(MovieBrowseController::class)->group(function () {
    Route::get('/', 'index')->name('movies');
    Route::get('show-times', 'showtimes')->name('movies.showtimes');
});


Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    //Theatres
    Route::resource('theatres', TheatreController::class);

    // Only Admins & Managers can access Movie CRUD
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('movies', MovieController::class);
    });

    //Bookings
    Route::controller(BookingController::class)->prefix('bookings')->group(function () {
        Route::get('/', 'index')->name('bookings');
        Route::post('reserve', 'reserve')->name('booking.reserve');
        Route::post('{bookingId}/confirm', 'confirm')->name('booking.confirm');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
