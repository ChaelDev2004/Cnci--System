<?php

// app/Http/Controllers/Admin/LeaderController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
  public function index()
  {
    return view('content.dashboard.leaders.index', ['leaders' => Leader::orderBy('sort_order')->get()]);
  }

  public function create()
  {
    return view('content.dashboard.leaders.create');
  }

  public function store(Request $request)
  {
    $data = $this->validated($request);
    if ($request->hasFile('image')) {
      $data['image'] = $request->file('image')->store('leaders', 'public');
    }
    Leader::create($data);
    return redirect()->route('admin.content.dashboard.about')->with('success', 'Leader added.');
  }

  public function edit(Leader $leader)
  {
    return view('admin.leaders.edit', compact('leader'));
  }

  public function update(Request $request, Leader $leader)
  {
    $data = $this->validated($request);
    if ($request->hasFile('image')) {
      $data['image'] = $request->file('image')->store('leaders', 'public');
    }
    $leader->update($data);
    return redirect()->route('admin.leaders.index')->with('success', 'Leader updated.');
  }

  public function destroy(Leader $leader)
  {
    $leader->delete();
    return back()->with('success', 'Leader removed.');
  }

  private function validated(Request $request)
  {
    return $request->validate([
      'name' => 'required|string|max:255',
      'title' => 'required|string|max:255',
      'subtitle' => 'nullable|string|max:255',
      'link' => 'nullable|string|max:255',
      'sort_order' => 'nullable|integer',
      'image' => 'nullable|image|max:4096',
    ]);
  }
}
