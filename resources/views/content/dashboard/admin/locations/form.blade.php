@if($errors->any())
  <div class="alert alert-danger" style="display:none;margin-bottom:16px;">
    <ul style="margin:0;padding-left:18px;">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="form-group">
  <label>Church Name</label>
  <input type="text" name="name" value="{{ old('name', $location->name ?? '') }}" required>
</div>

<div class="form-group">
  <label>City</label>
  <input type="text" name="city" value="{{ old('city', $location->city ?? '') }}" required>
</div>

<div class="form-group">
  <label>Full Address</label>
  <input type="text" name="address" value="{{ old('address', $location->address ?? '') }}" required>
</div>

<div class="form-group">
  <label>Assign Pastor</label>
  <select name="pastor_id" class="form-control">
    <option value="">No Pastor Assigned</option>
    @foreach($pastors as $pastor)
      <option value="{{ $pastor->id }}"
        {{ (string) old('pastor_id', $location->pastor_id ?? '') === (string) $pastor->id ? 'selected' : '' }}>
        {{ $pastor->name }}{{ $pastor->role ? ' — ' . $pastor->role : '' }}
      </option>
    @endforeach
  </select>
  <small style="color:#666;display:block;margin-top:6px;">Used for the “Meet Our Pastor” button on Find Us.</small>
</div>

<div class="form-group">
  <label>Google Maps Embed URL</label>
  <textarea name="map_embed_url" style="min-height:80px;" required placeholder="Paste the iframe src value">{{ old('map_embed_url', $location->map_embed_url ?? '') }}</textarea>
</div>

<div class="form-group">
  <label>Google Maps Direct Link</label>
  <input type="text" name="maps_link" value="{{ old('maps_link', $location->maps_link ?? '') }}" placeholder="https://maps.google.com/...">
</div>

<div class="form-group">
  <label>Service Time</label>
  <input type="text" name="service_time" value="{{ old('service_time', $location->service_time ?? '') }}" placeholder="e.g. Sun 10:00 AM">
</div>

<div class="form-group">
  <label>Sort Order</label>
  <input type="number" name="sort_order" value="{{ old('sort_order', $location->sort_order ?? 0) }}">
</div>

<div class="form-group">
  <label>
    <input type="checkbox" name="is_default" value="1" {{ old('is_default', $location->is_default ?? false) ? 'checked' : '' }}>
    Set as default location (shown first)
  </label>
</div>
