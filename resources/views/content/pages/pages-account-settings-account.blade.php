@extends('layouts/contentNavbarLayout')

@section('title', 'Account Settings')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="alert alert-danger mb-3">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="row">
  <div class="col-md-12">
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills flex-column flex-md-row gap-2">
        <li class="nav-item">
          <a class="nav-link active" href="#profile"><i class="bx bx-user me-1"></i> Profile</a>
        </li>
        @if(!$user->isBranch())
        <li class="nav-item">
          <a class="nav-link" href="#branding"><i class="bx bx-palette me-1"></i> Branding / CMS</a>
        </li>
        @endif
      </ul>
    </div>

    {{-- PROFILE --}}
    <div class="card mb-4" id="profile">
      <div class="card-header">
        <h5 class="mb-0">Your Profile</h5>
        <small class="text-muted">Update your admin account details</small>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.account.profile') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="d-flex align-items-start gap-4 pb-4 border-bottom mb-4">
            <img
              src="{{ $user->avatarUrl() }}"
              alt="Avatar"
              class="rounded"
              style="width:100px;height:100px;object-fit:cover;"
              id="avatarPreview">
            <div>
              <label class="btn btn-primary mb-2" for="avatar">
                Upload photo
                <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*" onchange="previewImage(this, 'avatarPreview')">
              </label>
              <div class="text-muted small">JPG or PNG. Max 2MB.</div>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="name">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="phone">Phone</label>
              <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Optional">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="password">New Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="password_confirmation">Confirm Password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
            </div>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Profile</button>
          </div>
        </form>
      </div>
    </div>

    {{-- BRANDING --}}
    @if(!$user->isBranch())
    <div class="card mb-4" id="branding">
      <div class="card-header">
        <h5 class="mb-0">Site Branding</h5>
        <small class="text-muted">CMS controls for brand name, logo, and favicon across the site</small>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.account.branding') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label" for="brand_name">Brand Name</label>
              <input type="text" class="form-control" id="brand_name" name="brand_name"
                value="{{ old('brand_name', $settings->brand_name) }}" placeholder="CNCI">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="brand_tagline">Brand Tagline</label>
              <input type="text" class="form-control" id="brand_tagline" name="brand_tagline"
                value="{{ old('brand_tagline', $settings->brand_tagline) }}" placeholder="Rosales">
            </div>
          </div>

          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label">Logo</label>
              <div class="d-flex align-items-center gap-3 mb-2">
                <img
                  src="{{ $settings->logoUrl() }}"
                  alt="Logo preview"
                  id="logoPreview"
                  style="width:80px;height:80px;object-fit:contain;border-radius:12px;background:#f5f5f5;padding:6px;">
                <div>
                  <input type="file" name="logo" id="logo" class="form-control" accept="image/*" onchange="previewImage(this, 'logoPreview')">
                  <div class="text-muted small mt-1">Shown in admin sidebar and public pages. Max 4MB.</div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Favicon</label>
              <div class="d-flex align-items-center gap-3 mb-2">
                <img
                  src="{{ $settings->faviconUrl() }}"
                  alt="Favicon preview"
                  id="faviconPreview"
                  style="width:48px;height:48px;object-fit:contain;border-radius:8px;background:#f5f5f5;padding:4px;">
                <div>
                  <input type="file" name="favicon" id="favicon" class="form-control" accept=".ico,image/png,image/jpeg,image/svg+xml,image/webp" onchange="previewImage(this, 'faviconPreview')">
                  <div class="text-muted small mt-1">Browser tab icon. ICO/PNG recommended. Max 1MB.</div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Branding</button>
          </div>
        </form>
      </div>
    </div>
    @endif
  </div>
</div>

<script>
function previewImage(input, previewId) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = function (e) {
    document.getElementById(previewId).src = e.target.result;
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
