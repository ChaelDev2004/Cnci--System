<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pastor->church }} - {{ $siteSettings->brandName() }}</title>
  <link rel="icon" href="{{ $siteSettings->faviconUrl() }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @include('layouts.partials.public-styles')
  <style>
    :root {
      --text: #2b2b2b;
      --muted: #5c5c5c;
      --line: #e6e6e6;
      --card: #fff;
      --red: #c41e2a;
      --blue: #024886;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', system-ui, sans-serif;
      color: var(--text);
      background: #fff;
      line-height: 1.6;
    }

    img {
      max-width: 100%;
      display: block;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    .container {
      width: min(1100px, calc(100% - 40px));
      margin: 0 auto;
    }

    /* ─── HERO ─── */
    .hero {
      position: relative;
      min-height: 52vh;
      display: grid;
      place-items: center;
      text-align: center;
      color: #fff;
      overflow: hidden;
      padding: 80px 20px;
    }

    .hero-bg {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transform: scale(1.02);
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.72));
    }

    .hero-content {
      position: relative;
      z-index: 1;
      max-width: 720px;
    }

    .hero-content h1 {
      font-size: clamp(2.4rem, 6vw, 4rem);
      font-weight: 800;
      letter-spacing: -0.03em;
      margin-bottom: 18px;
    }

    .hero-content p {
      font-size: 0.98rem;
      color: rgba(255, 255, 255, 0.88);
      max-width: 560px;
      margin: 0 auto 10px;
    }

    /* ─── SECTIONS ─── */
    .section {
      padding: 72px 0;
    }

    .section-title {
      font-size: clamp(1.5rem, 3vw, 2rem);
      font-weight: 800;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: #222;
      margin-bottom: 18px;
    }

    .section-title.center {
      text-align: center;
      margin-bottom: 36px;
    }

    .section-copy {
      color: var(--muted);
      font-size: 0.98rem;
      max-width: 460px;
    }

    .section-copy p + p {
      margin-top: 14px;
    }

    /* Location */
    .location-grid {
      display: grid;
      grid-template-columns: 1fr 1.15fr;
      gap: 48px;
      align-items: center;
    }

    .map-frame {
      border-radius: 18px;
      overflow: hidden;
      background: #f3f4f6;
      min-height: 280px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .map-frame iframe {
      width: 100%;
      height: 300px;
      border: 0;
      display: block;
    }

    .map-fallback {
      min-height: 300px;
      display: grid;
      place-items: center;
      color: #777;
      padding: 24px;
      text-align: center;
    }

    /* Pastor */
    .pastor-grid {
      display: grid;
      grid-template-columns: 0.95fr 1.05fr;
      gap: 48px;
      align-items: center;
    }

    .pastor-photo {
      border-radius: 18px;
      overflow: hidden;
      background: #ececec;
      aspect-ratio: 4 / 5;
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
    }

    .pastor-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .pastor-photo-placeholder {
      width: 100%;
      height: 100%;
      display: grid;
      place-items: center;
      font-size: 4rem;
      color: #c9c9c9;
      background: linear-gradient(145deg, #f0f0f0, #e2e2e2);
    }

    /* Schedule */
    .schedule-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }

    .schedule-card {
      background: var(--card);
      border: 1px solid #ececec;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
      display: flex;
      flex-direction: column;
      min-height: 420px;
    }

    .schedule-card-body {
      padding: 28px 24px 18px;
      flex: 1;
    }

    .schedule-card h3 {
      font-size: 1.15rem;
      font-weight: 800;
      margin-bottom: 18px;
      color: #1f1f1f;
    }

    .schedule-block + .schedule-block {
      margin-top: 16px;
    }

    .schedule-block strong {
      display: block;
      font-size: 0.95rem;
      margin-bottom: 4px;
    }

    .schedule-block span {
      display: block;
      color: var(--muted);
      font-size: 0.9rem;
      line-height: 1.45;
    }

    .schedule-card-media {
      height: 140px;
      position: relative;
      overflow: hidden;
    }

    .schedule-card-media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.55);
    }

    .schedule-card-media::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, transparent, rgba(0, 0, 0, 0.35));
    }

    .schedule-cta-wrap {
      display: flex;
      justify-content: center;
      margin-top: 34px;
    }

    .btn-outline {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 34px;
      border: 1.5px solid #333;
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: 0.2s ease;
      background: #fff;
    }

    .btn-outline:hover {
      background: #111;
      color: #fff;
    }

    /* Gallery */
    .gallery-masonry {
      columns: 3;
      column-gap: 14px;
    }

    .gallery-item {
      break-inside: avoid;
      margin-bottom: 14px;
      border: none;
      padding: 0;
      width: 100%;
      border-radius: 10px;
      overflow: hidden;
      cursor: pointer;
      background: transparent;
      display: block;
    }

    .gallery-item img {
      width: 100%;
      height: auto;
      display: block;
      transition: transform 0.3s ease;
    }

    .gallery-item:hover img,
    .gallery-item:focus-visible img {
      transform: scale(1.03);
    }

    .gallery-item:focus-visible {
      outline: 3px solid var(--blue);
      outline-offset: 2px;
    }

    .gallery-empty {
      text-align: center;
      color: #777;
      padding: 48px 20px;
      border: 1px dashed #ddd;
      border-radius: 14px;
    }

    .gallery-placeholders {
      display: grid;
      grid-template-columns: 1.2fr 1fr 1fr;
      grid-template-rows: 180px 140px 160px;
      gap: 14px;
    }

    .ph {
      border-radius: 10px;
    }

    .ph-a {
      grid-row: 1 / 3;
      background: #1e3a8a;
    }

    .ph-b {
      background: #dc2626;
    }

    .ph-c {
      background: #7c3aed;
    }

    .ph-d {
      background: #b91c1c;
    }

    .ph-e {
      background: #312e81;
    }

    .ph-f {
      background: #6d28d9;
    }

    /* Lightbox */
    .lightbox {
      position: fixed;
      inset: 0;
      z-index: 3000;
      background: rgba(10, 15, 20, 0.92);
      display: none;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    .lightbox.open {
      display: flex;
    }

    .lightbox-inner {
      position: relative;
      max-width: min(1100px, 100%);
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .lightbox-inner img {
      max-width: 100%;
      max-height: 85vh;
      object-fit: contain;
      border-radius: 8px;
    }

    .lightbox-close,
    .lightbox-nav {
      position: absolute;
      border: none;
      background: rgba(255, 255, 255, 0.12);
      color: #fff;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .lightbox-close {
      top: 18px;
      right: 18px;
      z-index: 2;
    }

    .lightbox-nav.prev {
      left: 12px;
    }

    .lightbox-nav.next {
      right: 12px;
    }

    .lightbox-caption {
      position: absolute;
      bottom: -36px;
      left: 0;
      right: 0;
      text-align: center;
      color: rgba(255, 255, 255, 0.75);
      font-size: 0.9rem;
    }

    /* Footer */
    .site-footer {
      margin-top: 40px;
      background: linear-gradient(90deg, #9b1c24 0%, #5a1f5c 45%, #024886 100%);
      color: #fff;
      padding: 48px 0 18px;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 180px 1fr 1.2fr;
      gap: 40px;
      align-items: start;
      padding-bottom: 28px;
    }

    .footer-logo img {
      width: 140px;
      height: 140px;
      object-fit: contain;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.08);
    }

    .footer-links {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
      padding-top: 18px;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.92);
      font-size: 0.95rem;
      transition: opacity 0.2s;
    }

    .footer-links a:hover {
      opacity: 0.75;
    }

    .footer-contact h4 {
      font-size: 0.95rem;
      margin-bottom: 4px;
      font-weight: 700;
    }

    .footer-contact p {
      margin-bottom: 14px;
      color: rgba(255, 255, 255, 0.88);
      font-size: 0.92rem;
    }

    .social-row {
      display: flex;
      gap: 10px;
      margin-top: 8px;
    }

    .social-row a {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.95);
      color: #222;
      display: grid;
      place-items: center;
      font-size: 0.9rem;
      transition: transform 0.2s;
    }

    .social-row a:hover {
      transform: translateY(-2px);
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.18);
      text-align: center;
      padding-top: 14px;
      font-size: 0.82rem;
      color: rgba(255, 255, 255, 0.8);
    }

    /* Responsive */
    @media (max-width: 900px) {
      .location-grid,
      .pastor-grid,
      .schedule-grid,
      .footer-grid {
        grid-template-columns: 1fr;
      }

      .gallery-masonry {
        columns: 2;
      }

      .gallery-placeholders {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: none;
      }

      .ph-a {
        grid-row: auto;
        min-height: 180px;
      }

      .footer-logo {
        justify-self: center;
      }

      .footer-links {
        align-items: center;
        text-align: center;
      }

      .footer-contact {
        text-align: center;
      }

      .social-row {
        justify-content: center;
      }

      .pastor-photo {
        max-width: 420px;
        margin: 0 auto;
      }
    }

    @media (max-width: 560px) {
      .section {
        padding: 52px 0;
      }

      .gallery-masonry {
        columns: 1;
      }

      .gallery-placeholders {
        grid-template-columns: 1fr;
      }

      .schedule-card {
        min-height: auto;
      }
    }
  </style>
