<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPageContent;
use App\Models\Leader;
use App\Models\Pastor;
use App\Models\Minister;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function edit()
    {
        $content = AboutPageContent::firstOrCreate([]);

        $leaders = Leader::orderBy('sort_order')->get();

        $pastors = Pastor::orderBy('sort_order')->get();

        $ministers = Minister::orderBy('sort_order')->get();


        return view('content.dashboard.about', compact(
            'content',
            'leaders',
            'pastors',
            'ministers'
        ));
    }


    public function update(Request $request)
    {
        $content = AboutPageContent::firstOrCreate([]);

        $data = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_eyebrow' => 'nullable|string|max:255',
            'hero_subtext' => 'nullable|string',
            'story_paragraph_1' => 'nullable|string',
            'story_paragraph_2' => 'nullable|string',
            'story_image' => 'nullable|image|max:4096',
            'hero_bg_image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('story_image')) {
            $data['story_image'] = $request->file('story_image')
                ->store('about', 'public');
        }

        if ($request->hasFile('hero_bg_image')) {
            $data['hero_bg_image'] = $request->file('hero_bg_image')
                ->store('about', 'public');
        }

        $content->update($data);

        return back()->with('success', 'About page updated.');
    }
}
