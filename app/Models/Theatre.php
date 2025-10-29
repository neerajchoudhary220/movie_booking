<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theatre extends Model
{
    protected $fillable = [
        'name',
        'location',
        'city',
        'state',
        'pincode',
        'status',
        'manager_id'
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // One theatre can have many screens
    public function screens()
    {
        return $this->hasMany(Screen::class);
    }

    public function shows()
    {
        return $this->hasManyThrough(Show::class, Screen::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
