<?php

// app/Http/Controllers/aboutController.php
namespace App\Http\Controllers;

use App\Models\AboutPageContent;
use App\Models\HomeSettings;
use App\Models\Leader;
use App\Models\Pastor;
use App\Models\Minister;

class aboutController extends Controller
{
    public function index()
    {
        $content  = AboutPageContent::first();
        $settings = HomeSettings::first() ?? new HomeSettings();
        $leaders  = Leader::orderBy('sort_order')->get();
        $pastors  = Pastor::orderBy('sort_order')->get();
        $ministers = Minister::where('group', 'gospel_minister')->orderBy('sort_order')->get();
        $staff    = Minister::where('group', 'region1_staff')->orderBy('sort_order')->get();

        return view('aboutUs', compact('content', 'settings', 'leaders', 'pastors', 'ministers', 'staff'));
    }
}
