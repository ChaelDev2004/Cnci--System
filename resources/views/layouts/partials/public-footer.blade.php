<footer class="public-footer">
  <div class="public-footer-glow" aria-hidden="true"></div>
  <div class="public-footer-inner">
    <div class="public-footer-grid">
      <div class="public-footer-brand">
        <a href="{{ url('/') }}" class="public-footer-brand-link">
          <img src="{{ $siteSettings->logoUrl() }}" alt="{{ $siteSettings->brandName() }} Logo">
          <div>
            <strong>{{ $siteSettings->brandName() }}</strong>
            @if($siteSettings->brandTagline())
              <span>{{ $siteSettings->brandTagline() }}</span>
            @endif
          </div>
        </a>
        <p class="public-footer-tagline">
          Influencing this generation for Christ through faith, righteousness, and holiness.
        </p>
        <a href="{{ url('/#contact') }}" class="public-footer-cta">Get in touch</a>
      </div>

      <div class="public-footer-col">
        <h4>Explore</h4>
        <ul class="public-footer-links">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ route('about') }}">About</a></li>
          <li><a href="{{ route('content.dashboard.events') }}">Events</a></li>
          <li><a href="{{ route('gallery') }}">Gallery</a></li>
          <li><a href="{{ route('findus') }}">Find Us</a></li>
          <li><a href="{{ url('/#contact') }}">Contact</a></li>
        </ul>
      </div>

      <div class="public-footer-col public-footer-contact">
        <h4>Visit &amp; Connect</h4>
        @if($siteSettings->contact_email)
          <a class="public-footer-meta" href="mailto:{{ $siteSettings->contact_email }}">
            <span class="public-footer-meta-label">Email</span>
            <span>{{ $siteSettings->contact_email }}</span>
          </a>
        @endif
        @if($siteSettings->contact_phone)
          <a class="public-footer-meta" href="tel:{{ preg_replace('/\s+/', '', $siteSettings->contact_phone) }}">
            <span class="public-footer-meta-label">Phone</span>
            <span>{{ $siteSettings->contact_phone }}</span>
          </a>
        @endif
        @if($siteSettings->contact_address)
          <div class="public-footer-meta">
            <span class="public-footer-meta-label">Location</span>
            <span>{{ $siteSettings->contact_address }}</span>
          </div>
        @endif
        @if($siteSettings->contact_hours)
          <div class="public-footer-meta">
            <span class="public-footer-meta-label">Hours</span>
            <span>{{ $siteSettings->contact_hours }}</span>
          </div>
        @endif
        @if($siteSettings->contact_website)
          <a class="public-footer-meta" href="{{ str_starts_with($siteSettings->contact_website, 'http://') || str_starts_with($siteSettings->contact_website, 'https://') ? $siteSettings->contact_website : 'https://'.$siteSettings->contact_website }}" target="_blank" rel="noopener">
            <span class="public-footer-meta-label">Website</span>
            <span>{{ $siteSettings->contact_website }}</span>
          </a>
        @endif
      </div>
    </div>

    <div class="public-footer-bottom">
      <p>&copy; {{ date('Y') }} {{ $siteSettings->brandName() }} Church. All rights reserved.</p>
      <p class="public-footer-bottom-note">Built for ministry · Region community</p>
    </div>
  </div>
</footer>
