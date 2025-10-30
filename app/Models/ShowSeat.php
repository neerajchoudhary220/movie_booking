<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowSeat extends Model
{

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_PENDING   = 'pending';   // temporarily locked
    public const STATUS_BOOKED    = 'booked';
    public const STATUS_BLOCKED   = 'blocked';   // admin/manual block for this show

    protected $fillable = [
        'show_id',
        'seat_id',
        'status',
        'price_override', // optional per-show price
        'locked_until',   // timestamp for auto-release
    ];

    protected $casts = [
        'price_override' => 'decimal:2',
        'locked_until'   => 'datetime',
    ];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

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
