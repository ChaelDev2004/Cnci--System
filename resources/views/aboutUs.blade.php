<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $siteSettings->brandName() }} · About Us</title>
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

    /* ─── HERO ────────────────────────────────────────────────────── */
    .hero-section {
      margin-top: 0;
      width: 100%;
      height: 100vh;
      min-height: 600px;
      justify-content: center;
      overflow: hidden;
      display: flex;
      align-items: center;
      text-align: center;
      position: relative;
    }

    .hero-bg-img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 0;
    }

    .hero-left-fade {
      position: absolute;
      inset: 0;
      background: linear-gradient(to right, rgba(0, 0, 0, 0.55) 0%, transparent 70%);
      z-index: 1;
    }

    .hero-bottom-fade {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 40%;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.5) 0%, transparent 100%);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 10;
      max-width: 1380px;
      padding: 0 40px;
      color: #fff;
      text-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
    }

    .hero-eyebrow {
      font-size: 1rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      margin-top: 30px;
      margin-bottom: 20px;
    }

    .hero-h1 {
      font-size: 5rem;
      font-weight: 600;
      line-height: 1.1;
      letter-spacing: -0.02em;
    }

    .hero-sub {
      font-size: 1.6rem;
      opacity: 0.85;
      margin: 16px 0 28px;
      width: 100%;
      line-height: 1.6;
      display: block;
    }

    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 18px;
    }

    .btn-primary {
      background: #f5d47b;
      border: none;
      padding: 12px 32px;
      border-radius: 60px;
      font-weight: 600;
      color: #1e2b3a;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-primary:hover {
      background: #ffe08a;
      transform: scale(0.97);
    }

    .btn-icon {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 1.5px solid rgba(255, 255, 255, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .btn-icon svg {
      width: 20px;
      height: 20px;
      stroke: #fff;
      stroke-width: 2;
      fill: none;
    }

    .reviews {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .stars {
      display: flex;
      gap: 3px;
    }

    .stars svg {
      width: 18px;
      height: 18px;
      fill: #f5d47b;
    }

    .reviews-text {
      font-size: 0.8rem;
      opacity: 0.7;
    }

    .hero-testimonial {
      position: absolute;
      bottom: 50px;
      right: 40px;
      z-index: 15;
      color: rgba(255, 255, 255, 0.7);
      font-style: italic;
      max-width: 260px;
      text-align: right;
      border-left: 2px solid #f5d47b;
      padding-left: 16px;
      font-size: 0.9rem;
    }

    /* ─── SECTIONS ────────────────────────────────────────────── */
    #mission,
    .about,
    .findUs,

    .footer {
      background: #f8f6f0;
      padding: 70px 24px;
      position: relative;
      z-index: 2;
    }

    #mission {
      background: linear-gradient(145deg, #f0ede5 0%, #f8f6f0 100%);
    }

    .mission-container,
    .purpose-container,
    .about-container {
      max-width: 1000px;
      margin: 0 auto 40px;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(2px);
      padding: 40px 48px;
      border-radius: 32px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .mission-container h2,
    .purpose-container h2,
    .about-container h2 {
      font-size: 2rem;
      color: #1e2b3a;
      margin-bottom: 16px;
      letter-spacing: -0.02em;
    }

    .mission-container p,
    .purpose-container p,
    .about-container p {
      color: #2c3e4e;
      line-height: 1.7;
      font-size: 1.05rem;
    }

    .about-btn button {
      background: #024886;
      border: none;
      padding: 10px 28px;
      border-radius: 60px;
      color: #fff;
      font-weight: 500;
      margin-top: 20px;
      cursor: pointer;
    }

    /* CTA */
    .nav-cta {
      flex-shrink: 0;
      display: inline-flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(6px);
      -webkit-backdrop-filter: blur(6px);
      border: none;
      box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.12);
      color: #fff;
      font-family: 'Inter', sans-serif;
      font-size: 0.73rem;
      font-weight: 500;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 10px 22px;
      border-radius: 9999px;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s;
      text-decoration: none;
    }

    .nav-cta::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      padding: 1.2px;
      background: linear-gradient(180deg,
          rgba(255, 255, 255, 0.45) 0%, rgba(255, 255, 255, 0.15) 20%,
          rgba(255, 255, 255, 0) 40%, rgba(255, 255, 255, 0) 60%,
          rgba(255, 255, 255, 0.15) 80%, rgba(255, 255, 255, 0.45) 100%);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }

    .nav-cta:hover {
      transform: scale(1.03);
    }

    /* our story */
    .our-story {
      margin-top: -50px;
      padding: 80px 20px;
      height: 100vh;
    }

    .our-story .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .story-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 60px;
    }

    .story-text {
      flex: 1;
      text-align: center;
    }

    .story-text h2 {
      font-size: 3rem;
      font-weight: 700;
      letter-spacing: 2px;
      color: #333;
      margin-bottom: 25px;
    }

    .story-text p {
      font-size: 1.3rem;
      line-height: 1.9;
      color: #555;
      margin-bottom: 30px;
    }

    .story-image {
      flex: 1;
      display: flex;
      justify-content: center;
    }

    .story-image img {
      width: 100%;
      max-width: 450px;
      height: 450px;
      object-fit: cover;
      border-radius: 25px;
      background: #ddd;
    }

    /* LEADERSHIP SECTION */
    .leadership-section {
      background: #f5f5f5;
      padding: 80px 20px;
    }

    .leadership-section .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-title {
      text-align: center;
      font-size: 3rem;
      font-weight: 700;
      letter-spacing: 2px;
      color: #333;
      margin-bottom: 60px;
    }

    .leadership-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 60px;
    }

    .leader-card {
      text-align: center;
    }

    .leader-image {
      background: #e9e9e9;
      border-radius: 20px;
      overflow: hidden;
      height: 420px;
      width: 420px;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      margin-bottom: 25px;
    }

    .leader-image img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .leader-card h3 {
      font-size: 2rem;
      font-weight: 700;
      color: #333;
      margin-bottom: 10px;
      letter-spacing: 1px;
    }

    .leader-card p {
      font-size: 1.8rem;
      color: #555;
      margin-bottom: 25px;
    }

    .leader-btn {
      display: inline-block;
      padding: 12px 35px;
      border: 2px solid #333;
      border-radius: 50px;
      text-decoration: none;
      color: #333;
      font-size: 1.2rem;
      transition: all .3s ease;
    }

    .leader-btn:hover {
      background: #333;
      color: #fff;
    }

    /* ===== FOOTER ===== */
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

    /* Social Media - Forced Horizontal */
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

    /* Copyright bar */
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

    /* ===== RESPONSIVE DESIGN ===== */

    /* Large screens (1200px and below) */
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

    /* Medium screens (992px and below) */
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
    }

    /* Small screens (768px and below) */
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
    }

    /* Extra small screens (480px and below) */
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
    }

    @media (max-width: 820px) {
      .nav-links {
        display: none;
      }

      .section-title {
        margin-top: 180px;
        font-size: 34px;
      }

      .nav-burger {
        display: flex;
      }

      .nav-inner {
        padding: 12px 20px;
      }

      .hero-h1 {
        font-size: 2.8rem;
      }

      .hero-testimonial {
        position: relative;
        bottom: auto;
        right: auto;
        margin-top: 20px;
        text-align: center;
        border-left: none;
        padding-left: 0;
      }

      .nav-logo {
        margin-right: -30px;
      }

      .story-content {
        flex-direction: column;
        text-align: center;
      }

      .story-text {
        order: 1;
      }

      .story-image {
        order: 2;
        width: 100%;
      }

      .story-text h2 {
        font-size: 2rem;
      }

      .story-text p {
        font-size: 1rem;
        line-height: 1.8;
      }

      .story-image img {
        max-width: 100%;
        height: auto;
        aspect-ratio: 1/1;
      }

      .leadership-grid {
        grid-template-columns: 1fr;
        gap: 40px;
      }

      .contact-card {
        padding: 24px;
      }
    }

    @media (max-width: 480px) {
      .hero-h1 {
        font-size: 2rem;
      }

      .mission-container,
      .purpose-container,
      .about-container {
        padding: 24px;
      }
    }

    @media (max-width: 992px) {
      .story-content {
        gap: 40px;
      }

      .story-text h2 {
        font-size: 2.5rem;
      }

      .story-text p {
        font-size: 1.1rem;
      }

      .story-image img {
        max-width: 380px;
        height: 380px;
      }
    }

    .leadership-section #leader-card-haha {
      margin: 0 auto;
      justify-content: center;
      justify-content: center;
    }

    .pastors-section {
      padding: 100px 20px;
      background: #f5f5f5;
    }

    .pastors-section .container {
      max-width: 1300px;
      margin: auto;
    }

    .section-title {
      text-align: center;
      font-size: 3rem;
      font-weight: 700;
      color: #333;
      letter-spacing: 2px;
      margin-bottom: 70px;
    }

    .pastors-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 60px 25px;
    }

    .pastor-card {
      text-align: center;
    }

    .pastor-image {
      width: 170px;
      height: 170px;
      margin: 0 auto 20px;
      background: #e8e8e8;
      border-radius: 50%;
      overflow: hidden;
    }

    .pastor-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .pastor-card h4 {
      font-size: 1rem;
      font-weight: 700;
      color: #333;
      letter-spacing: 1px;
      margin-bottom: 5px;
    }

    .pastor-card p {
      font-size: 0.95rem;
      color: #555;
      margin-bottom: 3px;
    }

    .pastor-card span {
      display: block;
      font-size: 0.95rem;
      color: #666;
    }

    /* Tablet */
    @media (max-width: 992px) {
      .pastors-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .section-title {
        font-size: 2.5rem;
      }
    }

    /* Mobile */
    @media (max-width: 576px) {
      .pastors-grid {
        grid-template-columns: 1fr;
        gap: 40px;
      }

      .section-title {
        font-size: 2rem;
      }

      .pastor-image {
        width: 140px;
        height: 140px;
      }
    }

    .ministers-section {
      padding: 80px 20px;
      background: #f5f5f5;
    }

    .ministers-section .container {
      max-width: 1100px;
      margin: auto;
    }

    .section-title {
      text-align: center;
      font-size: 3rem;
      font-weight: 700;
      letter-spacing: 2px;
      color: #333;
      margin-bottom: 50px;
    }

    .staff-title {
      margin-top: 80px;
    }

    .members-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 50px;
      justify-items: center;
    }

    .member-card {
      text-align: center;
      max-width: 250px;
    }

    .member-image {
      width: 170px;
      height: 170px;
      border-radius: 50%;
      overflow: hidden;
      margin: 0 auto 20px;
      background: #e8e8e8;
    }

    .member-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .member-card h4 {
      font-size: 1rem;
      font-weight: 700;
      color: #333;
      letter-spacing: 1px;
      margin-bottom: 5px;
    }

    .member-card p {
      font-size: 1rem;
      color: #555;
      margin-bottom: 3px;
    }

    .member-card span {
      display: block;
      font-size: 0.95rem;
      color: #666;
    }

    /* Tablet */
    @media (max-width: 992px) {

      .members-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .section-title {
        font-size: 2.4rem;
      }
    }

    /* Mobile */
    @media (max-width: 576px) {

      .members-grid {
        grid-template-columns: 1fr;
        gap: 40px;
      }

      .section-title {
        font-size: 2rem;
        margin-bottom: 35px;
      }

      .staff-title {
        margin-top: 60px;
      }

      .member-image {
        width: 140px;
        height: 140px;
      }

      .member-card h4 {
        font-size: 0.9rem;
      }
    }
  </style>
