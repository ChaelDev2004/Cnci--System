<?php

namespace App\Http\Controllers;

use App\Models\ChurchLocation;
use App\Models\HomeSettings;

class findUsController extends Controller
{
    public function index()
    {
        $settings = HomeSettings::first() ?? new HomeSettings();
        $locations = ChurchLocation::with('pastor')->orderBy('sort_order')->get();
        $defaultLocation = $locations->firstWhere('is_default', true) ?? $locations->first();

        return view('findus', compact('settings', 'locations', 'defaultLocation'));
    }
}
