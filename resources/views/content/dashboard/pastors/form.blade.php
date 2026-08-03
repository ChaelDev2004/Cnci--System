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
    <img src="{{ asset('storage/' . $pastor->image) }}" style="max-width:200px; border-radius:10px;">
  </div>
  @endif
</div>

<div class="form-group">
  <label>Sort Order</label>
  <input type="number" name="sort_order" value="{{ old('sort_order', $pastor->sort_order ?? 0) }}">
</div>