<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    public function index()
    {
        return view('content.dashboard.admin.home.slides.index', ['slides' => Slide::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('content.dashboard.admin.home.slides.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('bg_image')) {
            $data['bg_image'] = $request->file('bg_image')->store('slides', 'public');
        }
        Slide::create($data);
        return redirect()->route('slides.index')->with('success', 'Slide added.');
    }

    public function edit(Slide $slide)
    {
        return view('content.dashboard.admin.home.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $data = $this->validated($request);
        if ($request->hasFile('bg_image')) {
            $data['bg_image'] = $request->file('bg_image')->store('slides', 'public');
        }
        $slide->update($data);
        return redirect()->route('slides.index')->with('success', 'Slide updated.');
    }

    public function destroy(Slide $slide)
    {
        $slide->delete();
        return back()->with('success', 'Slide deleted.');
    }

    private function validated(Request $request)
    {
        return $request->validate([
            'bg_type'           => 'required|in:image,video,color',
            'bg_image'          => 'nullable|image|max:6144',
            'bg_video_url'      => 'nullable|string|max:500',
            'eyebrow'           => 'nullable|string|max:255',
            'heading'           => 'nullable|string|max:500',
            'subtext'           => 'nullable|string',
            'cta_primary_label' => 'nullable|string|max:255',
            'cta_primary_link'  => 'nullable|string|max:255',
            'testimonial'       => 'nullable|string',
            'service_badge'     => 'nullable|string|max:255',
            'layout'            => 'required|in:default,welcome,plain',
            'active'            => 'nullable|boolean',
            'sort_order'        => 'nullable|integer',
        ]);
    }
}
