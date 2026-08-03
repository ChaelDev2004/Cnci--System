<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChurchLocation;
use App\Models\Pastor;
use Illuminate\Http\Request;

class ChurchLocationController extends Controller
{
    public function index()
    {
        $locations = ChurchLocation::with('pastor')->orderBy('sort_order')->get();
        return view('locations.index', [
            'locations' => $locations
        ]);
    }

    public function create()
    {
        $pastors = Pastor::orderBy('name')->get();
        return view('content.dashboard.admin.locations.create', compact('pastors'));
    }

    public function store(Request $request)
    {
        if ($request->boolean('is_default')) {
            ChurchLocation::query()->update(['is_default' => false]);
        }

        $data = $this->validated($request);

        // Generate visit link based on pastor
        if ($request->filled('pastor_id')) {
            $pastor = Pastor::find($request->pastor_id);
            $data['visit_link'] = route('pastor.show', $pastor->slug ?? $pastor->id);
        }

        ChurchLocation::create($data);
        return redirect()->route('locations.index')->with('success', 'Location added.');
    }

    public function edit(ChurchLocation $location)
    {
        $pastors = Pastor::orderBy('name')->get();
        return view('locations.edit', compact('location', 'pastors'));
    }

    public function update(Request $request, ChurchLocation $location)
    {
        if ($request->boolean('is_default')) {
            ChurchLocation::where('id', '!=', $location->id)->update(['is_default' => false]);
        }

        $data = $this->validated($request);

        // Update visit link
        if ($request->filled('pastor_id')) {
            $pastor = Pastor::find($request->pastor_id);
            $data['visit_link'] = route('pastor.show', $pastor->slug ?? $pastor->id);
        }

        $location->update($data);
        return redirect()->route('locations.index')->with('success', 'Location updated.');
    }

    public function destroy(ChurchLocation $location)
    {
        $location->delete();
        return back()->with('success', 'Location removed.');
    }

    private function validated(Request $request)
    {
        return $request->validate([
            'name'          => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'map_embed_url' => 'required|string',
            'maps_link'     => 'nullable|string|max:500',
            'service_time'  => 'nullable|string|max:255',
            'is_default'    => 'nullable|boolean',
            'sort_order'    => 'nullable|integer',
            'pastor_id'     => 'nullable|exists:pastors,id',
        ]);
    }
}
