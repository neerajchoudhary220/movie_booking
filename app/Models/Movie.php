<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',      // e.g., Action, Drama, Sci-Fi
        'duration',      // in minutes
        'language',      // optional: Hindi/English/etc
        'release_date',  // optional
        'poster_url',
        'status',        // active/inactive
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
    public function scopeCategory($q, $cat)
    {
        return $q->where('category', $cat);
    }
}
