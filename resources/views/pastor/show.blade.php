<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pastor->name }} - CNCI Church</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* ─── RESET & BASE ─── */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
      background: #f0f2f5;
      color: #1a1a1a;
      padding-top: 80px;
      /* space for fixed nav */
    }

    /* ─── NAV (from landing page) ─────────────────────────────── */
    nav {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      width: 100%;
    }

    .nav-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 32px;
      max-width: 1600px;
      margin: 0 auto;
      gap: 20px;
      background: linear-gradient(to right, #d1202a, #024886);
    }

    .nav-logo {
      height: 40px;
      width: auto;
    }

    .nav-brand {
      font-weight: 600;
      font-size: 20px;
      color: #fff;
      letter-spacing: -0.02em;
      margin-right: auto;
    }

    .nav-brand-highlight {
      color: #f5c542;
    }

    .nav-links {
      display: flex;
      gap: 28px;
      list-style: none;
    }

    .nav-links a {
      color: rgba(255, 255, 255, 0.8);
      font-size: 14px;
      font-weight: 500;
      transition: 0.2s;
      text-decoration: none;
    }

    .nav-links a:hover {
      color: #fff;
    }

    .nav-cta {
      background: #f5c542;
      color: #1e1e1e;
      padding: 8px 22px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 14px;
      transition: 0.2s;
      text-decoration: none;
    }

    .nav-cta:hover {
      background: #e6b330;
    }

    .nav-burger {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 6px;
    }

    .nav-burger span {
      width: 26px;
      height: 2px;
      background: #fff;
      border-radius: 4px;
      transition: 0.3s;
    }

    /* mobile menu */
    .mob-menu {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background: #0f172a;
      z-index: 2000;
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .mob-menu.open {
      display: flex;
    }

    .mob-menu-brand {
      font-size: 28px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 30px;
      letter-spacing: -0.02em;
    }

    .mob-menu-close {
      position: absolute;
      top: 24px;
      right: 28px;
      background: transparent;
      border: none;
      width: 36px;
      height: 36px;
      cursor: pointer;
    }

    .mob-menu-close svg {
      width: 100%;
      height: 100%;
      stroke: #fff;
      stroke-width: 2;
    }

    .mob-links {
      list-style: none;
      text-align: center;
      margin-bottom: 40px;
    }

    .mob-links li {
      margin: 18px 0;
    }

    .mob-links a {
      color: #fff;
      font-size: 22px;
      font-weight: 400;
      opacity: 0.8;
      text-decoration: none;
    }

    .mob-links a:hover {
      opacity: 1;
    }

    .mob-menu-footer {
      color: rgba(255, 255, 255, 0.4);
      font-size: 14px;
      text-align: center;
    }

    /* ─── PASTOR DETAIL ─────────────────────────────────────────── */
    .pastor-detail-page {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .pastor-detail-card {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    /* ─── BACK BUTTON ─── */
    .back-button-wrap {
      padding: 20px 30px 0;
    }

    .back-button {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: #2d7c3a;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s;
      padding: 8px 16px;
      border-radius: 50px;
      background: #f0f7f0;
    }

    .back-button:hover {
      background: #2d7c3a;
      color: #fff;
      transform: translateX(-4px);
    }

    /* ─── HERO / HEADER ─── */
    .pastor-hero {
      background: linear-gradient(145deg, #1a3a2a 0%, #2d5a3a 100%);
      padding: 40px 50px 30px;
      color: #fff;
      position: relative;
    }

    .pastor-hero::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #f5b042, #e8a838, #f5b042);
    }

    .pastor-hero-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 15px;
    }

    .pastor-hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.12);
      padding: 6px 18px;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      color: #f5b042;
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .pastor-hero-badge i {
      font-size: 0.9rem;
    }

    .pastor-hero-title {
      font-size: 2.4rem;
      font-weight: 800;
      margin: 12px 0 4px;
      letter-spacing: -0.5px;
    }

    .pastor-hero-sub {
      font-size: 1.1rem;
      opacity: 0.85;
      font-weight: 400;
    }

    .pastor-hero-sub i {
      margin-right: 8px;
      color: #f5b042;
    }

    /* ─── GRID LAYOUT ─── */
    .pastor-grid {
      display: grid;
      grid-template-columns: 320px 1fr;
      gap: 40px;
      padding: 40px 50px;
    }

    /* ─── LEFT COLUMN ─── */
    .pastor-image-wrapper {
      position: relative;
    }

    .pastor-image-wrapper img {
      width: 100%;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      object-fit: cover;
      aspect-ratio: 1/1;
    }

    .pastor-image-placeholder {
      width: 100%;
      aspect-ratio: 1/1;
      background: linear-gradient(135deg, #2d7c3a, #1a5a2a);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255, 255, 255, 0.3);
      font-size: 100px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .pastor-role-badge {
      display: inline-block;
      margin-top: 16px;
      padding: 8px 20px;
      background: #2d7c3a;
      color: #fff;
      border-radius: 50px;
      font-size: 0.85rem;
      font-weight: 600;
      text-align: center;
      width: 100%;
    }

    .pastor-role-badge i {
      margin-right: 8px;
    }

    /* Social Icons under image */
    .pastor-social-compact {
      display: flex;
      gap: 10px;
      margin-top: 16px;
      justify-content: center;
    }

    .pastor-social-compact a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      color: #fff;
      font-size: 1rem;
      transition: all 0.3s;
      text-decoration: none;
    }

    .pastor-social-compact a:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .pastor-social-compact .fb {
      background: #1877f2;
    }

    .pastor-social-compact .ig {
      background: #e4405f;
    }

    .pastor-social-compact .yt {
      background: #ff0000;
    }

    .pastor-social-compact .em {
      background: #555;
    }

    /* ─── RIGHT COLUMN ─── */
    .section-block {
      margin-bottom: 28px;
    }

    .section-block:last-child {
      margin-bottom: 0;
    }

    .section-label {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #2d7c3a;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section-label::after {
      content: '';
      flex: 1;
      height: 2px;
      background: linear-gradient(90deg, #2d7c3a, transparent);
    }

    .section-label i {
      font-size: 1rem;
    }

    .section-content {
      color: #444;
      line-height: 1.8;
      font-size: 1rem;
    }

    .section-content p {
      margin-bottom: 10px;
    }

    .section-content p:last-child {
      margin-bottom: 0;
    }

    /* ─── LOCATION INFO ─── */
    .location-info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-top: 4px;
    }

    .location-info-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      background: #f8f9fa;
      border-radius: 12px;
      transition: all 0.3s;
    }

    .location-info-item:hover {
      background: #eef3ee;
    }

    .location-info-item i {
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #2d7c3a;
      color: #fff;
      border-radius: 50%;
      font-size: 0.85rem;
      flex-shrink: 0;
    }

    .location-info-item .label {
      font-size: 0.75rem;
      color: #888;
      display: block;
    }

    .location-info-item .value {
      font-weight: 600;
      color: #1a1a1a;
      display: block;
      font-size: 0.95rem;
    }

    .location-info-item .value a {
      color: #2d7c3a;
      text-decoration: none;
    }

    .location-info-item .value a:hover {
      text-decoration: underline;
    }

    /* ─── SERVICE SCHEDULE TABLE ─── */
    .schedule-table-wrap {
      overflow-x: auto;
      margin-top: 8px;
      border-radius: 12px;
      border: 1px solid #e8ece8;
    }

    .schedule-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.95rem;
    }

    .schedule-table thead {
      background: #f0f7f0;
    }

    .schedule-table th {
      text-align: left;
      padding: 12px 18px;
      font-weight: 700;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #2d7c3a;
      border-bottom: 2px solid #dce8dc;
    }

    .schedule-table td {
      padding: 12px 18px;
      border-bottom: 1px solid #eef3ee;
      color: #333;
    }

    .schedule-table tbody tr:last-child td {
      border-bottom: none;
    }

    .schedule-table tbody tr:hover {
      background: #f8fbf8;
    }

    .schedule-table .service-name {
      font-weight: 600;
    }

    .schedule-table .service-time {
      color: #2d7c3a;
      font-weight: 600;
    }

    .schedule-table .service-day {
      color: #888;
      font-size: 0.85rem;
    }

    /* ─── ACTION BUTTONS ─── */
    .action-buttons {
      display: flex;
      gap: 14px;
      margin-top: 30px;
      flex-wrap: wrap;
    }

    .btn-primary-custom {
      padding: 12px 32px;
      background: linear-gradient(135deg, #2d7c3a, #1a5a2a);
      color: #fff;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      border: none;
      cursor: pointer;
      font-size: 0.95rem;
    }

    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(45, 124, 58, 0.35);
      color: #fff;
      text-decoration: none;
    }

    .btn-secondary-custom {
      padding: 12px 32px;
      background: transparent;
      color: #2d7c3a;
      border: 2px solid #2d7c3a;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-size: 0.95rem;
    }

    .btn-secondary-custom:hover {
      background: #2d7c3a;
      color: #fff;
      text-decoration: none;
      transform: translateY(-2px);
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 820px) {

      .nav-links,
      .nav-cta {
        display: none;
      }

      .nav-burger {
        display: flex;
      }

      .nav-inner {
        padding: 14px 20px;
      }
    }

    @media (max-width: 992px) {
      .pastor-grid {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 30px;
      }

      .pastor-image-wrapper img,
      .pastor-image-placeholder {
        max-width: 320px;
        margin: 0 auto;
      }

      .pastor-hero-title {
        font-size: 2rem;
      }
    }

    @media (max-width: 768px) {
      body {
        padding-top: 70px;
      }

      .pastor-detail-page {
        margin: 20px auto;
        padding: 0 12px;
      }

      .pastor-grid {
        padding: 20px;
      }

      .pastor-hero {
        padding: 30px 20px 25px;
      }

      .pastor-hero-title {
        font-size: 1.6rem;
      }

      .location-info-grid {
        grid-template-columns: 1fr;
      }

      .action-buttons {
        flex-direction: column;
      }

      .action-buttons a {
        justify-content: center;
      }

      .schedule-table th,
      .schedule-table td {
        padding: 10px 14px;
        font-size: 0.85rem;
      }

      .back-button-wrap {
        padding: 16px 20px 0;
      }
    }

    @media (max-width: 480px) {
      .pastor-hero-title {
        font-size: 1.3rem;
      }

      .pastor-hero-sub {
        font-size: 0.95rem;
      }

      .pastor-grid {
        padding: 16px;
      }

      .schedule-table-wrap {
        font-size: 0.8rem;
      }

      .schedule-table th,
      .schedule-table td {
        padding: 8px 10px;
      }
    }
  </style>
