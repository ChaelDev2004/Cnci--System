<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pastor;
use App\Models\PastorImage;
use App\Models\HomeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PastorController extends Controller
{
    public function index()
    {
        $query = Pastor::orderBy('sort_order');
        $user = Auth::user();
        if ($user && $user->isBranch()) {
            $query->where('id', $user->assignedPastorId());
        }

        return view('content.dashboard.pastors.index', [
            'pastors' => $query->get(),
        ]);
    }

    public function create()
    {
        $this->denyBranch();

        return view('content.dashboard.pastors.create');
    }

    public function store(Request $request)
    {
        $this->denyBranch();
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pastors', 'public');
        }

        $pastor = Pastor::create($data);
        $this->storeGalleryImages($request, $pastor);

        return redirect()
            ->route('admin.pastors.index')
            ->with('success', 'Pastor added.');
    }

    public function edit(Pastor $pastor)
    {
        $this->authorizePastor($pastor);
        $pastor->load('galleryImages');

        return view('content.dashboard.pastors.edit', compact('pastor'));
    }

    public function update(Request $request, Pastor $pastor)
    {
        $this->authorizePastor($pastor);
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($pastor->image) {
                Storage::disk('public')->delete($pastor->image);
            }
            $data['image'] = $request->file('image')->store('pastors', 'public');
        }

        $pastor->update($data);
        $this->deleteSelectedGalleryImages($request);
        $this->storeGalleryImages($request, $pastor);

        return redirect()
            ->route('admin.pastors.index')
            ->with('success', 'Pastor updated.');
    }

    public function destroy(Pastor $pastor)
    {
        $this->denyBranch();
        $this->authorizePastor($pastor);

        foreach ($pastor->galleryImages as $image) {
            Storage::disk('public')->delete($image->path);
        }

        if ($pastor->image) {
            Storage::disk('public')->delete($pastor->image);
        }

        $pastor->delete();

        return redirect()
            ->route('admin.pastors.index')
            ->with('success', 'Pastor deleted.');
    }

    private function denyBranch(): void
    {
        $user = Auth::user();
        if ($user && $user->isBranch()) {
            abort(403, 'Branch accounts cannot create or delete pastors.');
        }
    }

    private function authorizePastor(Pastor $pastor): void
    {
        $user = Auth::user();
        if ($user && ! $user->canManagePastor((int) $pastor->id)) {
            abort(403, 'You can only edit your assigned pastor.');
        }
    }

    public function show($id)
    {
        $pastor = Pastor::with(['locations', 'galleryImages'])->findOrFail($id);
        $settings = HomeSettings::first() ?? new HomeSettings();

        return view('pastor.show', compact('pastor', 'settings'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
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
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:4096',
            'delete_gallery' => 'nullable|array',
            'delete_gallery.*' => 'integer|exists:pastor_images,id',
        ]);

        unset($data['gallery_images'], $data['delete_gallery'], $data['image']);

        return $data;
    }

    private function storeGalleryImages(Request $request, Pastor $pastor): void
    {
        if (!$request->hasFile('gallery_images')) {
            return;
        }

        $sortOrder = (int) $pastor->galleryImages()->max('sort_order');

        foreach ($request->file('gallery_images') as $file) {
            $sortOrder++;
            PastorImage::create([
                'pastor_id' => $pastor->id,
                'path' => $file->store('pastors/gallery', 'public'),
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function deleteSelectedGalleryImages(Request $request): void
    {
        $ids = $request->input('delete_gallery', []);

        if (empty($ids)) {
            return;
        }

        $images = PastorImage::whereIn('id', $ids)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }
}
