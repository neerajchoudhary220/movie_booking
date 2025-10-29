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
        'theatre_id',
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

    public function theatre()
    {
        return $this->belongsTo(Theatre::class);
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

    //Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED)
            ->orWhere('status', self::STATUS_RUNNING);
    }
    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>=', now());
    }

    public function scopeByTheatre($query, $theatreId)
    {
        return $query->where('theatre_id', $theatreId);
    }
    public function scopeByManager($query, $managerId)
    {
        return $query->whereHas('theatre', fn($t) => $t->where('manager_id', $managerId));
    }
}
