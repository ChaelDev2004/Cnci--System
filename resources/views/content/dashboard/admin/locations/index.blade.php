@extends('layouts/contentNavbarLayout')
@section('title', 'Find Us — Locations')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div>
    <h4 class="mb-1">Find Us</h4>
    <p class="text-muted mb-0">Manage church locations shown on the public Find Us page.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('findus') }}" class="btn btn-secondary" target="_blank" rel="noopener">View Public Page</a>
    <a href="{{ route('admin.locations.create') }}" class="btn">+ Add Location</a>
  </div>
</div>

<table>
  <tr>
    <th>Name</th>
    <th>City</th>
    <th>Address</th>
    <th>Pastor</th>
    <th>Service Time</th>
    <th>Default</th>
    <th>Actions</th>
  </tr>
  @forelse($locations as $loc)
  <tr>
    <td>{{ $loc->name }}</td>
    <td>{{ $loc->city }}</td>
    <td>{{ $loc->address }}</td>
    <td>{{ $loc->pastor->name ?? '—' }}</td>
    <td>{{ $loc->service_time ?: '—' }}</td>
    <td>{{ $loc->is_default ? 'Yes' : '' }}</td>
    <td class="actions">
      <a href="{{ route('admin.locations.edit', $loc) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('admin.locations.destroy', $loc) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this location?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="7">No locations yet. Click “Add Location” to create one.</td>
  </tr>
  @endforelse
</table>
@endsection
