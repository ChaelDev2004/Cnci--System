<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>{{ $siteSettings->brandName() }} Church</title>
  <link rel="icon" href="{{ $siteSettings->faviconUrl() }}" />
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  @include('layouts.partials.public-styles')
  <style>
    /* ─── SCROLL & LAYOUT ─────────────────────────────────────── */
    html,
    body {
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      max-width: 100%;
    }

    img, video, iframe {
      max-width: 100%;
    }

    .swiper-wrapper-container {
      position: relative;
      overflow: hidden;
      height: 100svh;
      height: 100dvh;
      width: 100%;
      max-width: 100%;
    }

    .swiper {
      height: 100svh;
      height: 100dvh;
      width: 100%;
    }

    .swiper-slide {
      height: 100svh;
      height: 100dvh;
      min-height: 100svh;
    }

    /* ─── SCROLL INDICATOR ────────────────────────────────────── */
    .scroll-indicator {
      position: fixed;
      bottom: 28px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 100;
      text-align: center;
      pointer-events: none;
      opacity: 1;
      transition: opacity 0.5s ease;
    }

    .scroll-indicator p {
      font-size: 12px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.55);
    }

    .scroll-indicator svg {
      display: block;
      margin: 4px auto 0;
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 60%, 100% { transform: translateY(0); }
      30% { transform: translateY(-6px); }
    }

    /* ─── SECTIONS (fluid, no huge fixed tops) ─────────────────── */
    #mission {
      min-height: auto;
      padding: clamp(48px, 8vw, 80px) clamp(16px, 4vw, 24px);
      background: #fff;
      position: relative;
      z-index: 1;
      margin-top: 0;
    }

    .about {
      min-height: auto;
      padding: clamp(56px, 10vw, 100px) clamp(16px, 4vw, 24px);
      background: #fff;
      position: relative;
      z-index: 1;
      margin-top: 0;
    }

    .findUs {
      min-height: auto;
      padding: clamp(40px, 6vw, 80px) clamp(12px, 3vw, 20px);
      background: #f8f7f4;
      position: relative;
      z-index: 1;
      margin-top: 0;
      width: 100%;
      box-sizing: border-box;
    }

    .contact {
      min-height: auto;
      padding: clamp(40px, 6vw, 80px) clamp(12px, 3vw, 20px);
      background: #fff;
      position: relative;
      z-index: 1;
      margin-top: 0;
      width: 100%;
      box-sizing: border-box;
    }

    /* ─── Bible verse welcome modal ─── */
    .verse-modal {
      position: fixed;
      inset: 0;
      z-index: 10000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.25rem;
      opacity: 0;
      visibility: hidden;
      transition: opacity .35s ease, visibility .35s ease;
    }

    .verse-modal.is-open {
      opacity: 1;
      visibility: visible;
    }

    .verse-modal__backdrop {
      position: absolute;
      inset: 0;
      background: rgba(10, 16, 28, 0.62);
      backdrop-filter: blur(6px);
    }

    .verse-modal__panel {
      position: relative;
      width: min(520px, 100%);
      background: linear-gradient(165deg, #ffffff 0%, #f7f8fb 100%);
      border-radius: 18px;
      padding: 2rem 1.75rem 1.5rem;
      box-shadow: 0 24px 60px rgba(0, 0, 0, 0.28);
      text-align: center;
      transform: translateY(18px) scale(0.97);
      transition: transform .4s cubic-bezier(.2, .8, .2, 1);
    }

    .verse-modal.is-open .verse-modal__panel {
      transform: translateY(0) scale(1);
    }

    .verse-modal__eyebrow {
      font-family: Inter, system-ui, sans-serif;
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: #8a94a6;
      margin: 0 0 1rem;
    }

    .verse-modal__ornament {
      width: 42px;
      height: 2px;
      margin: 0 auto 1.15rem;
      background: linear-gradient(90deg, #c41e2a, #024886);
      border-radius: 2px;
    }

    .verse-modal__text {
      font-family: "Instrument Serif", Georgia, serif;
      font-size: clamp(1.35rem, 3.2vw, 1.7rem);
      line-height: 1.45;
      color: #1a2230;
      margin: 0 0 1rem;
      font-weight: 400;
    }

    .verse-modal__ref {
      font-family: Inter, system-ui, sans-serif;
      font-size: 0.9rem;
      font-weight: 600;
      color: #024886;
      margin: 0 0 1.5rem;
      letter-spacing: 0.02em;
    }

    .verse-modal__close {
      appearance: none;
      border: none;
      border-radius: 999px;
      padding: 0.7rem 1.6rem;
      font-family: Inter, system-ui, sans-serif;
      font-size: 0.9rem;
      font-weight: 600;
      color: #fff;
      background: linear-gradient(135deg, #c41e2a, #024886);
      cursor: pointer;
      transition: transform .15s ease, opacity .15s ease;
    }

    .verse-modal__close:hover {
      transform: translateY(-1px);
      opacity: 0.95;
    }

    .verse-modal__x {
      position: absolute;
      top: 0.75rem;
      right: 0.85rem;
      width: 36px;
      height: 36px;
      border: none;
      background: transparent;
      color: #8a94a6;
      font-size: 1.35rem;
      line-height: 1;
      cursor: pointer;
      border-radius: 50%;
    }

    .verse-modal__x:hover {
      color: #1a2230;
      background: rgba(0, 0, 0, 0.05);
    }

    body.verse-modal-open {
      overflow: hidden;
    }

    /* Welcome gallery preview */
    .home-gallery {
      padding: clamp(48px, 8vw, 88px) clamp(16px, 4vw, 32px);
      background: #f7f7f8;
      position: relative;
      z-index: 1;
    }

    .home-gallery-inner {
      max-width: 1180px;
      margin: 0 auto;
    }

    .home-gallery-head {
      text-align: center;
      margin-bottom: clamp(24px, 4vw, 40px);
    }

    .home-gallery-head h2 {
      font-family: 'Raleway', sans-serif;
      font-size: clamp(1.6rem, 4vw, 2.2rem);
      font-weight: 700;
      color: #1e1e2a;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin: 0 0 10px;
    }

    .home-gallery-head p {
      margin: 0 auto;
      max-width: 520px;
      color: #5c5c5c;
      font-size: 1rem;
      line-height: 1.6;
    }

    .home-gallery-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
    }

    .home-gallery-item {
      position: relative;
      border-radius: 14px;
      overflow: hidden;
      aspect-ratio: 4 / 3;
      background: #e8e8ea;
      display: block;
    }

    .home-gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform .35s ease;
    }

    .home-gallery-item:hover img {
      transform: scale(1.06);
    }

    .home-gallery-item .cap {
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      padding: 24px 12px 10px;
      background: linear-gradient(transparent, rgba(0,0,0,.7));
      color: #fff;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .home-gallery-actions {
      margin-top: 28px;
      text-align: center;
    }

    .home-gallery-more {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 28px;
      border-radius: 999px;
      background: linear-gradient(90deg, #d1202a, #024886);
      color: #fff;
      font-weight: 600;
      font-size: 0.92rem;
      text-decoration: none;
      transition: transform .15s ease, box-shadow .15s ease;
    }

    .home-gallery-more:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(2, 72, 134, 0.28);
      color: #fff;
    }

    .home-gallery-empty {
      text-align: center;
      color: #697a8d;
      padding: 28px;
      background: #fff;
      border-radius: 14px;
      border: 1px dashed #ddd;
    }

    @media (max-width: 900px) {
      .home-gallery-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 480px) {
      .home-gallery-grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
      }
    }

   .btn-visit-us {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 28px;
  background: linear-gradient(135deg, #2d7c3a, #1a5a2a);
  color: #ffffff;
  border-radius: 50px;
  font-weight: 600;
  font-size: 0.95rem;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(45, 124, 58, 0.3);
  width: 100%;
  border: none;
  cursor: pointer;
}

.btn-visit-us:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 25px rgba(45, 124, 58, 0.4);
  background: linear-gradient(135deg, #3a9a4a, #1a5a2a);
  color: #ffffff;
  text-decoration: none;
}

.btn-visit-us i {
  font-size: 1.1rem;
}

    .swiper-pagination {
      z-index: 20;
    }

    /* Landing responsive overrides */
    @media (max-width: 900px) {
      .scroll-indicator { bottom: 18px; }
      .scroll-indicator p { font-size: 10px; }
    }

    @media (max-width: 680px) {
      .scroll-indicator { display: none; }
    }

    @media (max-width: 480px) {
      .about { padding-top: 48px; }
      .findUs .card,
      .contact-card {
        border-radius: 18px;
      }
    }
  </style>
</head>

<body @auth class="is-auth" @endauth>
  @php $activeNav = 'home'; $fixedNav = true; @endphp
  @include('layouts.partials.public-nav')

  {{-- ─── SWIPER ──────────────────────────────────────────────── --}}
  <div class="swiper-wrapper-container">
    <div class="swiper">
      <div class="swiper-wrapper">

        @foreach($slides as $slide)
        <div class="swiper-slide">

          {{-- Background --}}
          @if($slide->bg_type === 'video' && $slide->bg_video_url)
          <video class="bg-video" autoplay loop muted playsinline>
            <source src="{{ $slide->bg_video_url }}" type="video/mp4">
          </video>
          @elseif($slide->bg_type === 'image' && $slide->bg_image)
          <div class="bg-image">
            <img src="{{ asset('storage/'.$slide->bg_image) }}" alt="Slide Background">
          </div>
          @endif

          <div class="vignette"></div>
          <div class="left-fade"></div>
          <div class="bottom-fade"></div>

          {{-- Slide Content --}}
          @if($slide->layout === 'welcome')
          <div class="slide2-bg"></div>
          <div class="slide2-circle-glow"></div>
          <div class="slide2-left-fade"></div>
          <div class="slide2-top"></div>
          <div class="slide2-bottom"></div>
          <div class="slide-inner">
            @if($slide->eyebrow)
            <div class="eyebrow">{{ $slide->eyebrow }}</div>
            @endif
            @if($slide->heading)
            <h1 class="slide2-h1">{!! nl2br(e($slide->heading)) !!}</h1>
            @endif
            <div class="divider"></div>
            @if($slide->subtext)
            <p class="slide2-p">{!! nl2br(e($slide->subtext)) !!}</p>
            @endif
            <div class="slide2-actions">
              @if($slide->cta_primary_label)
              <button class="btn-glass" onclick="window.location='{{ $slide->cta_primary_link ?? '#' }}'">
                {{ $slide->cta_primary_label }}
              </button>
              @endif
            </div>
            @if($slide->service_badge)
            <div class="service-badge">{{ $slide->service_badge }}</div>
            @endif
          </div>

          @elseif($slide->layout === 'default')
          <div class="slide-inner">
            @if($slide->eyebrow)
            <div class="hero-eyebrow">{{ $slide->eyebrow }}</div>
            @endif
            @if($slide->heading)
            <h1 class="hero-h1">{!! nl2br(e($slide->heading)) !!}</h1>
            @endif
            @if($slide->subtext)
            <p class="hero-sub">{!! nl2br(e($slide->subtext)) !!}</p>
            @endif
            @if($slide->cta_primary_label)
            <div class="hero-actions">
              <button class="btn-primary" onclick="window.location='{{ $slide->cta_primary_link ?? '#' }}'">
                {{ $slide->cta_primary_label }}
              </button>
            </div>
            @endif
          </div>
          @if($slide->testimonial)
          <div class="testimonial">
            <p>"{!! nl2br(e($slide->testimonial)) !!}"</p>
          </div>
          @endif

          @endif
          {{-- layout === 'plain' renders background only, no inner content --}}

        </div>
        @endforeach

      </div>
    </div>
  </div>

  {{-- ─── MISSION ─────────────────────────────────────────────── --}}
  <section id="mission">
    <div class="mission-container">
      <h2>Mission</h2>
      <p>{{ $settings->mission_text ?? 'We are an Evangelistic, Missionary church...' }}</p>
    </div>
    <div class="purpose-container">
      <h2>Purpose</h2>
      <p>{{ $settings->purpose_text ?? 'Our purpose is to proclaim Salvation, Healing, Deliverance...' }}</p>
    </div>
  </section>

  {{-- ─── ABOUT ──────────────────────────────────────────────── --}}
  <section class="about" id="about">
    <div class="about-container">
      <h2>About Us</h2>
      <p>{{ $settings->about_text ?? 'The Bishop of Christ New Creation Missionary Church Inc...' }}</p>
      <div class="about-btn">
        <button><a href="{{ route('about') }}">Learn More</a></button>
      </div>
    </div>
  </section>

  {{-- ─── GALLERY PREVIEW ─────────────────────────────────────── --}}
  <section class="home-gallery" id="gallery">
    <div class="home-gallery-inner">
      <div class="home-gallery-head">
        <h2>Gallery</h2>
        <p>Glimpses of worship, fellowship, and life across CNCI churches.</p>
      </div>

      @if(($galleryImages ?? collect())->isEmpty())
        <div class="home-gallery-empty">
          Gallery photos will appear here once they are uploaded.
        </div>
      @else
        <div class="home-gallery-grid">
          @foreach($galleryImages as $image)
            <a href="{{ route('gallery') }}" class="home-gallery-item" aria-label="View gallery">
              <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?: 'Gallery photo' }}" loading="lazy">
              <span class="cap">
                {{ $image->caption ?: ($image->pastor->church ?? $image->pastor->name ?? 'CNCI') }}
              </span>
            </a>
          @endforeach
        </div>
      @endif

      <div class="home-gallery-actions">
        <a href="{{ route('gallery') }}" class="home-gallery-more">
          View More <span aria-hidden="true">&rarr;</span>
        </a>
      </div>
    </div>
  </section>

  {{-- ─── FIND US ─────────────────────────────────────────────── --}}
