<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMenuItem;
use App\Support\AdminMenuBuilder;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        AdminMenuBuilder::ensureDefaults();

        $items = AdminMenuItem::with('children')
            ->roots()
            ->orderBy('sort_order')
            ->get();

        return view('content.dashboard.admin.menu.index', compact('items'));
    }

    public function create()
    {
        $parents = AdminMenuItem::roots()->where('type', 'link')->orderBy('sort_order')->get();

        return view('content.dashboard.admin.menu.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        AdminMenuItem::create($data);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item added.');
    }

    public function edit(AdminMenuItem $menu)
    {
        $parents = AdminMenuItem::roots()
            ->where('type', 'link')
            ->where('id', '!=', $menu->id)
            ->orderBy('sort_order')
            ->get();

        return view('content.dashboard.admin.menu.edit', [
            'item' => $menu,
            'parents' => $parents,
        ]);
    }

    public function update(Request $request, AdminMenuItem $menu)
    {
        $data = $this->validated($request);
        $menu->update($data);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item updated.');
    }

    public function destroy(AdminMenuItem $menu)
    {
        $menu->children()->delete();
        $menu->delete();

        return back()->with('success', 'Menu item deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'type' => 'required|in:link,header',
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'target' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:admin_menu_items,id',
            'badge_text' => 'nullable|string|max:50',
            'badge_class' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if (($data['type'] ?? '') === 'header') {
            $data['url'] = null;
            $data['icon'] = null;
            $data['slug'] = null;
            $data['parent_id'] = null;
        }

        return $data;
    }
}
