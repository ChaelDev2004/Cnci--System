<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventsPageController extends Controller
{
    public function index()
    {
        // Dummy data for testing
        $events = [
            (object) [
                'title' => 'Sunday Worship',
                'tag' => 'Weekly',
                'description' => 'Join us for a powerful time of worship, prayer, and the Word.',
                'image_url' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'date' => 'Every Sunday',
                'time' => '9:00 AM & 11:00 AM',
                'location' => 'CNCI Church',
                'button_text' => 'Learn More',
                'button_url' => '#',
            ],
            // Add more dummy events...
        ];

        return view('content.dashboard.events', compact('events'));
    }
}