<section class="findUs" id="findUs">
  <div class="card">
    <div class="card-left">
      <div class="map-wrapper">
        <iframe
          id="mapIframe"
          src="{{ $defaultLocation->map_embed_url ?? '' }}"
          title="Church location map"
          style="border:0; width:100%; height:100%; min-height:220px;"
          allowfullscreen loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
    <div class="card-right">
      <div class="card-header">
        <span class="badge"><i class="fas fa-church" style="margin-right:5px;"></i> CNCI Church</span>
        <h2><i class="fas fa-map-pin" style="font-size:1.8rem;"></i> Find a Church Near You</h2>
        <p>God created you on purpose for a purpose. At Life.Church, we want to help you become the person He created you to be.</p>
      </div>
      <div class="location-section">
        <div class="location-selector">
          <label for="churchSelect"><i class="fas fa-location-dot"></i> Choose a location</label>
          <select id="churchSelect" onchange="updateLocation(this)">
            @foreach($locations as $loc)
            @php
              $pastorVisitLink = $loc->visit_link
                ?: ($loc->pastor_id ? route('pastor.show', $loc->pastor_id) : '#');
            @endphp
            <option
              value="{{ $loc->id }}"
              data-name="{{ $loc->name }}"
              data-address="{{ $loc->address }}"
              data-maps="{{ $loc->maps_link }}"
              data-time="{{ $loc->service_time }}"
              data-embed="{{ $loc->map_embed_url }}"
              data-visit="{{ $pastorVisitLink }}"
              data-pastor-name="{{ $loc->pastor->name ?? '' }}"
              {{ $defaultLocation && $loc->id === $defaultLocation->id ? 'selected' : '' }}>
              {{ $loc->city }}
            </option>
            @endforeach
          </select>
        </div>
        <div class="church-card" id="churchCard">
          <div class="church-name">
            <span class="pin-icon"><i class="fas fa-place-of-worship"></i></span>
            <h3 id="churchNameDisplay">{{ $defaultLocation->name ?? '' }}</h3>
          </div>
          <div class="church-address">
            <i class="fas fa-map-pin"></i>
            <span id="churchAddressDisplay">{{ $defaultLocation->address ?? '' }}</span>
          </div>
          <div class="action-row">
            <a href="{{ $defaultLocation->maps_link ?? '#' }}" id="openMapsBtn" class="btn-open-maps" target="_blank" rel="noopener noreferrer">
              <i class="fas fa-map"></i> Open in Google Maps
            </a>
            <span class="church-meta" id="churchMetaDisplay">
              <i class="fas fa-clock"></i> Service: {{ $defaultLocation->service_time ?? '' }}
            </span>
          </div>
          <!-- VISIT US BUTTON - REMOVED target="_blank" -->
          <div class="visit-row" style="margin-top: 12px;">
            @php
              $defaultVisitLink = ($defaultLocation->visit_link ?? null)
                ?: (($defaultLocation->pastor_id ?? null) ? route('pastor.show', $defaultLocation->pastor_id) : '#');
            @endphp
            <a href="{{ $defaultVisitLink }}" id="visitUsBtn" class="btn-visit-us">
              <i class="fas fa-hand-wave"></i> Meet Our Pastor
            </a>
          </div>
          @if($defaultLocation && $defaultLocation->pastor)
            <div style="margin-top: 10px; font-size: 0.9rem; color: #666; text-align: center;">
              <i class="fas fa-user-pastor"></i> Pastored by: <strong>{{ $defaultLocation->pastor->name }}</strong>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
  {{-- ─── CONTACT ─────────────────────────────────────────────── --}}
  <section class="contact" id="contact">
    <div class="contact-card">
      <div class="info-side">
        <div class="info-header">
          <h3><i class="fas fa-hands-praying"></i> We're here for you</h3>
          <p>Whether you need prayer, want to know more about our church, or plan to visit — our community is ready to welcome you.</p>
        </div>
        <div class="info-block">
          <p><i class="fas fa-pray"></i> <span class="highlight">Prayer requests</span> — our team prays daily.</p>
          <p style="margin-top:.7rem"><i class="fas fa-church"></i> <span class="highlight">Visit us</span> — Sundays at 10am, all are welcome.</p>
          <p style="margin-top:.7rem"><i class="fas fa-question-circle"></i> <span class="highlight">New here?</span> We'd love to connect with you.</p>
        </div>
        <div class="info-footer">
          <div class="small-note">
            <i class="fas fa-phone-alt"></i>
            <span>{{ $settings->contact_phone ?? '+1 (555) 234-5678' }} · {{ $settings->contact_email ?? 'office@church.org' }}</span>
          </div>
          <div class="small-note" style="margin-top:.4rem">
            <i class="fas fa-map-pin"></i>
            <span>{{ $settings->contact_address ?? '123 Peaceful Lane, Graceville' }}</span>
          </div>
          <div class="contact-meta">
            <span><i class="fas fa-clock"></i> {{ $settings->contact_hours ?? 'Mon–Fri 9am–4pm' }}</span>
            <span><i class="fas fa-globe"></i> {{ $settings->contact_website ?? 'church.org/visit' }}</span>
          </div>
          <div class="bottom-tags">
            <span><i class="fas fa-hand-holding-heart"></i> prayer</span>
            <span><i class="fas fa-users"></i> community</span>
            <span><i class="fas fa-cross"></i> faith</span>
          </div>
        </div>
      </div>

      {{-- Contact form stays the same --}}
      <div class="form-side">
        <h2><i class="fas fa-pen-fancy"></i> Get in touch</h2>
        <div class="sub-head">We would love to hear from you.</div>
        <div class="we-love">
          <i class="fas fa-heart" style="color:#b89b7b;"></i>
          Whether you need prayer, want to know more, or visit — we're here.
        </div>
        @if(session('contact_success'))
          <div class="alert alert-success" style="display:none">{{ session('contact_success') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger" style="display:none">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('contact.store') }}" method="POST" class="cnci-minimal-form">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label for="name">Name <span class="required-star">*</span></label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Your name" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
            </div>
          </div>
          <div class="form-group">
            <div class="subject-label">
              <label for="subject">Subject</label>
              <span>Get in touch with Us</span>
            </div>
            <input type="text" id="subject" name="subject" placeholder="How can we help?" value="{{ old('subject', 'Prayer / Visit') }}">
          </div>
          <div class="form-group">
            <label for="message">Message <span class="required-star">*</span></label>
            <textarea id="message" name="message" placeholder="Write your message…" required>{{ old('message') }}</textarea>
          </div>
          <button type="submit" class="submit-btn">
            Send message
          </button>
        </form>
      </div>
    </div>
  </section>

  @include('layouts.partials.public-footer')

  {{-- Bible verse modal — random verse on every landing open --}}
  <div class="verse-modal" id="verseModal" role="dialog" aria-modal="true" aria-labelledby="verseModalText" hidden>
    <div class="verse-modal__backdrop" data-verse-close></div>
    <div class="verse-modal__panel">
      <button type="button" class="verse-modal__x" data-verse-close aria-label="Close">&times;</button>
      <p class="verse-modal__eyebrow">Word for today</p>
      <div class="verse-modal__ornament" aria-hidden="true"></div>
      <p class="verse-modal__text" id="verseModalText"></p>
      <p class="verse-modal__ref" id="verseModalRef"></p>
      <button type="button" class="verse-modal__close" data-verse-close>Amen</button>
    </div>
  </div>

  @include('layouts.partials.public-scripts')
  @include('layouts.partials.cnci-ui')

  <!-- ─── SCRIPTS ─────────────────────────────────────────────── -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      once: true, // animation only once
      mirror: false,
      disable: 'mobile' // optional: disable on mobile (set to false if you want)
    });



    /* ── 1. Swiper init ── */
    const swiper = new Swiper('.swiper', {
      loop: false,
      speed: 900,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      mousewheel: false,
      keyboard: {
        enabled: true
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      grabCursor: true,
    });

    /* ── 2. Manual wheel handler ─────────────────────────────── */
    const swiperContainer = document.querySelector('.swiper-wrapper-container');
    let scrollLocked = false;

    swiperContainer.addEventListener('wheel', function(e) {
      const atLast = swiper.activeIndex === swiper.slides.length - 1;
      const atFirst = swiper.activeIndex === 0;

      if (e.deltaY > 0 && atLast) return;
      if (e.deltaY < 0 && atFirst) return;

      e.preventDefault();

      if (scrollLocked) return;
      scrollLocked = true;
      e.deltaY > 0 ? swiper.slideNext() : swiper.slidePrev();
      setTimeout(() => {
        scrollLocked = false;
      }, 950);
    }, {
      passive: false
    });

    /* ── 4. Scroll indicator ─────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function() {
      const indicator = document.createElement('div');
      indicator.className = 'scroll-indicator';
      indicator.innerHTML = `
        <p>Scroll</p>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
             stroke="rgba(255,255,255,.55)" stroke-width="2">
          <path d="M7 10l5 5 5-5"/>
        </svg>`;
      swiperContainer.insertAdjacentElement('afterend', indicator);

      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          indicator.style.opacity = entry.isIntersecting ? '0' : '1';
        });
      }, {
        threshold: 0.1
      });
      observer.observe(document.getElementById('mission'));

      swiper.on('slideChange', () => {
        const isLast = swiper.activeIndex === swiper.slides.length - 1;
        indicator.style.opacity = isLast ? '0.6' : '1';
      });
    });
    (function() {
      // ----- church data (extended with all provided iframes & links) -----
      const churchData = {
        rosales: {
          name: 'Christ New Creation International · Rosales',
          address: 'Rosales, Pangasinan, Philippines',
          mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3837.0513024851025!2d120.64179077490043!3d15.90638298474974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33913b1ea64d2437%3A0xa9d03b507bc51ee1!2sChrist%20New%20Creation%20International%20%7C%20Rosales!5e0!3m2!1sen!2sph!4v1781717613592!5m2!1sen!2sph',
          mapsLink: 'https://www.google.com/maps?q=Christ+New+Creation+International+Rosales+Pangasinan',
          meta: 'Sun 10:00 AM'
        },
        urdaneta: {
          name: 'Christ New Creation International · Urdaneta',
          address: 'Urdaneta, Pangasinan, Philippines',
          mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61406.70293008173!2d120.4825107486328!3d15.860857500000012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391383892c264c3%3A0x75e133f10beda15a!2sChrist%20New%20Creation%20International!5e0!3m2!1sen!2sph!4v1781718333411!5m2!1sen!2sph',
          mapsLink: 'https://www.google.com/maps?q=Christ+New+Creation+International+Urdaneta+Pangasinan',
          meta: 'Sun 9:30 AM'
        },
        san_manuel: {
          name: 'Christ New Creation International · San Manuel',
          address: 'San Manuel, Pangasinan, Philippines',
          mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61435.760322104186!2d120.84853984863275!3d15.765150900000025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3390d7fecb3397ad%3A0x9b7fc92500fbe7bb!2sChrist%20New%20Creation%20International!5e0!3m2!1sen!2sph!4v1781718354782!5m2!1sen!2sph',
          mapsLink: 'https://www.google.com/maps?q=Christ+New+Creation+International+San+Manuel+Pangasinan',
          meta: 'Sun 8:30 AM'
        },
        manila: {
          name: 'CNCI · Manila Central',
          address: 'Manila, Metro Manila, Philippines',
          mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15445.96162931244!2d120.9842195!3d14.5995124!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca03571ec38b%3A0x69b1b6e7e9d8b1e4!2sManila%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1781717613592',
          mapsLink: 'https://www.google.com/maps?q=Manila+CNCI+church',
          meta: 'Sun 9:00 AM'
        },
        cebu: {
          name: 'CNCI · Cebu City',
          address: 'Cebu City, Cebu, Philippines',
          mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125459.18772373352!2d123.8692049!3d10.3156992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9982a0d96e0a3%3A0xac84f6c7b9c8a0a1!2sCebu%20City%2C%20Cebu!5e0!3m2!1sen!2sph!4v1781717613592',
          mapsLink: 'https://www.google.com/maps?q=Cebu+City+CNCI',
          meta: 'Sun 10:30 AM'
        },
        davao: {
          name: 'CNCI · Davao City',
          address: 'Davao City, Davao del Sur, Philippines',
          mapSrc: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126277.04623899652!2d125.5487484!3d7.1907082!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f96cbe9c51ae4d%3A0x6fc0d819b6931075!2sDavao%20City%2C%20Davao%20del%20Sur!5e0!3m2!1sen!2sph!4v1781717613592',
          mapsLink: 'https://www.google.com/maps?q=Davao+City+CNCI',
          meta: 'Sun 8:00 AM'
        }
      };

      // DOM refs
      const selectEl = document.getElementById('churchSelect');
      const churchNameEl = document.getElementById('churchNameDisplay');
      const churchAddressEl = document.getElementById('churchAddressDisplay');
      const mapIframe = document.getElementById('mapIframe');
      const openMapsBtn = document.getElementById('openMapsBtn');
      const churchMetaEl = document.getElementById('churchMetaDisplay');

      // ----- helper: update UI based on selected value -----
      function updateChurch(locationKey) {
        const data = churchData[locationKey];
        if (!data) return;

        // update name, address
        churchNameEl.textContent = data.name;
        churchAddressEl.textContent = data.address;

        // update iframe src
        mapIframe.src = data.mapSrc;

        // update open maps button href
        openMapsBtn.href = data.mapsLink;

        // update meta (service time)
        if (churchMetaEl) {
          churchMetaEl.innerHTML = `<i class="fas fa-clock"></i> ${data.meta}`;
        }
      }

      // ----- event listener for dropdown -----
      selectEl.addEventListener('change', function(e) {
        const selected = e.target.value;
        updateChurch(selected);
      });

      // ----- set initial state (Rosales) -----
      selectEl.value = 'rosales';
      updateChurch('rosales');

      console.log('CNCI Church finder ready (map on left, choose on right).');
    })();
    const locations = @json($locations -> keyBy('id'));

    function updateLocation(select) {
  const option = select.options[select.selectedIndex];
  const name = option.dataset.name;
  const address = option.dataset.address;
  const maps = option.dataset.maps;
  const time = option.dataset.time;
  const embed = option.dataset.embed;
  const visitLink = option.dataset.visit || '#';
  const pastorName = option.dataset.pastorName || '';

  document.getElementById('churchNameDisplay').textContent = name;
  document.getElementById('churchAddressDisplay').textContent = address;
  document.getElementById('openMapsBtn').href = maps;
  document.getElementById('churchMetaDisplay').innerHTML = '<i class="fas fa-clock"></i> Service: ' + time;
  document.getElementById('mapIframe').src = embed;
  
  // Update Visit Us button - SAME TAB (no target="_blank")
  const visitBtn = document.getElementById('visitUsBtn');
  visitBtn.href = visitLink;
  // Remove any target attribute if it exists
  visitBtn.removeAttribute('target');
  
  // Update pastor name display
  const pastorDisplay = document.querySelector('.church-card > div:last-child');
  if (pastorDisplay && pastorName) {
    pastorDisplay.innerHTML = `<i class="fas fa-user-pastor"></i> Pastored by: <strong>${pastorName}</strong>`;
  }
}
  </script>

  <script>
  (function () {
    const verses = [
      { text: 'For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.', ref: 'John 3:16' },
      { text: 'I can do all things through Christ who strengthens me.', ref: 'Philippians 4:13' },
      { text: 'The Lord is my shepherd; I shall not want.', ref: 'Psalm 23:1' },
      { text: 'Trust in the Lord with all your heart and lean not on your own understanding.', ref: 'Proverbs 3:5' },
      { text: 'Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.', ref: 'Joshua 1:9' },
      { text: 'Come to me, all you who are weary and burdened, and I will give you rest.', ref: 'Matthew 11:28' },
      { text: 'Jesus said to him, “I am the way and the truth and the life. No one comes to the Father except through me.”', ref: 'John 14:6' },
      { text: 'And we know that in all things God works for the good of those who love him.', ref: 'Romans 8:28' },
      { text: 'The Lord bless you and keep you; the Lord make his face shine on you and be gracious to you.', ref: 'Numbers 6:24–25' },
      { text: 'Delight yourself in the Lord, and he will give you the desires of your heart.', ref: 'Psalm 37:4' },
      { text: 'Cast all your anxiety on him because he cares for you.', ref: '1 Peter 5:7' },
      { text: 'Your word is a lamp to my feet and a light to my path.', ref: 'Psalm 119:105' },
      { text: 'But seek first his kingdom and his righteousness, and all these things will be given to you as well.', ref: 'Matthew 6:33' },
      { text: 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.', ref: 'Philippians 4:6' },
      { text: 'Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!', ref: '2 Corinthians 5:17' },
      { text: 'Love is patient, love is kind. It does not envy, it does not boast, it is not proud.', ref: '1 Corinthians 13:4' },
      { text: 'This is the day that the Lord has made; let us rejoice and be glad in it.', ref: 'Psalm 118:24' },
      { text: 'Let your light shine before others, that they may see your good deeds and glorify your Father in heaven.', ref: 'Matthew 5:16' },
      { text: 'God is our refuge and strength, an ever-present help in trouble.', ref: 'Psalm 46:1' },
      { text: 'He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.', ref: 'Micah 6:8' },
      { text: 'Go therefore and make disciples of all nations… teaching them to obey everything I have commanded you.', ref: 'Matthew 28:19–20' },
      { text: 'The name of the Lord is a fortified tower; the righteous run to it and are safe.', ref: 'Proverbs 18:10' },
      { text: 'Create in me a clean heart, O God, and renew a right spirit within me.', ref: 'Psalm 51:10' },
      { text: 'Faith comes from hearing, and hearing through the word of Christ.', ref: 'Romans 10:17' },
      { text: 'Be still, and know that I am God.', ref: 'Psalm 46:10' },
      { text: 'Greater love has no one than this: to lay down one’s life for one’s friends.', ref: 'John 15:13' },
      { text: 'The joy of the Lord is your strength.', ref: 'Nehemiah 8:10' },
      { text: 'Ask and it will be given to you; seek and you will find; knock and the door will be opened to you.', ref: 'Matthew 7:7' },
      { text: 'In the beginning God created the heavens and the earth.', ref: 'Genesis 1:1' },
      { text: 'Blessed are the peacemakers, for they will be called children of God.', ref: 'Matthew 5:9' },
    ];

    const modal = document.getElementById('verseModal');
    const textEl = document.getElementById('verseModalText');
    const refEl = document.getElementById('verseModalRef');
    if (!modal || !textEl || !refEl) return;

    const LAST_KEY = 'cnci-last-verse-ref';

    function pickVerse() {
      let last = '';
      try { last = sessionStorage.getItem(LAST_KEY) || ''; } catch (e) {}
      const pool = verses.filter((v) => v.ref !== last);
      const list = pool.length ? pool : verses;
      const verse = list[Math.floor(Math.random() * list.length)];
      try { sessionStorage.setItem(LAST_KEY, verse.ref); } catch (e) {}
      return verse;
    }

    function openModal() {
      const verse = pickVerse();
      textEl.textContent = '“' + verse.text + '”';
      refEl.textContent = '— ' + verse.ref;
      modal.hidden = false;
      requestAnimationFrame(function () {
        modal.classList.add('is-open');
        document.body.classList.add('verse-modal-open');
      });
    }

    function closeModal() {
      modal.classList.remove('is-open');
      document.body.classList.remove('verse-modal-open');
      setTimeout(function () {
        modal.hidden = true;
      }, 320);
    }

    modal.querySelectorAll('[data-verse-close]').forEach(function (el) {
      el.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) {
        closeModal();
      }
    });

    // Show on every landing page open
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function () {
        setTimeout(openModal, 450);
      });
    } else {
      setTimeout(openModal, 450);
    }
  })();
  </script>

</body>

</html>