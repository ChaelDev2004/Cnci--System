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
  <label for="pastor_id">Assign to Pastor <span style="color:#c41e2a;">*</span></label>
  @if($pastors->isEmpty())
    <p style="color:#c41e2a;margin:8px 0;">No pastors found. <a href="{{ route('admin.pastors.create') }}">Add a pastor first</a>.</p>
  @endif
  <select name="pastor_id" id="pastor_id" class="form-control" required {{ $pastors->isEmpty() ? 'disabled' : '' }}>
    <option value="">Select a pastor</option>
    @foreach($pastors as $pastor)
      <option
        value="{{ $pastor->id }}"
        {{ (string) old('pastor_id', $image->pastor_id ?? '') === (string) $pastor->id ? 'selected' : '' }}>
        {{ $pastor->name }}{{ $pastor->church ? ' — ' . $pastor->church : '' }}{{ $pastor->role ? ' (' . $pastor->role . ')' : '' }}
      </option>
    @endforeach
  </select>
  <small style="display:block;margin-top:6px;color:#666;">
    This photo will appear on that pastor’s public gallery page.
  </small>
</div>

@if(isset($image))
  <div class="form-group">
    <label>Current Image</label>
    <div style="margin-top:8px;">
      <img src="{{ asset('storage/' . $image->path) }}" alt="Current gallery" style="max-width:220px;border-radius:10px;">
    </div>
  </div>

  <div class="form-group">
    <label for="image">Replace Image (optional)</label>
    <input type="file" name="image" id="image" accept="image/*">
  </div>
@else
  <div class="form-group">
    <label for="images">Gallery Images <span style="color:#c41e2a;">*</span></label>
    <input type="file" name="images[]" id="images" accept="image/*" multiple required>
    <small style="display:block;margin-top:6px;color:#666;">
      You can upload multiple images. All selected files will be assigned to the pastor above.
    </small>
  </div>
@endif

<div class="form-group">
  <label for="caption">Caption (optional)</label>
  <input type="text" name="caption" id="caption" value="{{ old('caption', $image->caption ?? '') }}" placeholder="e.g. Sunday worship">
</div>

<div class="form-group">
  <label for="sort_order">Sort Order</label>
  <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $image->sort_order ?? 0) }}">
</div>
