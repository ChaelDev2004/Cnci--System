<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pastor;
use Illuminate\Http\Request;
use App\Models\ChurchLocation;

class PastorController extends Controller
{
  public function index()
  {
    return view('content.dashboard.pastors.index', [
      'pastors' => Pastor::orderBy('sort_order')->get(),
    ]);
  }

  public function create()
  {
    return view('content.dashboard.pastors.create');
  }

  public function store(Request $request)
  {
    if ($request->boolean('is_default')) {
      ChurchLocation::query()->update(['is_default' => false]);
    }

    $data = $this->validated($request);

    // Generate visit link if pastor is selected
    if ($request->filled('pastor_id')) {
      $pastor = Pastor::find($request->pastor_id);
      if ($pastor && $pastor->slug) {
        $data['visit_link'] = route('pastor.show', $pastor->slug);
      }
    }

    ChurchLocation::create($data);
    return redirect()->route('locations.index')->with('success', 'Location added.');
  }

  public function edit(Pastor $pastor)
  {
    return view('content.dashboard.pastors.edit', compact('pastor'));
  }

  public function update(Request $request, ChurchLocation $location)
  {
    if ($request->boolean('is_default')) {
      ChurchLocation::where('id', '!=', $location->id)->update(['is_default' => false]);
    }

    $data = $this->validated($request);

    // Update visit link if pastor is selected
    if ($request->filled('pastor_id')) {
      $pastor = Pastor::find($request->pastor_id);
      if ($pastor && $pastor->slug) {
        $data['visit_link'] = route('pastor.show', $pastor->slug);
      }
    } else {
      $data['visit_link'] = null;
    }

    $location->update($data);
    return redirect()->route('locations.index')->with('success', 'Location updated.');
  }

  public function destroy(Pastor $pastor)
  {
    $pastor->delete();

    return back()->with('success', 'Pastor removed.');
  }

  private function validated(Request $request)
  {
    return $request->validate([
      'name' => 'required|string|max:255',
      'role' => 'nullable|string|max:255',
      'church' => 'required|string|max:255',
      'sort_order' => 'nullable|integer',
      'image' => 'nullable|image|max:4096',
      'bio' => 'nullable|string',
      'email' => 'nullable|email|max:255',
      'phone' => 'nullable|string|max:255',
      'facebook' => 'nullable|string|max:255',
      'instagram' => 'nullable|string|max:255',
      'youtube' => 'nullable|string|max:255',
    ]);
  }
  // Add this method for public viewing
  public function show($id)
  {
    $pastor = Pastor::findOrFail($id);
    return view('pastor.show', compact('pastor'));
  }

  // Update the validated method to include new fields

}
