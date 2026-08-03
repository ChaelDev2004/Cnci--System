@php
  $activeNav = 'findus';
  $defaultVisitLink = ($defaultLocation->visit_link ?? null)
    ?: (($defaultLocation->pastor_id ?? null) ? route('pastor.show', $defaultLocation->pastor_id) : '#');
@endphp
@extends('layouts.public')

@section('title', 'Find Us — ' . $siteSettings->brandName())

@push('styles')
<style>
  :root {
    --text: #222;
    --muted: #5c5c5c;
    --red: #c41e2a;
    --blue: #024886;
  }
  .container { width: min(1100px, calc(100% - 40px)); margin: 0 auto; }
  .hero {
    position: relative;
    min-height: 42vh;
    display: grid;
    place-items: center;
    text-align: center;
    color: #fff;
    overflow: hidden;
    padding: 70px 20px;
    background:
      linear-gradient(180deg, rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.7)),
      url('{{ asset('assets/img/backgrounds/aboutUs-bg.png') }}') center/cover no-repeat;
  }
  .hero h1 {
    font-size: clamp(2.2rem, 5vw, 3.4rem);
    font-weight: 800;
    letter-spacing: -0.03em;
    margin-bottom: 12px;
  }
  .hero p {
    max-width: 560px;
    margin: 0 auto;
    color: rgba(255, 255, 255, 0.88);
  }
  .section { padding: 64px 0; }
  .find-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.95fr;
    gap: 28px;
    align-items: stretch;
  }
  .map-frame {
    border-radius: 18px;
    overflow: hidden;
    background: #f3f4f6;
    min-height: 420px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
  }
  .map-frame iframe {
    width: 100%;
    height: 100%;
    min-height: 420px;
    border: 0;
    display: block;
  }
  .panel {
    background: #fff;
    border: 1px solid #ececec;
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.05);
  }
  .badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f0f4ff;
    color: var(--blue);
    font-size: 0.78rem;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 999px;
    margin-bottom: 12px;
  }
  .panel h2 { font-size: 1.55rem; font-weight: 800; margin-bottom: 8px; }
  .panel .intro { color: var(--muted); margin-bottom: 22px; font-size: 0.96rem; }
  label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: #444; }
  select {
    width: 100%;
    border: 1px solid #d9dee3;
    border-radius: 10px;
    padding: 12px 14px;
    font: inherit;
    margin-bottom: 18px;
    background: #fff;
  }
  .church-card {
    border: 1px solid #ececec;
    border-radius: 14px;
    padding: 18px;
    background: #fafafa;
  }
  .church-name { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px; }
  .church-name h3 { font-size: 1.05rem; font-weight: 700; line-height: 1.35; }
  .pin-icon {
    width: 34px; height: 34px; border-radius: 50%;
    background: var(--blue); color: #fff;
    display: grid; place-items: center; flex-shrink: 0;
  }
  .church-address {
    color: var(--muted); font-size: 0.92rem; margin-bottom: 14px;
    display: flex; gap: 8px; align-items: flex-start;
  }
  .meta {
    color: var(--blue); font-weight: 600; font-size: 0.9rem;
    margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
  }
  .pastor-line { font-size: 0.9rem; color: #666; margin-top: 12px; text-align: center; }
  .actions { display: flex; flex-direction: column; gap: 10px; }
  .btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    padding: 12px 18px; border-radius: 999px; font-weight: 600; font-size: 0.92rem;
    border: 1.5px solid transparent; transition: 0.2s ease; text-decoration: none;
  }
  .btn-primary { background: linear-gradient(135deg, var(--blue), #0369a1); color: #fff; }
  .btn-primary:hover { filter: brightness(1.05); color: #fff; }
  .btn-outline { background: #fff; border-color: #333; color: #222; }
  .btn-outline:hover { background: #111; color: #fff; }
  .empty {
    text-align: center; color: #777; padding: 40px 20px;
    border: 1px dashed #ddd; border-radius: 14px;
  }
  @media (max-width: 900px) {
    .find-grid { grid-template-columns: 1fr; }
    .map-frame, .map-frame iframe { min-height: 280px; }
  }
</style>
@endpush

@section('content')
<header class="hero">
  <div>
    <h1>Find Us</h1>
    <p>Choose a CNCI location near you, get directions, and meet the pastor serving that church.</p>
  </div>
</header>

<section class="section">
  <div class="container">
    @if($locations->isEmpty())
      <div class="empty">
        <i class="fas fa-map-location-dot" style="font-size:2rem;color:var(--blue);margin-bottom:10px;"></i>
        <p>Church locations will appear here once they are added in Admin → Find Us.</p>
      </div>
    @else
      <div class="find-grid">
        <div class="map-frame">
          <iframe
            id="mapIframe"
            src="{{ $defaultLocation->map_embed_url ?? '' }}"
            title="Church location map"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="panel">
          <span class="badge"><i class="fas fa-church"></i> CNCI Church</span>
          <h2>Find a Church Near You</h2>
          <p class="intro">God created you on purpose for a purpose. We would love to welcome you this Sunday.</p>

          <label for="churchSelect"><i class="fas fa-location-dot"></i> Choose a location</label>
          <select id="churchSelect">
            @foreach($locations as $loc)
              @php
                $visit = $loc->visit_link ?: ($loc->pastor_id ? route('pastor.show', $loc->pastor_id) : '#');
              @endphp
              <option
                value="{{ $loc->id }}"
                data-name="{{ $loc->name }}"
                data-address="{{ $loc->address }}"
                data-maps="{{ $loc->maps_link }}"
                data-time="{{ $loc->service_time }}"
                data-embed="{{ $loc->map_embed_url }}"
                data-visit="{{ $visit }}"
                data-pastor="{{ $loc->pastor->name ?? '' }}"
                {{ $defaultLocation && $loc->id === $defaultLocation->id ? 'selected' : '' }}>
                {{ $loc->city }}
              </option>
            @endforeach
          </select>

          <div class="church-card">
            <div class="church-name">
              <span class="pin-icon"><i class="fas fa-place-of-worship"></i></span>
              <h3 id="churchNameDisplay">{{ $defaultLocation->name ?? '' }}</h3>
            </div>
            <div class="church-address">
              <i class="fas fa-map-pin"></i>
              <span id="churchAddressDisplay">{{ $defaultLocation->address ?? '' }}</span>
            </div>
            <div class="meta" id="churchMetaDisplay">
              <i class="fas fa-clock"></i>
              <span>Service: {{ $defaultLocation->service_time ?? 'TBA' }}</span>
            </div>
            <div class="actions">
              <a href="{{ $defaultLocation->maps_link ?? '#' }}" id="openMapsBtn" class="btn btn-outline" target="_blank" rel="noopener">
                <i class="fas fa-map"></i> Open in Google Maps
              </a>
              <a href="{{ $defaultVisitLink }}" id="visitUsBtn" class="btn btn-primary">
                <i class="fas fa-hand-wave"></i> Meet Our Pastor
              </a>
            </div>
            <div class="pastor-line" id="pastorDisplay" @if(!($defaultLocation->pastor->name ?? null)) style="display:none" @endif>
              <i class="fas fa-user"></i>
              Pastored by: <strong id="pastorName">{{ $defaultLocation->pastor->name ?? '' }}</strong>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</section>
@endsection

@push('scripts')
@if($locations->isNotEmpty())
<script>
  document.getElementById('churchSelect').addEventListener('change', function () {
    const option = this.options[this.selectedIndex];
    document.getElementById('churchNameDisplay').textContent = option.dataset.name || '';
    document.getElementById('churchAddressDisplay').textContent = option.dataset.address || '';
    document.getElementById('openMapsBtn').href = option.dataset.maps || '#';
    document.getElementById('churchMetaDisplay').innerHTML =
      '<i class="fas fa-clock"></i><span>Service: ' + (option.dataset.time || 'TBA') + '</span>';
    document.getElementById('mapIframe').src = option.dataset.embed || '';
    document.getElementById('visitUsBtn').href = option.dataset.visit || '#';

    const pastorDisplay = document.getElementById('pastorDisplay');
    const pastorName = option.dataset.pastor || '';
    if (pastorName) {
      document.getElementById('pastorName').textContent = pastorName;
      pastorDisplay.style.display = '';
    } else {
      pastorDisplay.style.display = 'none';
    }
  });
</script>
@endif
@endpush
