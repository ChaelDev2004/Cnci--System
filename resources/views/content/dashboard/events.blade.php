<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $siteSettings->brandName() }} · Events</title>
  <link rel="icon" href="{{ $siteSettings->faviconUrl() }}" />

  <!-- Google Fonts & Font Awesome -->
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  @include('layouts.partials.public-styles')

  <style>
    /* ─── RESET / BASE ─────────────────────────────────────────── */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
      background: #f8f6f0;
    }

    /* ─── NAV (legacy, do not target shared .public-nav) ───────── */
    nav:not(.public-nav) {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      width: 100%;
      background: linear-gradient(to right, #d1202a, #024886);
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    }

    .nav-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 32px;
      max-width: 1400px;
      margin: 0 auto;
      gap: 24px;
    }

    .nav-brand {
      font-family: 'Raleway', sans-serif;
      font-size: 1.4rem;
      font-weight: 400;
      color: #fff;
      letter-spacing: 0.04em;
      text-decoration: none;
    }

    .nav-logo {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: -300px;
    }

    .nav-brand-highlight {
      color: #f5d47b;
    }

    .nav-links {
      display: flex;
      list-style: none;
      gap: 28px;
    }

    .nav-links a {
      color: rgba(255, 255, 255, 0.85);
      text-decoration: none;
      font-size: 0.95rem;
      font-weight: 500;
      transition: 0.2s;
    }

    .nav-links a:hover {
      color: #fff;
    }

    .nav-burger {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 4px;
    }

    .nav-burger span {
      width: 26px;
      height: 2.5px;
      background: #fff;
      border-radius: 4px;
      transition: 0.3s;
    }

    .nav-burger.open span:nth-child(1) {
      transform: rotate(45deg) translate(5px, 5px);
    }

    .nav-burger.open span:nth-child(2) {
      opacity: 0;
    }

    .nav-burger.open span:nth-child(3) {
      transform: rotate(-45deg) translate(5px, -5px);
    }

    /* ── MOBILE MENU OVERLAY ── */
    .mob-menu {
      position: fixed;
      inset: 0;
      z-index: 50;
      background: rgba(4, 4, 4, 0.97);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.4s ease;
    }

    .mob-menu.open {
      opacity: 1;
      pointer-events: all;
    }

    .mob-menu-brand {
      position: absolute;
      top: 26px;
      left: 24px;
      font-family: 'Instrument Serif', serif;
      font-size: 1.4rem;
      color: rgba(255, 255, 255, 0.35);
      letter-spacing: 0.04em;
      text-decoration: none;
    }

    .mob-menu-close {
      position: absolute;
      top: 22px;
      right: 24px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 0.5px solid rgba(255, 255, 255, 0.18);
      background: rgba(255, 255, 255, 0.07);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s;
    }

    .mob-menu-close:hover {
      background: rgba(255, 255, 255, 0.16);
    }

    .mob-menu-close svg {
      width: 15px;
      height: 15px;
      stroke: #fff;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
    }

    .mob-links {
      list-style: none;
      text-align: center;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .mob-links li {
      overflow: hidden;
    }

    .mob-links a {
      font-family: 'Instrument Serif', serif;
      font-size: clamp(2.6rem, 10vw, 4.5rem);
      font-weight: 400;
      color: #fff;
      text-decoration: none;
      letter-spacing: -0.3px;
      line-height: 1.12;
      display: inline-block;
      opacity: 0;
      transform: translateY(36px);
      transition: color 0.2s, opacity 0.5s ease, transform 0.5s ease;
    }

    .mob-menu.open .mob-links li:nth-child(1) a {
      opacity: 1;
      transform: translateY(0);
      transition-delay: 0.06s;
    }

    .mob-menu.open .mob-links li:nth-child(2) a {
      opacity: 1;
      transform: translateY(0);
      transition-delay: 0.13s;
    }

    .mob-menu.open .mob-links li:nth-child(3) a {
      opacity: 1;
      transform: translateY(0);
      transition-delay: 0.2s;
    }

    .mob-menu.open .mob-links li:nth-child(4) a {
      opacity: 1;
      transform: translateY(0);
      transition-delay: 0.27s;
    }

    .mob-links a:hover {
      color: rgba(255, 220, 140, 0.9);
    }

    .mob-menu-footer {
      position: absolute;
      bottom: 36px;
      text-align: center;
    }

    .mob-menu-footer p {
      font-size: 0.68rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.3);
      line-height: 1.9;
    }

    .mob-menu-footer span {
      color: rgba(255, 220, 140, 0.55);
    }

    /* ─── HERO (events) ────────────────────────────────────────── */
    .hero-section {
      margin-top: 0;
      width: 100%;
      height: 60vh;
      min-height: 400px;
      display: flex;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero-bg-img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 0;
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0.25) 100%);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 10;
      max-width: 1000px;
      margin: 0 auto;
      padding: 0 24px;
      color: #fff;
    }

    .hero-content h1 {
      font-size: 4.2rem;
      font-weight: 600;
      letter-spacing: -0.02em;
      margin-bottom: 12px;
    }

    .hero-content p {
      font-size: 1.3rem;
      opacity: 0.9;
      line-height: 1.6;
      max-width: 700px;
      margin: 0 auto;
    }

    /* ─── EVENTS GRID ──────────────────────────────────────────── */
    .events-section {
      padding: 80px 24px 100px;
      max-width: 1300px;
      margin: 0 auto;
    }

    .events-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px 30px;
    }

    .event-card {
      background: #fff;
      border-radius: 28px;
      overflow: hidden;
      box-shadow: 0 8px 28px rgba(0, 0, 0, 0.06);
      transition: transform 0.25s ease, box-shadow 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .event-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .event-image {
      width: 100%;
      height: 200px;
      background: #e0dcd2;
      object-fit: cover;
      display: block;
    }

    .event-body {
      padding: 24px 24px 28px;
    }

    .event-tag {
      display: inline-block;
      background: #d1202a;
      color: #fff;
      font-size: 0.7rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 4px 14px;
      border-radius: 40px;
      margin-bottom: 14px;
    }

    .event-body h3 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1e2b3a;
      margin-bottom: 8px;
      letter-spacing: -0.3px;
    }

    .event-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 12px 20px;
      font-size: 0.85rem;
      color: #4a5a6a;
      margin-bottom: 14px;
    }

    .event-meta i {
      margin-right: 6px;
      color: #024886;
      width: 16px;
    }

    .event-body p {
      color: #2c3e4e;
      line-height: 1.6;
      font-size: 0.95rem;
      margin-bottom: 18px;
    }

    .event-btn {
      display: inline-block;
      background: #024886;
      color: #fff;
      font-weight: 500;
      padding: 8px 24px;
      border-radius: 60px;
      text-decoration: none;
      font-size: 0.85rem;
      transition: background 0.2s, transform 0.15s;
    }

    .event-btn:hover {
      background: #1a5f9e;
      transform: scale(0.97);
    }

    /* ─── CTA BANNER ───────────────────────────────────────────── */
    .cta-banner {
      background: linear-gradient(135deg, #024886, #d1202a);
      padding: 60px 24px;
      text-align: center;
      color: #fff;
      margin: 20px 24px 60px;
      border-radius: 48px;
    }

    .cta-banner h2 {
      font-size: 2.6rem;
      font-weight: 600;
      letter-spacing: -0.02em;
      margin-bottom: 12px;
    }

    .cta-banner p {
      font-size: 1.2rem;
      opacity: 0.9;
      max-width: 600px;
      margin: 0 auto 28px;
      line-height: 1.6;
    }

    .cta-btn {
      background: #f5d47b;
      border: none;
      padding: 14px 44px;
      border-radius: 60px;
      font-weight: 600;
      color: #1e2b3a;
      font-size: 1rem;
      cursor: pointer;
      transition: 0.2s;
    }

    .cta-btn:hover {
      background: #ffe08a;
      transform: scale(0.97);
    }

    /* ─── FOOTER ────────────────────────────────────────────────── */
    .footer {
      background: linear-gradient(to right, #c0392b, #2c3e7a);
      display: flex;
      align-items: center;
      padding: 40px 48px 0;
      gap: 0;
      flex-wrap: wrap;
      margin: 0 auto;
      padding-left: 300px;
      padding-right: 300px;
      position: relative;
      z-index: 2;
    }

    .footer .main-logo img {
      width: 210px;
      height: 210px;
      object-fit: contain;
      border-radius: 50%;
    }

    .footer .line-horizontal {
      width: 2px;
      height: 300px;
      background: rgba(255, 255, 255, 0.35);
      margin: 0 40px;
      flex-shrink: 0;
    }

    .footer .footer-nav-links {
      display: flex;
      align-items: center;
      gap: 48px;
      flex: 1;
    }

    .footer .footer-nav-links ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .footer .footer-nav-links ul li a {
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      font-size: 30px;
      font-family: 'Inter', sans-serif;
      transition: color 0.2s;
    }

    .footer .footer-nav-links ul li a:hover {
      color: #ffffff;
      text-decoration: underline;
    }

    .footer .other-info {
      display: flex;
      flex-direction: column;
      gap: 2px;
      margin-left: auto;
    }

    .footer .other-info h3 {
      font-size: 16px;
      font-weight: 400;
      color: rgba(255, 255, 255, 0.6);
      margin: 0 0 2px;
      font-family: 'Inter', sans-serif;
    }

    .footer .other-info p {
      font-size: 16px;
      font-weight: 500;
      color: #ffffff;
      margin: 0 0 10px;
      font-family: 'Inter', sans-serif;
    }

    .socmed {
      display: flex !important;
      flex-direction: row !important;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
    }

    ul {
      list-style: none;
    }

    .example-2 {
      display: flex !important;
      flex-direction: row !important;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      padding: 0;
      margin: 0;
    }

    .example-2 .icon-content {
      margin: 0 10px;
      position: relative;
      display: inline-block;
    }

    .example-2 .icon-content .tooltip {
      position: absolute;
      top: -30px;
      left: 50%;
      transform: translateX(-50%);
      color: #fff;
      padding: 6px 10px;
      border-radius: 5px;
      opacity: 0;
      visibility: hidden;
      font-size: 14px;
      transition: all 0.3s ease;
      white-space: nowrap;
      font-family: 'Inter', sans-serif;
    }

    .example-2 .icon-content:hover .tooltip {
      opacity: 1;
      visibility: visible;
      top: -50px;
    }

    .example-2 .icon-content a {
      position: relative;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      color: #4d4d4d;
      background-color: #000;
      transition: all 0.3s ease-in-out;
      flex-shrink: 0;
    }

    .example-2 .icon-content a:hover {
      box-shadow: 3px 2px 45px 0px rgb(0 0 0 / 12%);
    }

    .example-2 .icon-content a svg {
      position: relative;
      z-index: 1;
      width: 30px;
      height: 30px;
      fill: #ffffff;
      stroke: #ffffff;
    }

    .example-2 .icon-content a:hover {
      color: white;
    }

    .example-2 .icon-content a .filled {
      position: absolute;
      top: auto;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 0;
      background-color: #000;
      transition: all 0.3s ease-in-out;
    }

    .example-2 .icon-content a:hover .filled {
      height: 100%;
    }

    .example-2 .icon-content a[data-social='spotify'] .filled,
    .example-2 .icon-content a[data-social='spotify']~.tooltip {
      background-color: #1db954;
    }

    .example-2 .icon-content a[data-social='pinterest'] .filled,
    .example-2 .icon-content a[data-social='pinterest']~.tooltip {
      background-color: #bd081c;
    }

    .example-2 .icon-content a[data-social='dribbble'] .filled,
    .example-2 .icon-content a[data-social='dribbble']~.tooltip {
      background-color: #ea4c89;
    }

    .example-2 .icon-content a[data-social='telegram'] .filled,
    .example-2 .icon-content a[data-social='telegram']~.tooltip {
      background-color: #0088cc;
    }

    .footer .footer-bottom {
      width: 100%;
      text-align: center;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.65);
      padding: 16px 0 14px;
      margin-top: 28px;
      border-top: 1px solid rgba(255, 255, 255, 0.15);
      font-family: 'Inter', sans-serif;
    }

    /* ─── RESPONSIVE ────────────────────────────────────────────── */
    @media screen and (max-width: 1200px) {
      .footer {
        padding-left: 150px;
        padding-right: 150px;
      }

      .footer .footer-nav-links ul li a {
        font-size: 26px;
      }

      .footer .line-horizontal {
        margin: 0 30px;
      }
    }

    @media screen and (max-width: 992px) {
      .footer {
        padding: 30px 40px 0;
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .footer .main-logo img {
        width: 160px;
        height: 160px;
      }

      .footer .line-horizontal {
        display: none;
      }

      .footer .footer-nav-links {
        flex-direction: column;
        gap: 20px;
        width: 100%;
        margin: 20px 0;
      }

      .footer .footer-nav-links ul {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px 30px;
      }

      .footer .footer-nav-links ul li a {
        font-size: 22px;
      }

      .footer .other-info {
        margin-left: 0;
        align-items: center;
      }

      .example-2 {
        justify-content: center;
        gap: 5px;
      }

      .example-2 .icon-content {
        margin: 0 8px;
      }

      .example-2 .icon-content a {
        width: 45px;
        height: 45px;
      }

      .example-2 .icon-content a svg {
        width: 25px;
        height: 25px;
      }

      .hero-content h1 {
        font-size: 3rem;
      }
    }

    @media screen and (max-width: 768px) {
      .footer {
        padding: 25px 20px 0;
      }

      .footer .main-logo img {
        width: 130px;
        height: 130px;
      }

      .footer .footer-nav-links ul li a {
        font-size: 18px;
      }

      .footer .other-info h3,
      .footer .other-info p {
        font-size: 14px;
      }

      .example-2 {
        justify-content: center;
        gap: 5px;
        flex-wrap: wrap;
      }

      .example-2 .icon-content {
        margin: 0 6px;
      }

      .example-2 .icon-content a {
        width: 40px;
        height: 40px;
      }

      .example-2 .icon-content a svg {
        width: 22px;
        height: 22px;
      }

      .example-2 .icon-content .tooltip {
        font-size: 12px;
        padding: 4px 8px;
      }

      .hero-content h1 {
        font-size: 2.6rem;
      }

      .cta-banner {
        margin: 20px 12px 40px;
        padding: 40px 20px;
      }

      .cta-banner h2 {
        font-size: 2rem;
      }
    }

    @media screen and (max-width: 480px) {
      .footer {
        padding: 20px 15px 0;
      }

      .footer .main-logo img {
        width: 100px;
        height: 100px;
      }

      .footer .footer-nav-links ul {
        gap: 10px 20px;
      }

      .footer .footer-nav-links ul li a {
        font-size: 16px;
      }

      .footer .other-info h3,
      .footer .other-info p {
        font-size: 12px;
      }

      .socmed {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap;
        justify-content: center;
      }

      .example-2 {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap;
        justify-content: center;
        gap: 3px;
      }

      .example-2 .icon-content {
        margin: 0 4px;
      }

      .example-2 .icon-content a {
        width: 35px;
        height: 35px;
      }

      .example-2 .icon-content a svg {
        width: 18px;
        height: 18px;
      }

      .example-2 .icon-content .tooltip {
        font-size: 10px;
        padding: 3px 6px;
        top: -25px;
      }

      .example-2 .icon-content:hover .tooltip {
        top: -40px;
      }

      .footer .footer-bottom {
        font-size: 11px;
        padding: 12px 0 10px;
      }

      .hero-content h1 {
        font-size: 2rem;
      }

      .hero-content p {
        font-size: 1rem;
      }

      .events-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 820px) {
      .nav-links {
        display: none;
      }

      .nav-burger {
        display: flex;
      }

      .nav-inner {
        padding: 12px 20px;
      }

      .nav-logo {
        margin-right: -30px;
      }
    }

    /* ─── NO EVENTS STYLES ────────────────────────────────────── */
    .no-events {
      text-align: center;
      padding: 60px 20px;
      grid-column: 1 / -1;
    }

    .no-events i {
      font-size: 4rem;
      color: #d1202a;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .no-events h3 {
      font-size: 1.8rem;
      color: #1e2b3a;
      margin-bottom: 10px;
    }

    .no-events p {
      color: #4a5a6a;
      font-size: 1.1rem;
    }

    /* ─── EVENT STATUS BADGE ───────────────────────────────────── */
    .event-status {
      display: inline-block;
      font-size: 0.65rem;
      font-weight: 600;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      padding: 3px 12px;
      border-radius: 30px;
      margin-left: 8px;
    }

    .event-status.upcoming {
      background: #28a745;
      color: #fff;
    }

    .event-status.past {
      background: #6c757d;
      color: #fff;
    }

    .event-status.today {
      background: #ffc107;
      color: #1e2b3a;
    }
  </style>
</head>

<body>

  @php $activeNav = 'events'; $fixedNav = false; @endphp
  @include('layouts.partials.public-nav')

  <!-- ─── HERO ─────────────────────────────────────────────────── -->
  <section class="hero-section">
    <img src="{{ asset('assets/img/backgrounds/events-bg.jpg') }}" alt="Events Background" class="hero-bg-img">
    <div class="hero-overlay"></div>
    <div class="hero-content" data-aos="fade-up" data-aos-duration="900">
      <h1>Upcoming Events</h1>
      <p>Gather with us for worship, fellowship, and community. There's always something happening at CNCI Rosales.</p>
    </div>
  </section>

  <!-- ─── EVENTS GRID ──────────────────────────────────────────── -->
  <section class="events-section">
    <div class="events-grid">

      @forelse($events as $event)
      <div class="event-card" data-aos="fade-up" data-aos-duration="700" data-aos-delay="{{ $loop->index * 50 }}">
        <!-- Event Image -->
        @if($event->image_url)
        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="event-image">
        @else
        <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Default event image" class="event-image">
        @endif

        <div class="event-body">
          <!-- Tag -->
          @if($event->tag)
          <span class="event-tag">{{ $event->tag }}</span>
          @endif

          <!-- Title -->
          <h3>
            {{ $event->title }}
            @if(isset($event->event_date) && $event->event_date)
            @if($event->event_date->isToday())
            <span class="event-status today">Today</span>
            @elseif($event->event_date->isFuture())
            <span class="event-status upcoming">Upcoming</span>
            @else
            <span class="event-status past">Past</span>
            @endif
            @endif
          </h3>

          <!-- Meta Information -->
          <div class="event-meta">
            @if($event->date)
            <span><i class="fas fa-calendar-alt"></i> {{ $event->date }}</span>
            @endif

            @if($event->time)
            <span><i class="fas fa-clock"></i> {{ $event->time }}</span>
            @endif

            @if($event->location)
            <span><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</span>
            @endif
          </div>

          <!-- Description -->
          <p>{{ Str::limit($event->description, 120) }}</p>

          <!-- Button -->
          <a href="{{ $event->button_url ?? '#' }}" class="event-btn">
            {{ $event->button_text ?? 'Learn More' }}
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
      @empty
      <!-- No Events -->
      <div class="no-events" data-aos="fade-up" data-aos-duration="700">
        <i class="fas fa-calendar-times"></i>
        <h3>No Events Scheduled</h3>
        <p>Check back soon for upcoming events and gatherings at CNCI Rosales.</p>
        <a href="#" class="event-btn" style="margin-top: 20px; display: inline-block;">
          <i class="fas fa-bell"></i> Get Notified
        </a>
      </div>
      @endforelse

    </div>

    <!-- Pagination (if using pagination) -->
    @if(isset($events) && is_object($events) && method_exists($events, 'links'))
    <div class="d-flex justify-content-center mt-5">
      {{ $events->links() }}
    </div>
    @endif
  </section>

  <!-- ─── CTA BANNER ─────────────────────────────────────────────── -->
  <div class="cta-banner" data-aos="zoom-in" data-aos-duration="800">
    <h2>Plan Your Visit</h2>
    <p>We'd love to welcome you in person. Let us know you're coming and we'll prepare a warm seat just for you.</p>
    <button class="cta-btn" onclick="window.location.href='{{ url('/#findUs') }}'">I'm Coming &rarr;</button>
  </div>

  @include('layouts.partials.public-footer')
  @include('layouts.partials.public-scripts')

  <!-- ─── SCRIPTS ─────────────────────────────────────────────── -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      once: true,
      mirror: false,
      disable: 'mobile'
    });


    // ── Event card hover effect ──
    document.querySelectorAll('.event-card').forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px)';
        this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.08)';
      });
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '0 8px 28px rgba(0,0,0,0.06)';
      });
    });

    // ── Smooth scroll for CTA button ──
    document.querySelector('.cta-btn')?.addEventListener('click', function() {
      const target = document.querySelector('.events-section');
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  </script>

</body>

</html>