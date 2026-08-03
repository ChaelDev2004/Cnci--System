<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Minister;
use Illuminate\Http\Request;

class MinisterController extends Controller
{
  public function index()
  {
    return view('content.dashboard.ministers.index', [
      'ministers' => Minister::where('group', 'gospel_minister')->orderBy('sort_order')->get(),
      'staff' => Minister::where('group', 'region1_staff')->orderBy('sort_order')->get(),
    ]);
  }

  public function create()
  {
    return view('content.dashboard.ministers.create');
  }

  public function store(Request $request)
  {
    $data = $this->validated($request);

    if ($request->hasFile('image')) {
      $data['image'] = $request->file('image')->store('ministers', 'public');
    }

    Minister::create($data);

    return redirect()->route('content.dashboard.ministers.index')->with('success', 'Member added.');
  }

  public function edit(Minister $minister)
  {
    return view('content.dashboard.ministers.edit', compact('minister'));
  }

  public function update(Request $request, Minister $minister)
  {
    $data = $this->validated($request);

    if ($request->hasFile('image')) {
      $data['image'] = $request->file('image')->store('ministers', 'public');
    }

    $minister->update($data);

    return redirect()->route('content.dashboard.ministers.index')->with('success', 'Member updated.');
  }

  public function destroy(Minister $minister)
  {
    $minister->delete();

    return back()->with('success', 'Member removed.');
  }

  private function validated(Request $request)
  {
    return $request->validate([
      'name' => 'required|string|max:255',
      'role' => 'nullable|string|max:255',
      'subrole' => 'nullable|string|max:255',
      'group' => 'required|in:gospel_minister,region1_staff',
      'sort_order' => 'nullable|integer',
      'image' => 'nullable|image|max:4096',
    ]);
  }
}
