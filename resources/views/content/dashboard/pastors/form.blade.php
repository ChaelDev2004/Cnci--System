<div class="form-group">
  <label>Pastor Name</label>
  <input type="text" name="name" value="{{ old('name', $pastor->name ?? '') }}" required>
</div>

<div class="form-group">
  <label>Role/Title</label>
  <input type="text" name="role" value="{{ old('role', $pastor->role ?? '') }}" placeholder="e.g. Senior Pastor">
</div>

<div class="form-group">
  <label>Church Name</label>
  <input type="text" name="church" value="{{ old('church', $pastor->church ?? '') }}" required>
</div>

<div class="form-group">
  <label>Biography</label>
  <textarea name="bio" rows="5" style="min-height:120px;">{{ old('bio', $pastor->bio ?? '') }}</textarea>
</div>

<div class="form-group">
  <label>Email</label>
  <input type="email" name="email" value="{{ old('email', $pastor->email ?? '') }}">
</div>

<div class="form-group">
  <label>Phone</label>
  <input type="text" name="phone" value="{{ old('phone', $pastor->phone ?? '') }}">
</div>

<div class="form-group">
  <label>Facebook URL</label>
  <input type="text" name="facebook" value="{{ old('facebook', $pastor->facebook ?? '') }}" placeholder="https://facebook.com/pastor">
</div>

<div class="form-group">
  <label>Instagram URL</label>
  <input type="text" name="instagram" value="{{ old('instagram', $pastor->instagram ?? '') }}" placeholder="https://instagram.com/pastor">
</div>

<div class="form-group">
  <label>YouTube URL</label>
  <input type="text" name="youtube" value="{{ old('youtube', $pastor->youtube ?? '') }}" placeholder="https://youtube.com/pastor">
</div>

<div class="form-group">
  <label>Pastor Image</label>
  <input type="file" name="image" accept="image/*">
  @if(isset($pastor) && $pastor->image)
  <div style="margin-top:10px;">
    <img src="{{ asset('storage/' . $pastor->image) }}" style="max-width:200px; border-radius:10px;" alt="{{ $pastor->name }}">
  </div>
  @endif
</div>

<div class="form-group">
  <label>Gallery Images</label>
  <input type="file" name="gallery_images[]" accept="image/*" multiple>
  <small style="display:block;margin-top:6px;color:#666;">Upload multiple photos for this pastor’s public gallery page.</small>
  @if(isset($pastor) && $pastor->galleryImages && $pastor->galleryImages->count())
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:12px;margin-top:14px;">
    @foreach($pastor->galleryImages as $galleryImage)
    <label style="display:block;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;cursor:pointer;">
      <img src="{{ asset('storage/' . $galleryImage->path) }}" alt="Gallery image" style="width:100%;height:100px;object-fit:cover;display:block;">
      <span style="display:flex;align-items:center;gap:6px;padding:8px;font-size:12px;">
        <input type="checkbox" name="delete_gallery[]" value="{{ $galleryImage->id }}">
        Delete
      </span>
    </label>
    @endforeach
  </div>
  @endif
</div>

<div class="form-group">
  <label>Sort Order</label>
  <input type="number" name="sort_order" value="{{ old('sort_order', $pastor->sort_order ?? 0) }}">
</div>