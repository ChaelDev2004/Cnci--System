<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CalendarController extends Controller
{
    private const CATEGORIES = [
        'Personal' => '#ff3e1d',
        'Business' => '#696cff',
        'Family' => '#ffab00',
        'Holiday' => '#71dd37',
        'ETC' => '#03c3ec',
    ];

    public function index()
    {
        $categories = self::CATEGORIES;

        return view('content.dashboard.admin.calendar.index', compact('categories'));
    }

    public function events(Request $request)
    {
        $query = Event::query()->whereNotNull('event_date');

        if ($request->filled('start')) {
            $query->where('event_date', '>=', $request->date('start')->startOfDay());
        }

        if ($request->filled('end')) {
            $query->where('event_date', '<=', $request->date('end')->endOfDay());
        }

        $events = $query->orderBy('event_date')->get()->map(function (Event $event) {
            $tag = $event->tag ?: 'ETC';
            $color = self::CATEGORIES[$tag] ?? '#8592a3';

            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => optional($event->event_date)->toIso8601String(),
                'allDay' => false,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'calendar' => $tag,
                    'location' => $event->location,
                    'description' => $event->description,
                    'is_active' => $event->is_active,
                ],
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'required|string|max:100',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['title']);
        $original = $slug;
        $count = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        $event = Event::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'tag' => $validated['tag'],
            'description' => $validated['description'] ?: $validated['title'],
            'location' => $validated['location'] ?? null,
            'event_date' => $validated['event_date'],
            'date' => date('F d, Y', strtotime($validated['event_date'])),
            'time' => date('g:i A', strtotime($validated['event_date'])),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => 0,
            'button_text' => 'Learn More',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event created.',
            'event' => $this->toCalendarEvent($event),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'tag' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'event_date' => 'sometimes|required|date',
            'is_active' => 'nullable|boolean',
        ]);

        if (isset($validated['title'])) {
            $event->title = $validated['title'];
        }
        if (isset($validated['tag'])) {
            $event->tag = $validated['tag'];
        }
        if (array_key_exists('description', $validated)) {
            $event->description = $validated['description'] ?: $event->title;
        }
        if (array_key_exists('location', $validated)) {
            $event->location = $validated['location'];
        }
        if (isset($validated['event_date'])) {
            $event->event_date = $validated['event_date'];
            $event->date = date('F d, Y', strtotime($validated['event_date']));
            $event->time = date('g:i A', strtotime($validated['event_date']));
        }
        if ($request->has('is_active')) {
            $event->is_active = $request->boolean('is_active');
        }

        $event->save();

        return response()->json([
            'success' => true,
            'message' => 'Event updated.',
            'event' => $this->toCalendarEvent($event->fresh()),
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted.',
        ]);
    }

    private function toCalendarEvent(Event $event): array
    {
        $tag = $event->tag ?: 'ETC';
        $color = self::CATEGORIES[$tag] ?? '#8592a3';

        return [
            'id' => $event->id,
            'title' => $event->title,
            'start' => optional($event->event_date)->toIso8601String(),
            'backgroundColor' => $color,
            'borderColor' => $color,
            'extendedProps' => [
                'calendar' => $tag,
                'location' => $event->location,
                'description' => $event->description,
                'is_active' => $event->is_active,
            ],
        ];
    }
}
