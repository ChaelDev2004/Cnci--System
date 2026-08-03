@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\ContactMessage;
use App\Models\PageVisit;

$user = Auth::user();
$currentRoute = Route::currentRouteName() ?? '';
$pageTitles = [
    'admin.dashboard' => 'Dashboard',
    'admin.calendar.index' => 'Calendar',
    'admin.gallery.index' => 'Gallery',
    'admin.gallery.create' => 'Add Gallery Image',
    'admin.gallery.edit' => 'Edit Gallery Image',
    'admin.locations.index' => 'Find Us',
    'admin.locations.create' => 'Add Location',
    'admin.locations.edit' => 'Edit Location',
    'admin.contact.index' => 'Contact',
    'admin.contact.show' => 'Contact Message',
    'admin.events.index' => 'Events',
    'admin.events.create' => 'Create Event',
    'admin.events.edit' => 'Edit Event',
    'admin.about.edit' => 'About Page',
    'content.dashboard.admin.index' => 'Home Settings',
    'content.dashboard.home.edit' => 'Home Settings',
    'admin.account.index' => 'Account Settings',
    'admin.branches.index' => 'Branch Accounts',
    'admin.branches.create' => 'Add Branch Account',
    'admin.branches.edit' => 'Edit Branch Account',
    'admin.pastors.index' => 'Pastors',
    'admin.pastors.create' => 'Add Pastor',
    'admin.pastors.edit' => 'Edit Pastor',
];
$pageTitle = $pageTitles[$currentRoute] ?? 'Admin Panel';

\App\Models\User::ensureColumns();

$unreadMessages = 0;
$latestMessages = collect();
$unreadVisits = 0;
$latestVisits = collect();
$isBranchUser = $user && method_exists($user, 'isBranch') && $user->isBranch();
try {
    if (! $isBranchUser && ContactMessage::tableReady()) {
        $unreadMessages = ContactMessage::where('is_read', false)->count();
        $latestMessages = ContactMessage::orderByDesc('created_at')->take(5)->get();
    }
} catch (\Throwable $e) {
    // table may not exist yet
}
try {
    if (! $isBranchUser && PageVisit::tableReady()) {
        $unreadVisits = PageVisit::where('is_read', false)->count();
        $latestVisits = PageVisit::orderByDesc('created_at')->take(3)->get();
    }
} catch (\Throwable $e) {
    // table may not exist yet
}
$unreadTotal = $unreadMessages + $unreadVisits;
@endphp

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if(isset($navbarFull))
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
    <a href="{{ route('admin.dashboard') }}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">@include('_partials.macros')</span>
        <span class="app-brand-text demo menu-text fw-bold text-heading">CNCI Admin</span>
    </a>
</div>
@endif

<!-- ! Not required for layout-without-menu -->
@if(!isset($navbarHideToggle))
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base bx bx-menu icon-md"></i>
    </a>
</div>
@endif

