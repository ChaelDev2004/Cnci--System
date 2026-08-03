@extends('layouts.app')

@section('title', $pastor->name . ' - CNCI Church')

@section('content')
<style>
  .pastor-detail-page {
    padding: 60px 20px;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
  }

  .pastor-detail-card {
    max-width: 1100px;
    margin: 0 auto;
    background: white;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    animation: fadeInUp 0.6s ease;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .pastor-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 50px;
    padding: 50px;
  }

  .pastor-image-wrapper {
    position: relative;
  }

  .pastor-image-wrapper img {
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    object-fit: cover;
    aspect-ratio: 1/1;
  }

  .pastor-image-placeholder {
    width: 100%;
    aspect-ratio: 1/1;
    background: linear-gradient(135deg, #2d7c3a, #1a5a2a);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 100px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .pastor-badge {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    background: rgba(45, 124, 58, 0.95);
    color: white;
    padding: 12px 20px;
    border-radius: 15px;
    text-align: center;
    font-weight: 600;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .pastor-badge i {
    margin-right: 8px;
  }

  .pastor-name {
    font-size: 2.8rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 5px 0;
    line-height: 1.2;
  }

  .pastor-role {
    color: #2d7c3a;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 5px 0;
  }

  .pastor-church {
    color: #666;
    font-size: 1.1rem;
    margin: 5px 0 20px 0;
  }

  .pastor-church i {
    color: #2d7c3a;
    margin-right: 8px;
  }

  .section-title {
    color: #1a1a1a;
    font-size: 1.3rem;
    font-weight: 700;
    margin: 30px 0 15px 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .section-title i {
    color: #2d7c3a;
    font-size: 1.4rem;
  }

  .pastor-bio {
    color: #444;
    line-height: 1.9;
    font-size: 1.05rem;
    margin-bottom: 25px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 15px;
    border-left: 4px solid #2d7c3a;
  }

  .pastor-bio p {
    margin: 0;
  }

  .contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin: 15px 0 25px 0;
  }

  .contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s;
    text-decoration: none;
    color: #333;
  }

  .contact-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
  }

  .contact-item i {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #2d7c3a;
    color: white;
    border-radius: 50%;
    font-size: 0.9rem;
    flex-shrink: 0;
  }

  .contact-item .contact-label {
    font-size: 0.85rem;
    color: #888;
    display: block;
  }

  .contact-item .contact-value {
    font-weight: 600;
    color: #1a1a1a;
    display: block;
  }

  .contact-item a {
    color: #2d7c3a;
    text-decoration: none;
  }

  .contact-item a:hover {
    text-decoration: underline;
  }

  .social-links {
    display: flex;
    gap: 12px;
    margin: 20px 0 10px 0;
    flex-wrap: wrap;
  }

  .social-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    border-radius: 50px;
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s;
  }

  .social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    color: white;
    text-decoration: none;
  }

  .social-link.facebook {
    background: #1877f2;
  }

  .social-link.instagram {
    background: #e4405f;
  }

  .social-link.youtube {
    background: #ff0000;
  }

  .social-link.email {
    background: #555;
  }

  .action-buttons {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    flex-wrap: wrap;
  }

  .btn-primary-custom {
    padding: 14px 35px;
    background: linear-gradient(135deg, #2d7c3a, #1a5a2a);
    color: white;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: none;
    cursor: pointer;
  }

  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(45, 124, 58, 0.4);
    color: white;
    text-decoration: none;
  }

  .btn-secondary-custom {
    padding: 14px 35px;
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
  }

  .btn-secondary-custom:hover {
    background: #2d7c3a;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
  }

  /* Service Times Section */
  .service-times-section {
    background: #f8f9fa;
    padding: 30px 50px;
    border-top: 1px solid #e0e0e0;
  }

  .service-times-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 15px;
  }

  .service-card {
    background: white;
    padding: 20px 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s;
    border-left: 4px solid #2d7c3a;
  }

  .service-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  }

  .service-card .church-name {
    font-weight: 700;
    color: #1a1a1a;
    font-size: 1.1rem;
    margin-bottom: 5px;
  }

  .service-card .church-city {
    color: #888;
    font-size: 0.9rem;
    margin-bottom: 8px;
  }

  .service-card .church-time {
    color: #2d7c3a;
    font-weight: 600;
  }

  .service-card .church-time i {
    margin-right: 5px;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .pastor-grid {
      grid-template-columns: 1fr;
      gap: 30px;
      padding: 30px;
    }

    .pastor-image-wrapper img,
    .pastor-image-placeholder {
      max-width: 400px;
      margin: 0 auto;
    }

    .pastor-name {
      font-size: 2.2rem;
    }
  }

  @media (max-width: 768px) {
    .pastor-grid {
      padding: 20px;
    }

    .contact-grid {
      grid-template-columns: 1fr;
    }

    .service-times-section {
      padding: 20px;
    }

    .action-buttons {
      flex-direction: column;
    }

    .action-buttons a {
      justify-content: center;
    }

    .pastor-name {
      font-size: 1.8rem;
    }

    .pastor-bio {
      padding: 15px;
      font-size: 0.95rem;
    }
  }
</style>

