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
<div class="row">
    <div class="col-xxl-8 mb-6 order-0">
        <div class="card">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">
                            <span id="greeting"></span>, Pastor {{ Auth::user()->name }}! 🤲
                        </h5>
                        <p class="mb-6">
                            You have {{ $stats['total_events'] }} events on record,
                            {{ $stats['active_events'] }} currently active.
                        </p>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-primary">Manage Events</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('assets/img/backgrounds/pastorImg.png') }}" height="175" alt="View Badge User" />
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
                @if (\Illuminate\Support\Facades\Route::has('locations.index'))
                <a href="{{ route('locations.index') }}" class="btn btn-sm btn-icon">
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