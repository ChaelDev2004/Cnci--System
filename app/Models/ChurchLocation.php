<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchLocation extends Model
{
    protected $fillable = [
        'name',
        'city',
        'address',
        'map_embed_url',
        'maps_link',
        'service_time',
        'is_default',
        'sort_order',
        'pastor_id', // Add this
        'visit_link', // Add this for custom visit page
    ];

    // Relationship with Pastor
    public function pastor()
    {
        return $this->belongsTo(Pastor::class);
    }
}