</head>

<body>
  @php $activeNav = 'findus'; $fixedNav = false; @endphp
  @include('layouts.partials.public-nav')

  @php
    $location = $pastor->locations->first();
    $churchName = $pastor->church ?: ($location->name ?? 'CNCI Church');
    $locationText = $location
      ? trim(($location->address ?? '') . ($location->city ? ', ' . $location->city : ''))
      : 'Visit us this Sunday and experience the presence of God with our church family.';
    $bioParagraphs = $pastor->bio
      ? preg_split("/\n\s*\n/", trim($pastor->bio))
      : [
          $pastor->name . ' serves as the Resident Pastor of ' . $churchName . ', leading the congregation in worship, discipleship, and community outreach.',
          'Through preaching the Word and shepherding the flock, the pastor continues to guide families toward a deeper relationship with Christ.',
        ];
    $galleryItems = $pastor->galleryImages->map(fn ($img) => [
      'src' => asset('storage/' . $img->path),
      'alt' => $img->caption ?: ($churchName . ' gallery'),
    ])->values();
    if ($pastor->image) {
      $galleryItems = $galleryItems->prepend([
        'src' => asset('storage/' . $pastor->image),
        'alt' => $pastor->name,
      ])->values();
    }
    $heroImage = asset('assets/img/backgrounds/aboutUs-bg.png');
    $sundayTime = $location->service_time ?? '9:00 AM – 12:00 PM';
    $cardImages = [
      $galleryItems[0]['src'] ?? null,
      $galleryItems[1]['src'] ?? ($galleryItems[0]['src'] ?? null),
      $galleryItems[2]['src'] ?? ($galleryItems[0]['src'] ?? null),
    ];
  @endphp

  {{-- HERO --}}
  <header class="hero">
    <img class="hero-bg" src="{{ $heroImage }}" alt="{{ $churchName }}">
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="hero-content">
      <h1>{{ $churchName }}</h1>
      <p>
        Welcome to {{ $churchName }}. We are a community of faith committed to worship,
        discipleship, and sharing the love of Christ in our city and beyond.
      </p>
      <p>
        Join us this week as we gather for Sunday services, prayer, and youth ministry —
        everyone is welcome here.
      </p>
    </div>
  </header>

  {{-- LOCATION --}}
  <section class="section">
    <div class="container location-grid">
      <div>
        <h2 class="section-title">Location</h2>
        <div class="section-copy">
          <p>
            @if($location)
              Find us at <strong>{{ $location->name }}</strong> —
              {{ $locationText }}.
              We would love to welcome you and your family this Sunday.
            @else
              {{ $churchName }} is ready to welcome you. Reach out to our team for directions and visit details.
            @endif
          </p>
          @if($location && $location->maps_link)
          <p style="margin-top:18px;">
            <a class="btn-outline" href="{{ $location->maps_link }}" target="_blank" rel="noopener">Open in Google Maps</a>
          </p>
          @endif
        </div>
      </div>
      <div class="map-frame">
        @if($location && $location->map_embed_url)
          <iframe
            src="{{ $location->map_embed_url }}"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
            title="{{ $churchName }} map"></iframe>
        @else
          <div class="map-fallback">
            <div>
              <i class="fas fa-map-location-dot" style="font-size:2rem;margin-bottom:10px;color:#024886;"></i>
              <p>{{ $locationText }}</p>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>

  {{-- RESIDENT PASTOR --}}
  <section class="section" style="padding-top:24px;">
    <div class="container pastor-grid">
      <div class="pastor-photo">
        @if($pastor->image)
          <img src="{{ asset('storage/' . $pastor->image) }}" alt="{{ $pastor->name }}">
        @else
          <div class="pastor-photo-placeholder"><i class="fas fa-user"></i></div>
        @endif
      </div>
      <div>
        <h2 class="section-title">Resident Pastor</h2>
        <div class="section-copy">
          <p style="font-weight:700;color:#222;margin-bottom:10px;">
            {{ $pastor->name }}@if($pastor->role) — {{ $pastor->role }}@endif
          </p>
          @foreach($bioParagraphs as $paragraph)
            <p>{{ $paragraph }}</p>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- SERVICE SCHEDULE --}}
  <section class="section" style="padding-top:24px;">
    <div class="container">
      <h2 class="section-title center">Service Schedule</h2>
      <div class="schedule-grid">

        <article class="schedule-card">
          <div class="schedule-card-body">
            <h3>Sunday Service</h3>
            <div class="schedule-block">
              <strong>Morning Session</strong>
              <span>{{ $sundayTime }}</span>
              <span>{{ $churchName }}</span>
            </div>
            <div class="schedule-block">
              <strong>Afternoon Session</strong>
              <span>3:00 PM – 5:00 PM</span>
              <span>{{ $churchName }}</span>
            </div>
          </div>
          <div class="schedule-card-media">
            @if($cardImages[0])
              <img src="{{ $cardImages[0] }}" alt="Sunday service">
            @else
              <img src="https://images.unsplash.com/photo-1438232992991-995b7058bbb3?w=800&q=80" alt="Sunday service">
            @endif
          </div>
        </article>

        <article class="schedule-card">
          <div class="schedule-card-body">
            <h3>Prayer Meeting</h3>
            <div class="schedule-block">
              <strong>Monday &amp; Wednesday</strong>
              <span>7:00 AM – 9:00 AM</span>
            </div>
            <div class="schedule-block">
              <strong>Tuesday &amp; Thursday</strong>
              <span>7:00 PM – 9:00 PM</span>
            </div>
            <div class="schedule-block">
              <strong>Saturday</strong>
              <span>4:00 PM – 6:00 PM</span>
            </div>
          </div>
          <div class="schedule-card-media">
            @if($cardImages[1])
              <img src="{{ $cardImages[1] }}" alt="Prayer meeting">
            @else
              <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=800&q=80" alt="Prayer meeting">
            @endif
          </div>
        </article>

        <article class="schedule-card">
          <div class="schedule-card-body">
            <h3>YOB</h3>
            <div class="schedule-block">
              <strong>YOB Glow</strong>
              <span>Every Friday</span>
              <span>7:00 PM – 9:00 PM</span>
            </div>
            <div class="schedule-block">
              <strong>YOB Crew</strong>
              <span>Every Saturday</span>
              <span>1:00 PM – 3:00 PM</span>
            </div>
          </div>
          <div class="schedule-card-media">
            @if($cardImages[2])
              <img src="{{ $cardImages[2] }}" alt="YOB ministry">
            @else
              <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=800&q=80" alt="YOB ministry">
            @endif
          </div>
        </article>

      </div>

      <div class="schedule-cta-wrap">
        <a href="{{ url('/') }}#findUs" class="btn-outline">Service Offered.</a>
      </div>
    </div>
  </section>

  {{-- CHURCH GALLERY --}}
  <section class="section" style="padding-top:20px;padding-bottom:80px;">
    <div class="container">
      <h2 class="section-title center">Church Gallery</h2>

      @if($galleryItems->count())
        <div class="gallery-masonry" id="pastorGalleryGrid">
          @foreach($galleryItems as $index => $item)
            <button
              type="button"
              class="gallery-item"
              data-index="{{ $index }}"
              aria-label="Open gallery image {{ $index + 1 }}">
              <img src="{{ $item['src'] }}" alt="{{ $item['alt'] }}" loading="lazy">
            </button>
          @endforeach
        </div>
      @else
        <div class="gallery-placeholders" aria-hidden="true">
          <div class="ph ph-a"></div>
          <div class="ph ph-b"></div>
          <div class="ph ph-c"></div>
          <div class="ph ph-d"></div>
          <div class="ph ph-e"></div>
          <div class="ph ph-f"></div>
        </div>
        <p class="gallery-empty" style="margin-top:18px;border:none;padding:8px;">
          Upload gallery photos in Admin → Pastors to fill this section.
        </p>
      @endif
    </div>
  </section>

  @include('layouts.partials.public-footer')

  <div class="lightbox" id="pastorLightbox" role="dialog" aria-modal="true" aria-label="Church gallery" hidden>
    <button type="button" class="lightbox-close" id="lightboxClose" aria-label="Close gallery">
      <i class="fas fa-times"></i>
    </button>
    <button type="button" class="lightbox-nav prev" id="lightboxPrev" aria-label="Previous photo">
      <i class="fas fa-chevron-left"></i>
    </button>
    <div class="lightbox-inner">
      <img src="" alt="" id="lightboxImage">
      <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
    <button type="button" class="lightbox-nav next" id="lightboxNext" aria-label="Next photo">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>

  <script>
    (function() {
      const items = @json($galleryItems);
      if (!items.length) return;

      const lightbox = document.getElementById('pastorLightbox');
      const imageEl = document.getElementById('lightboxImage');
      const captionEl = document.getElementById('lightboxCaption');
      let current = 0;

      function render() {
        const item = items[current];
        imageEl.src = item.src;
        imageEl.alt = item.alt;
        captionEl.textContent = (current + 1) + ' / ' + items.length;
      }

      function openAt(index) {
        current = index;
        render();
        lightbox.hidden = false;
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
      }

      function closeLightbox() {
        lightbox.classList.remove('open');
        lightbox.hidden = true;
        document.body.style.overflow = '';
      }

      document.querySelectorAll('.gallery-item').forEach(function(btn) {
        btn.addEventListener('click', function() {
          openAt(Number(btn.dataset.index));
        });
      });

      document.getElementById('lightboxClose').addEventListener('click', closeLightbox);
      document.getElementById('lightboxPrev').addEventListener('click', function() {
        current = (current - 1 + items.length) % items.length;
        render();
      });
      document.getElementById('lightboxNext').addEventListener('click', function() {
        current = (current + 1) % items.length;
        render();
      });

      lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) closeLightbox();
      });

      document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') {
          current = (current - 1 + items.length) % items.length;
          render();
        }
        if (e.key === 'ArrowRight') {
          current = (current + 1) % items.length;
          render();
        }
      });
    })();
  </script>
  @include('layouts.partials.public-scripts')

</body>

</html>
