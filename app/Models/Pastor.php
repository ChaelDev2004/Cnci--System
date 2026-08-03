<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pastor extends Model
{
    protected $fillable = [
        'name',
        'role',
        'church',
        'sort_order',
        'image',
        'bio', // Add this for pastor description
        'email', // Add this
        'phone', // Add this
        'facebook', // Add social media
        'instagram',
        'youtube',
    ];

    // Relationship with ChurchLocation
    public function locations()
    {
        return $this->hasMany(ChurchLocation::class);
    }
}
