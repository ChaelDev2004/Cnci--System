@extends('layouts/contentNavbarLayout')
@section('title', 'Church Locations')
@section('content')
<a href="{{ route('admin.locations.create') }}" class="btn">+ Add Location</a>
<br><br>
<table>
  <tr>
    <th>Name</th>
    <th>City</th>
    <th>Address</th>
    <th>Service Time</th>
    <th>Default</th>
    <th>Actions</th>
  </tr>
  @foreach($locations as $loc)
  <tr>
    <td>{{ $loc->name }}</td>
    <td>{{ $loc->city }}</td>
    <td>{{ $loc->address }}</td>
    <td>{{ $loc->service_time }}</td>
    <td>{{ $loc->is_default ? '⭐ Yes' : '' }}</td>
    <td class="actions">
      <a href="{{ route('locations.edit', $loc) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('locations.destroy', $loc) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete location?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection