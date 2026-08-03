@php
  \App\Models\User::ensureColumns();
  $navActive = $activeNav ?? '';
  $galleryHref = ($navActive === 'home') ? '#gallery' : route('gallery');
  $authUser = auth()->user();
@endphp

<nav class="public-nav {{ !empty($fixedNav) ? 'is-fixed' : '' }}" aria-label="Main">
  <div class="public-nav-inner">
    <a href="{{ url('/') }}" class="public-nav-brand-wrap">
      <img class="public-nav-logo" src="{{ $siteSettings->logoUrl() }}" alt="{{ $siteSettings->brandName() }} Logo">
      <span class="public-nav-brand">
        {{ $siteSettings->brandName() }}
        <span>{{ $siteSettings->brandTagline() }}</span>
      </span>
    </a>

    <ul class="public-nav-links">
      <li><a href="{{ url('/') }}" class="{{ $navActive === 'home' ? 'active' : '' }}">Home</a></li>
      <li><a href="{{ route('about') }}" class="{{ $navActive === 'about' ? 'active' : '' }}">About</a></li>
      <li><a href="{{ route('content.dashboard.events') }}" class="{{ $navActive === 'events' ? 'active' : '' }}">Events</a></li>
      <li><a href="{{ $galleryHref }}" class="{{ $navActive === 'gallery' ? 'active' : '' }}">Gallery</a></li>
      <li><a href="{{ route('findus') }}" class="{{ $navActive === 'findus' ? 'active' : '' }}">Find Us</a></li>
    </ul>

    @auth
      <div class="public-nav-auth">
        <div class="public-nav-user" id="publicNavUser">
          <button type="button" class="public-nav-user-btn" id="publicNavUserBtn" aria-haspopup="true" aria-expanded="false">
            <span class="public-nav-avatar">
              @if($authUser->avatar)
                <img src="{{ $authUser->avatarUrl() }}" alt="{{ $authUser->name }}">
              @else
                {{ strtoupper(substr($authUser->name ?? 'A', 0, 1)) }}
              @endif
            </span>
            <span class="public-nav-user-meta">
              <strong>{{ $authUser->name }}</strong>
              <span>{{ $authUser->isBranch() ? 'Branch' : 'Admin' }}</span>
            </span>
          </button>
          <div class="public-nav-dropdown" role="menu">
            <a href="{{ route('admin.account.index') }}" role="menuitem">Account Settings</a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" class="logout-btn" role="menuitem">Logout</button>
            </form>
          </div>
        </div>
        <a class="public-nav-dash" href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
    @else
      <a href="{{ url('/#findUs') }}" class="public-nav-cta guest-only">Plan a Visit</a>
    @endauth

    <button class="public-nav-burger" id="publicBurger" type="button" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="public-mob-menu" id="publicMobMenu">
  <div class="public-mob-top">
    <a href="{{ url('/') }}" class="public-mob-brand">{{ $siteSettings->brandName() }}</a>
    <button type="button" class="public-mob-close" id="publicMobClose" aria-label="Close">&times;</button>
  </div>
  <ul class="public-mob-links">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ route('about') }}">About</a></li>
    <li><a href="{{ route('content.dashboard.events') }}">Events</a></li>
    <li><a href="{{ route('gallery') }}">Gallery</a></li>
    <li><a href="{{ route('findus') }}">Find Us</a></li>
    @auth
      <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
      <li><a href="{{ route('admin.account.index') }}">Account Settings</a></li>
    @endauth
  </ul>
  <div class="public-mob-footer">
    @auth
      <p style="margin-bottom:10px;">Logged in as <strong>{{ $authUser->name }}</strong></p>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" style="background:#f5c542;color:#1e1e1e;border:none;border-radius:999px;padding:10px 18px;font-weight:600;cursor:pointer;">Logout</button>
      </form>
    @else
      <p>Sunday Services</p>
      <p><span>9:00 AM</span> &nbsp;&amp;&nbsp; <span>11:00 AM</span></p>
      <p style="margin-top:8px;"><a href="{{ url('/#findUs') }}" style="color:#f5c542;">Plan a Visit &rarr;</a></p>
    @endauth
  </div>
</div>
