<div class="form-group">
  <label>Name</label>
  <input type="text" name="name" value="{{ old('name', $leader->name ?? '') }}" required>
</div>

<div class="form-group">
  <label>Title</label>
  <input type="text" name="title" value="{{ old('title', $leader->title ?? '') }}" required>
</div>

<div class="form-group">
  <label>Subtitle (optional, e.g. extra line)</label>
  <input type="text" name="subtitle" value="{{ old('subtitle', $leader->subtitle ?? '') }}">
</div>

<div class="form-group">
  <label>"Know More" Link</label>
  <input type="text" name="link" value="{{ old('link', $leader->link ?? '') }}">
</div>

<div class="form-group">
  <label>Sort Order</label>
  <input type="number" name="sort_order" value="{{ old('sort_order', $leader->sort_order ?? 0) }}">
</div>

<div class="form-group">
  <label>Image</label>
  <input type="file" name="image">
  @if(!empty($leader) && $leader->image)
  <div class="preview"><img src="{{ asset('storage/'.$leader->image) }}"></div>
  @endif
</div>