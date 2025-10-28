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
        'contact_number',
        'status',
    ];

    public function managers()
    {
        return $this->hasMany(User::class);
    }

    // One theatre can have many screens
    public function screens()
    {
        return $this->hasMany(Screen::class);
    }
}
