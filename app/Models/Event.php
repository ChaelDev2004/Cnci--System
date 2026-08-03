<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tag',
        'description',
        'image_url',
        'date',
        'time',
        'location',
        'button_text',
        'button_url',
        'is_active',
        'sort_order',
        'event_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('title') && !$event->isDirty('slug')) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())
            ->orWhereNull('event_date')
            ->orderBy('event_date');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now())
            ->orderBy('event_date', 'desc');
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        if ($this->event_date) {
            return $this->event_date->format('F d, Y');
        }
        return $this->date ?? 'TBD';
    }

    public function getFormattedTimeAttribute()
    {
        if ($this->event_date) {
            return $this->event_date->format('g:i A');
        }
        return $this->time ?? 'TBD';
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->is_active) {
            return '<span class="badge bg-success">Active</span>';
        }
        return '<span class="badge bg-danger">Inactive</span>';
    }

    // Helper methods
    public function isUpcoming()
    {
        if ($this->event_date) {
            return $this->event_date >= now();
        }
        return true;
    }

    public function isPast()
    {
        if ($this->event_date) {
            return $this->event_date < now();
        }
        return false;
    }
}
