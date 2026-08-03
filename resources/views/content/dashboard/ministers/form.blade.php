<div class="form-group">
  <label>Name</label>
  <input type="text" name="name" value="{{ old('name', $minister->name ?? '') }}" required>
</div>

<div class="form-group">
  <label>Role</label>
  <input type="text" name="role" value="{{ old('role', $minister->role ?? '') }}">
</div>

<div class="form-group">
  <label>Subrole (optional)</label>
  <input type="text" name="subrole" value="{{ old('subrole', $minister->subrole ?? '') }}">
</div>

<div class="form-group">
  <label>Group</label>
  <select name="group" required>
    @php $current = old('group', $minister->group ?? ''); @endphp
    <option value="gospel_minister" {{ $current == 'gospel_minister' ? 'selected' : '' }}>Gospel Minister</option>
    <option value="region1_staff" {{ $current == 'region1_staff' ? 'selected' : '' }}>Region 1 Staff</option>
  </select>
</div>

<div class="form-group">
  <label>Sort Order</label>
  <input type="number" name="sort_order" value="{{ old('sort_order', $minister->sort_order ?? 0) }}">
</div>

<div class="form-group">
  <label>Image</label>
  <input type="file" name="image">
  @if(!empty($minister) && $minister->image)
  <div class="preview"><img src="{{ asset('storage/'.$minister->image) }}"></div>
  @endif
</div>