</head>

<body>

  @php $activeNav = 'about'; $fixedNav = false; @endphp
  @include('layouts.partials.public-nav')

  <!-- ─── HERO SECTION ───────────────────────────────────────── -->
  <section class="hero-section">
    <img src="{{ $content->hero_bg_image ? asset('storage/'.$content->hero_bg_image) : asset('assets/img/backgrounds/aboutUs-bg.png') }}" alt="About Us Background" class="hero-bg-img">
    <div class="hero-content" data-aos="fade-up" data-aos-duration="900">
      <h1 class="hero-h1">{{ $content->hero_title ?? 'OUR MISSION' }}</h1>
      <div class="hero-eyebrow">
        <h1>{{ $content->hero_eyebrow ?? "Influencing this generation for Christ through faith, righteousness, and holiness." }}</h1>
      </div>
      <p class="hero-sub">{{ $content->hero_subtext ?? "We are an evangelistic and missionary church committed to sharing the Gospel and advancing God's Kingdom. Empowered by the Holy Spirit, we disciple and equip believers for ministry as we fulfill the Great Commission (Matthew 28:16–20)." }}</p>
    </div>
  </section>

  <!-- ─── OUR STORY ───────────────────────────────────────────── -->
  <section class="our-story">
    <div class="container">
      <div class="story-content">
        <div class="story-text" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100" data-aos-offset="40">
          <h2>OUR STORY</h2>
          <p>{{ $content->story_paragraph_1 ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' }}</p>
          <p>{{ $content->story_paragraph_2 ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' }}</p>
        </div>
        <div class="story-image" data-aos="fade-left" data-aos-duration="800" data-aos-offset="40">
          <img src="{{ $content->story_image ? asset('storage/'.$content->story_image) : 'https://via.placeholder.com/500x500' }}" alt="Our Story">
        </div>
      </div>
    </div>
  </section>

  <!-- ─── LEADERSHIP ─────────────────────────────────────────────── -->
  <section class="leadership-section">
    <div class="container">

      <h2 class="section-title">THE LEADERSHIP</h2>

      <div class="leadership-grid">

        @foreach($leaders as $leader)

        <div class="leader-card" data-aos="fade-up" data-aos-duration="800">

          <div class="leader-image">
            <img
              src="{{ $leader->image 
                            ? asset('storage/'.$leader->image) 
                            : asset('assets/img/default.png') 
                        }}"
              alt="{{ $leader->name }}">
          </div>

          <h3>{{ strtoupper($leader->name) }}</h3>

          <p>{{ $leader->title }}</p>

          @if($leader->subtitle)
          <p>{{ $leader->subtitle }}</p>
          @endif

          <a href="{{ $leader->link ?? '#' }}" class="leader-btn">
            Know More
          </a>

        </div>

        @endforeach

      </div>

    </div>
  </section>

  <section class="pastors-section">
    <div class="container">

      <h2 class="section-title">THE PASTORS</h2>

      <div class="pastors-grid">

        @foreach($pastors as $index => $pastor)
        <a href="{{ route('pastor.show', $pastor->id) }}" class="pastor-card" data-aos="zoom-in" data-aos-duration="800" @if($index % 4 !=0) data-aos-delay="{{ ($index % 4) * 100 }}" @endif style="text-decoration:none;color:inherit;display:block;">
          <div class="pastor-image">
            <img src="{{ $pastor->image ? asset('storage/'.$pastor->image) : asset('images/default-pastor.png') }}" alt="{{ $pastor->name }}">
          </div>

          <h4>{{ $pastor->name }}</h4>
          @if($pastor->role)
          <p>{{ $pastor->role }}</p>
          @endif
          <span>{{ $pastor->church }}</span>
        </a>
        @endforeach

      </div>

    </div>
  </section>
  <section class="ministers-section">
    <div class="container">

      <!-- Gospel Ministers -->
      <h2 class="section-title">THE GOSPEL MINISTERS</h2>

      <div class="members-grid">

        @foreach($ministers as $index => $m)
        <div class="member-card" data-aos="zoom-in" @if($index % 4 !=0) data-aos-delay="{{ ($index % 4) * 100 }}" @endif>
          <div class="member-image">
            <img src="{{ $m->image ? asset('storage/'.$m->image) : asset('images/default-member.png') }}" alt="{{ $m->name }}">
          </div>
          <h4>{{ $m->name }}</h4>
          @if($m->role)
          <p>{{ $m->role }}</p>
          @endif
          @if($m->subrole)
          <span>{{ $m->subrole }}</span>
          @endif
        </div>
        @endforeach

      </div>

      <!-- Region 1 Staff -->
      <h2 class="section-title staff-title">THE REGION 1 STAFF</h2>

      <div class="members-grid">

        @foreach($staff as $index => $s)
        <div class="member-card" data-aos="zoom-in" @if($index % 4 !=0) data-aos-delay="{{ ($index % 4) * 100 }}" @endif>
          <div class="member-image">
            <img src="{{ $s->image ? asset('storage/'.$s->image) : asset('images/default-member.png') }}" alt="{{ $s->name }}">
          </div>
          <h4>{{ $s->name }}</h4>
          @if($s->role)
          <p>{{ $s->role }}</p>
          @endif
          @if($s->subrole)
          <span>{{ $s->subrole }}</span>
          @endif
        </div>
        @endforeach

      </div>

    </div>
  </section>

  @include('layouts.partials.public-footer')
  @include('layouts.partials.public-scripts')

  <!-- ─── SCRIPTS ─────────────────────────────────────────────── -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      mirror: false,
      disable: 'mobile'
    });

  </script>

</body>

</html>