</head>

<body>

  <!-- ─── NAV (from landing page) ─────────────────────────────── -->
  <nav>
    <div class="nav-inner">
      <img class="nav-logo" src="{{ asset('images/logo.png') }}" alt="CNCI Logo">
      <a href="{{ url('/') }}" class="nav-brand">CNCI <span class="nav-brand-highlight">Rosales</span></a>
      <ul class="nav-links">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/') }}#gallery">Gallery</a></li>
        <li><a href="{{ url('/') }}#events">Events</a></li>
        <li><a href="{{ url('/') }}#findUs">Find Us</a></li>
      </ul>
      <a href="{{ url('/') }}#findUs" class="nav-cta">Plan a Visit</a>
      <button class="nav-burger" id="burgerBtn1" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <!-- MOBILE MENU OVERLAY -->
  <div class="mob-menu" id="mobMenu">
    <a href="{{ url('/') }}" class="mob-menu-brand">CNCI</a>
    <button class="mob-menu-close" id="mobClose" aria-label="Close">
      <svg viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
      </svg>
    </button>
    <ul class="mob-links">
      <li><a href="{{ url('/') }}">Home</a></li>
      <li><a href="{{ url('/') }}#gallery">Gallery</a></li>
      <li><a href="{{ url('/') }}#events">Events</a></li>
      <li><a href="{{ url('/') }}#findUs">Find Us</a></li>
    </ul>
    <div class="mob-menu-footer">
      <p>Sunday Services</p>
      @if($pastor->locations->count() > 0)
      <p>
        @foreach($pastor->locations as $index => $location)
        @if($location->service_time)
        <span>{{ preg_replace('/^[A-Za-z]+\s*/', '', $location->service_time) }}</span>
        @if(!$loop->last) &amp; @endif
        @endif
        @endforeach
      </p>
      @else
      <p><span>9:00 AM</span> &nbsp;&amp;&nbsp; <span>11:00 AM</span></p>
      @endif
      <p style="margin-top:8px;color:rgba(255,255,255,0.22);">
        <a href="{{ url('/') }}#findUs" style="color:rgba(255,255,255,0.4); text-decoration:none;">Plan a Visit &rarr;</a>
      </p>
    </div>
  </div>

  <!-- ─── PASTOR DETAIL ─────────────────────────────────────────── -->
  <div class="pastor-detail-page">
    <div class="pastor-detail-card">

      <!-- ─── BACK BUTTON ─── -->
      <div class="back-button-wrap">
        <a href="{{ url('/') }}#findUs" class="back-button">
          <i class="fas fa-arrow-left"></i> Back to Locations
        </a>
      </div>

      <!-- ─── HERO ─── -->
      <div class="pastor-hero">
        <div class="pastor-hero-top">
          <span class="pastor-hero-badge">
            <i class="fas fa-cross"></i> CNCI Church
          </span>
          <span style="font-size:0.85rem; opacity:0.7;">
            <i class="fas fa-calendar-alt"></i>
            @if($pastor->created_at)
            Since {{ $pastor->created_at->format('Y') }}
            @else
            Since 2005
            @endif
          </span>
        </div>
        <h1 class="pastor-hero-title">{{ $pastor->name }}</h1>
        <div class="pastor-hero-sub">
          <i class="fas fa-church"></i> {{ $pastor->church }}
        </div>
      </div>

      <!-- ─── MAIN GRID ─── -->
      <div class="pastor-grid">

        <!-- ─── LEFT COLUMN ─── -->
        <div class="pastor-image-wrapper">
          @if($pastor->image)
          <img src="{{ asset('storage/' . $pastor->image) }}" alt="{{ $pastor->name }}" loading="lazy">
          @else
          <div class="pastor-image-placeholder">
            <i class="fas fa-user-pastor"></i>
          </div>
          @endif

          @if($pastor->role)
          <div class="pastor-role-badge">
            <i class="fas fa-user-tie"></i> {{ $pastor->role }}
          </div>
          @endif

          <!-- Social Icons Compact -->
          <div class="pastor-social-compact">
            @if($pastor->facebook)
            <a href="{{ $pastor->facebook }}" target="_blank" rel="noopener" class="fb" title="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            @endif
            @if($pastor->instagram)
            <a href="{{ $pastor->instagram }}" target="_blank" rel="noopener" class="ig" title="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
            @endif
            @if($pastor->youtube)
            <a href="{{ $pastor->youtube }}" target="_blank" rel="noopener" class="yt" title="YouTube">
              <i class="fab fa-youtube"></i>
            </a>
            @endif
            @if($pastor->email)
            <a href="mailto:{{ $pastor->email }}" class="em" title="Email">
              <i class="fas fa-envelope"></i>
            </a>
            @endif
          </div>
        </div>

        <!-- ─── RIGHT COLUMN ─── -->
        <div class="pastor-details">

          <!-- ─── RESIDENT PASTOR ─── -->
          <div class="section-block">
            <div class="section-label">
              <i class="fas fa-user-pastor"></i> Resident Pastor
            </div>
            <div class="section-content">
              <p><strong>{{ $pastor->name }}</strong> @if($pastor->role)– {{ $pastor->role }}@endif</p>
              <p style="color:#666; font-size:0.95rem;">
                {{ $pastor->church }} • {{ $pastor->locations->count() }} location(s)
              </p>
            </div>
          </div>

          <!-- ─── BIO ─── -->
          @if($pastor->bio)
          <div class="section-block">
            <div class="section-label">
              <i class="fas fa-book-open"></i> About
            </div>
            <div class="section-content">
              <p>{{ $pastor->bio }}</p>
            </div>
          </div>
          @endif

          <!-- ─── LOCATION / CONTACT ─── -->
          <div class="section-block">
            <div class="section-label">
              <i class="fas fa-map-pin"></i> Location &amp; Contact
            </div>
            <div class="location-info-grid">
              @if($pastor->email)
              <div class="location-info-item">
                <i class="fas fa-envelope"></i>
                <div>
                  <span class="label">Email</span>
                  <span class="value">
                    <a href="mailto:{{ $pastor->email }}">{{ $pastor->email }}</a>
                  </span>
                </div>
              </div>
              @endif
              @if($pastor->phone)
              <div class="location-info-item">
                <i class="fas fa-phone"></i>
                <div>
                  <span class="label">Phone</span>
                  <span class="value">
                    <a href="tel:{{ $pastor->phone }}">{{ $pastor->phone }}</a>
                  </span>
                </div>
              </div>
              @endif
              @if($pastor->locations->first())
              <div class="location-info-item">
                <i class="fas fa-church"></i>
                <div>
                  <span class="label">Church</span>
                  <span class="value">{{ $pastor->locations->first()->name }}</span>
                </div>
              </div>
              <div class="location-info-item">
                <i class="fas fa-map-pin"></i>
                <div>
                  <span class="label">Address</span>
                  <span class="value">{{ $pastor->locations->first()->address }}</span>
                </div>
              </div>
              @endif
            </div>
          </div>

          <!-- ─── SERVICE SCHEDULE ─── -->
          @if($pastor->locations->count() > 0)
          <div class="section-block">
            <div class="section-label">
              <i class="fas fa-clock"></i> Service Schedule
            </div>
            <div class="schedule-table-wrap">
              <table class="schedule-table">
                <thead>
                  <tr>
                    <th>Service</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Location</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pastor->locations as $location)
                  <tr>
                    <td class="service-name">
                      <i class="fas fa-place-of-worship" style="color:#2d7c3a; margin-right:8px;"></i>
                      {{ $location->name }}
                    </td>
                    <td class="service-day">
                      @php
                      $day = 'Sunday';
                      if($location->service_time) {
                      $day = preg_replace('/\s*\d{1,2}:\d{2}\s*[AP]M.*$/i', '', $location->service_time);
                      $day = trim($day) ?: 'Sunday';
                      }
                      @endphp
                      {{ $day }}
                    </td>
                    <td class="service-time">
                      @if($location->service_time)
                      {{ preg_replace('/^[A-Za-z]+\s*/', '', $location->service_time) }}
                      @else
                      10:00 AM
                      @endif
                    </td>
                    <td style="color:#666; font-size:0.9rem;">
                      {{ $location->city }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif

          <!-- ─── ACTION BUTTONS ─── -->
          <div class="action-buttons">
            <a href="{{ url('/') }}#findUs" class="btn-primary-custom">
              <i class="fas fa-church"></i> Visit Our Church
            </a>
            <a href="{{ url('/') }}#findUs" class="btn-secondary-custom">
              <i class="fas fa-arrow-left"></i> Back to Locations
            </a>
          </div>

        </div>
        <!-- /right column -->

      </div>
      <!-- /grid -->

    </div>
    <!-- /card -->
  </div>
  <!-- /page -->

  <!-- ─── MOBILE MENU SCRIPT ───────────────────────────────────── -->
  <script>
    (function() {
      const mobMenu = document.getElementById('mobMenu');
      const mobClose = document.getElementById('mobClose');
      const burger = document.getElementById('burgerBtn1');

      function openMenu() {
        mobMenu.classList.add('open');
        document.body.style.overflow = 'hidden';
      }

      function closeMenu() {
        mobMenu.classList.remove('open');
        document.body.style.overflow = '';
      }

      if (burger) {
        burger.addEventListener('click', function(e) {
          e.stopPropagation();
          mobMenu.classList.contains('open') ? closeMenu() : openMenu();
        });
      }

      if (mobClose) {
        mobClose.addEventListener('click', closeMenu);
      }

      if (mobMenu) {
        mobMenu.addEventListener('click', function(e) {
          if (e.target === mobMenu) closeMenu();
        });
      }

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMenu();
      });

      // Close menu when a link is clicked
      document.querySelectorAll('.mob-links a').forEach(function(link) {
        link.addEventListener('click', closeMenu);
      });
    })();
  </script>

</body>

</html>