<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    protected $fillable = [
        'booking_id',
        'show_id',
        'seat_id',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function show()
    {
        return $this->belongsTo(Show::class);
    }
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
