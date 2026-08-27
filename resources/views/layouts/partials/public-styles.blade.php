{{-- Shared public site chrome: nav + footer styles --}}
<style>
  :root {
    --cnci-red: #c41e2a;
    --cnci-blue: #024886;
    --cnci-gold: #f5c542;
  }

  .public-nav {
    position: sticky;
    top: 0;
    z-index: 1000;
    width: 100%;
    background: linear-gradient(90deg, #d1202a, #024886);
  }

  .public-nav.is-fixed {
    position: fixed;
    left: 0;
    right: 0;
  }

  .public-nav-inner {
    width: min(1600px, 100%);
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: clamp(10px, 2vw, 32px);
    padding: clamp(14px, 2.2vw, 22px) clamp(16px, 4vw, 48px);
    box-sizing: border-box;
  }

  .public-nav-brand-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    text-decoration: none;
  }

  .public-nav-logo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }

  .public-nav-brand {
    color: #fff;
    font-weight: 700;
    font-size: clamp(1rem, 2.2vw, 1.25rem);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .public-nav-brand span {
    color: var(--cnci-gold);
  }

  .public-nav-links {
    display: flex;
    align-items: center;
    gap: 28px;
    list-style: none;
    margin: 0;
    padding: 0;
    flex: 1;
    justify-content: center;
  }

  .public-nav-links a {
    color: rgba(255, 255, 255, 0.78);
    text-decoration: none;
    font-size: 0.78rem;
    font-weight: 500;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    transition: color .2s;
  }

  .public-nav-links a:hover,
  .public-nav-links a.active {
    color: #fff;
  }

  .public-nav-cta {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.22);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 10px 20px;
    border-radius: 9999px;
    text-decoration: none;
    transition: transform .15s ease, background .15s ease;
  }

  .public-nav-cta:hover {
    transform: translateY(-1px);
    background: rgba(255, 255, 255, 0.14);
    color: #fff;
  }

  .public-nav-auth {
    display: none;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
  }

  .public-nav-user {
    position: relative;
  }

  .public-nav-user-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 6px 14px 6px 6px;
    border-radius: 12px;
    background: rgba(20, 24, 36, 0.92);
    border: 1px solid rgba(255,255,255,0.14);
    color: #fff;
    cursor: pointer;
    font: inherit;
    text-align: left;
  }

  .public-nav-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    background: linear-gradient(135deg, #696cff, #03c3ec);
    display: grid;
    place-items: center;
    font-weight: 700;
    flex-shrink: 0;
  }

  .public-nav-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .public-nav-user-meta strong {
    display: block;
    font-size: 0.88rem;
    max-width: 110px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .public-nav-user-meta span {
    display: block;
    font-size: 0.72rem;
    color: rgba(255,255,255,0.55);
  }

  .public-nav-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 180px;
    background: #1c2130;
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px;
    box-shadow: 0 14px 36px rgba(0,0,0,0.35);
    padding: 6px;
    display: none;
    z-index: 1200;
  }

  .public-nav-user.open .public-nav-dropdown {
    display: block;
  }

  .public-nav-dropdown a,
  .public-nav-dropdown button {
    display: flex;
    width: 100%;
    border: none;
    background: transparent;
    color: #fff;
    text-decoration: none;
    font-size: 0.85rem;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    text-align: left;
    font-family: inherit;
  }

  .public-nav-dropdown a:hover,
  .public-nav-dropdown button:hover {
    background: rgba(255,255,255,0.08);
  }

  .public-nav-dropdown .logout-btn {
    color: #ff8d8d;
  }

  .public-nav-dash {
    display: inline-flex;
    align-items: center;
    padding: 10px 18px;
    border-radius: 12px;
    background: rgba(20, 24, 36, 0.85);
    border: 1px solid rgba(255,255,255,0.28);
    color: #fff;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 600;
  }

  .public-nav-burger {
    display: none;
    flex-direction: column;
    gap: 5px;
    width: 40px;
    height: 40px;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.08);
    border: 0.5px solid rgba(255, 255, 255, 0.16);
    border-radius: 9999px;
    cursor: pointer;
    flex-shrink: 0;
  }

  .public-nav-burger span {
    display: block;
    width: 16px;
    height: 1.5px;
    background: #fff;
    border-radius: 2px;
    transition: .2s ease;
  }

  .public-mob-menu {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(10, 14, 28, 0.97);
    z-index: 2000;
    flex-direction: column;
    padding: 28px 24px;
  }

  .public-mob-menu.open {
    display: flex;
  }

  .public-mob-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 36px;
  }

  .public-mob-brand {
    color: #fff;
    font-weight: 700;
    font-size: 1.2rem;
    text-decoration: none;
  }

  .public-mob-close {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.2);
    background: transparent;
    color: #fff;
    font-size: 1.4rem;
    cursor: pointer;
  }

  .public-mob-links {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 18px;
  }

  .public-mob-links a {
    color: #fff;
    text-decoration: none;
    font-size: 1.25rem;
    font-weight: 600;
  }

  .public-mob-footer {
    margin-top: auto;
    padding-top: 24px;
    color: rgba(255,255,255,0.7);
  }

  /* Footer */
  .public-footer {
    position: relative;
    overflow: hidden;
    background:
      radial-gradient(ellipse 80% 60% at 10% 0%, rgba(255, 255, 255, 0.12), transparent 55%),
      radial-gradient(ellipse 70% 50% at 90% 100%, rgba(2, 72, 134, 0.45), transparent 50%),
      linear-gradient(115deg, #9b1c24 0%, #6b1f4a 42%, #024886 100%);
    color: #fff;
    padding: clamp(48px, 7vw, 72px) 0 0;
    margin-top: 0;
  }

  .public-footer-glow {
    position: absolute;
    inset: auto -10% -40% auto;
    width: 420px;
    height: 420px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245, 197, 66, 0.18), transparent 70%);
    pointer-events: none;
  }

  .public-footer-inner {
    position: relative;
    width: min(1100px, calc(100% - 40px));
    margin: 0 auto;
    z-index: 1;
  }

  .public-footer-grid {
    display: grid;
    grid-template-columns: 1.35fr 0.7fr 1.1fr;
    gap: clamp(28px, 4vw, 48px);
    padding-bottom: clamp(28px, 4vw, 40px);
  }

  .public-footer-brand-link {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: #fff;
    margin-bottom: 1rem;
  }

  .public-footer-brand-link img {
    width: 72px;
    height: 72px;
    object-fit: contain;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    flex-shrink: 0;
  }

  .public-footer-brand-link strong {
    display: block;
    font-size: 1.35rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    line-height: 1.15;
  }

  .public-footer-brand-link span {
    display: block;
    margin-top: 0.2rem;
    font-size: 0.82rem;
    opacity: 0.78;
    font-weight: 500;
  }

  .public-footer-tagline {
    margin: 0 0 1.25rem;
    max-width: 34ch;
    font-size: 0.95rem;
    line-height: 1.55;
    color: rgba(255, 255, 255, 0.86);
  }

  .public-footer-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.65rem 1.35rem;
    border-radius: 999px;
    background: #fff;
    color: #024886;
    font-weight: 700;
    font-size: 0.88rem;
    text-decoration: none;
    letter-spacing: 0.01em;
    transition: transform .15s ease, box-shadow .15s ease;
    margin-top: 0.35rem;
  }

  .public-footer-cta:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    color: #024886;
  }

  /* Social icons (Facebook / Instagram) */
  .public-footer-social.example-2 {
    list-style: none;
    margin: 0 0 1.15rem;
    padding: 0;
    display: flex;
    justify-content: flex-start;
    align-items: center;
  }

  .example-2 .icon-content {
    margin: 0 10px 0 0;
    position: relative;
  }

  .example-2 .icon-content:last-child {
    margin-right: 0;
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
    white-space: nowrap;
    transition: all 0.3s ease;
    pointer-events: none;
    z-index: 2;
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
    background-color: #fff;
    transition: all 0.3s ease-in-out;
    text-decoration: none;
  }

  .example-2 .icon-content a:hover {
    box-shadow: 3px 2px 45px 0px rgb(0 0 0 / 12%);
    color: white;
  }

  .example-2 .icon-content a svg {
    position: relative;
    z-index: 1;
    width: 22px;
    height: 22px;
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

  .example-2 .icon-content a[data-social="facebook"] .filled,
  .example-2 .icon-content a[data-social="facebook"] ~ .tooltip {
    background-color: #1877f2;
  }

  .example-2 .icon-content a[data-social="instagram"] .filled,
  .example-2 .icon-content a[data-social="instagram"] ~ .tooltip {
    background: linear-gradient(
      45deg,
      #405de6,
      #5b51db,
      #b33ab4,
      #c135b4,
      #e1306c,
      #fd1f1f
    );
  }

  .public-footer-col h4 {
    margin: 0 0 1rem;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.7);
  }

  .public-footer-links {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0.55rem;
  }

  .public-footer-links a {
    color: rgba(255, 255, 255, 0.92);
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: color .15s ease, padding-left .15s ease;
  }

  .public-footer-links a:hover {
    color: #fff;
    padding-left: 4px;
  }

  .public-footer-contact {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
  }

  .public-footer-meta {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    text-decoration: none;
    color: rgba(255, 255, 255, 0.92);
  }

  a.public-footer-meta:hover span:last-child {
    text-decoration: underline;
    text-underline-offset: 3px;
  }

  .public-footer-meta-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.55);
  }

  .public-footer-meta span:last-child {
    font-size: 0.95rem;
    line-height: 1.4;
  }

  .public-footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.16);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem 1.5rem;
    padding: 1rem 0 1.25rem;
    font-size: 0.82rem;
    color: rgba(255, 255, 255, 0.78);
  }

  .public-footer-bottom p {
    margin: 0;
  }

  .public-footer-bottom-note {
    opacity: 0.7;
  }

  @media (min-width: 901px) {
    .public-nav-auth { display: inline-flex; }
    body.is-auth .public-nav-cta.guest-only { display: none; }
  }

  @media (max-width: 900px) {
    .public-nav-links,
    .public-nav-cta,
    .public-nav-auth {
      display: none !important;
    }
    .public-nav-burger { display: flex; }
    .public-footer-grid {
      grid-template-columns: 1fr;
      text-align: center;
    }
    .public-footer-brand-link {
      justify-content: center;
      text-align: left;
    }
    .public-footer-tagline {
      margin-left: auto;
      margin-right: auto;
    }
    .public-footer-social.example-2 {
      justify-content: center;
    }
    .example-2 .icon-content {
      margin: 0 8px;
    }
    .public-footer-links,
    .public-footer-contact {
      align-items: center;
    }
    .public-footer-links {
      align-items: center;
    }
    .public-footer-meta {
      align-items: center;
      text-align: center;
    }
    .public-footer-bottom {
      flex-direction: column;
      text-align: center;
      justify-content: center;
    }
  }
</style>
