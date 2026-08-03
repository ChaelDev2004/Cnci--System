@php
$stats = [
'total_events' => \App\Models\Event::count(),
'active_events' => \App\Models\Event::where('is_active', true)->count(),
'upcoming_events' => \App\Models\Event::where('event_date', '>=', now())->count(),
'total_pastors' => \App\Models\Pastor::count(),
'total_leaders' => \App\Models\Leader::count(),
'total_ministers' => \App\Models\Minister::where('group', 'gospel_minister')->count(),
'total_staff' => \App\Models\Minister::where('group', 'region1_staff')->count(),
'total_locations' => \App\Models\ChurchLocation::count(),
];

$thisMonthEvents = \App\Models\Event::whereMonth('created_at', now()->month)
->whereYear('created_at', now()->year)
->count();

$lastMonthEvents = \App\Models\Event::whereMonth('created_at', now()->subMonth()->month)
->whereYear('created_at', now()->subMonth()->year)
->count();

$eventsGrowth = $lastMonthEvents > 0
? round((($thisMonthEvents - $lastMonthEvents) / $lastMonthEvents) * 100, 1)
: ($thisMonthEvents > 0 ? 100 : 0);

$recentEvents = \App\Models\Event::orderBy('created_at', 'desc')->take(5)->get();

$recentLocations = \App\Models\ChurchLocation::with('pastor')
->orderBy('sort_order')
->take(5)
->get();

$eventsPerMonth = \App\Models\Event::selectRaw('MONTH(event_date) as month, COUNT(*) as total')
->whereYear('event_date', now()->year)
->groupBy('month')
->pluck('total', 'month');

$monthlyEvents = collect(range(1, 12))
->map(fn ($m) => (int) ($eventsPerMonth[$m] ?? 0))
->values();

// Data for the new "Team Distribution" donut chart
$teamDistribution = [
'labels' => ['Pastors', 'Leaders', 'Gospel Ministers', 'Region 1 Staff'],
'series' => [
$stats['total_pastors'],
$stats['total_leaders'],
$stats['total_ministers'],
$stats['total_staff'],
],
];

// Welcome page visit analytics
$visitStats = [
    'total' => 0,
    'today' => 0,
    'week' => 0,
    'unread' => 0,
];
$dailyVisits = collect(range(6, 0))->map(fn () => 0)->values();
$dailyVisitLabels = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->format('D'))->values();
$recentVisits = collect();

try {
    if (\App\Models\PageVisit::tableReady()) {
        $visitStats['total'] = \App\Models\PageVisit::where('page', 'welcome')->count();
        $visitStats['today'] = \App\Models\PageVisit::where('page', 'welcome')->whereDate('created_at', today())->count();
        $visitStats['week'] = \App\Models\PageVisit::where('page', 'welcome')->where('created_at', '>=', now()->subDays(7))->count();
        $visitStats['unread'] = \App\Models\PageVisit::where('is_read', false)->count();

        $visitsByDay = \App\Models\PageVisit::where('page', 'welcome')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $dailyVisits = collect(range(6, 0))->map(function ($i) use ($visitsByDay) {
            $day = now()->subDays($i)->toDateString();
            return (int) ($visitsByDay[$day] ?? 0);
        })->values();

        $dailyVisitLabels = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->format('D'))->values();
        $recentVisits = \App\Models\PageVisit::where('page', 'welcome')->orderByDesc('created_at')->take(6)->get();

        // Opening dashboard marks visit notifications as read
        \App\Models\PageVisit::where('is_read', false)->update(['is_read' => true]);
    }
} catch (\Throwable $e) {
    // table may not exist yet
}

