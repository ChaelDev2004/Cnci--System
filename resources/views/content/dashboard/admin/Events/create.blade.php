@extends('layouts/contentNavbarLayout')

@section('title', 'Create Event')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Create New Event</h1>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Back
    </a>
  </div>

  <!-- Display validation errors -->
  @if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Validation Errors:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="eventForm">
        @csrf

        <div class="row">
          <div class="col-md-8">
            <!-- Title -->
            <div class="mb-3">
              <label for="title" class="form-label">Title *</label>
              <input type="text" class="form-control @error('title') is-invalid @enderror"
                id="title" name="title" value="{{ old('title') }}" required>
              @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Tag -->
            <div class="mb-3">
              <label for="tag" class="form-label">Tag</label>
              <input type="text" class="form-control @error('tag') is-invalid @enderror"
                id="tag" name="tag" value="{{ old('tag') }}" placeholder="e.g., Weekly, Youth, Conference">
              @error('tag')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
              <label for="description" class="form-label">Description *</label>
              <textarea class="form-control @error('description') is-invalid @enderror"
                id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
              @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Date and Time -->
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="date" class="form-label">Date</label>
                  <input type="text" class="form-control @error('date') is-invalid @enderror"
                    id="date" name="date" value="{{ old('date') }}" placeholder="e.g., Every Sunday">
                  @error('date')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="time" class="form-label">Time</label>
                  <input type="text" class="form-control @error('time') is-invalid @enderror"
                    id="time" name="time" value="{{ old('time') }}" placeholder="e.g., 9:00 AM & 11:00 AM">
                  @error('time')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Location -->
            <div class="mb-3">
              <label for="location" class="form-label">Location</label>
              <input type="text" class="form-control @error('location') is-invalid @enderror"
                id="location" name="location" value="{{ old('location') }}">
              @error('location')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Button Text and URL -->
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="button_text" class="form-label">Button Text</label>
                  <input type="text" class="form-control @error('button_text') is-invalid @enderror"
                    id="button_text" name="button_text" value="{{ old('button_text', 'Learn More') }}">
                  @error('button_text')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="button_url" class="form-label">Button URL</label>
                  <input type="url" class="form-control @error('button_url') is-invalid @enderror"
                    id="button_url" name="button_url" value="{{ old('button_url') }}" placeholder="https://...">
                  @error('button_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Event Date -->
            <div class="mb-3">
              <label for="event_date" class="form-label">Event Date (for sorting)</label>
              <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror"
                id="event_date" name="event_date" value="{{ old('event_date') }}">
              @error('event_date')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="text-muted">Used for ordering upcoming events</small>
            </div>
          </div>

          <div class="col-md-4">
            <!-- Image Upload -->
            <div class="mb-3">
              <label for="image_file" class="form-label">Event Image</label>
              <input type="file" class="form-control @error('image_file') is-invalid @enderror"
                id="image_file" name="image_file" accept="image/*">
              @error('image_file')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="text-muted">Max 5MB. Recommended: 800x500px</small>
              <div id="imagePreview" class="mt-2" style="display:none;">
                <img id="preview" src="#" alt="Preview" style="max-width:100%;max-height:200px;border-radius:8px;">
              </div>
            </div>

            <!-- Image URL -->
            <div class="mb-3">
              <label for="image_url" class="form-label">Or Image URL</label>
              <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://...">
              @error('image_url')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Active Status - FIXED CHECKBOX -->
            <div class="mb-3">
              <div class="form-check form-switch">
                <!-- Hidden input ensures a value is always sent -->
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
              </div>
            </div>

            <!-- Sort Order -->
            <div class="mb-3">
              <label for="sort_order" class="form-label">Sort Order</label>
              <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
              @error('sort_order')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary" id="submitBtn">
            <i class="fas fa-save"></i> Create Event
          </button>
          <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Image preview
    document.getElementById('image_file').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });

    // Form submission loading state
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...';
    });

    // Display validation errors with SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any())
            let errorMessages = '';
            @foreach($errors->all() as $error)
                errorMessages += '<li>{{ $error }}</li>';
            @endforeach
            
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error!',
                html: `<ul style="text-align: left; padding-left: 20px;">${errorMessages}</ul>`,
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'Got it!',
            });
        @endif
    });
</script>
@endpush