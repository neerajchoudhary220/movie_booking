<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_PENDING   = 'pending';   // temp lock
    public const STATUS_BOOKED    = 'booked';
    public const STATUS_BLOCKED   = 'blocked';   // maintenance or admin block

    protected $fillable = [
        'screen_id',
        'row_label',   // e.g., A, B,... AA
        'row_index',   // 1-based index for easy sorting
        'col_number',  // 1..N
        'seat_number', // e.g., A01
        'type',        // regular | premium | vip
        'status',      // available | pending | booked | blocked
        'price_override',
    ];

    protected $casts = [
        'price_override' => 'decimal:2',
    ];

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }

    // Scope: only available seats
    public function scopeAvailable($q)
    {
        return $q->where('status', self::STATUS_AVAILABLE);
    }
    public function scopePending($q)
    {
        return $q->where('status', self::STATUS_PENDING);
    }
    public function scopeBooked($q)
    {
        return $q->where('status', self::STATUS_BOOKED);
    }
    public function scopeBlocked($q)
    {
        return $q->where('status', self::STATUS_BLOCKED);
    }
}
