@extends('layouts/contentNavbarLayout')
@section('title', 'Pastor Gallery')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.gallery.create') }}" class="btn">+ Add Gallery Image</a>
<br><br>

<table>
  <tr>
    <th>Preview</th>
    <th>Assigned Pastor</th>
    <th>Church</th>
    <th>Caption</th>
    <th>Order</th>
    <th>Actions</th>
  </tr>
  @forelse($images as $image)
  <tr>
    <td>
      <img class="thumb" src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?: 'Gallery' }}">
    </td>
    <td>{{ $image->pastor->name ?? '—' }}</td>
    <td>{{ $image->pastor->church ?? '—' }}</td>
    <td>{{ $image->caption ?: '—' }}</td>
    <td>{{ $image->sort_order }}</td>
    <td class="actions">
      @if($image->pastor)
      <a href="{{ route('pastor.show', $image->pastor->id) }}" class="btn btn-secondary" target="_blank" rel="noopener">View Page</a>
      @endif
      <a href="{{ route('admin.gallery.edit', $image) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this gallery image?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="6">No gallery images yet. Click “Add Gallery Image” and choose a pastor.</td>
  </tr>
  @endforelse
</table>
@endsection