<div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">
    <div class="navbar-nav align-items-center flex-grow-1">
        <div class="nav-item d-none d-md-block me-3">
            <h5 class="mb-0 fw-semibold text-heading">{{ $pageTitle }}</h5>
        </div>
        <div class="nav-item d-flex align-items-center flex-grow-1" style="max-width:360px;">
            <i class="icon-base bx bx-search icon-md"></i>
            <input
                type="text"
                id="adminMenuSearch"
                class="form-control border-0 shadow-none ps-1 ps-sm-2"
                placeholder="Search menu..."
                aria-label="Search menu">
        </div>
    </div>

    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Notifications -->
        <li class="nav-item navbar-dropdown dropdown-notifications dropdown me-3">
            <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill position-relative"
               href="javascript:void(0);"
               data-bs-toggle="dropdown"
               aria-expanded="false">
                <i class="icon-base bx bx-bell icon-md"></i>
                @if($unreadTotal > 0)
                    <span class="badge rounded-pill bg-danger badge-notifications" style="position:absolute;top:2px;right:2px;font-size:0.65rem;">
                        {{ $unreadTotal > 9 ? '9+' : $unreadTotal }}
                    </span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end py-0" style="width:min(340px,90vw);">
                <li class="dropdown-menu-header border-bottom">
                    <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="mb-0 me-auto">Notifications</h6>
                        <span class="badge bg-label-primary">{{ $unreadTotal }} New</span>
                    </div>
                </li>
                <li class="dropdown-notifications-list">
                    <ul class="list-group list-group-flush">
                        @foreach($latestMessages as $msg)
                            <li class="list-group-item list-group-item-action {{ $msg->is_read ? '' : 'bg-label-primary' }}">
                                <a href="{{ route('admin.contact.show', $msg) }}" class="d-block text-body">
                                    <div class="fw-semibold">
                                        <i class="bx bx-envelope me-1"></i>
                                        @if(!$msg->is_read)
                                            <span class="badge bg-danger me-1" style="font-size:0.65rem;">New</span>
                                        @endif
                                        Contact: {{ $msg->name }}
                                    </div>
                                    <small class="text-muted d-block text-truncate">{{ $msg->subject ?: Str::limit($msg->message, 50) }}</small>
                                    <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @endforeach
                        @foreach($latestVisits as $visit)
                            <li class="list-group-item list-group-item-action {{ $visit->is_read ? '' : 'bg-label-info' }}">
                                <a href="{{ route('admin.dashboard') }}" class="d-block text-body">
                                    <div class="fw-semibold"><i class="bx bx-show me-1"></i> Welcome page visit</div>
                                    <small class="text-muted d-block">{{ $visit->ip_address ?: 'Visitor' }} viewed the home page</small>
                                    <small class="text-muted">{{ $visit->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @endforeach
                        @if($latestVisits->isEmpty() && $latestMessages->isEmpty())
                            <li class="list-group-item text-center text-muted py-4">No notifications yet</li>
                        @endif
                    </ul>
                </li>
                <li class="dropdown-menu-footer border-top">
                    <div class="d-flex">
                        <a href="{{ route('admin.contact.index') }}" class="dropdown-item d-flex justify-content-center p-3 border-end">
                            @if($unreadMessages > 0)
                                <span class="badge bg-danger me-1">{{ $unreadMessages }}</span>
                            @endif
                            Messages
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item d-flex justify-content-center p-3">
                            Visits
                        </a>
                    </div>
                </li>
            </ul>
        </li>

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    @if($user && $user->avatar)
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
                    @else
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            {{ strtoupper(Str::substr($user->name ?? 'A', 0, 1)) }}
                        </span>
                    @endif
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.account.index') }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    @if($user && $user->avatar)
                                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
                                    @else
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ strtoupper(Str::substr($user->name ?? 'A', 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $user->name ?? 'Admin' }}</h6>
                                <small class="text-muted">{{ $user->email ?? 'Administrator' }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                        <i class="icon-base bx bx-home icon-md me-3"></i><span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.account.index') }}">
                        <i class="icon-base bx bx-user icon-md me-3"></i><span>Account Settings</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.contact.index') }}">
                        <i class="icon-base bx bx-envelope icon-md me-3"></i><span>Contact</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ url('/') }}" target="_blank" rel="noopener">
                        <i class="icon-base bx bx-globe icon-md me-3"></i><span>View Website</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider my-1"></div>
                </li>
                <li>
                    <a class="dropdown-item"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-base bx bx-power-off icon-md me-3"></i>
                        <span>Log Out</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('adminMenuSearch');
  if (!input) return;

  input.addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('#layout-menu .menu-inner > .menu-item').forEach(function (item) {
      const label = (item.querySelector('.menu-link div') || {}).textContent || '';
      item.style.display = !q || label.toLowerCase().includes(q) ? '' : 'none';
    });
  });
});
</script>
