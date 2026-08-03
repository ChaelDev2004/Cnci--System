<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSettings extends Model
{
    protected $guarded = [];

    public function brandName(): string
    {
        return $this->brand_name ?: 'CNCI';
    }

    public function brandTagline(): string
    {
        return $this->brand_tagline ?: 'Rosales';
    }

    public function logoUrl(): string
    {
        if ($this->logo_path) {
            return asset('storage/' . $this->logo_path);
        }

        return asset('assets/img/avatars/cnciLogo.png');
    }

    public function faviconUrl(): string
    {
        if ($this->favicon_path) {
            return asset('storage/' . $this->favicon_path);
        }

        return asset('assets/img/favicon/favicon.ico');
    }
}
