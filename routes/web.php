
<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\MovieBrowseController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\TheatreController;
use Illuminate\Support\Facades\Route;


Route::controller(MovieBrowseController::class)->group(function () {
    Route::get('/', 'index')->name('movies');
    Route::get('show-times/{movie}', 'showtimes')->name('movies.showtimes');
});


Route::middleware(['auth'])->group(function () {
    //Customer Booking
    Route::controller(CustomerBookingController::class)->prefix('bookings')->name('customer.bookings.')->group(function () {
        Route::get('create/{show}', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
    //Movies
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('movies', MovieController::class);
    });
    //Theatres
    Route::resource('theatres', TheatreController::class);
    //Screens
    Route::resource('screens', ScreenController::class);
    //Shows
    Route::resource('shows', ShowController::class);
    //Seats
    Route::controller(SeatController::class)->prefix('screens/{screen}/seats')->name('screens.seats.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{seat}/edit', 'edit')->name('edit');
        Route::put('/{seat}', 'update')->name('update');
        Route::delete('/{seat}', 'destroy')->name('destroy');
        Route::post('/generate-layout', 'generateLayout')->name('generate');
        Route::post('/{seat}/toggle', 'toggleStatus')->name('toggle');
    });

    // Route::resource('seats', SeatController::class);
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
