<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PastorImage extends Model
{
    protected $fillable = [
        'pastor_id',
        'path',
        'caption',
        'sort_order',
    ];

    public function pastor(): BelongsTo
    {
        return $this->belongsTo(Pastor::class);
    }
}
