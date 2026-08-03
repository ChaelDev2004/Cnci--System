@extends('layouts/contentNavbarLayout')
@section('title', 'Sidebar Menu')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div>
    <h4 class="mb-1">Sidebar Menu</h4>
    <p class="text-muted mb-0">Manage dynamic admin sidebar items, order, icons, and visibility.</p>
  </div>
  <a href="{{ route('admin.menu.create') }}" class="btn">+ Add Menu Item</a>
</div>

<table>
  <tr>
    <th>Order</th>
    <th>Type</th>
    <th>Name</th>
    <th>URL / Slug</th>
    <th>Active</th>
    <th>Actions</th>
  </tr>
  @forelse($items as $item)
    <tr>
      <td>{{ $item->sort_order }}</td>
      <td>{{ ucfirst($item->type) }}</td>
      <td>
        @if($item->icon)<i class="{{ $item->icon }}"></i>@endif
        <strong>{{ $item->name }}</strong>
        @if($item->children->count())
          <div class="text-muted small mt-1">
            @foreach($item->children as $child)
              — {{ $child->name }}@if(!$loop->last)<br>@endif
            @endforeach
          </div>
        @endif
      </td>
      <td>
        <div>{{ $item->url ?: '—' }}</div>
        <small class="text-muted">{{ $item->slug ?: '' }}</small>
      </td>
      <td>{{ $item->is_active ? 'Yes' : 'No' }}</td>
      <td class="actions">
        <a href="{{ route('admin.menu.edit', $item) }}" class="btn btn-secondary">Edit</a>
        <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this menu item?')">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger" type="submit">Delete</button>
        </form>
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="6">No menu items yet.</td>
    </tr>
  @endforelse
</table>
@endsection
