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

<!-- NEW: Pastor Selection -->
<div class="form-group">
  <label>Select Pastor for this Location</label>
  <select name="pastor_id" class="form-control">
    <option value="">No Pastor Assigned</option>
    @foreach($pastors as $pastor)
    <option value="{{ $pastor->id }}"
      {{ old('pastor_id', $location->pastor_id ?? '') == $pastor->id ? 'selected' : '' }}>
      {{ $pastor->name }} {{ $pastor->role ? '- ' . $pastor->role : '' }}
    </option>
    @endforeach
  </select>
  <small style="color: #666;">Select a pastor to display when users click "Visit Us"</small>
</div>

<div class="form-group">
  <label>Google Maps Embed URL (paste the iframe src value)</label>
  <textarea name="map_embed_url" style="min-height:80px;">{{ old('map_embed_url', $location->map_embed_url ?? '') }}</textarea>
</div>
<div class="form-group">
  <label>Google Maps Direct Link (for "Open in Google Maps" button)</label>
  <input type="text" name="maps_link" value="{{ old('maps_link', $location->maps_link ?? '') }}">
</div>
<div class="form-group">
  <label>Service Time (e.g. "Sun 10:00 AM")</label>
  <input type="text" name="service_time" value="{{ old('service_time', $location->service_time ?? '') }}">
</div>
<div class="form-group">
  <label>Sort Order</label>
  <input type="number" name="sort_order" value="{{ old('sort_order', $location->sort_order ?? 0) }}">
</div>
<div class="form-group">
  <label>
    <input type="checkbox" name="is_default" value="1" {{ old('is_default', $location->is_default ?? false) ? 'checked' : '' }}>
    Set as default location (shown first on homepage)
  </label>
</div>