@extends('layouts/contentNavbarLayout')
@section('title', 'Home Page Settings')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Home Page Settings</h4>
  <p class="text-muted mb-0">Edit mission, about, and contact panel content.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('content.dashboard.home.update') }}" method="POST">
      @csrf
      @method('PUT')

      <h3>Mission &amp; Purpose</h3>
      <div class="form-group">
        <label>Mission Text</label>
        <textarea name="mission_text">{{ old('mission_text', $settings->mission_text) }}</textarea>
      </div>
      <div class="form-group">
        <label>Purpose Text</label>
        <textarea name="purpose_text">{{ old('purpose_text', $settings->purpose_text) }}</textarea>
      </div>

      <h3>About Us</h3>
      <div class="form-group">
        <label>About Text</label>
        <textarea name="about_text" style="min-height:120px;">{{ old('about_text', $settings->about_text) }}</textarea>
      </div>

      <h3>Contact Info Panel</h3>
      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-group mb-0">
            <label>Phone</label>
            <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group mb-0">
            <label>Email</label>
            <input type="text" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group mb-0">
            <label>Address</label>
            <input type="text" name="contact_address" value="{{ old('contact_address', $settings->contact_address) }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group mb-0">
            <label>Office Hours</label>
            <input type="text" name="contact_hours" value="{{ old('contact_hours', $settings->contact_hours) }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group mb-0">
            <label>Website</label>
            <input type="text" name="contact_website" value="{{ old('contact_website', $settings->contact_website) }}">
          </div>
        </div>
      </div>

      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save Settings</button>
      </div>
    </form>
  </div>
</div>
@endsection
