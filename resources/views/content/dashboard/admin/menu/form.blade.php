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
  <label for="type">Type</label>
  <select name="type" id="type" class="form-control" required>
    <option value="link" {{ old('type', $item->type ?? 'link') === 'link' ? 'selected' : '' }}>Link</option>
    <option value="header" {{ old('type', $item->type ?? '') === 'header' ? 'selected' : '' }}>Divider / Section Name</option>
  </select>
  <small style="color:#666;display:block;margin-top:6px;">
    Choose <strong>Divider / Section Name</strong> to show a labeled separator in the sidebar (e.g. CMS, Branches, Settings).
  </small>
</div>

<div class="form-group">
  <label for="name" id="nameLabel">Label</label>
  <input type="text" name="name" id="name" value="{{ old('name', $item->name ?? '') }}" required placeholder="e.g. Branches">
</div>

<div class="link-only-fields">
  <div class="form-group">
    <label for="url">URL</label>
    <input type="text" name="url" id="url" value="{{ old('url', $item->url ?? '') }}" placeholder="/admin/dashboard">
  </div>

  <div class="form-group">
    <label for="icon">Icon class</label>
    <input type="text" name="icon" id="icon" value="{{ old('icon', $item->icon ?? 'menu-icon icon-base bx bx-circle') }}" placeholder="menu-icon icon-base bx bx-home">
    <small style="color:#666;">Boxicons class, e.g. menu-icon icon-base bx bx-calendar</small>
  </div>

  <div class="form-group">
    <label for="slug">Route slug (for active highlight)</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug', $item->slug ?? '') }}" placeholder="admin.dashboard">
  </div>

  <div class="form-group">
    <label for="parent_id">Parent (optional submenu)</label>
    <select name="parent_id" id="parent_id" class="form-control">
      <option value="">None (top level)</option>
      @foreach($parents as $parent)
        <option value="{{ $parent->id }}" {{ (string) old('parent_id', $item->parent_id ?? '') === (string) $parent->id ? 'selected' : '' }}>
          {{ $parent->name }}
        </option>
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label for="target">Target</label>
    <select name="target" id="target" class="form-control">
      <option value="_self" {{ old('target', $item->target ?? '_self') === '_self' ? 'selected' : '' }}>Same tab</option>
      <option value="_blank" {{ old('target', $item->target ?? '') === '_blank' ? 'selected' : '' }}>New tab</option>
    </select>
  </div>

  <div class="form-group">
    <label for="badge_text">Badge text (optional)</label>
    <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text', $item->badge_text ?? '') }}" placeholder="New">
  </div>

  <div class="form-group">
    <label for="badge_class">Badge class</label>
    <input type="text" name="badge_class" id="badge_class" value="{{ old('badge_class', $item->badge_class ?? 'danger') }}" placeholder="danger">
  </div>
</div>

<div class="form-group">
  <label for="sort_order">Sort order</label>
  <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
</div>

<div class="form-group">
  <label>
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
    Active (show in sidebar)
  </label>
</div>

<script>
(function () {
  const typeEl = document.getElementById('type');
  const nameLabel = document.getElementById('nameLabel');
  const linkFields = document.querySelector('.link-only-fields');

  function syncType() {
    const isHeader = typeEl.value === 'header';
    nameLabel.textContent = isHeader ? 'Divider name' : 'Label';
    if (linkFields) linkFields.style.display = isHeader ? 'none' : '';
  }

  typeEl.addEventListener('change', syncType);
  syncType();
})();
</script>