<div class="pastor-detail-page">
  <div class="pastor-detail-card">
    <div class="pastor-grid">
      <!-- Left Column - Image -->
      <div class="pastor-image-wrapper">
        @if($pastor->image)
        <img src="{{ asset('storage/' . $pastor->image) }}"
          alt="{{ $pastor->name }}"
          loading="lazy">
        @else
        <div class="pastor-image-placeholder">
          <i class="fas fa-user-pastor"></i>
        </div>
        @endif

        @if($pastor->role)
        <div class="pastor-badge">
          <i class="fas fa-cross"></i> {{ $pastor->role }}
        </div>
        @endif
      </div>

      <!-- Right Column - Details -->
      <div class="pastor-details">
        <h1 class="pastor-name">{{ $pastor->name }}</h1>

        @if($pastor->church)
        <p class="pastor-church">
          <i class="fas fa-church"></i> {{ $pastor->church }}
        </p>
        @endif

        <!-- Biography -->
        @if($pastor->bio)
        <div class="section-title">
          <i class="fas fa-book-open"></i> About Pastor {{ $pastor->name }}
        </div>
        <div class="pastor-bio">
          <p>{{ $pastor->bio }}</p>
        </div>
        @endif

        <!-- Contact Information -->
        @if($pastor->email || $pastor->phone)
        <div class="section-title">
          <i class="fas fa-address-card"></i> Contact Information
        </div>
        <div class="contact-grid">
          @if($pastor->email)
          <a href="mailto:{{ $pastor->email }}" class="contact-item">
            <i class="fas fa-envelope"></i>
            <div>
              <span class="contact-label">Email</span>
              <span class="contact-value">{{ $pastor->email }}</span>
            </div>
          </a>
          @endif

          @if($pastor->phone)
          <a href="tel:{{ $pastor->phone }}" class="contact-item">
            <i class="fas fa-phone"></i>
            <div>
              <span class="contact-label">Phone</span>
              <span class="contact-value">{{ $pastor->phone }}</span>
            </div>
          </a>
          @endif
        </div>
        @endif

        <!-- Social Media -->
        @if($pastor->facebook || $pastor->instagram || $pastor->youtube)
        <div class="section-title">
          <i class="fas fa-share-alt"></i> Connect on Social Media
        </div>
        <div class="social-links">
          @if($pastor->facebook)
          <a href="{{ $pastor->facebook }}" target="_blank" rel="noopener noreferrer" class="social-link facebook">
            <i class="fab fa-facebook-f"></i> Facebook
          </a>
          @endif

          @if($pastor->instagram)
          <a href="{{ $pastor->instagram }}" target="_blank" rel="noopener noreferrer" class="social-link instagram">
            <i class="fab fa-instagram"></i> Instagram
          </a>
          @endif

          @if($pastor->youtube)
          <a href="{{ $pastor->youtube }}" target="_blank" rel="noopener noreferrer" class="social-link youtube">
            <i class="fab fa-youtube"></i> YouTube
          </a>
          @endif

          @if($pastor->email)
          <a href="mailto:{{ $pastor->email }}" class="social-link email">
            <i class="fas fa-envelope"></i> Email
          </a>
          @endif
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
          <a href="{{ url('/') }}#findUs" class="btn-primary-custom">
            <i class="fas fa-arrow-left"></i> Back to Locations
          </a>

          @if($pastor->locations->count() > 0)
          <a href="{{ url('/') }}#findUs" class="btn-secondary-custom">
            <i class="fas fa-church"></i> Find Our Church
          </a>
          @endif
        </div>
      </div>
    </div>

    <!-- Service Times Section -->
    @if($pastor->locations->count() > 0)
    <div class="service-times-section">
      <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 5px;">
        <i class="fas fa-clock" style="color: #2d7c3a; font-size: 1.5rem;"></i>
        <h3 style="margin: 0; color: #1a1a1a;">Service Times</h3>
        <span style="margin-left: auto; color: #888; font-size: 0.9rem;">
          {{ $pastor->locations->count() }} location(s)
        </span>
      </div>
      <p style="color: #666; margin-top: 5px; margin-bottom: 15px;">
        Join us at one of our church locations pastored by {{ $pastor->name }}
      </p>

      <div class="service-times-grid">
        @foreach($pastor->locations as $location)
        <div class="service-card">
          <div class="church-name">
            <i class="fas fa-place-of-worship" style="color: #2d7c3a; margin-right: 8px;"></i>
            {{ $location->name }}
          </div>
          <div class="church-city">
            <i class="fas fa-map-pin"></i> {{ $location->city }}
          </div>
          @if($location->address)
          <div style="color: #888; font-size: 0.85rem; margin: 5px 0;">
            {{ $location->address }}
          </div>
          @endif
          @if($location->service_time)
          <div class="church-time">
            <i class="fas fa-clock"></i> {{ $location->service_time }}
          </div>
          @endif
          <a href="{{ $location->maps_link ?? '#' }}" target="_blank"
            style="display: inline-block; margin-top: 10px; color: #2d7c3a; font-size: 0.85rem; text-decoration: none;">
            <i class="fas fa-map"></i> Get Directions
          </a>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

@push('styles')
<style>
  /* Additional styles if needed */
  .pastor-detail-page {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
  }
</style>
@endpush