<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pastor;
use App\Models\PastorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $query = PastorImage::with('pastor')->orderByDesc('id');
        $this->scopeImages($query);

        return view('content.dashboard.gallery.index', [
            'images' => $query->get(),
        ]);
    }

    public function create()
    {
        return view('content.dashboard.gallery.create', [
            'pastors' => $this->pastorsForForm(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pastor_id' => 'required|exists:pastors,id',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:4096',
        ]);

        $this->authorizePastor((int) $data['pastor_id']);

        $sortOrder = (int) ($data['sort_order'] ?? PastorImage::where('pastor_id', $data['pastor_id'])->max('sort_order'));

        foreach ($request->file('images') as $file) {
            $sortOrder++;
            PastorImage::create([
                'pastor_id' => $data['pastor_id'],
                'path' => $file->store('pastors/gallery', 'public'),
                'caption' => $data['caption'] ?? null,
                'sort_order' => $sortOrder,
            ]);
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image(s) added and assigned to pastor.');
    }

    public function edit(PastorImage $gallery)
    {
        $this->authorizePastor((int) $gallery->pastor_id);

        return view('content.dashboard.gallery.edit', [
            'image' => $gallery,
            'pastors' => $this->pastorsForForm(),
        ]);
    }

    public function update(Request $request, PastorImage $gallery)
    {
        $this->authorizePastor((int) $gallery->pastor_id);

        $data = $request->validate([
            'pastor_id' => 'required|exists:pastors,id',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|max:4096',
        ]);

        $this->authorizePastor((int) $data['pastor_id']);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->path);
            $data['path'] = $request->file('image')->store('pastors/gallery', 'public');
        }

        unset($data['image']);
        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image updated.');
    }

    public function destroy(PastorImage $gallery)
    {
        $this->authorizePastor((int) $gallery->pastor_id);
        Storage::disk('public')->delete($gallery->path);
        $gallery->delete();

        return back()->with('success', 'Gallery image deleted.');
    }

    private function pastorsForForm()
    {
        $user = Auth::user();
        $query = Pastor::orderBy('name');

        if ($user && $user->isBranch()) {
            $query->where('id', $user->assignedPastorId());
        }

        return $query->get();
    }

    private function scopeImages($query): void
    {
        $user = Auth::user();
        if ($user && $user->isBranch()) {
            $query->where('pastor_id', $user->assignedPastorId());
        }
    }

    private function authorizePastor(int $pastorId): void
    {
        $user = Auth::user();
        if ($user && ! $user->canManagePastor($pastorId)) {
            abort(403, 'You can only manage gallery for your assigned pastor.');
        }
    }
}
