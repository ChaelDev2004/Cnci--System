<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSettings;
use Illuminate\Http\Request;

class HomeSettingsController extends Controller
{
    public function edit()
    {
        $settings = HomeSettings::firstOrCreate([]);
        return view('content.dashboard.admin.home.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = HomeSettings::firstOrCreate([]);
        $settings->update($request->validate([
            'mission_text'    => 'nullable|string',
            'purpose_text'    => 'nullable|string',
            'about_text'      => 'nullable|string',
            'contact_phone'   => 'nullable|string|max:255',
            'contact_email'   => 'nullable|string|max:255',
            'contact_address' => 'nullable|string|max:255',
            'contact_hours'   => 'nullable|string|max:255',
            'contact_website' => 'nullable|string|max:255',
        ]));
        return back()->with('success', 'Home settings updated.');
    }
}
