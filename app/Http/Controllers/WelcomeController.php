<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSettings;
use App\Models\PageVisit;
use App\Models\PastorImage;
use App\Models\Slide;
use App\Models\ChurchLocation;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        PageVisit::track($request, 'welcome');

        $settings  = HomeSettings::first() ?? new HomeSettings();
        $slides    = Slide::where('active', true)->orderBy('sort_order')->get();
        $locations = ChurchLocation::with('pastor')->orderBy('sort_order')->get();
        $defaultLocation = $locations->firstWhere('is_default', true) ?? $locations->first();
        $galleryImages = PastorImage::with('pastor')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        return view('welcome', compact(
            'settings',
            'slides',
            'locations',
            'defaultLocation',
            'galleryImages'
        ));
    }
}
