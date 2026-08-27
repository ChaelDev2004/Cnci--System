{{-- Shared minimalist forms + SweetAlert2 flash/confirm --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
  /* ── Admin page / card rhythm ── */
  .layout-page .container-xxl,
  .layout-page .container-fluid {
    padding-top: 0.25rem;
  }

  .layout-page .card {
    border: 1px solid #eef0f3;
    border-radius: 14px;
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.04);
    margin-bottom: 1.5rem;
    overflow: hidden;
  }

  .layout-page .card .card-header {
    background: #fff;
    border-bottom: 1px solid #f0f2f5;
    padding: 1.15rem 1.75rem;
  }

  .layout-page .card .card-header h5,
  .layout-page .card .card-header .card-title {
    margin-bottom: 0.2rem;
    font-weight: 700;
    letter-spacing: -0.01em;
  }

  .layout-page .card .card-body {
    padding: 1.75rem 1.85rem 1.85rem;
  }

  /* Forms dropped directly in .card (no card-body) */
  .layout-page .card > form {
    padding: 1.75rem 1.85rem 1.65rem;
  }

  .layout-page .card > form > .btn,
  .layout-page .card > form > button[type="submit"],
  .layout-page .card > form > .d-flex.gap-2 {
    margin-top: 0.65rem;
  }

  /* ── Minimalist form system ── */
  .card .form-label,
  .form-group > label,
  label.form-label,
  .minimal-form-group label {
    display: block;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #8a94a6;
    margin-bottom: 0.55rem;
  }

  .card .form-control,
  .card .form-select,
  .form-group input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="hidden"]),
  .form-group select,
  .form-group textarea,
  .minimal-form-group input,
  .minimal-form-group textarea,
  .minimal-form-group select {
    width: 100%;
    border: none;
    border-bottom: 1px solid #e6e8ec;
    border-radius: 0;
    background: transparent;
    box-shadow: none !important;
    padding: 0.7rem 0 0.75rem;
    font-size: 0.95rem;
    line-height: 1.45;
    color: #1e1e2a;
    transition: border-color .2s ease;
  }

  .card .form-control:focus,
  .card .form-select:focus,
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus,
  .minimal-form-group input:focus,
  .minimal-form-group textarea:focus,
  .minimal-form-group select:focus {
    border-bottom-color: #024886;
    outline: none;
    box-shadow: none !important;
  }

  .card .form-control.is-invalid,
  .card .form-select.is-invalid {
    border-bottom-color: #c41e2a;
  }

  .card textarea.form-control,
  .form-group textarea,
  .minimal-form-group textarea {
    min-height: 120px;
    resize: vertical;
    line-height: 1.55;
  }

  .card input[type="file"].form-control,
  .form-group input[type="file"] {
    border: 1px dashed #d5d9e0;
    border-radius: 10px;
    padding: 0.9rem 1rem;
    background: #fafbfc;
    margin-top: 0.15rem;
  }

  .card .form-check {
    padding: 0.65rem 0.85rem;
    margin: 0.25rem 0 0.5rem;
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-radius: 10px;
    min-height: auto;
  }

  .card .form-check-input {
    border-radius: 4px;
    margin-top: 0.2rem;
  }

  .card .form-check-label {
    text-transform: none;
    letter-spacing: 0;
    font-size: 0.9rem;
    font-weight: 500;
    color: #3a4150;
    margin-bottom: 0;
  }

  .card .btn,
  .btn-minimal {
    border-radius: 999px;
    font-weight: 600;
    letter-spacing: 0.02em;
    padding: 0.6rem 1.45rem;
  }

  .card .btn-primary,
  .card > form > .btn:not(.btn-outline-secondary):not(.btn-outline-danger):not(.btn-secondary) {
    background: linear-gradient(135deg, #c41e2a, #024886);
    border: none;
    color: #fff;
  }

  .card .btn-outline-primary,
  .card .btn-outline-secondary,
  .card .btn-outline-danger {
    border-width: 1px;
  }

  .card .btn + .btn,
  .card .btn + a.btn {
    margin-left: 0.35rem;
  }

  /* Field spacing */
  .form-group,
  .minimal-form-group {
    margin-bottom: 1.4rem;
  }

  .form-group:last-of-type,
  .minimal-form-group:last-of-type {
    margin-bottom: 1rem;
  }

  .layout-page .card .mb-3 {
    margin-bottom: 1.35rem !important;
  }

  .layout-page .card .row.g-3,
  .layout-page .card form .row:not(.g-0) {
    --bs-gutter-x: 1.4rem;
    --bs-gutter-y: 1.35rem;
  }

  .layout-page .card form .row > [class*="col-"] {
    margin-bottom: 0.15rem;
  }

  .form-group small,
  .form-text,
  .card .text-muted.small,
  .card small.text-muted {
    display: block;
    color: #9aa3b2;
    font-size: 0.8rem;
    margin-top: 0.45rem;
    line-height: 1.4;
  }

  /* Action bar under forms */
  .layout-page .card .mt-4.d-flex,
  .layout-page .cnci-form-actions {
    margin-top: 1.5rem !important;
    padding-top: 1.25rem;
    border-top: 1px solid #f0f2f5;
    gap: 0.65rem !important;
    flex-wrap: wrap;
  }

  .layout-page .card .form-actions,
  .cnci-form-actions {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid #f0f2f5;
  }

  /* Page titles above forms */
  .layout-page .mb-3 > h4.mb-1,
  .layout-page h1,
  .layout-page .d-flex.justify-content-between h1 {
    letter-spacing: -0.02em;
  }

  .layout-page .mb-3 > p.text-muted {
    margin-top: 0.35rem;
  }

  /* Section headings inside forms */
  .layout-page .card form > h3,
  .layout-page .card > form > h3,
  .layout-page .card .card-body > h3,
  .layout-page .card .card-body > h5.mb-3 {
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #8a94a6;
    margin: 1.75rem 0 1.1rem;
    padding-bottom: 0.55rem;
    border-bottom: 1px solid #f0f2f5;
  }

  .layout-page .card form > h3:first-child,
  .layout-page .card > form > h3:first-child,
  .layout-page .card .card-body > h5.mb-3:first-child {
    margin-top: 0;
  }

  /* Checkbox label inside plain form-group */
  .form-group > label:has(input[type="checkbox"]) {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    text-transform: none;
    letter-spacing: 0;
    font-size: 0.9rem;
    font-weight: 500;
    color: #3a4150;
    padding: 0.75rem 0.9rem;
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-radius: 10px;
    margin-bottom: 0;
    cursor: pointer;
  }

  .layout-page .card form .row.g-3 .form-group.mb-0,
  .layout-page .card form .row .form-group.mb-0 {
    margin-bottom: 0;
  }

  @media (max-width: 767.98px) {
    .layout-page .card .card-body,
    .layout-page .card > form {
      padding: 1.25rem 1.15rem 1.35rem;
    }

    .layout-page .card .card-header {
      padding: 1rem 1.15rem;
    }
  }

  /* ── Admin sidebar: logo + menu icons aligned ── */
  #layout-menu .app-brand {
    display: flex;
    align-items: center;
    min-height: 64px;
    padding-inline: 1.15rem !important;
  }

  #layout-menu .app-brand-link {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    min-width: 0;
  }

  #layout-menu .app-brand-logo {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    border: 1px solid #eef0f3;
  }

  #layout-menu .app-brand-logo img {
    width: 32px !important;
    height: 32px !important;
    object-fit: contain;
  }

  #layout-menu .app-brand-text {
    line-height: 1.2;
    margin-left: 0 !important;
  }

  #layout-menu .menu-inner > .menu-item > .menu-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-height: 42px;
    padding-block: 0.55rem;
  }

  #layout-menu .menu-inner > .menu-item > .menu-link > i,
  #layout-menu .menu-inner > .menu-item > .menu-link > .menu-icon {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 1.5rem;
    min-width: 1.5rem;
    height: 1.5rem;
    margin-inline-end: 0 !important;
    font-size: 1.25rem;
    line-height: 1;
    flex-shrink: 0;
    text-align: center;
  }

  #layout-menu .menu-inner > .menu-item > .menu-link > div {
    line-height: 1.25;
    flex: 1 1 auto;
    min-width: 0;
  }

  #layout-menu .menu-header {
    padding-top: 1rem;
    padding-bottom: 0.35rem;
  }

  /* Dashboard stat icons — same size/alignment */
  .layout-page .avatar .avatar-initial {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
  }

  .layout-page .avatar .avatar-initial i,
  .layout-page .view-page-icon i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }

  .layout-page .view-page-icon {
    width: 44px;
    height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  /* Public / contact form minimal */
  .cnci-minimal-form .form-group label,
  .contact .form-group label {
    display: block;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #8a94a6;
    margin-bottom: 0.4rem;
  }

  .cnci-minimal-form .form-group input,
  .cnci-minimal-form .form-group textarea,
  .contact .form-group input,
  .contact .form-group textarea {
    width: 100%;
    border: none;
    border-bottom: 1px solid #e6e8ec;
    border-radius: 0;
    background: transparent;
    padding: 0.65rem 0;
    font-size: 0.95rem;
    outline: none;
  }

  .cnci-minimal-form .form-group input:focus,
  .cnci-minimal-form .form-group textarea:focus,
  .contact .form-group input:focus,
  .contact .form-group textarea:focus {
    border-bottom-color: #024886;
  }

  .contact .submit-btn,
  .cnci-minimal-form .submit-btn {
    border: none;
    border-radius: 999px;
    padding: 0.75rem 1.6rem;
    background: linear-gradient(135deg, #c41e2a, #024886);
    color: #fff;
    font-weight: 600;
    letter-spacing: 0.03em;
    cursor: pointer;
  }

  /* SweetAlert2 minimal tweak */
  .swal2-popup.cnci-swal {
    border-radius: 16px;
    font-family: inherit;
    padding: 1.6rem 1.4rem;
  }

  .swal2-popup.cnci-swal .swal2-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e1e2a;
  }

  .swal2-popup.cnci-swal .swal2-html-container {
    font-size: 0.95rem;
    color: #5c6570;
  }

  .swal2-styled.cnci-confirm {
    border-radius: 999px !important;
    background: linear-gradient(135deg, #c41e2a, #024886) !important;
    box-shadow: none !important;
    padding: 0.55rem 1.4rem !important;
  }

  .swal2-styled.cnci-cancel {
    border-radius: 999px !important;
    background: #eef0f3 !important;
    color: #444 !important;
    box-shadow: none !important;
  }

  /* Hide bootstrap flash banners when SweetAlert handles them */
  .swal-handled-flash {
    display: none !important;
  }

  /* ═══════════════════════════════════════════
     Admin theme: cards + text readable in BOTH modes
     ═══════════════════════════════════════════ */
  #cnciThemeToggle {
    transition: transform .15s ease, background-color .15s ease;
  }
  #cnciThemeToggle:hover {
    transform: scale(1.06);
  }

  /* —— Light mode —— */
  [data-bs-theme="light"] {
    color-scheme: light;
  }

  [data-bs-theme="light"] .layout-page,
  [data-bs-theme="light"] .content-wrapper {
    color: #566a7f;
  }

  [data-bs-theme="light"] .layout-page .card,
  [data-bs-theme="light"] .layout-page .minimal-card {
    background-color: #ffffff !important;
    color: #566a7f !important;
    border-color: #e7e7e8 !important;
  }

  [data-bs-theme="light"] .layout-page .card h1,
  [data-bs-theme="light"] .layout-page .card h2,
  [data-bs-theme="light"] .layout-page .card h3,
  [data-bs-theme="light"] .layout-page .card h4,
  [data-bs-theme="light"] .layout-page .card h5,
  [data-bs-theme="light"] .layout-page .card h6,
  [data-bs-theme="light"] .layout-page .card .card-title,
  [data-bs-theme="light"] .layout-page .text-heading,
  [data-bs-theme="light"] .layout-page h1,
  [data-bs-theme="light"] .layout-page h2,
  [data-bs-theme="light"] .layout-page h3,
  [data-bs-theme="light"] .layout-page h4,
  [data-bs-theme="light"] .layout-page h5,
  [data-bs-theme="light"] .layout-page h6 {
    color: #384551 !important;
  }

  [data-bs-theme="light"] .layout-page .text-muted,
  [data-bs-theme="light"] .layout-page .card-subtitle,
  [data-bs-theme="light"] .layout-page .text-body-secondary {
    color: #a1acb8 !important;
  }

  [data-bs-theme="light"] .layout-page .card .form-control,
  [data-bs-theme="light"] .layout-page .card .form-select,
  [data-bs-theme="light"] .layout-page .form-group input,
  [data-bs-theme="light"] .layout-page .form-group select,
  [data-bs-theme="light"] .layout-page .form-group textarea {
    color: #384551 !important;
  }

  [data-bs-theme="light"] .layout-page table,
  [data-bs-theme="light"] .layout-page .table {
    color: #566a7f;
  }

  [data-bs-theme="light"] .view-page-card {
    background: linear-gradient(180deg, #fff 0%, #f8f9fc 100%) !important;
    color: #384551 !important;
    border-color: rgba(67, 89, 113, 0.12) !important;
  }

  [data-bs-theme="light"] .view-page-card p {
    color: #697a8d !important;
  }

  [data-bs-theme="light"] .cnci-stat-card-danger {
    background: linear-gradient(135deg, #fff5f5 0%, #fff 70%) !important;
    border: 1px solid rgba(255, 62, 29, 0.12) !important;
    color: #566a7f !important;
  }

  /* —— Dark mode —— */
  [data-bs-theme="dark"] {
    color-scheme: dark;
  }

  [data-bs-theme="dark"] body {
    background-color: #25293c !important;
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .layout-wrapper,
  [data-bs-theme="dark"] .layout-container,
  [data-bs-theme="dark"] .layout-page,
  [data-bs-theme="dark"] .content-wrapper,
  [data-bs-theme="dark"] .container-p-y,
  [data-bs-theme="dark"] .container-xxl,
  [data-bs-theme="dark"] .container-fluid {
    background-color: #25293c !important;
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .layout-navbar,
  [data-bs-theme="dark"] .navbar.layout-navbar {
    background-color: rgba(47, 51, 73, 0.95) !important;
    backdrop-filter: blur(8px);
    border-bottom: 1px solid #434968 !important;
    box-shadow: none !important;
  }

  [data-bs-theme="dark"] .layout-navbar .text-heading,
  [data-bs-theme="dark"] .layout-navbar h5,
  [data-bs-theme="dark"] .layout-navbar .nav-link,
  [data-bs-theme="dark"] .layout-navbar .form-control {
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .layout-navbar .form-control::placeholder {
    color: #8b8da3 !important;
  }

  [data-bs-theme="dark"] #layout-menu,
  [data-bs-theme="dark"] .bg-menu-theme {
    background-color: #2f3349 !important;
    color: #cbcbe2 !important;
    box-shadow: none !important;
  }

  [data-bs-theme="dark"] #layout-menu .menu-link,
  [data-bs-theme="dark"] #layout-menu .menu-inner > .menu-item > .menu-link > div,
  [data-bs-theme="dark"] #layout-menu .app-brand-text,
  [data-bs-theme="dark"] #layout-menu .menu-header-text {
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] #layout-menu .menu-item.active > .menu-link,
  [data-bs-theme="dark"] #layout-menu .menu-item.active > .menu-link > div {
    color: #fff !important;
  }

  [data-bs-theme="dark"] #layout-menu .app-brand-logo {
    background: rgba(255, 255, 255, 0.06);
    border-color: #434968;
  }

  [data-bs-theme="dark"] .layout-page .card,
  [data-bs-theme="dark"] .layout-page .minimal-card,
  [data-bs-theme="dark"] .dropdown-menu {
    background-color: #2f3349 !important;
    color: #cbcbe2 !important;
    border-color: #434968 !important;
    box-shadow: 0 0.25rem 1rem rgba(15, 20, 34, 0.4) !important;
  }

  [data-bs-theme="dark"] .layout-page .card .card-header,
  [data-bs-theme="dark"] .layout-page .card .card-footer {
    background-color: transparent !important;
    border-color: #434968 !important;
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .layout-page .card .card-body,
  [data-bs-theme="dark"] .layout-page .card p,
  [data-bs-theme="dark"] .layout-page .card li,
  [data-bs-theme="dark"] .layout-page .card span:not(.badge):not(.avatar-initial):not(.bx),
  [data-bs-theme="dark"] .layout-page .card label,
  [data-bs-theme="dark"] .layout-page .card .form-check-label {
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .layout-page .card h1,
  [data-bs-theme="dark"] .layout-page .card h2,
  [data-bs-theme="dark"] .layout-page .card h3,
  [data-bs-theme="dark"] .layout-page .card h4,
  [data-bs-theme="dark"] .layout-page .card h5,
  [data-bs-theme="dark"] .layout-page .card h6,
  [data-bs-theme="dark"] .layout-page .card .card-title,
  [data-bs-theme="dark"] .layout-page .text-heading,
  [data-bs-theme="dark"] .layout-page h1,
  [data-bs-theme="dark"] .layout-page h2,
  [data-bs-theme="dark"] .layout-page h3,
  [data-bs-theme="dark"] .layout-page h4,
  [data-bs-theme="dark"] .layout-page h5,
  [data-bs-theme="dark"] .layout-page h6,
  [data-bs-theme="dark"] .dropdown-item,
  [data-bs-theme="dark"] .dropdown-header h6 {
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .layout-page .text-muted,
  [data-bs-theme="dark"] .layout-page .card-subtitle,
  [data-bs-theme="dark"] .layout-page .text-body-secondary,
  [data-bs-theme="dark"] .layout-page .card small,
  [data-bs-theme="dark"] .layout-page .form-text,
  [data-bs-theme="dark"] .layout-page .form-group small {
    color: #a0a1b8 !important;
  }

  [data-bs-theme="dark"] .layout-page .text-body,
  [data-bs-theme="dark"] .layout-page a.text-body {
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .layout-page a:not(.btn):not(.badge):not(.nav-link):not(.dropdown-item) {
    color: #8592ff;
  }

  [data-bs-theme="dark"] .card .form-label,
  [data-bs-theme="dark"] .form-group > label,
  [data-bs-theme="dark"] label.form-label,
  [data-bs-theme="dark"] .minimal-form-group label {
    color: #a0a1b8 !important;
  }

  [data-bs-theme="dark"] .card .form-control,
  [data-bs-theme="dark"] .card .form-select,
  [data-bs-theme="dark"] .form-group input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="hidden"]),
  [data-bs-theme="dark"] .form-group select,
  [data-bs-theme="dark"] .form-group textarea,
  [data-bs-theme="dark"] .minimal-form-group input,
  [data-bs-theme="dark"] .minimal-form-group textarea,
  [data-bs-theme="dark"] .minimal-form-group select {
    color: #e7e7f0 !important;
    background-color: transparent !important;
    border-bottom-color: #434968 !important;
  }

  [data-bs-theme="dark"] .card .form-control::placeholder,
  [data-bs-theme="dark"] .form-group input::placeholder,
  [data-bs-theme="dark"] .form-group textarea::placeholder {
    color: #8b8da3 !important;
  }

  [data-bs-theme="dark"] .card .form-control:focus,
  [data-bs-theme="dark"] .card .form-select:focus,
  [data-bs-theme="dark"] .form-group input:focus,
  [data-bs-theme="dark"] .form-group select:focus,
  [data-bs-theme="dark"] .form-group textarea:focus {
    border-bottom-color: #8592ff !important;
  }

  [data-bs-theme="dark"] .card input[type="file"].form-control,
  [data-bs-theme="dark"] .form-group input[type="file"],
  [data-bs-theme="dark"] .card .form-check,
  [data-bs-theme="dark"] .form-group > label:has(input[type="checkbox"]) {
    background: rgba(255, 255, 255, 0.04) !important;
    border-color: #434968 !important;
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .layout-page .cnci-form-actions,
  [data-bs-theme="dark"] .layout-page .card .mt-4.d-flex,
  [data-bs-theme="dark"] .layout-page .card form > h3,
  [data-bs-theme="dark"] .layout-page .card .card-body > h5.mb-3 {
    border-color: #434968 !important;
  }

  [data-bs-theme="dark"] .layout-page table,
  [data-bs-theme="dark"] .layout-page .table,
  [data-bs-theme="dark"] .layout-page .table > :not(caption) > * > * {
    color: #cbcbe2 !important;
    border-color: #434968 !important;
    background-color: transparent !important;
  }

  [data-bs-theme="dark"] .layout-page .table thead th,
  [data-bs-theme="dark"] .layout-page table th {
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .layout-page .table-hover > tbody > tr:hover > * {
    background-color: rgba(255, 255, 255, 0.04) !important;
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .layout-page .list-group-item {
    background-color: transparent !important;
    color: #cbcbe2 !important;
    border-color: #434968 !important;
  }

  [data-bs-theme="dark"] .layout-page .border,
  [data-bs-theme="dark"] .layout-page .border-bottom,
  [data-bs-theme="dark"] .layout-page .border-top,
  [data-bs-theme="dark"] .dropdown-divider {
    border-color: #434968 !important;
  }

  [data-bs-theme="dark"] .layout-page .bg-light,
  [data-bs-theme="dark"] .layout-page .bg-label-secondary {
    background-color: rgba(255, 255, 255, 0.06) !important;
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .content-footer,
  [data-bs-theme="dark"] .footer {
    background-color: transparent !important;
    color: #a0a1b8 !important;
    border-top: 1px solid #434968 !important;
  }

  [data-bs-theme="dark"] .content-footer .footer-link,
  [data-bs-theme="dark"] .footer .footer-link {
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .view-page-card {
    background: linear-gradient(180deg, #363b54 0%, #2f3349 100%) !important;
    border-color: #434968 !important;
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .view-page-card h6 {
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .view-page-card p {
    color: #a0a1b8 !important;
  }

  [data-bs-theme="dark"] .view-page-card .open-label {
    color: #8592ff !important;
  }

  [data-bs-theme="dark"] .cnci-stat-card-danger {
    background: linear-gradient(135deg, #3a2a30 0%, #2f3349 70%) !important;
    border: 1px solid rgba(255, 62, 29, 0.28) !important;
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .cnci-stat-card-danger h4,
  [data-bs-theme="dark"] .cnci-stat-card-danger p {
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .swal2-popup.cnci-swal {
    background: #2f3349 !important;
    color: #cbcbe2 !important;
  }

  [data-bs-theme="dark"] .swal2-popup.cnci-swal .swal2-title {
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .swal2-popup.cnci-swal .swal2-html-container {
    color: #a0a1b8 !important;
  }

  /* Override common hardcoded light-only inline helpers inside admin pages */
  [data-bs-theme="dark"] .minimal-card,
  [data-bs-theme="dark"] .minimal-form-group input,
  [data-bs-theme="dark"] .minimal-form-group textarea,
  [data-bs-theme="dark"] .minimal-form-group select {
    color: #e7e7f0 !important;
  }

  [data-bs-theme="dark"] .section-title,
  [data-bs-theme="dark"] .subsection-title {
    color: #a0a1b8 !important;
    border-bottom-color: #434968 !important;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function () {
  // ── Light / Dark theme toggle ──
  const THEME_KEY = 'cnci-admin-theme';

  function getTheme() {
    try {
      return localStorage.getItem(THEME_KEY) || 'light';
    } catch (e) {
      return 'light';
    }
  }

  function setTheme(theme) {
    const next = theme === 'dark' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-bs-theme', next);
    document.documentElement.style.colorScheme = next;
    try {
      localStorage.setItem(THEME_KEY, next);
    } catch (e) {}

    const icon = document.getElementById('cnciThemeIcon');
    if (icon) {
      icon.className = next === 'dark'
        ? 'icon-base bx bx-sun icon-md'
        : 'icon-base bx bx-moon icon-md';
    }

    const btn = document.getElementById('cnciThemeToggle');
    if (btn) {
      btn.setAttribute('aria-label', next === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
      btn.setAttribute('title', next === 'dark' ? 'Light mode' : 'Dark mode');
    }
  }

  function toggleTheme() {
    setTheme(getTheme() === 'dark' ? 'light' : 'dark');
  }

  // Apply immediately (icon may not exist yet)
  setTheme(getTheme());

  document.addEventListener('DOMContentLoaded', function () {
    setTheme(getTheme());
    const toggle = document.getElementById('cnciThemeToggle');
    if (toggle) {
      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        toggleTheme();
      });
    }
  });

  window.cnciSetTheme = setTheme;
  window.cnciToggleTheme = toggleTheme;

  const flash = {
    success: @json(session('success') ?: session('contact_success')),
    error: @json(session('error')),
    warning: @json(session('warning')),
    info: @json(session('info')),
    denied: @json(session('denied')),
    validation: @json($errors->any() ? $errors->all() : []),
  };

  const toastBase = {
    customClass: {
      popup: 'cnci-swal',
      confirmButton: 'cnci-confirm',
      cancelButton: 'cnci-cancel',
    },
    buttonsStyling: true,
  };

  function showFlash() {
    if (flash.success) {
      Swal.fire({
        ...toastBase,
        icon: 'success',
        title: 'Success',
        text: flash.success,
        timer: 2600,
        showConfirmButton: false,
      });
      return;
    }

    if (flash.denied) {
      Swal.fire({
        ...toastBase,
        icon: 'error',
        title: 'Access denied',
        text: flash.denied,
        confirmButtonText: 'OK',
      });
      return;
    }

    if (flash.error) {
      Swal.fire({
        ...toastBase,
        icon: 'error',
        title: 'Something went wrong',
        text: flash.error,
        confirmButtonText: 'OK',
      });
      return;
    }

    if (flash.warning) {
      Swal.fire({
        ...toastBase,
        icon: 'warning',
        title: 'Notice',
        text: flash.warning,
        confirmButtonText: 'OK',
      });
      return;
    }

    if (flash.info) {
      Swal.fire({
        ...toastBase,
        icon: 'info',
        title: 'Info',
        text: flash.info,
        confirmButtonText: 'OK',
      });
      return;
    }

    if (flash.validation && flash.validation.length) {
      const list = flash.validation.map((m) => `<li style="text-align:left;margin:4px 0;">${m}</li>`).join('');
      Swal.fire({
        ...toastBase,
        icon: 'warning',
        title: 'Please check the form',
        html: `<ul style="padding-left:18px;margin:0;">${list}</ul>`,
        confirmButtonText: 'Fix fields',
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.alert-success, .alert-danger, .alert-warning, .alert-info').forEach((el) => {
      if (!((el.textContent || '').trim())) return;
      // Keep Sneat UI kit demo alerts visible
      if (/ui-alerts|ui-offcanvas/.test(window.location.pathname)) return;

      if (
        (flash.success && el.classList.contains('alert-success')) ||
        ((flash.error || flash.denied) && el.classList.contains('alert-danger')) ||
        (flash.validation && flash.validation.length && (el.classList.contains('alert-danger') || el.classList.contains('alert-warning')))
      ) {
        el.classList.add('swal-handled-flash');
      }
    });

    showFlash();

    // Confirm destructive actions
    document.querySelectorAll('form[data-swal-confirm], form[onsubmit*="confirm"]').forEach((form) => {
      let msg = form.getAttribute('data-swal-confirm');
      if (!msg) {
        const onsubmit = form.getAttribute('onsubmit') || '';
        const match = onsubmit.match(/confirm\s*\(\s*['"]([^'"]+)['"]\s*\)/);
        msg = match ? match[1] : 'Are you sure you want to continue? This cannot be undone.';
      }

      form.removeAttribute('onsubmit');
      form.addEventListener('submit', function (e) {
        if (form.dataset.swalConfirmed === '1') {
          form.dataset.swalConfirmed = '0';
          return;
        }
        e.preventDefault();
        Swal.fire({
          ...toastBase,
          icon: 'warning',
          title: 'Please confirm',
          text: msg,
          showCancelButton: true,
          confirmButtonText: 'Yes, continue',
          cancelButtonText: 'Cancel',
          reverseButtons: true,
        }).then((result) => {
          if (result.isConfirmed) {
            form.dataset.swalConfirmed = '1';
            form.submit();
          }
        });
      });
    });

    // Buttons with data-swal-confirm on forms without attribute on form itself
    document.querySelectorAll('button[data-swal-confirm], a[data-swal-confirm]').forEach((el) => {
      el.addEventListener('click', function (e) {
        const msg = el.getAttribute('data-swal-confirm') || 'Are you sure?';
        const form = el.closest('form');
        if (!form && el.tagName === 'A') {
          e.preventDefault();
          const href = el.getAttribute('href');
          Swal.fire({
            ...toastBase,
            icon: 'warning',
            title: 'Please confirm',
            text: msg,
            showCancelButton: true,
            confirmButtonText: 'Yes, continue',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
          }).then((result) => {
            if (result.isConfirmed && href) window.location.href = href;
          });
        }
      });
    });
  });

  // Global helper for 403 / denied from JS
  window.cnciDenied = function (message) {
    Swal.fire({
      ...toastBase,
      icon: 'error',
      title: 'Access denied',
      text: message || 'You do not have permission to do that.',
      confirmButtonText: 'OK',
    });
  };
})();
</script>
