<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AccountSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = HomeSettings::firstOrCreate([]);

        return view('content.pages.pages-account-settings-account', compact('user', 'settings'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|max:2048',
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateBranding(Request $request)
    {
        if (Auth::user()?->isBranch()) {
            abort(403, 'Branch accounts cannot change site branding.');
        }

        $settings = HomeSettings::firstOrCreate([]);

        $validated = $request->validate([
            'brand_name' => 'nullable|string|max:255',
            'brand_tagline' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:4096',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg,gif,svg,webp|max:1024',
        ]);

        $settings->brand_name = $validated['brand_name'] ?? null;
        $settings->brand_tagline = $validated['brand_tagline'] ?? null;

        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $settings->logo_path = $request->file('logo')->store('branding', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path) {
                Storage::disk('public')->delete($settings->favicon_path);
            }
            $settings->favicon_path = $request->file('favicon')->store('branding', 'public');
        }

        $settings->save();

        return back()->with('success', 'Branding settings updated successfully.');
    }
}
