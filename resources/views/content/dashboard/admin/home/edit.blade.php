@extends('layouts/contentNavbarLayout')
@section('title', 'Home Page Settings')

@section('content')
<div class="card">
  <form action="{{ route('content.dashboard.home.update') }}" method="POST">
    @csrf @method('PUT')

    <h3 style="margin-bottom:12px;">Mission & Purpose</h3>
    <div class="form-group">
      <label>Mission Text</label>
      <textarea name="mission_text">{{ old('mission_text', $settings->mission_text) }}</textarea>
    </div>
    <div class="form-group">
      <label>Purpose Text</label>
      <textarea name="purpose_text">{{ old('purpose_text', $settings->purpose_text) }}</textarea>
    </div>

    <h3 style="margin:20px 0 12px;">About Us</h3>
    <div class="form-group">
      <label>About Text</label>
      <textarea name="about_text" style="min-height:120px;">{{ old('about_text', $settings->about_text) }}</textarea>
    </div>

    <h3 style="margin:20px 0 12px;">Contact Info Panel</h3>
    <div class="form-group">
      <label>Phone</label>
      <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="text" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}">
    </div>
    <div class="form-group">
      <label>Address</label>
      <input type="text" name="contact_address" value="{{ old('contact_address', $settings->contact_address) }}">
    </div>
    <div class="form-group">
      <label>Office Hours</label>
      <input type="text" name="contact_hours" value="{{ old('contact_hours', $settings->contact_hours) }}">
    </div>
    <div class="form-group">
      <label>Website</label>
      <input type="text" name="contact_website" value="{{ old('contact_website', $settings->contact_website) }}">
    </div>

    <button class="btn" type="submit">Save Settings</button>
  </form>
</div>
@endsection