$contactStats = [
    'total' => 0,
    'unread' => 0,
];
$recentContactMessages = collect();
try {
    if (\App\Models\ContactMessage::tableReady()) {
        $contactStats['total'] = \App\Models\ContactMessage::count();
        $contactStats['unread'] = \App\Models\ContactMessage::where('is_read', false)->count();
        $recentContactMessages = \App\Models\ContactMessage::orderByDesc('created_at')->take(5)->get();
    }
} catch (\Throwable $e) {
    // table may not exist yet
}
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<style>
  .view-page-card {
    display: block;
    text-decoration: none;
    color: inherit;
    border: 1px solid rgba(67, 89, 113, 0.12);
    border-radius: 14px;
    padding: 1.15rem 1rem;
    height: 100%;
    background: linear-gradient(180deg, #fff 0%, #f8f9fc 100%);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .view-page-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(67, 89, 113, 0.12);
    border-color: rgba(105, 108, 255, 0.35);
    color: inherit;
  }
  .view-page-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    margin-bottom: 0.85rem;
    font-size: 1.25rem;
  }
  .view-page-card h6 {
    margin: 0 0 0.25rem;
    font-weight: 700;
  }
  .view-page-card p {
    margin: 0;
    color: #697a8d;
    font-size: 0.85rem;
  }
  .view-page-card .open-label {
    margin-top: 0.85rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #696cff;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .welcome-hero-card {
    border: 0;
    overflow: hidden;
    background: linear-gradient(135deg, #696cff 0%, #8592ff 45%, #03c3ec 120%);
    color: #fff;
  }
  .welcome-hero-card .card-title,
  .welcome-hero-card p {
    color: #fff;
  }
  .welcome-hero-card p {
    opacity: 0.9;
  }
  .welcome-hero-card .btn-light {
    font-weight: 600;
  }
  .welcome-hero-card .btn-outline-light {
    font-weight: 600;
  }
</style>

<div class="row">
    <div class="col-xxl-8 mb-6 order-0">
        <div class="card welcome-hero-card">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-white text-primary">Admin Dashboard</span>
                        </div>
                        <h5 class="card-title mb-3">
                            <span id="greeting"></span>, {{ Auth::user()->name }}
                        </h5>
                        <p class="mb-6">
                            You have {{ $stats['total_events'] }} events on record,
                            {{ $stats['active_events'] }} currently active.
                        </p>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-light">Manage Events</a>
                        <a href="{{ url('/') }}" class="btn btn-sm btn-outline-light ms-1" target="_blank" rel="noopener">View Website</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('assets/img/backgrounds/pastorImg.png') }}" height="175" alt="Dashboard" style="filter: drop-shadow(0 12px 24px rgba(0,0,0,.2));" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="events" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Total Events</p>
                        <h4 class="card-title mb-3">{{ $stats['total_events'] }}</h4>
                        <small class="{{ $eventsGrowth >= 0 ? 'text-success' : 'text-danger' }} fw-medium">
                            <i class="icon-base bx {{ $eventsGrowth >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt' }}"></i>
                            {{ $eventsGrowth }}% vs last month
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="active events" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Active Events</p>
                        <h4 class="card-title mb-3">{{ $stats['active_events'] }}</h4>
                        <small class="text-success fw-medium">
                            <i class="icon-base bx bx-up-arrow-alt"></i> {{ $stats['upcoming_events'] }} upcoming
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome page visits -->
    <div class="col-12 order-1 mb-6">
        <div class="row g-4">
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 border-0 shadow-none" style="background:linear-gradient(135deg,#fff5f5 0%,#fff 70%);border:1px solid rgba(255,62,29,.12)!important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-envelope"></i></span>
                            </div>
                            @if($contactStats['unread'] > 0)
                                <span class="badge bg-danger">{{ $contactStats['unread'] }} new</span>
                            @endif
                        </div>
                        <p class="mb-1">Contact Messages</p>
                        <h4 class="mb-1">{{ $contactStats['total'] }}</h4>
                        <small class="text-muted d-block mb-3">Form submissions from the website</small>
                        <a href="{{ route('admin.contact.index') }}" class="btn btn-sm btn-danger">
                            {{ $contactStats['unread'] > 0 ? 'View new messages' : 'Open inbox' }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Latest Contacts</h6>
                        <a href="{{ route('admin.contact.index') }}" class="small">All</a>
                    </div>
                    <div class="card-body pt-3">
                        <ul class="list-unstyled mb-0">
                            @forelse($recentContactMessages as $msg)
                                <li class="mb-2">
                                    <a href="{{ route('admin.contact.show', $msg) }}" class="d-flex justify-content-between align-items-start text-body text-decoration-none">
                                        <span class="text-truncate pe-2" style="max-width:70%;">
                                            @unless($msg->is_read)
                                                <span class="badge bg-label-danger me-1">New</span>
                                            @endunless
                                            {{ $msg->name }}
                                        </span>
                                        <small class="text-muted flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</small>
                                    </a>
                                </li>
                            @empty
                                <li class="text-muted">No contact messages yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-show"></i></span>
                            </div>
                            @if($visitStats['unread'] > 0)
                                <span class="badge bg-label-danger">{{ $visitStats['unread'] }} new</span>
                            @endif
                        </div>
                        <p class="mb-1">Welcome Views</p>
                        <h4 class="mb-0">{{ $visitStats['total'] }}</h4>
                        <small class="text-muted">All-time visitors</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="avatar mb-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-calendar"></i></span>
                        </div>
                        <p class="mb-1">Today</p>
                        <h4 class="mb-0">{{ $visitStats['today'] }}</h4>
                        <small class="text-muted">Welcome page visits</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="avatar mb-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-bar-chart-alt-2"></i></span>
                        </div>
                        <p class="mb-1">Last 7 Days</p>
                        <h4 class="mb-0">{{ $visitStats['week'] }}</h4>
                        <small class="text-muted">Weekly visitors</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Recent Visitors</h6>
                    </div>
                    <div class="card-body pt-3">
                        <ul class="list-unstyled mb-0">
                            @forelse($recentVisits as $visit)
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-truncate" style="max-width:60%;">{{ $visit->ip_address ?: 'Unknown IP' }}</span>
                                    <small class="text-muted">{{ $visit->created_at->diffForHumans() }}</small>
                                </li>
                            @empty
                                <li class="text-muted">No visits yet. Open the home page in a private window to test.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">Welcome Page Visits</h5>
                            <p class="card-subtitle mb-0">Visitor activity over the last 7 days</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="welcomeVisitsChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Per Month -->
    <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6 total-revenue">
        <div class="card">
            <div class="row row-bordered g-0">
                <div class="col-lg-8">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Events This Year</h5>
                        </div>
                    </div>
                    <div id="totalRevenueChart" class="px-3"
                        data-chart="{{ $monthlyEvents->toJson() }}"></div>
                </div>
                <div class="col-lg-4">
                    <div class="card-body px-xl-9 py-12 d-flex align-items-center flex-column">
                        <div class="text-center fw-medium my-6">
                            {{ $stats['total_events'] }} events total this year
                        </div>
                        <div class="d-flex gap-11 justify-content-between">
                            <div class="d-flex">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-2 bg-label-primary"><i class="icon-base bx bx-calendar-check icon-lg text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Active</small>
                                    <h6 class="mb-0">{{ $stats['active_events'] }}</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded-2 bg-label-info"><i class="icon-base bx bx-calendar-event icon-lg text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Upcoming</small>
                                    <h6 class="mb-0">{{ $stats['upcoming_events'] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Overview -->
    <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2 profile-report">
        <div class="row">
            <div class="col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/paypal.png') }}" alt="pastors" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Pastors</p>
                        <h4 class="card-title mb-3">{{ $stats['total_pastors'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="leaders" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Leaders</p>
                        <h4 class="card-title mb-3">{{ $stats['total_leaders'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-sm-row flex-column gap-10 flex-wrap">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title mb-6">
                                    <h5 class="text-nowrap mb-1">Ministry Team</h5>
                                    <span class="badge bg-label-warning">{{ now()->year }}</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <span class="text-success text-nowrap fw-medium">
                                        <i class="icon-base bx bx-group"></i> Gospel Ministers
                                    </span>
                                    <h4 class="mb-0">{{ $stats['total_ministers'] }}</h4>
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="d-block text-body-secondary">Region 1 Staff</small>
                                <h5 class="mb-0">{{ $stats['total_staff'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Team Breakdown -->
    <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1 me-2">Team Breakdown</h5>
                    <p class="card-subtitle">
                        {{ $stats['total_pastors'] + $stats['total_leaders'] + $stats['total_ministers'] + $stats['total_staff'] }} total people
                    </p>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <li class="d-flex align-items-center mb-5">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-crown"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Pastors</h6>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">{{ $stats['total_pastors'] }}</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-5">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="icon-base bx bx-star"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Leaders</h6>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">{{ $stats['total_leaders'] }}</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-5">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-info"><i class="icon-base bx bx-book-bookmark"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Gospel Ministers</h6>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">{{ $stats['total_ministers'] }}</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-5">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="icon-base bx bx-briefcase"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Region 1 Staff</h6>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">{{ $stats['total_staff'] }}</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-dark"><i class="icon-base bx bx-map-pin"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Church Locations</h6>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">{{ $stats['total_locations'] }}</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- View Pages -->
    <div class="col-12 order-1 mb-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-1">View Pages</h5>
                    <p class="card-subtitle mb-0">Preview public pages while signed in as admin</p>
                </div>
                <a href="{{ url('/') }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                    <i class="bx bx-link-external me-1"></i> Open Home
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ url('/') }}" target="_blank" rel="noopener" class="view-page-card">
                            <div class="view-page-icon bg-label-primary text-primary"><i class="bx bx-home"></i></div>
                            <h6>Home / Welcome</h6>
                            <p>Landing page, hero slides, and contact form</p>
                            <span class="open-label">Open page <i class="bx bx-right-arrow-alt"></i></span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('about') }}" target="_blank" rel="noopener" class="view-page-card">
                            <div class="view-page-icon bg-label-info text-info"><i class="bx bx-book-open"></i></div>
                            <h6>About</h6>
                            <p>Story, pastors, leaders, and ministry teams</p>
                            <span class="open-label">Open page <i class="bx bx-right-arrow-alt"></i></span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('content.dashboard.events') }}" target="_blank" rel="noopener" class="view-page-card">
                            <div class="view-page-icon bg-label-warning text-warning"><i class="bx bx-calendar-event"></i></div>
                            <h6>Events</h6>
                            <p>Public event listings and schedules</p>
                            <span class="open-label">Open page <i class="bx bx-right-arrow-alt"></i></span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-4 col-xxl-2">
                        <a href="{{ route('gallery') }}" target="_blank" rel="noopener" class="view-page-card">
                            <div class="view-page-icon bg-label-secondary text-secondary"><i class="bx bx-images"></i></div>
                            <h6>Gallery</h6>
                            <p>Church and pastor photo gallery</p>
                            <span class="open-label">Open page <i class="bx bx-right-arrow-alt"></i></span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('findus') }}" target="_blank" rel="noopener" class="view-page-card">
                            <div class="view-page-icon bg-label-success text-success"><i class="bx bx-map-alt"></i></div>
                            <h6>Find Us</h6>
                            <p>Locations, maps, and meet our pastor</p>
                            <span class="open-label">Open page <i class="bx bx-right-arrow-alt"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="col-md-6 col-lg-4 order-2 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Recent Events</h5>
                <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-icon">
                    <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                </a>
            </div>
            <div class="card-body pt-4">
                <ul class="p-0 m-0">
                    @forelse ($recentEvents as $event)
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            @if ($event->image_url)
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="rounded" />
                            @else
                            <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-calendar"></i></span>
                            @endif
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">{{ $event->tag ?? 'Event' }}</small>
                                <h6 class="fw-normal mb-0">{{ $event->title }}</h6>
                            </div>
                            <span class="badge {{ $event->is_active ? 'bg-label-success' : 'bg-label-secondary' }}">
                                {{ $event->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="text-body-secondary">No events yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Church Locations -->
    <div class="col-md-6 col-lg-4 order-3 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Church Locations</h5>
                @if (\Illuminate\Support\Facades\Route::has('admin.locations.index'))
                <a href="{{ route('admin.locations.index') }}" class="btn btn-sm btn-icon">
                    <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                </a>
                @endif
            </div>
            <div class="card-body pt-4">
                <ul class="p-0 m-0">
                    @forelse ($recentLocations as $location)
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded {{ $location->is_default ? 'bg-label-success' : 'bg-label-secondary' }}">
                                <i class="icon-base bx bx-church"></i>
                            </span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <small class="d-block">{{ $location->city }}</small>
                                <h6 class="fw-normal mb-0">{{ $location->name }}</h6>
                            </div>
                            <div class="text-end">
                                @if ($location->is_default)
                                <span class="badge bg-label-success mb-1">Default</span>
                                @endif
                                <small class="d-block text-body-secondary">
                                    {{ $location->pastor->name ?? 'Unassigned' }}
                                </small>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="text-body-secondary">No locations added yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Additional Charts -->
<div class="row">
    <!-- Events Trend (Line Chart) -->
    <div class="col-12 col-lg-7 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Events Trend</h5>
                    <p class="card-subtitle mb-0">Monthly events created in {{ now()->year }}</p>
                </div>
            </div>
            <div class="card-body">
                <div id="eventsLineChart"></div>
            </div>
        </div>
    </div>

    <!-- Team Distribution (Donut Chart) -->
    <div class="col-12 col-lg-5 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Team Distribution</h5>
                    <p class="card-subtitle mb-0">Across all ministry roles</p>
                </div>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div id="teamDonutChart"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(e) {
        const hour = new Date().getHours();
        let greeting = '';
        if (hour < 12) {
            greeting = 'Good Morning';
        } else if (hour < 18) {
            greeting = 'Good Afternoon';
        } else {
            greeting = 'Good Evening';
        }
        document.getElementById('greeting').textContent = greeting;

        // --- Shared style helpers pulled from CSS custom properties, ---
        // --- so the charts stay in sync with the template's theme.  ---
        const styles = getComputedStyle(document.body);
        const primaryColor = styles.getPropertyValue('--bs-primary').trim() || '#696cff';
        const successColor = styles.getPropertyValue('--bs-success').trim() || '#71dd37';
        const infoColor = styles.getPropertyValue('--bs-info').trim() || '#03c3ec';
        const warningColor = styles.getPropertyValue('--bs-warning').trim() || '#ffab00';
        const borderColor = styles.getPropertyValue('--bs-border-color').trim() || '#e7e7ff';
        const bodyColor = styles.getPropertyValue('--bs-body-color').trim() || '#697a8d';
        const fontFamily = styles.getPropertyValue('--bs-font-sans-serif').trim() || 'Public Sans';

        // ---- Events Trend Line Chart ----
        const eventsLineEl = document.querySelector('#eventsLineChart');
        if (eventsLineEl && typeof ApexCharts !== 'undefined') {
            const monthlyEvents = @json($monthlyEvents);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const lineChart = new ApexCharts(eventsLineEl, {
                chart: {
                    type: 'line',
                    height: 330,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false
                    },
                    fontFamily: fontFamily
                },
                series: [{
                    name: 'Events',
                    data: monthlyEvents
                }],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    size: 5,
                    colors: ['#fff'],
                    strokeColors: primaryColor,
                    strokeWidth: 3,
                    hover: {
                        size: 7
                    }
                },
                colors: [primaryColor],
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 6,
                    padding: {
                        top: -10,
                        left: 5,
                        bottom: 5
                    }
                },
                xaxis: {
                    categories: months,
                    labels: {
                        style: {
                            colors: bodyColor,
                            fontSize: '13px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: bodyColor,
                            fontSize: '13px'
                        },
                        formatter: (val) => Math.round(val)
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val) => val + ' event' + (val === 1 ? '' : 's')
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                }
            });
            lineChart.render();
        }

        // ---- Welcome visits (last 7 days) ----
        const welcomeVisitsEl = document.querySelector('#welcomeVisitsChart');
        if (welcomeVisitsEl && typeof ApexCharts !== 'undefined') {
            const dailyVisits = @json($dailyVisits);
            const dailyVisitLabels = @json($dailyVisitLabels);

            const visitsChart = new ApexCharts(welcomeVisitsEl, {
                chart: {
                    type: 'area',
                    height: 280,
                    parentHeightOffset: 0,
                    toolbar: { show: false },
                    fontFamily: fontFamily
                },
                series: [{
                    name: 'Visitors',
                    data: dailyVisits
                }],
                colors: [infoColor],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 6
                },
                xaxis: {
                    categories: dailyVisitLabels,
                    labels: {
                        style: { colors: bodyColor, fontSize: '13px' }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    min: 0,
                    labels: {
                        style: { colors: bodyColor, fontSize: '13px' },
                        formatter: (val) => Math.round(val)
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val) => val + ' visit' + (val === 1 ? '' : 's')
                    }
                }
            });
            visitsChart.render();
        }

        // ---- Team Distribution Donut Chart ----
        const teamDonutEl = document.querySelector('#teamDonutChart');
        if (teamDonutEl && typeof ApexCharts !== 'undefined') {
            const labels = @json($teamDistribution['labels']);
            const series = @json($teamDistribution['series']);

            const donutChart = new ApexCharts(teamDonutEl, {
                chart: {
                    type: 'donut',
                    height: 300,
                    fontFamily: fontFamily
                },
                series: series,
                labels: labels,
                colors: [primaryColor, successColor, infoColor, warningColor],
                stroke: {
                    width: 0
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => Math.round(val) + '%'
                },
                legend: {
                    position: 'bottom',
                    fontSize: '13px',
                    labels: {
                        colors: bodyColor
                    },
                    markers: {
                        offsetX: -3
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 4
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Team',
                                    fontSize: '14px',
                                    color: bodyColor,
                                    formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                },
                                value: {
                                    fontSize: '22px',
                                    fontWeight: 600
                                }
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 260
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            });
            donutChart.render();
        }
    });
</script>
@endsection