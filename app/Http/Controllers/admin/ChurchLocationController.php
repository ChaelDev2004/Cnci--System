<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChurchLocation;
use App\Models\Pastor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChurchLocationController extends Controller
{
    public function index()
    {
        $query = ChurchLocation::with('pastor')->orderBy('sort_order');
        $this->scopeLocations($query);

        return view('content.dashboard.admin.locations.index', [
            'locations' => $query->get(),
        ]);
    }

    public function create()
    {
        $this->denyBranch();

        return view('content.dashboard.admin.locations.create', [
            'pastors' => Pastor::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->denyBranch();

        if ($request->boolean('is_default')) {
            ChurchLocation::query()->update(['is_default' => false]);
        }

        $data = $this->validated($request);
        $data['is_default'] = $request->boolean('is_default');
        $data['visit_link'] = $this->visitLinkFor($request->input('pastor_id'));

        ChurchLocation::create($data);

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Location added.');
    }

    public function edit(ChurchLocation $location)
    {
        $this->authorizeLocation($location);

        return view('content.dashboard.admin.locations.edit', [
            'location' => $location,
            'pastors' => $this->pastorsForForm(),
        ]);
    }

    public function update(Request $request, ChurchLocation $location)
    {
        $this->authorizeLocation($location);

        if ($request->boolean('is_default')) {
            ChurchLocation::where('id', '!=', $location->id)->update(['is_default' => false]);
        }

        $data = $this->validated($request);
        $user = Auth::user();

        if ($user && $user->isBranch()) {
            $data['pastor_id'] = $user->assignedPastorId();
        } else {
            $data['is_default'] = $request->boolean('is_default');
            $data['visit_link'] = $this->visitLinkFor($request->input('pastor_id'));
            if (! $request->filled('pastor_id')) {
                $data['pastor_id'] = null;
            }
        }

        if ($user && $user->isBranch()) {
            $data['visit_link'] = $this->visitLinkFor((string) $user->assignedPastorId());
            unset($data['is_default']);
        }

        $location->update($data);

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Location updated.');
    }

    public function destroy(ChurchLocation $location)
    {
        $this->denyBranch();
        $location->delete();

        return back()->with('success', 'Location removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'map_embed_url' => 'required|string',
            'maps_link' => 'nullable|string|max:500',
            'service_time' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'pastor_id' => 'nullable|exists:pastors,id',
        ]);
    }

    private function visitLinkFor(?string $pastorId): ?string
    {
        if (! $pastorId) {
            return null;
        }

        $pastor = Pastor::find($pastorId);

        return $pastor ? route('pastor.show', $pastor->id) : null;
    }

    private function scopeLocations($query): void
    {
        $user = Auth::user();
        if ($user && $user->isBranch()) {
            $query->where('pastor_id', $user->assignedPastorId());
        }
    }

    private function authorizeLocation(ChurchLocation $location): void
    {
        $user = Auth::user();
        if ($user && $user->isBranch() && (int) $location->pastor_id !== $user->assignedPastorId()) {
            abort(403, 'You can only edit your assigned branch location.');
        }
    }

    private function denyBranch(): void
    {
        $user = Auth::user();
        if ($user && $user->isBranch()) {
            abort(403, 'Branch accounts cannot create or delete locations.');
        }
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
}
