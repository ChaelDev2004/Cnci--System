<div class="form-group">
  <label>Layout</label>
  <select name="layout" required>
    @foreach(['default' => 'Default (with CTA & reviews)', 'welcome' => 'Welcome (glass buttons)', 'plain' => 'Plain (image only)'] as $val => $label)
    <option value="{{ $val }}" {{ old('layout', $slide->layout ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label>Background Type</label>
  <select name="bg_type" id="bgTypeSelect" required onchange="toggleBgFields()">
    @foreach(['image' => 'Image', 'video' => 'Video URL', 'color' => 'Color Only'] as $val => $label)
    <option value="{{ $val }}" {{ old('bg_type', $slide->bg_type ?? 'image') == $val ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
  </select>
</div>

<div class="form-group" id="bgImageField">
  <label>Background Image</label>
  <input type="file" name="bg_image">
  @if(!empty($slide) && $slide->bg_image)
  <div class="preview"><img src="{{ asset('storage/'.$slide->bg_image) }}"></div>
  @endif
</div>

<div class="form-group" id="bgVideoField" style="display:none">
  <label>Background Video URL (.mp4)</label>
  <input type="text" name="bg_video_url" value="{{ old('bg_video_url', $slide->bg_video_url ?? '') }}">
</div>

<div class="form-group">
  <label>Eyebrow Text</label>
  <input type="text" name="eyebrow" value="{{ old('eyebrow', $slide->eyebrow ?? '') }}">
</div>

<div class="form-group">
  <label>Heading</label>
  <textarea name="heading">{{ old('heading', $slide->heading ?? '') }}</textarea>
</div>

<div class="form-group">
  <label>Sub Text</label>
  <textarea name="subtext">{{ old('subtext', $slide->subtext ?? '') }}</textarea>
</div>

<div class="form-group">
  <label>CTA Button Label</label>
  <input type="text" name="cta_primary_label" value="{{ old('cta_primary_label', $slide->cta_primary_label ?? '') }}">
</div>

<div class="form-group">
  <label>CTA Button Link</label>
  <input type="text" name="cta_primary_link" value="{{ old('cta_primary_link', $slide->cta_primary_link ?? '#') }}">
</div>

<div class="form-group">
  <label>Testimonial Quote (optional)</label>
  <textarea name="testimonial">{{ old('testimonial', $slide->testimonial ?? '') }}</textarea>
</div>

<div class="form-group">
  <label>Service Badge Text (optional, e.g. "9:00 AM & 11:00 AM")</label>
  <input type="text" name="service_badge" value="{{ old('service_badge', $slide->service_badge ?? '') }}">
</div>

<div class="form-group">
  <label>Sort Order</label>
  <input type="number" name="sort_order" value="{{ old('sort_order', $slide->sort_order ?? 0) }}">
</div>

<div class="form-group">
  <label>
    <input type="checkbox" name="active" value="1" {{ old('active', $slide->active ?? true) ? 'checked' : '' }}>
    Active (show on site)
  </label>
</div>

<script>
  function toggleBgFields() {
    const type = document.getElementById('bgTypeSelect').value;
    document.getElementById('bgImageField').style.display = type === 'image' ? 'block' : 'none';
    document.getElementById('bgVideoField').style.display = type === 'video' ? 'block' : 'none';
  }
  toggleBgFields();
</script>