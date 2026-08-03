<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CNCI Church · Events</title>

  <!-- Google Fonts & Font Awesome -->
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

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

    /* ─── NAV (fixed) ──────────────────────────────────────────── */
    nav {
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
      margin-top: 74px;
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

  <!-- ─── NAV ─────────────────────────────────────────────────── -->
  <nav>
    <div class="nav-inner">
      <img class="nav-logo" src="{{ asset('assets/img/avatars/cnciLogo.png') }}" alt="CNCI Logo">
      <a href="#" class="nav-brand">CNCI <span class="nav-brand-highlight">Rosales</span></a>
      <ul class="nav-links">
        <li><a href="">Home</a></li>
        <li><a href="">About</a></li>
        <li><a href="">Gallery</a></li>
        <li><a href="" class="active">Events</a></li>
        <li><a href="">Find Us</a></li>
      </ul>
      <a href="#" class="nav-cta">Plan a Visit</a>
      <button class="nav-burger" id="burgerBtn1" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <!-- MOBILE MENU -->
  <div class="mob-menu" id="mobMenu">
    <button class="mob-menu-close" id="mobClose" aria-label="Close">
      <svg viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
      </svg>
    </button>
    <ul class="mob-links">
      <li><a href="">Home</a></li>
      <li><a href="">About</a></li>
      <li><a href="">Gallery</a></li>
      <li><a href="" class="active">Events</a></li>
      <li><a href="">Find Us</a></li>
    </ul>
    <div class="mob-menu-footer">
      <p>Sunday Services</p>
      <p><span>9:00 AM</span> &nbsp;&amp;&nbsp; <span>11:00 AM</span></p>
      <p style="margin-top:8px;color:rgba(255,255,255,0.22);">Plan a Visit &rarr;</p>
    </div>
  </div>

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
    <button class="cta-btn" onclick="window.location.href='#'">I'm Coming &rarr;</button>
  </div>

  <!-- ─── FOOTER ─────────────────────────────────────────────────── -->
  <footer class="footer">
    <div class="main-logo">
      <img src="{{ asset('assets/img/avatars/cnciLogo.png') }}" alt="CNCI Logo">
    </div>

    <div class="line-horizontal"></div>

    <div class="footer-nav-links">
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">About</a></li>
        <li><a href="">Gallery</a></li>
        <li><a href="">Events</a></li>
        <li><a href="{{ route('findus') }}">Find Us</a></li>
      </ul>

      <div class="other-info">
        <h3>Email:</h3>
        <p>cnciregion1@gmail.com</p>
        <h3>Location:</h3>
        <p>Region 1, Philippines</p>

        <!-- Social Media -->
        <div class="socmed">
          <ul class="example-2">
            <li class="icon-content">
              <a href="#" data-social="spotify" aria-label="Spotify">
                <div class="filled"></div>
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.52 17.34c-.24.36-.72.48-1.08.24-2.94-1.8-6.66-2.16-11.04-1.2-.42.12-.84-.12-.96-.54-.12-.42.12-.84.54-.96 4.8-1.08 8.94-.66 12.3 1.38.36.24.48.72.24 1.08zm1.44-3.24c-.3.42-.84.6-1.26.3-3.36-2.1-8.52-2.7-12.54-1.44-.48.18-1.02-.12-1.2-.6-.18-.48.12-1.02.6-1.2 4.5-1.44 10.14-.78 13.98 1.56.42.3.6.84.3 1.26zm.12-3.36c-4.02-2.4-10.68-2.64-14.52-1.44-.54.18-1.14-.12-1.32-.66-.18-.54.12-1.14.66-1.32 4.44-1.5 11.7-1.2 16.26 1.5.48.3.66.9.36 1.38-.3.42-.9.6-1.44.3z" />
                </svg>
              </a>
              <span class="tooltip">Spotify</span>
            </li>
            <li class="icon-content">
              <a href="#" data-social="pinterest" aria-label="Pinterest">
                <div class="filled"></div>
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 0C5.37 0 0 5.37 0 12c0 5.08 3.16 9.43 7.62 11.18-.1-.95-.19-2.41.04-3.44.2-.93 1.33-5.65 1.33-5.65s-.34-.68-.34-1.68c0-1.57.91-2.74 2.04-2.74.96 0 1.42.72 1.42 1.59 0 .97-.62 2.42-.94 3.76-.27 1.12.56 2.04 1.67 2.04 2.01 0 3.56-2.12 3.56-5.18 0-2.71-1.95-4.6-4.73-4.6-3.22 0-5.11 2.41-5.11 4.9 0 .97.37 2.01.84 2.58.09.11.11.21.08.32-.09.38-.28 1.16-.32 1.32-.05.2-.17.24-.39.15-1.45-.68-2.35-2.79-2.35-4.49 0-3.65 2.65-7 7.64-7 4.01 0 7.12 2.86 7.12 6.67 0 3.98-2.51 7.18-5.99 7.18-1.17 0-2.27-.61-2.64-1.33 0 0-.58 2.2-.72 2.74-.26.99-.96 2.23-1.43 2.99C9.58 22.8 10.76 23 12 23c6.63 0 12-5.37 12-12S18.63 0 12 0z" />
                </svg>
              </a>
              <span class="tooltip">Pinterest</span>
            </li>
            <li class="icon-content">
              <a href="#" data-social="dribbble" aria-label="Dribbble">
                <div class="filled"></div>
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 0C5.38 0 0 5.38 0 12s5.38 12 12 12 12-5.38 12-12S18.62 0 12 0zm9.96 11.18c-.28-.06-2.32-.48-4.66-.22.99-2.72 2.08-4.96 2.22-5.28 1.97 1.6 3.26 3.98 3.4 6.62-.32.06-.68.1-1.04.12-1.24.04-2.76-.12-3.88-.74-1.12-.62-2.16-1.44-2.16-1.44.04-.12.08-.24.12-.36.7-2.02 1.44-4.64 1.44-4.64 2.72.72 4.98 2.44 6.42 4.68-.48.16-1.82.46-3.84.58zm-8.84-2.91c.44.38 1.28 1.34 1.98 2.48-2.52.94-5.24 1.48-6.36 1.62-.14-.24-.28-.5-.4-.78-.66-1.62-1.72-3.32-1.86-3.58 0 0 1.42-.58 4.14-1.58.46.66 1.14 1.48 1.8 2.12-1.52.56-2.78 1.28-3.06 1.48.06.12.14.24.22.36.32.5.74 1.08 1.28 1.32.3.14.92.28 1.46.28-.04-.62.08-1.24.12-1.74.02-.2.04-.38.04-.46 1.08-.46 2.48-1.12 4.12-1.82 2.74-1.2 3.86-2.62 4.02-2.82.54.58.98 1.24 1.28 1.96-.76.44-2.08 1.12-3.64 1.72zm-4.72 4.34c.02.04.04.08.06.12.14.28.28.54.44.8-1.54.46-3.22.34-4.12.22.24-.42 1.18-1.72 3.32-2.96.12.08.24.16.36.24.46.38 1.06 1.04 1.74 1.58.32.26.64.48.96.68-1.14.46-2.04 1.04-2.66 1.64-1.12.94-1.34 1.86-1.34 1.86.26.08.52.14.78.2 1.6-.04 3.6-.68 5.18-2.2.74.32 1.54.56 2.32.72-1.26 1.96-3.32 3.34-5.72 3.72-.3.06-.6.1-.9.14.04-.06.08-.12.12-.18.34-.54.74-1.3.96-1.94.12-.34.2-.72.24-1.1.16.06.34.12.52.16 1.28.28 2.72.12 3.78-.24-1.38 2.12-3.74 3.66-6.44 4.02.1-.04.2-.08.3-.12 1.36-.48 2.94-1.74 3.94-3.58.32.12.66.22 1.02.32-1.14 2.18-2.98 3.62-4.78 4.14-.32.1-.66.16-1.02.18.06-.04.12-.08.16-.14.4-.46.88-1.14 1.12-1.82.12-.34.2-.72.24-1.08-.28.08-.56.12-.86.16-2.24.28-3.48-.36-4.16-.74.24-.26 1.04-.88 2.38-1.68.34.6.78 1.2 1.38 1.72-.08.34-.16.68-.22 1.02.02.04.06.06.08.1.28-.06.58-.14.86-.24 1.16-.44 2.26-1.44 3.06-2.96.44-.84.74-1.84.96-2.96 2.28.38 4.6.04 4.6.04-1.4 3.42-4.64 5.84-8.38 6.08-1.36.08-2.64-.22-3.78-.88-.1-.06-.2-.12-.3-.18.18-.04.36-.08.54-.14 2.48-.76 4.48-2.64 5.68-4.7.04-.06.06-.12.1-.18.14-.24.26-.48.38-.74z" />
                </svg>
              </a>
              <span class="tooltip">Dribbble</span>
            </li>
            <li class="icon-content">
              <a href="#" data-social="telegram" aria-label="Telegram">
                <div class="filled"></div>
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.67 8.19l-1.66 7.75c-.15.64-.52.8-.97.5l-2.73-2.01-1.34 1.29c-.15.15-.28.28-.57.28l.2-2.99 5.52-4.99c.24-.21-.05-.33-.38-.12l-6.74 4.24-2.88-.9c-.62-.19-.63-.62.13-.92l11.18-4.31c.52-.19.98.13.81.9z" />
                </svg>
              </a>
              <span class="tooltip">Telegram</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© {{ date('Y') }} CNCI. All rights reserved.</p>
    </div>
  </footer>

  <!-- ─── SCRIPTS ─────────────────────────────────────────────── -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      once: true,
      mirror: false,
      disable: 'mobile'
    });

    // ── Mobile menu ──
    const mobMenu = document.getElementById('mobMenu');
    const mobClose = document.getElementById('mobClose');
    const burger = document.getElementById('burgerBtn1');

    function openMenu() {
      mobMenu.classList.add('open');
      burger.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      mobMenu.classList.remove('open');
      burger.classList.remove('open');
      document.body.style.overflow = '';
    }

    burger.addEventListener('click', () => mobMenu.classList.contains('open') ? closeMenu() : openMenu());
    mobClose.addEventListener('click', closeMenu);
    mobMenu.addEventListener('click', e => {
      if (e.target === mobMenu) closeMenu();
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeMenu();
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