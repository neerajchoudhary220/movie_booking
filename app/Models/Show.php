<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_RUNNING   = 'running';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';


    protected $fillable = [
        'movie_id',
        'screen_id',
        'starts_at',
        'ends_at',
        'base_price',
        'price_map',      // JSON: {"regular":120.00,"premium":180.00,"vip":240.00}
        'status',
        'lock_minutes',   // how long to hold "pending" seats
    ];

    protected $casts = [
        'starts_at'  => 'datetime',
        'ends_at'    => 'datetime',
        'base_price' => 'decimal:2',
        'price_map'  => 'array',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    // Per-show seat states
    public function showSeats()
    {
        return $this->hasMany(ShowSeat::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
