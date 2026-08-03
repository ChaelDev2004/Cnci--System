<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSettings;
use App\Models\Slide;
use App\Models\ChurchLocation;

class WelcomeController extends Controller
{
    public function index()
    {
        $settings  = HomeSettings::first() ?? new HomeSettings();
        $slides    = Slide::where('active', true)->orderBy('sort_order')->get();
        $locations = ChurchLocation::orderBy('sort_order')->get();
        $defaultLocation = $locations->firstWhere('is_default', true) ?? $locations->first();
    
        // PASS the variables to the view
        return view('welcome', compact('settings', 'slides', 'locations', 'defaultLocation'));
    }
}
