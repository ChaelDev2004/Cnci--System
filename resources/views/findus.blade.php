<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>CNCI Church</title>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    /* ─── RESET & BASE ─────────────────────────────────────────── */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      overflow-x: hidden;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
      background: #fff;
    }

    img {
      max-width: 100%;
      display: block;
    }

    a {
      text-decoration: none;
    }

    /* ─── SCROLL & LAYOUT ─────────────────────────────────────── */
    .swiper-wrapper-container {
      position: relative;
      overflow: hidden;
      height: 100vh;
      width: 100%;
    }

    .swiper {
      height: 100vh;
      width: 100%;
    }

    .swiper-slide {
      height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
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

      0%,
      60%,
      100% {
        transform: translateY(0);
      }

      30% {
        transform: translateY(-6px);
      }
    }

    /* ─── HERO BANNER (Rosales) ───────────────────────────────── */
    .hero-banner {
      position: relative;
      min-height: 420px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      padding: 60px 20px;
    }

    .hero-banner-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .hero-banner-bg img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    .hero-banner-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.55);
      z-index: 1;
    }

    .hero-banner-content {
      position: relative;
      z-index: 2;
      max-width: 900px;
      text-align: center;
      color: #fff;
    }

    .hero-banner-title {
      font-family: 'Inter', sans-serif;
      font-weight: 700;
      font-size: clamp(32px, 5vw, 48px);
      letter-spacing: 0.01em;
      margin-bottom: 24px;
    }

    .hero-banner-text {
      font-family: 'Inter', sans-serif;
      font-weight: 400;
      font-size: 15px;
      line-height: 1.8;
      color: rgba(255, 255, 255, 0.9);
    }

    /* ─── FIND US ─────────────────────────────────────────────── */
    .findUs {
      min-height: 50vh;
      padding: 80px 20px;
      background: #f8f6f2;
      color: #1e1e1e;
      position: relative;
      z-index: 1;
      margin-top: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      display: flex;
      flex-wrap: wrap;
      max-width: 1200px;
      width: 100%;
      background: #fff;
      border-radius: 28px;
      overflow: hidden;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
    }

    .card-left {
      flex: 1 1 50%;
      min-height: 320px;
      background: #eae7e0;
    }

    .map-wrapper {
      width: 100%;
      height: 100%;
      min-height: 320px;
    }

    .map-wrapper iframe {
      width: 100%;
      height: 100%;
      min-height: 320px;
      border: 0;
      display: block;
    }

    .card-right {
      flex: 1 1 50%;
      padding: 40px 36px;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .badge {
      display: inline-block;
      background: #d1202a;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      padding: 6px 16px;
      border-radius: 40px;
      letter-spacing: 0.4px;
      margin-bottom: 16px;
    }

    .card-header h2 {
      font-size: 30px;
      margin-bottom: 10px;
      color: #1e1e1e;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .card-header p {
      color: #555;
      font-size: 15px;
      line-height: 1.6;
      margin-bottom: 24px;
    }

    .location-selector {
      margin-bottom: 20px;
    }

    .location-selector label {
      display: block;
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 6px;
      color: #1e1e1e;
    }

    .location-selector select {
      width: 100%;
      padding: 14px 18px;
      border-radius: 40px;
      border: 1px solid #ddd;
      font-size: 15px;
      background: #fff;
      color: #1e1e1e;
      outline: none;
      transition: 0.2s;
      cursor: pointer;
    }

    .location-selector select:focus {
      border-color: #d1202a;
      box-shadow: 0 0 0 3px rgba(209, 32, 42, 0.15);
    }

    .church-card {
      background: #f8f6f2;
      border-radius: 20px;
      padding: 20px 24px;
      margin-top: 6px;
    }

    .church-name {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
    }

    .church-name h3 {
      font-size: 18px;
      color: #1e1e1e;
    }

    .pin-icon {
      color: #d1202a;
      font-size: 20px;
    }

    .church-address {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #444;
      font-size: 14px;
      margin-bottom: 14px;
    }

    .church-address i {
      color: #024886;
      width: 20px;
    }

    .action-row {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 16px;
      margin-top: 4px;
    }

    .btn-open-maps {
      background: #024886;
      color: #fff;
      padding: 10px 22px;
      border-radius: 40px;
      font-weight: 500;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: 0.2s;
    }

    .btn-open-maps:hover {
      background: #013a6b;
    }

    .church-meta {
      color: #555;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .church-meta i {
      color: #d1202a;
    }

    /* ─── CONTACT ─────────────────────────────────────────────── */
    .contact {
      min-height: 100vh;
      padding: 80px 20px;
      background: #f0ede7;
      color: #1e1e1e;
      position: relative;
      z-index: 1;
      margin-top: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .contact-card {
      display: flex;
      flex-wrap: wrap;
      max-width: 1200px;
      width: 100%;
      background: #fff;
      border-radius: 28px;
      overflow: hidden;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
    }

    .info-side {
      flex: 1 1 45%;
      background: #024886;
      padding: 48px 40px;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .info-header h3 {
      font-size: 28px;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info-header p {
      font-size: 15px;
      line-height: 1.7;
      opacity: 0.85;
      margin-bottom: 28px;
    }

    .info-block p {
      font-size: 15px;
      line-height: 1.6;
      margin-bottom: 0.4rem;
    }

    .highlight {
      color: #f5c542;
      font-weight: 500;
    }

    .info-footer {
      margin-top: 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.15);
      padding-top: 24px;
    }

    .small-note {
      font-size: 14px;
      opacity: 0.8;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .contact-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      margin-top: 12px;
      font-size: 14px;
      opacity: 0.8;
    }

    .bottom-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 16px;
    }

    .bottom-tags span {
      background: rgba(255, 255, 255, 0.12);
      padding: 4px 16px;
      border-radius: 30px;
      font-size: 13px;
    }

    /* form side */
    .form-side {
      flex: 1 1 55%;
      padding: 48px 40px;
      background: #fff;
    }

    .form-side h2 {
      font-size: 28px;
      margin-bottom: 4px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: #1e1e1e;
    }

    .sub-head {
      font-size: 14px;
      color: #777;
      margin-bottom: 12px;
    }

    .we-love {
      background: #f8f6f2;
      padding: 12px 18px;
      border-radius: 12px;
      font-size: 14px;
      color: #1e1e1e;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
    }

    .form-group {
      flex: 1 1 100%;
      margin-bottom: 16px;
    }

    .form-group label {
      display: block;
      font-weight: 500;
      font-size: 14px;
      margin-bottom: 4px;
      color: #1e1e1e;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px 16px;
      border-radius: 12px;
      border: 1px solid #ddd;
      font-size: 15px;
      transition: 0.2s;
      background: #fafafa;
      font-family: inherit;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #024886;
      outline: none;
      box-shadow: 0 0 0 3px rgba(2, 72, 134, 0.1);
      background: #fff;
    }

    .form-group textarea {
      min-height: 120px;
      resize: vertical;
    }

    .subject-label {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 4px;
    }

    .subject-label span {
      font-size: 13px;
      color: #888;
    }

    .required-star {
      color: #d1202a;
    }

    .submit-btn {
      background: #d1202a;
      color: #fff;
      border: none;
      padding: 14px 32px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
      transition: 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-top: 6px;
    }

    .submit-btn:hover {
      background: #b01b23;
      transform: scale(1.02);
    }

    /* ─── FOOTER ────────────────────────────────────────────────── */
    .footer {
      background: #0f172a;
      color: #fff;
      padding: 60px 30px 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .main-logo img {
      width: 80px;
      height: auto;
      margin-bottom: 16px;
    }

    .line-horizontal {
      width: 60px;
      height: 2px;
      background: #d1202a;
      margin: 16px auto 24px;
    }

    .footer-nav-links {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 40px 60px;
      max-width: 1000px;
      width: 100%;
      margin-bottom: 20px;
    }

    .footer-nav-links ul {
      list-style: none;
      display: flex;
      flex-wrap: wrap;
      gap: 20px 32px;
      padding: 0;
    }

    .footer-nav-links ul li a {
      color: #ccc;
      font-weight: 400;
      font-size: 15px;
      transition: 0.2s;
    }

    .footer-nav-links ul li a:hover {
      color: #fff;
    }

    .other-info h3 {
      font-size: 15px;
      font-weight: 500;
      color: #aaa;
      margin-top: 12px;
    }

    .other-info p {
      color: #ddd;
      font-size: 14px;
    }

    .socmed {
      margin-top: 20px;
    }

    .example-2 {
      display: flex;
      justify-content: center;
      gap: 20px;
      list-style: none;
      padding: 0;
    }

    .icon-content a {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: #1e293b;
      color: #fff;
      transition: 0.2s;
    }

    .icon-content a:hover {
      background: #d1202a;
      transform: translateY(-4px);
    }

    .icon-content svg {
      width: 24px;
      height: 24px;
    }

    .tooltip {
      position: absolute;
      bottom: -28px;
      background: #1e293b;
      color: #fff;
      font-size: 11px;
      padding: 2px 10px;
      border-radius: 12px;
      opacity: 0;
      pointer-events: none;
      transition: 0.2s;
    }

    .icon-content a:hover .tooltip {
      opacity: 1;
    }

    /* ─── SWIPER SLIDE STYLES (minimal) ──────────────────────── */
    .bg-video,
    .bg-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
      object-fit: cover;
    }

    .bg-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .vignette {
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at center, transparent 40%, rgba(0, 0, 0, 0.45));
      z-index: 1;
    }

    .slide-inner {
      position: relative;
      z-index: 2;
      max-width: 800px;
      padding: 20px 30px;
      color: #fff;
      text-align: center;
    }

    .hero-h1 {
      font-size: clamp(36px, 6vw, 64px);
      font-weight: 700;
      line-height: 1.1;
      margin-bottom: 16px;
    }

    .hero-sub {
      font-size: 18px;
      opacity: 0.9;
      max-width: 600px;
      margin: 0 auto 28px;
      line-height: 1.6;
    }

    .btn-primary {
      background: #d1202a;
      border: none;
      padding: 14px 40px;
      border-radius: 40px;
      font-weight: 600;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-primary:hover {
      background: #b01b23;
      transform: scale(1.03);
    }

    .eyebrow {
      font-size: 13px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      opacity: 0.7;
      margin-bottom: 10px;
    }

    .slide2-h1 {
      font-size: clamp(32px, 5vw, 56px);
      font-weight: 700;
      line-height: 1.1;
      margin-bottom: 12px;
    }

    .slide2-p {
      font-size: 16px;
      opacity: 0.9;
      max-width: 500px;
      margin: 0 auto 20px;
      line-height: 1.6;
    }

    .btn-glass {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      padding: 12px 32px;
      border-radius: 40px;
      color: #fff;
      font-weight: 500;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-glass:hover {
      background: rgba(255, 255, 255, 0.25);
    }

    .service-badge {
      margin-top: 18px;
      font-size: 14px;
      opacity: 0.7;
      background: rgba(0, 0, 0, 0.3);
      display: inline-block;
      padding: 6px 18px;
      border-radius: 40px;
    }

    .divider {
      width: 60px;
      height: 2px;
      background: #d1202a;
      margin: 14px auto 18px;
    }

    .testimonial {
      position: absolute;
      bottom: 60px;
      right: 40px;
      z-index: 3;
      max-width: 280px;
      color: rgba(255, 255, 255, 0.8);
      font-style: italic;
      font-size: 14px;
      line-height: 1.5;
      background: rgba(0, 0, 0, 0.3);
      padding: 16px 20px;
      border-radius: 16px;
      backdrop-filter: blur(4px);
    }

    /* ─── NAV ──────────────────────────────────────────────────── */
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
    }

    .mob-links a:hover {
      opacity: 1;
    }

    .mob-menu-footer {
      color: rgba(255, 255, 255, 0.4);
      font-size: 14px;
      text-align: center;
    }

    /* ─── RESPONSIVE ──────────────────────────────────────────── */
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

      .card-left,
      .card-right,
      .info-side,
      .form-side {
        flex: 1 1 100%;
      }

      .card-right {
        padding: 28px 20px;
      }

      .info-side {
        padding: 32px 24px;
      }

      .form-side {
        padding: 32px 24px;
      }

      .hero-banner {
        min-height: 300px;
        padding: 40px 16px;
      }

      .findUs {
        padding: 50px 16px;
      }

      .contact {
        padding: 50px 16px;
      }
    }

    @media (max-width: 480px) {
      .nav-brand {
        font-size: 16px;
      }

      .hero-h1 {
        font-size: 28px;
      }

      .slide2-h1 {
        font-size: 28px;
      }
    }
  </style>
</head>

<body>
  <nav>
    <div class="nav-inner">
      <img class="nav-logo" src="https://placehold.co/80x80/1e293b/fff?text=CNCI" alt="CNCI Logo">
      <a href="#" class="nav-brand">CNCI <span class="nav-brand-highlight">Rosales</span></a>
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">Gallery</a></li>
        <li><a href="#">Events</a></li>
        <li><a href="#findUs">Find Us</a></li>
      </ul>
      <a href="#" class="nav-cta">Plan a Visit</a>
      <button class="nav-burger" id="burgerBtn1" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
  <!-- MOBILE MENU OVERLAY -->
  <div class="mob-menu" id="mobMenu">
    <a href="#" class="mob-menu-brand">CNCI</a>
    <button class="mob-menu-close" id="mobClose" aria-label="Close">
      <svg viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
      </svg>
    </button>
    <ul class="mob-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">Gallery</a></li>
      <li><a href="#">Events</a></li>
      <li><a href="#findUs">Find Us</a></li>
    </ul>
    <div class="mob-menu-footer">
      <p>Sunday Services</p>
      <p><span>9:00 AM</span> &nbsp;&amp;&nbsp; <span>11:00 AM</span></p>
      <p style="margin-top:8px;color:rgba(255,255,255,0.22);">Plan a Visit &rarr;</p>
    </div>
  </div>

  {{-- ─── SWIPER ──────────────────────────────────────────────── --}}
  <div class="swiper-wrapper-container">
    <div class="swiper">
      <div class="swiper-wrapper">

        <!-- SLIDE 1: welcome layout -->
        <div class="swiper-slide">
          <div class="bg-image">
            <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=1200&h=800&fit=crop" alt="Church interior">
          </div>
          <div class="vignette"></div>
          <div class="slide-inner">
            <div class="eyebrow">Welcome Home</div>
            <h1 class="slide2-h1">Christ New Creation<br>International</h1>
            <div class="divider"></div>
            <p class="slide2-p">A place where faith, hope, and love grow.</p>
            <div class="slide2-actions">
              <button class="btn-glass" onclick="window.location='#'">Plan Your Visit</button>
            </div>
            <div class="service-badge">Sunday 9:00 AM &amp; 11:00 AM</div>
          </div>
        </div>

        <!-- SLIDE 2: default layout with testimonial -->
        <div class="swiper-slide">
          <div class="bg-image">
            <img src="https://images.unsplash.com/photo-1438032953109-d7f6b3c6b3f7?w=1200&h=800&fit=crop" alt="Worship">
          </div>
          <div class="vignette"></div>
          <div class="slide-inner">
            <div class="eyebrow">Join Us</div>
            <h1 class="hero-h1">Worship &amp; Community</h1>
            <p class="hero-sub">Experience the love of Christ in a welcoming family.</p>
            <div class="hero-actions">
              <button class="btn-primary" onclick="window.location='#'">I'm New Here</button>
            </div>
          </div>
          <div class="testimonial">
            <p>"This church has become our second home."</p>
          </div>
        </div>

        <!-- SLIDE 3: plain background (no inner content) -->
        <div class="swiper-slide">
          <div class="bg-image">
            <img src="https://images.unsplash.com/photo-1504052434569-70ad5836ab65?w=1200&h=800&fit=crop" alt="Prayer">
          </div>
          <div class="vignette"></div>
          <!-- no slide-inner -> just background -->
        </div>

      </div>
      <!-- pagination (optional) -->
      <div class="swiper-pagination"></div>
    </div>
  </div>

  {{-- ─── ROSALES BANNER ──────────────────────────────────────── --}}
  <section class="hero-banner">
    <div class="hero-banner-bg">
      <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=1200&h=600&fit=crop" alt="CNCI Rosales building">
    </div>
    <div class="hero-banner-overlay"></div>
    <div class="hero-banner-content">
      <h2 class="hero-banner-title">CNCI Rosales</h2>
      <p class="hero-banner-text">A vibrant church family in the heart of Pangasinan. We are committed to sharing the love of Jesus, building strong communities, and raising disciples who make a difference. Join us as we worship, grow, and serve together.</p>
    </div>
  </section>

  {{-- ─── FIND US ─────────────────────────────────────────────── --}}
  <section class="findUs" id="findUs">
    <div class="card">
      <div class="card-left">
        <div class="map-wrapper">
          <iframe id="mapIframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3837.0513024851025!2d120.64179077490043!3d15.90638298474974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33913b1ea64d2437%3A0xa9d03b507bc51ee1!2sChrist%20New%20Creation%20International%20%7C%20Rosales!5e0!3m2!1sen!2sph!4v1781717613592!5m2!1sen!2sph" width="600" height="400" style="border:0; width:100%;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <div class="card-right">
        <div class="card-header">
          <span class="badge"><i class="fas fa-church" style="margin-right:5px;"></i> CNCI Church</span>
          <h2><i class="fas fa-map-pin" style="font-size:1.8rem;"></i> Find a Church Near You</h2>
          <p>God created you on purpose for a purpose. At CNCI, we want to help you become the person He created you to be.</p>
        </div>
        <div class="location-section">
          <div class="location-selector">
            <label for="churchSelect"><i class="fas fa-location-dot"></i> Choose a location</label>
            <select id="churchSelect">
              <option value="rosales" selected>Rosales</option>
              <option value="urdaneta">Urdaneta</option>
              <option value="san_manuel">San Manuel</option>
              <option value="manila">Manila</option>
              <option value="cebu">Cebu</option>
              <option value="davao">Davao</option>
            </select>
          </div>
          <div class="church-card" id="churchCard">
            <div class="church-name">
              <span class="pin-icon"><i class="fas fa-place-of-worship"></i></span>
              <h3 id="churchNameDisplay">Christ New Creation International · Rosales</h3>
            </div>
            <div class="church-address">
              <i class="fas fa-map-pin"></i>
              <span id="churchAddressDisplay">Rosales, Pangasinan, Philippines</span>
            </div>
            <div class="action-row">
              <a href="https://www.google.com/maps?q=Christ+New+Creation+International+Rosales+Pangasinan" id="openMapsBtn" class="btn-open-maps" target="_blank" rel="noopener noreferrer">
                <i class="fas fa-map"></i> Open in Google Maps
              </a>
              <span class="church-meta" id="churchMetaDisplay">
                <i class="fas fa-clock"></i> Sun 10:00 AM
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ─── CONTACT ─────────────────────────────────────────────── --}}
  <section class="contact">
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
            <span>+1 (555) 234-5678 · office@church.org</span>
          </div>
          <div class="small-note" style="margin-top:.4rem">
            <i class="fas fa-map-pin"></i>
            <span>123 Peaceful Lane, Graceville</span>
          </div>
          <div class="contact-meta">
            <span><i class="fas fa-clock"></i> Mon–Fri 9am–4pm</span>
            <span><i class="fas fa-globe"></i> church.org/visit</span>
          </div>
          <div class="bottom-tags">
            <span><i class="fas fa-hand-holding-heart"></i> prayer</span>
            <span><i class="fas fa-users"></i> community</span>
            <span><i class="fas fa-cross"></i> faith</span>
          </div>
        </div>
      </div>

      <div class="form-side">
        <h2><i class="fas fa-pen-fancy"></i> Get in touch</h2>
        <div class="sub-head">We would love to hear from you.</div>
        <div class="we-love">
          <i class="fas fa-heart" style="color:#b89b7b;"></i>
          Whether you need prayer, want to know more, or visit — we're here.
        </div>
        <form>
          <div class="form-row">
            <div class="form-group">
              <label for="name"><i class="fas fa-user"></i> Name <span class="required-star">*</span></label>
              <input type="text" id="name" placeholder="Your name" required>
            </div>
            <div class="form-group">
              <label for="email"><i class="fas fa-envelope"></i> Email</label>
              <input type="email" id="email" placeholder="you@example.com">
            </div>
          </div>
          <div class="form-group">
            <div class="subject-label">
              <label for="subject"><i class="fas fa-tag"></i> Subject</label>
              <span>Get in touch with Us</span>
            </div>
            <input type="text" id="subject" placeholder="How can we help?" value="Prayer / Visit">
          </div>
          <div class="form-group">
            <label for="message"><i class="fas fa-comment-dots"></i> Message <span class="required-star">*</span></label>
            <textarea id="message" placeholder="Write your message…" required></textarea>
          </div>
          <button type="submit" class="submit-btn">
            <i class="fas fa-paper-plane"></i> SUBMIT
          </button>
        </form>
      </div>
    </div>
  </section>

  <section class="footer">
    <div class="main-logo">
      <img src="https://placehold.co/80x80/1e293b/fff?text=CNCI" alt="CNCI Logo">
    </div>
    <div class="line-horizontal"></div>
    <div class="footer-nav-links">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Portfolio</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <div class="other-info">
        <h3>Email:</h3>
        <p>cnciregion1@gmail.com</p>
        <h3>Location:</h3>
        <p>Region 1, Philippines</p>
        <div class="socmed">
          <ul class="example-2">
            <li class="icon-content">
              <a data-social="spotify" aria-label="Spotify" href="#">
                <div class="filled"></div>
                <svg viewBox="0 0 100 100" version="1.1">
                  <path fill="currentColor" d="M50,4C24.7,4,4,24.7,4,50s20.6,46,46,46s46-20.6,46-46S75.4,4,50,4z M71.6,71.5c0,0,0,0.1-0.1,0.1c-0.8,1.2-2,1.8-3.2,1.8  c-0.7,0-1.4-0.2-2-0.6c-10.2-6.3-23.3-7.7-38.8-4.1c-2.1,0.6-4-0.9-4.5-2.7c-0.6-2.3,0.9-4.1,2.7-4.6c17.7-4,32.6-2.3,44.4,5  c0.9,0.4,1.5,1,1.8,1.9C72.2,69.3,72.1,70.5,71.6,71.5z M76.9,59.3L76.9,59.3c-0.8,1.1-1.9,1.9-3.2,2.1c-0.2,0-0.5,0.1-0.7,0.1  c-0.8,0-1.6-0.3-2.3-0.7c-12-7.3-30.1-9.4-43.9-5c-2.5,0.6-5-0.7-5.6-3c-0.6-2.5,0.7-4.9,3-5.5c16.5-5,37.2-2.5,51.4,6.2  c0.8,0.4,1.5,1.3,1.8,2.5C77.9,57,77.6,58.3,76.9,59.3z M83.2,45.6c-1,1.4-2.7,2.1-4.4,2.1c-0.9,0-1.9-0.2-2.7-0.7c0,0,0,0,0,0  c-13.9-8.3-37.8-9.3-51.4-5.1c-2.7,0.8-5.5-0.7-6.4-3.3c-0.8-2.7,0.7-5.6,3.3-6.4c16.2-4.8,43-3.8,59.8,6.2  C83.8,39.6,84.7,42.9,83.2,45.6C83.3,45.5,83.3,45.5,83.2,45.6z"></path>
                </svg>
              </a>
              <div class="tooltip">Spotify</div>
            </li>
            <li class="icon-content">
              <a data-social="pinterest" aria-label="Pinterest" href="#">
                <div class="filled"></div>
                <svg viewBox="0 0 100 100" version="1.1">
                  <path fill="currentColor" d="M83,17.8C74.5,8.9,63.4,4.3,50,4.1C37.7,4.2,26.8,8.6,17.9,17.3C8.9,26,4.3,37,4.1,50c0,0,0,0,0,0c0,9.1,2.5,17.4,7.4,24.9  c4.9,7.4,11.6,13.2,20.1,17.1c0.3,0.1,0.7,0.1,1-0.1c0.3-0.2,0.5-0.5,0.5-0.8l0-4.9c0.1-2.1,0.7-5.3,1.7-9.5c1-4,1.7-6.7,1.9-7.6  c0.7-3,1.7-7.2,3-12.6c0.1-0.2,0-0.5-0.1-0.7c-0.4-0.8-1-2.6-1.5-6.6c0.1-2.7,0.8-5.2,2.1-7.3c1.2-2,3.1-3.1,5.7-3.5  c2,0.1,4.7,0.8,5.1,5.9c-0.1,1.8-0.8,4.5-1.9,8.1c-1.2,3.8-1.9,6.3-2.1,7.6c-0.7,2.5-0.2,4.8,1.5,6.8c1.6,1.9,3.8,2.9,6.5,3.1  c4.3-0.1,8.1-2.6,11.2-7.5c1.7-3,2.9-6.3,3.5-9.7c0.7-3.4,0.7-7.1,0-10.8c-0.7-3.8-2.2-7.1-4.5-9.8c0,0-0.1-0.1-0.1-0.1  c-4.3-3.7-9.5-5.3-15.6-5c-6,0.4-11.3,2.6-15.9,6.6c-2.9,3.2-4.8,7.1-5.7,11.6c-0.9,4.6,0,9.1,2.6,13.3c0.3,0.5,0.5,0.8,0.6,1  c0,0.3,0,1-0.5,2.8c-0.5,1.8-0.9,2.2-0.9,2.2c0,0-0.1,0-0.1,0.1c0,0-0.2,0-0.4-0.1c-2.2-1-3.9-2.4-5.2-4.2c-1.3-1.9-2.1-4-2.5-6.3  c-0.3-2.5-0.4-5-0.3-7.5c0.2-2.5,0.7-5.1,1.4-7.7c3-6.9,8.5-11.9,16.3-14.8c7.8-2.9,16-3.2,24.3-0.8c6.5,2.8,11,7.4,13.6,13.7  c2.5,6.4,2.8,13.4,0.8,20.8c-2.2,7.1-6.4,12.4-12.1,15.7c-5.6,2.8-10.8,3-15.7,0.7c-1.8-1.1-3.1-2.3-3.9-3.5c-0.2-0.3-0.6-0.5-1-0.5  c-0.4,0.1-0.7,0.3-0.8,0.7c-0.7,2.7-1.3,4.7-1.6,6.2c-1.4,5.4-2.6,9.2-3.4,11c-0.8,1.6-1.6,3.1-2.4,4.3c-0.2,0.3-0.2,0.6-0.1,0.9  s0.3,0.5,0.6,0.6c4.3,1.3,8.7,2,13,2c12.4-0.1,23.2-4.6,32.1-13.4C91.1,73.9,95.8,62.9,96,50C95.9,37.5,91.5,26.7,83,17.8z"></path>
                </svg>
              </a>
              <div class="tooltip">Pinterest</div>
            </li>
            <li class="icon-content">
              <a data-social="dribbble" aria-label="Dribbble" href="#">
                <div class="filled"></div>
                <svg viewBox="0 0 100 100" version="1.1">
                  <path fill="currentColor" d="M83.5,18.5C74.9,9.3,62.8,4,50.2,4c-6.1,0-12,1.1-17.6,3.4C15.2,14.5,4,31.3,4,50c0,13.9,6.2,26.9,17,35.7  C29.2,92.3,39.4,96,50,96c6.6,0,13.2-1.5,19.2-4.2c12.5-5.7,21.7-16.6,25.2-29.8C95.5,57.9,96,53.8,96,50  C96,38.3,91.6,27.1,83.5,18.5z M75,22.3c-0.7,0.9-1.4,1.8-2.1,2.6c-1.4,1.6-2.8,3-4.4,4.3c-0.3,0.3-0.6,0.6-1,0.8  c-1,0.9-2.1,1.7-3.2,2.5l-0.3,0.2c-1.1,0.7-2.2,1.5-3.5,2.2c-0.4,0.3-0.9,0.5-1.4,0.8c-0.8,0.5-1.7,0.9-2.7,1.4  c-0.6,0.3-1.2,0.5-1.8,0.8L54.3,38c-0.1,0-0.2,0.1-0.3,0.1c0,0,0,0,0,0c-1.3-2.6-2.4-4.9-3.5-7l-0.3-0.5c-1.1-2-2.2-4-3.3-6  l-0.7-1.3c-1.1-1.9-2.2-3.7-3.2-5.4l-0.7-1.1c-0.7-1.2-1.4-2.3-2.2-3.5c3.2-0.8,6.5-1.3,9.8-1.3c9.4,0,18.4,3.5,25.4,9.8  C75.3,21.9,75.2,22.1,75,22.3z M46.4,40.6c-1.4,0.4-2.9,0.8-4.4,1.1c-0.3,0-0.7,0.1-0.9,0.2c-6,1-12.5,1.4-19.4,1.1  c-0.3,0-0.6,0-0.9,0c-0.3,0-0.5,0-0.7,0c-2.5-0.2-4.9-0.4-7.2-0.7c2.3-11.2,9.6-20.9,19.8-26.1c2.1,3.3,4.2,6.7,6.3,10.3l0.4,0.7  c0.9,1.6,1.9,3.4,3.2,5.8l0.6,1.2C44.4,36.6,45.4,38.6,46.4,40.6z M24.4,51.1c2.2,0.1,4.2,0,6.2-0.1l0.7,0c0.4,0,0.9,0,1.3,0  c2.8-0.2,5.5-0.5,8.5-1c0.5-0.1,1-0.2,1.6-0.3l0.5-0.1c2.2-0.4,4.2-0.9,6.1-1.4c0.1,0,0.3-0.1,0.4-0.1l0.5,1.1  c1.2,2.8,2.3,5.5,3.3,8.1c0,0,0,0,0,0c-0.2,0.1-0.5,0.2-0.7,0.2c-2,0.6-4,1.4-5.9,2.2c-0.6,0.3-1.3,0.5-1.9,0.8  c-1.4,0.6-2.7,1.3-4.1,2.1l-0.3,0.2c-0.2,0.1-0.5,0.2-0.6,0.4c-1.5,0.9-3.1,1.9-4.7,3c-0.2,0.1-0.4,0.3-0.6,0.4  c-0.2,0.1-0.4,0.3-0.6,0.5c-1,0.7-2,1.5-3,2.3c-0.4,0.3-0.7,0.6-1.1,0.9l-0.3,0.3c-0.7,0.6-1.5,1.3-2.2,1.9l-0.2,0.2  c-0.4,0.4-0.7,0.7-1.1,1.1l-0.2,0.2c-0.6,0.6-1.3,1.3-2,2l-0.4,0.4c-0.2,0.2-0.4,0.4-0.5,0.6C16.1,69.9,12,60.2,12,50.3  c0,0,0.1,0,0.1,0c0.4,0,0.7,0,1.1,0.1c3.5,0.4,6.9,0.6,10.3,0.7C23.8,51,24.1,51.1,24.4,51.1z M29.5,81.9c0.2-0.2,0.3-0.4,0.5-0.5  c1-1.1,2-2.1,3-3c1.9-1.8,3.8-3.3,5.7-4.8c0.2-0.1,0.4-0.3,0.6-0.4c0.2-0.2,0.5-0.4,0.8-0.6c1.1-0.8,2.2-1.5,3.4-2.2  c0.1-0.1,0.2-0.1,0.3-0.2c0.1-0.1,0.2-0.1,0.3-0.2c1.4-0.8,2.9-1.6,4.5-2.3c0.3-0.1,0.6-0.2,0.8-0.4l0.6-0.3  c1.1-0.5,2.2-0.9,3.5-1.4c0.5-0.2,1.1-0.4,1.7-0.6l0.2-0.1c0.4-0.1,0.7-0.2,1.1-0.3c0,0,0,0,0,0c1.1,3.2,2.3,6.4,3.3,9.8l0.1,0.4  c1.1,3.6,2,7.3,2.9,10.8C51.7,89.8,39.3,88.3,29.5,81.9C29.4,81.9,29.4,81.9,29.5,81.9z M65.6,62.9c0.7-0.1,1.3-0.2,2-0.2  c2-0.2,4-0.2,5.9-0.2c0.2,0,0.4,0,0.6,0l0.2,0c2.2,0.1,4.6,0.3,6.9,0.6c0.4,0.1,0.9,0.1,1.3,0.2l0.6,0.1c0.7,0.1,1.5,0.3,2.2,0.4  c-3,7.6-8.3,14-15.2,18.3c-0.8-3.1-1.7-6.2-2.6-9.2l-0.1-0.4c-0.9-3-1.9-6.1-3.1-9.5C64.8,63.1,65.2,63,65.6,62.9z M81.6,55.2  C80,55,78.4,54.9,77,54.8l-0.9-0.1c-0.9-0.1-1.9-0.1-2.8-0.2c-0.2,0-0.3,0-0.5,0c-0.2,0-0.4,0-0.6,0c-2,0-3.9,0.1-5.9,0.3  c-0.2,0-0.3,0-0.5,0.1c-0.1,0-0.2,0-0.3,0c-1.3,0.1-2.6,0.3-3.9,0.5c-0.1-0.1-0.1-0.3-0.2-0.4c-0.1-0.2-0.2-0.5-0.3-0.7  c-1.1-2.9-2.3-5.7-3.2-7.8l-0.3-0.6c-0.1-0.1-0.1-0.3-0.2-0.4c0,0,0,0,0.1,0c0.2-0.1,0.5-0.2,0.7-0.3c0.6-0.2,1.2-0.5,1.8-0.8  c1.2-0.5,2.4-1.2,3.6-1.8c0.1-0.1,0.3-0.2,0.5-0.2c0.2-0.1,0.5-0.2,0.7-0.4c1.5-0.9,2.9-1.8,4.2-2.7l0.3-0.2  c0.2-0.1,0.4-0.3,0.6-0.4c0.9-0.6,1.9-1.4,2.8-2.2c1.5-1.2,2.9-2.5,4.3-4c0.8-0.8,1.5-1.6,2.2-2.4l0.4-0.5c0.5-0.5,0.9-1.1,1.3-1.6  C85.5,34.3,88,42.1,88,50c0,2-0.2,4.1-0.5,6.1c-0.3,0-0.6-0.1-0.8-0.1c-0.4-0.1-0.7-0.1-1.1-0.2l-1.1-0.2  C83.5,55.5,82.5,55.3,81.6,55.2z"></path>
                </svg>
              </a>
              <div class="tooltip">Dribbble</div>
            </li>
            <li class="icon-content">
              <a data-social="telegram" aria-label="Telegram" href="#">
                <div class="filled"></div>
                <svg viewBox="0 0 100 100" version="1.1">
                  <path fill="currentColor" d="M95,9.9c-1.3-1.1-3.4-1.2-7-0.1c0,0,0,0,0,0c-2.5,0.8-24.7,9.2-44.3,17.3c-17.6,7.3-31.9,13.7-33.6,14.5  c-1.9,0.6-6,2.4-6.2,5.2c-0.1,1.8,1.4,3.4,4.3,4.7c3.1,1.6,16.8,6.2,19.7,7.1c1,3.4,6.9,23.3,7.2,24.5c0.4,1.8,1.6,2.8,2.2,3.2  c0.1,0.1,0.3,0.3,0.5,0.4c0.3,0.2,0.7,0.3,1.2,0.3c0.7,0,1.5-0.3,2.2-0.8c3.7-3,10.1-9.7,11.9-11.6c7.9,6.2,16.5,13.1,17.3,13.9  c0,0,0.1,0.1,0.1,0.1c1.9,1.6,3.9,2.5,5.7,2.5c0.6,0,1.2-0.1,1.8-0.3c2.1-0.7,3.6-2.7,4.1-5.4c0-0.1,0.1-0.5,0.3-1.2  c3.4-14.8,6.1-27.8,8.3-38.7c2.1-10.7,3.8-21.2,4.8-26.8c0.2-1.4,0.4-2.5,0.5-3.2C96.3,13.5,96.5,11.2,95,9.9z M30,58.3l47.7-31.6  c0.1-0.1,0.3-0.2,0.4-0.3c0,0,0,0,0,0c0.1,0,0.1-0.1,0.2-0.1c0.1,0,0.1,0,0.2-0.1c-0.1,0.1-0.2,0.4-0.4,0.6L66,38.1  c-8.4,7.7-19.4,17.8-26.7,24.4c0,0,0,0,0,0.1c0,0-0.1,0.1-0.1,0.1c0,0,0,0.1-0.1,0.1c0,0.1,0,0.1-0.1,0.2c0,0,0,0.1,0,0.1  c0,0,0,0,0,0.1c-0.5,5.6-1.4,15.2-1.8,19.5c0,0,0,0,0-0.1C36.8,81.4,31.2,62.3,30,58.3z"></path>
                </svg>
              </a>
              <div class="tooltip">Telegram</div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ─── SCRIPTS ─────────────────────────────────────────────── -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      mirror: false,
      disable: 'mobile'
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

    /* ── 3. Mobile menu ──────────────────────────────────────── */
    const mobMenu = document.getElementById('mobMenu');
    const mobClose = document.getElementById('mobClose');
    const burgers = [
      document.getElementById('burgerBtn1'),
    ];

    function openMenu() {
      mobMenu.classList.add('open');
      burgers.forEach(b => b && b.classList.add('open'));
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      mobMenu.classList.remove('open');
      burgers.forEach(b => b && b.classList.remove('open'));
      document.body.style.overflow = '';
    }

    burgers.forEach(b => b && b.addEventListener('click', () =>
      mobMenu.classList.contains('open') ? closeMenu() : openMenu()
    ));
    mobClose.addEventListener('click', closeMenu);
    mobMenu.addEventListener('click', e => {
      if (e.target === mobMenu) closeMenu();
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeMenu();
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

      // we removed #mission, so observe the hero-banner instead
      const target = document.querySelector('.hero-banner') || document.body;
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          indicator.style.opacity = entry.isIntersecting ? '0' : '1';
        });
      }, {
        threshold: 0.1
      });
      observer.observe(target);

      swiper.on('slideChange', () => {
        const isLast = swiper.activeIndex === swiper.slides.length - 1;
        indicator.style.opacity = isLast ? '0.6' : '1';
      });
    });

    /* ── 5. Find Us / Map dropdown ───────────────────────────── */
    (function() {
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

      const selectEl = document.getElementById('churchSelect');
      const churchNameEl = document.getElementById('churchNameDisplay');
      const churchAddressEl = document.getElementById('churchAddressDisplay');
      const mapIframe = document.getElementById('mapIframe');
      const openMapsBtn = document.getElementById('openMapsBtn');
      const churchMetaEl = document.getElementById('churchMetaDisplay');

      function updateChurch(locationKey) {
        const data = churchData[locationKey];
        if (!data) return;
        churchNameEl.textContent = data.name;
        churchAddressEl.textContent = data.address;
        mapIframe.src = data.mapSrc;
        openMapsBtn.href = data.mapsLink;
        if (churchMetaEl) {
          churchMetaEl.innerHTML = `<i class="fas fa-clock"></i> ${data.meta}`;
        }
      }

      selectEl.addEventListener('change', function(e) {
        updateChurch(e.target.value);
      });

      // initial
      selectEl.value = 'rosales';
      updateChurch('rosales');
    })();
  </script>
</body>

</html>