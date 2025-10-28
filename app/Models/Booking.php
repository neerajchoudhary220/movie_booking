<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public const STATUS_PENDING   = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_EXPIRED   = 'expired';

    protected $fillable = [
        'user_id',
        'show_id',
        'status',
        'total_amount',
        'payment_ref',
        'expires_at', // auto-release seats if not confirmed by this time
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'expires_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function show()
    {
        return $this->belongsTo(Show::class);
    }
    public function items()
    {
        return $this->hasMany(BookingSeat::class);
    }
}
