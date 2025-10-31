
<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\MovieBrowseController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\TheatreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Customer
Route::middleware('customer')->controller(MovieBrowseController::class)->group(function () {
    Route::get('/', 'index')->name('movies.index');
    Route::get('show-times/{movie}', 'showtimes')->name('movies.showtimes');

    Route::middleware('auth')->group(function () {
        //Booking
        Route::controller(CustomerBookingController::class)->prefix('bookings')->name('bookings.')->group(function () {
            Route::get('create/{show}', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
        //Profile
        Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
    });
});


//Admin/Manager
Route::middleware(['auth', 'checkRole:Admin,Manager'])->prefix('admin')->group(function () {
    //dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
    //movie
    Route::name('admin.')->group(function () {
        Route::resource('movies', MovieController::class);
        //Bookings
        Route::controller(BookingController::class)->prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{booking}', 'show')->name('show');
            Route::put('/{booking}', 'update')->name('update');
        });
        Route::middleware('checkRole:Admin')->group(function () {
            Route::resource('users', UserController::class)->except('destroy');
            Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/update', 'update')->name('update');
            });
        });
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
});




require __DIR__ . '/auth.php';
