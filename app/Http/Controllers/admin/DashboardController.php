<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Leader;
use App\Models\Pastor;
use App\Models\Minister;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events'    => Event::count(),
            'active_events'   => Event::where('is_active', true)->count(),
            'upcoming_events' => Event::where('event_date', '>=', now())->count(),
            'total_pastors'   => Pastor::count(),
            'total_leaders'   => Leader::count(),
            'total_ministers' => Minister::where('group', 'gospel_minister')->count(),
            'total_staff'     => Minister::where('group', 'region1_staff')->count(),
        ];

        // % change helpers (compares this month's new events vs last month's)
        $thisMonthEvents = Event::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthEvents = Event::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $eventsGrowth = $lastMonthEvents > 0
            ? round((($thisMonthEvents - $lastMonthEvents) / $lastMonthEvents) * 100, 1)
            : ($thisMonthEvents > 0 ? 100 : 0);

        // 5 most recently added events
        $recentEvents = Event::orderBy('created_at', 'desc')->take(5)->get();

        // Events grouped by month for the "Total Revenue" style chart
        $eventsPerMonth = Event::selectRaw('MONTH(event_date) as month, COUNT(*) as total')
            ->whereYear('event_date', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyEvents = collect(range(1, 12))
            ->map(fn($m) => (int) ($eventsPerMonth[$m] ?? 0))
            ->values();

        return view('content.dashboard.analytics', compact(
            'stats',
            'eventsGrowth',
            'recentEvents',
            'monthlyEvents'
        ));
    }
}
