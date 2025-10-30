<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = [
        'theatre_id',
        'name',
        'capacity',
        'rows',
        'cols',
        'status',
    ];

    //  Relationships
    public function theatre()
    {
        return $this->belongsTo(Theatre::class);
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    //Scopes
    public function scopeForManager($query, $managerId)
    {
        return $query->whereHas('theatre', function ($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        });
    }

    public function scopeForTheatres($query, $theatre_ids)
    {
        return $query->whereIn('theatre_id', $theatre_ids);
    }
}
