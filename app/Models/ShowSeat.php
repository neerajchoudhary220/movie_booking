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
}
