<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pastor extends Model
{
    protected $fillable = [
        'name',
        'role',
        'church',
        'sort_order',
        'image',
        'bio',
        'email',
        'phone',
        'facebook',
        'instagram',
        'youtube',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(ChurchLocation::class);
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(PastorImage::class)->orderBy('sort_order');
    }
}
