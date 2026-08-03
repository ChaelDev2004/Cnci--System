@php
  $activeNav = 'gallery';
@endphp
@extends('layouts.public')

@section('title', 'Gallery — ' . $siteSettings->brandName())

@push('styles')
<style>
  .hero {
    background: linear-gradient(135deg, rgba(193,30,42,.92), rgba(2,72,134,.92));
    color: #fff;
    text-align: center;
    padding: clamp(56px, 10vw, 96px) 20px;
  }
  .hero h1 {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    letter-spacing: -0.02em;
    margin-bottom: 10px;
  }
  .hero p {
    max-width: 560px;
    margin: 0 auto;
    color: rgba(255,255,255,0.88);
    font-size: 1.05rem;
  }
  .gallery-wrap { padding: clamp(32px, 5vw, 56px) 0 72px; background: #f7f7f8; }
  .container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
  .filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 28px;
    justify-content: center;
  }
  .filters a {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 999px;
    background: #fff;
    border: 1px solid #e8e8e8;
    color: #5c5c5c;
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
  }
  .filters a:hover,
  .filters a.active {
    background: #024886;
    border-color: #024886;
    color: #fff;
  }
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
  }
  .gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    border: 1px solid #e8e8e8;
    cursor: pointer;
    aspect-ratio: 4 / 3;
    border: 0;
    padding: 0;
    width: 100%;
  }
  .gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .35s ease;
  }
  .gallery-item:hover img { transform: scale(1.06); }
  .gallery-meta {
    position: absolute;
    left: 0; right: 0; bottom: 0;
    padding: 28px 14px 12px;
    background: linear-gradient(transparent, rgba(0,0,0,.72));
    color: #fff;
    text-align: left;
  }
  .gallery-meta strong { display: block; font-size: 0.9rem; }
  .gallery-meta span { font-size: 0.78rem; opacity: .85; }
  .empty {
    text-align: center;
    background: #fff;
    border: 1px dashed #e8e8e8;
    border-radius: 16px;
    padding: 48px 20px;
    color: #5c5c5c;
  }
  .lightbox {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.88);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    padding: 20px;
  }
  .lightbox.open { display: flex; }
  .lightbox img {
    max-width: min(960px, 100%);
    max-height: min(82vh, 100%);
    border-radius: 12px;
    object-fit: contain;
  }
  .lightbox-close {
    position: absolute;
    top: 18px;
    right: 22px;
    color: #fff;
    font-size: 1.6rem;
    background: transparent;
    border: 0;
    cursor: pointer;
  }
  .lightbox-caption {
    position: absolute;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255,255,255,.9);
    text-align: center;
    font-size: 0.92rem;
    max-width: 90%;
  }
  @media (max-width: 900px) {
    .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  }
  @media (max-width: 480px) {
    .gallery-grid { grid-template-columns: 1fr; }
  }
</style>
@endpush

@section('content')
<header class="hero">
  <h1>Gallery</h1>
  <p>Moments from CNCI churches, worship, and community life across our branches.</p>
</header>

<section class="gallery-wrap">
  <div class="container">
    @if($pastors->isNotEmpty())
      <div class="filters">
        <a href="{{ route('gallery') }}" class="{{ !$pastorId ? 'active' : '' }}">All</a>
        @foreach($pastors as $pastor)
          <a href="{{ route('gallery', ['pastor' => $pastor->id]) }}"
             class="{{ (string) $pastorId === (string) $pastor->id ? 'active' : '' }}">
            {{ $pastor->church ?: $pastor->name }}
          </a>
        @endforeach
      </div>
    @endif

    @if($images->isEmpty())
      <div class="empty">
        <p>No gallery photos yet. Branch pastors can upload images from the admin Gallery.</p>
      </div>
    @else
      <div class="gallery-grid">
        @foreach($images as $image)
          <button
            type="button"
            class="gallery-item"
            data-src="{{ asset('storage/' . $image->path) }}"
            data-caption="{{ $image->caption ?: (($image->pastor->church ?? $image->pastor->name ?? 'CNCI') . ($image->pastor ? ' · ' . $image->pastor->name : '')) }}">
            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?: 'Gallery photo' }}" loading="lazy">
            <div class="gallery-meta">
              <strong>{{ $image->caption ?: ($image->pastor->church ?? 'CNCI Church') }}</strong>
              @if($image->pastor)
                <span>{{ $image->pastor->name }}</span>
              @endif
            </div>
          </button>
        @endforeach
      </div>
    @endif
  </div>
</section>

<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Gallery image">
  <button type="button" class="lightbox-close" id="lightboxClose" aria-label="Close">&times;</button>
  <img src="" alt="" id="lightboxImg">
  <div class="lightbox-caption" id="lightboxCaption"></div>
</div>
@endsection

@push('scripts')
<script>
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const closeBtn = document.getElementById('lightboxClose');

  document.querySelectorAll('.gallery-item').forEach((item) => {
    item.addEventListener('click', () => {
      lightboxImg.src = item.dataset.src;
      lightboxImg.alt = item.dataset.caption || 'Gallery photo';
      lightboxCaption.textContent = item.dataset.caption || '';
      lightbox.classList.add('open');
    });
  });

  function closeLightbox() {
    lightbox.classList.remove('open');
    lightboxImg.src = '';
  }

  closeBtn.addEventListener('click', closeLightbox);
  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeLightbox();
  });
</script>
@endpush
