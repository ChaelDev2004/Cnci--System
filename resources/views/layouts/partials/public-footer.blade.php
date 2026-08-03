<footer class="public-footer">
  <div class="public-footer-inner">
    <div class="public-footer-grid">
      <div class="public-footer-logo">
        <img src="{{ $siteSettings->logoUrl() }}" alt="{{ $siteSettings->brandName() }} Logo">
      </div>
      <ul class="public-footer-links">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('content.dashboard.events') }}">Events</a></li>
        <li><a href="{{ route('gallery') }}">Gallery</a></li>
        <li><a href="{{ route('findus') }}">Find Us</a></li>
        <li><a href="{{ url('/#contact') }}">Contact</a></li>
      </ul>
      <div class="public-footer-contact">
        @if($siteSettings->contact_email)
          <h4>Email</h4>
          <p>{{ $siteSettings->contact_email }}</p>
        @endif
        @if($siteSettings->contact_phone)
          <h4>Phone</h4>
          <p>{{ $siteSettings->contact_phone }}</p>
        @endif
        @if($siteSettings->contact_address)
          <h4>Location</h4>
          <p>{{ $siteSettings->contact_address }}</p>
        @endif
        @if($siteSettings->contact_hours)
          <h4>Hours</h4>
          <p>{{ $siteSettings->contact_hours }}</p>
        @endif
      </div>
    </div>
    <div class="public-footer-bottom">
      &copy; {{ date('Y') }} {{ $siteSettings->brandName() }}. All rights reserved.
    </div>
  </div>
</footer>
