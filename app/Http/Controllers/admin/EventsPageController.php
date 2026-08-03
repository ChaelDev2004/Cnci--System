<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class EventsPageController extends Controller
{
    /**
     * Display a listing of events (Admin)
     */
    public function index()
    {
        try {
            $events = Event::orderBy('sort_order')
                ->orderBy('event_date', 'desc')
                ->paginate(10);

            return view('content.dashboard.admin.Events.index', compact('events'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch events: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load events: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        return view('content.dashboard.admin.Events.create');
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'tag' => 'nullable|string|max:100',
                'description' => 'required|string',
                'image_url' => 'nullable|url|max:500',
                'image_file' => 'nullable|image|max:5120',
                'date' => 'nullable|string|max:255',
                'time' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'button_text' => 'nullable|string|max:100',
                'button_url' => 'nullable|url|max:500',
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer|min:0',
                'event_date' => 'nullable|date',
            ]);

            // Handle image upload
            if ($request->hasFile('image_file')) {
                try {
                    $path = $request->file('image_file')->store('events', 'public');
                    $validated['image_url'] = asset('storage/' . $path);
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                    return redirect()->back()
                        ->with('error', 'Image upload failed: ' . $e->getMessage())
                        ->withInput();
                }
            }

            // Set defaults
            $validated['slug'] = Str::slug($validated['title']);
            $validated['is_active'] = $request->has('is_active') ? true : false;

            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Event::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }

            // Create the event
            $event = Event::create($validated);

            Log::info('Event created successfully', ['id' => $event->id, 'title' => $event->title]);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event "' . $event->title . '" created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors - redirect back with errors
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Event creation failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to create event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified event
     */
    public function edit(Event $event)
    {
        try {
            return view('content.dashboard.admin.Events.edit', compact('event'));
        } catch (\Exception $e) {
            Log::error('Failed to load edit form: ' . $e->getMessage());
            return redirect()->route('admin.events.index')
                ->with('error', 'Failed to load event: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified event
     */
    public function update(Request $request, Event $event)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'tag' => 'nullable|string|max:100',
                'description' => 'required|string',
                'image_url' => 'nullable|url|max:500',
                'image_file' => 'nullable|image|max:5120',
                'date' => 'nullable|string|max:255',
                'time' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'button_text' => 'nullable|string|max:100',
                'button_url' => 'nullable|url|max:500',
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer|min:0',
                'event_date' => 'nullable|date',
            ]);

            // Handle image upload
            if ($request->hasFile('image_file')) {
                try {
                    $path = $request->file('image_file')->store('events', 'public');
                    $validated['image_url'] = asset('storage/' . $path);
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                    return redirect()->back()
                        ->with('error', 'Image upload failed: ' . $e->getMessage())
                        ->withInput();
                }
            }

            // Handle checkbox - properly set is_active
            $validated['is_active'] = $request->has('is_active') ? true : false;

            // Update the event
            $event->update($validated);

            Log::info('Event updated successfully', ['id' => $event->id, 'title' => $event->title]);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event "' . $event->title . '" updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Event update failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified event
     */
    public function destroy(Event $event)
    {
        try {
            $eventTitle = $event->title;
            $event->delete();

            Log::info('Event deleted successfully', ['id' => $event->id, 'title' => $eventTitle]);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event "' . $eventTitle . '" deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Event deletion failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete event: ' . $e->getMessage());
        }
    }

    /**
     * Toggle event active status
     */
    public function toggleActive(Event $event)
    {
        try {
            $event->update(['is_active' => !$event->is_active]);
            $status = $event->is_active ? 'activated' : 'deactivated';

            Log::info('Event toggled successfully', ['id' => $event->id, 'title' => $event->title, 'status' => $status]);

            return redirect()->back()
                ->with('success', 'Event "' . $event->title . '" ' . $status . ' successfully!');
        } catch (\Exception $e) {
            Log::error('Event toggle failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to toggle event status: ' . $e->getMessage());
        }
    }

    /**
     * Display public events page
     */
    public function publicIndex()
    {
        try {
            $events = Event::active()
                ->orderBy('sort_order')
                ->orderBy('event_date', 'asc')
                ->get();

            return view('pages.events', compact('events'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch public events: ' . $e->getMessage());
            return view('pages.events', ['events' => collect([])])
                ->with('error', 'Failed to load events. Please try again later.');
        }
    }

    /**
     * Reorder events (for drag-and-drop sorting)
     */
    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'order' => 'required|array',
                'order.*' => 'required|integer|exists:events,id',
            ]);

            foreach ($request->order as $index => $id) {
                Event::where('id', $id)->update(['sort_order' => $index]);
            }

            Log::info('Events reordered successfully');

            return response()->json([
                'success' => true,
                'message' => 'Events reordered successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Event reorder failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to reorder events: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete events
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'required|integer|exists:events,id',
            ]);

            $count = Event::whereIn('id', $request->ids)->delete();

            Log::info('Bulk delete completed', ['count' => $count]);

            return redirect()->route('admin.events.index')
                ->with('success', $count . ' events deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Bulk delete failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete events: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate an event
     */
    public function duplicate(Event $event)
    {
        try {
            $newEvent = $event->replicate();
            $newEvent->title = $event->title . ' (Copy)';
            $newEvent->slug = Str::slug($newEvent->title);

            // Ensure unique slug
            $originalSlug = $newEvent->slug;
            $count = 1;
            while (Event::where('slug', $newEvent->slug)->exists()) {
                $newEvent->slug = $originalSlug . '-' . $count++;
            }

            $newEvent->save();

            Log::info('Event duplicated successfully', [
                'original_id' => $event->id,
                'new_id' => $newEvent->id,
                'title' => $newEvent->title
            ]);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event duplicated successfully!');
        } catch (\Exception $e) {
            Log::error('Event duplication failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to duplicate event: ' . $e->getMessage());
        }
    }

    /**
     * Search events
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('query');

            if (empty($query)) {
                return redirect()->route('admin.events.index');
            }

            $events = Event::where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('tag', 'LIKE', "%{$query}%")
                ->orderBy('sort_order')
                ->paginate(10);

            return view('content.dashboard.admin.Events.index', compact('events'));
        } catch (\Exception $e) {
            Log::error('Event search failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.events.index')
                ->with('error', 'Failed to search events: ' . $e->getMessage());
        }
    }

    /**
     * Get upcoming events (for API or AJAX)
     */
    public function upcoming()
    {
        try {
            $events = Event::active()
                ->where('event_date', '>=', now())
                ->orderBy('event_date', 'asc')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $events
            ]);
        } catch (\Exception $e) {
            Log::error('Upcoming events fetch failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch upcoming events: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get event statistics (for dashboard)
     */
    public function stats()
    {
        try {
            $stats = [
                'total' => Event::count(),
                'active' => Event::where('is_active', true)->count(),
                'inactive' => Event::where('is_active', false)->count(),
                'upcoming' => Event::where('event_date', '>=', now())->count(),
                'past' => Event::where('event_date', '<', now())->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Event stats failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export events to CSV
     */
    public function export()
    {
        try {
            $events = Event::orderBy('created_at', 'desc')->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="events_' . date('Y-m-d') . '.csv"',
            ];

            $callback = function () use ($events) {
                $file = fopen('php://output', 'w');

                // Add headers
                fputcsv($file, ['ID', 'Title', 'Tag', 'Date', 'Time', 'Location', 'Status', 'Created At']);

                // Add rows
                foreach ($events as $event) {
                    fputcsv($file, [
                        $event->id,
                        $event->title,
                        $event->tag ?? 'N/A',
                        $event->date ?? 'N/A',
                        $event->time ?? 'N/A',
                        $event->location ?? 'N/A',
                        $event->is_active ? 'Active' : 'Inactive',
                        $event->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            Log::info('Events exported successfully', ['count' => $events->count()]);

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Event export failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to export events: ' . $e->getMessage());
        }
    }

    /**
     * Restore a soft-deleted event (if using soft deletes)
     */
    public function restore($id)
    {
        try {
            $event = Event::withTrashed()->findOrFail($id);
            $event->restore();

            Log::info('Event restored successfully', ['id' => $event->id, 'title' => $event->title]);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event "' . $event->title . '" restored successfully!');
        } catch (\Exception $e) {
            Log::error('Event restore failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to restore event: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete an event (if using soft deletes)
     */
    public function forceDelete($id)
    {
        try {
            $event = Event::withTrashed()->findOrFail($id);
            $eventTitle = $event->title;
            $event->forceDelete();

            Log::info('Event permanently deleted', ['id' => $id, 'title' => $eventTitle]);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event "' . $eventTitle . '" permanently deleted!');
        } catch (\Exception $e) {
            Log::error('Event force delete failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to permanently delete event: ' . $e->getMessage());
        }
    }
}
