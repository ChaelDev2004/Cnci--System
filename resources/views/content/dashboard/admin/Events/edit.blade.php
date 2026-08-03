  @extends('layouts/contentNavbarLayout')
  @error('button_url')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
  </div>
  </div>
  </div>

  <div class="mb-3">
    <label for="event_date" class="form-label">Event Date (for sorting)</label>
    <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror"
      id="event_date" name="event_date" value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d\TH:i') : '') }}">
    @error('event_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="text-muted">Used for ordering upcoming events</small>
  </div>
  </div>

  <div class="col-md-4">
    @if($event->image_url)
    <div class="mb-3">
      <label class="form-label">Current Image</label>
      <div>
        <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
          style="max-width:100%;max-height:200px;object-fit:cover;border-radius:8px;">
      </div>
    </div>
    @endif

    <div class="mb-3">
      <label for="image_file" class="form-label">Replace Image</label>
      <input type="file" class="form-control @error('image_file') is-invalid @enderror"
        id="image_file" name="image_file" accept="image/*">
      @error('image_file')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      <small class="text-muted">Max 5MB. Recommended: 800x500px</small>
    </div>

    <div class="mb-3">
      <label for="image_url" class="form-label">Or Image URL</label>
      <input type="url" class="form-control @error('image_url') is-invalid @enderror"
        id="image_url" name="image_url" value="{{ old('image_url', $event->image_url) }}" placeholder="https://...">
      @error('image_url')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <div class="form-check form-switch">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
          {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
      </div>
    </div>

    <div class="mb-3">
      <label for="sort_order" class="form-label">Sort Order</label>
      <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
        id="sort_order" name="sort_order" value="{{ old('sort_order', $event->sort_order) }}" min="0">
      @error('sort_order')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </div>
  </div>

  <div class="mt-3">
    <button type="submit" class="btn btn-primary">Update Event</button>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
  </form>
  </div>
  </div>
  </div>
  @endsection id="image_url" name="image_url" value="{{ old('image_url', $event->image_url) }}" placeholder="https://...">
  @error('image_url')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
  </div>

  <div class="mb-3">
    <div class="form-check form-switch">
      <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
        {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
      <label class="form-check-label" for="is_active">Active</label>
    </div>
  </div>

  <div class="mb-3">
    <label for="sort_order" class="form-label">Sort Order</label>
    <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
      id="sort_order" name="sort_order" value="{{ old('sort_order', $event->sort_order) }}" min="0">
    @error('sort_order')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  </div>
  </div>

  <div class="mt-3">
    <button type="submit" class="btn btn-primary" id="submitBtn">
      <i class="fas fa-save"></i> Update Event
    </button>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
  </form>
  </div>
  </div>
  </div>

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

    // Form submission
    document.getElementById('eventForm').addEventListener('submit', function(e) {
      const submitBtn = document.getElementById('submitBtn');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
    });

    // Flash messages
    document.addEventListener('DOMContentLoaded', function() {
      @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonColor: '#28a745',
        confirmButtonText: 'OK',
        willClose: () => {
          window.location.href = '{{ route("admin.events.index") }}';
        }
      });
      @endif

      @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session("error") }}',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'OK'
      });
      @endif

      @if($errors - > any())
      Swal.fire({
        icon: 'warning',
        title: 'Validation Error!',
        html: `
                    <ul style="text-align: left;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
        confirmButtonColor: '#ffc107',
        confirmButtonText: 'Got it!',
      });
      @endif
    });
  </script>
  @endpush
  @endsection