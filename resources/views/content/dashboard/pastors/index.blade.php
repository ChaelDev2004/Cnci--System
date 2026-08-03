@extends('layouts/contentNavbarLayout')

@section('content')
<a href="{{ route('content.dashboard.pastors.create') }}" class="btn">+ Add Pastor</a>
<br><br>
<table>
  <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Role</th>
    <th>Church</th>
    <th>Order</th>
    <th>Actions</th>
  </tr>
  @foreach($pastors as $pastor)
  <tr>
    <td>@if($pastor->image)<img class="thumb" src="{{ asset('storage/'.$pastor->image) }}">@endif</td>
    <td>{{ $pastor->name }}</td>
    <td>{{ $pastor->role }}</td>
    <td>{{ $pastor->church }}</td>
    <td>{{ $pastor->sort_order }}</td>
    <td class="actions">
      <a href="{{ route('pastor.show', $pastor->id) }}" class="btn btn-secondary" target="_blank" rel="noopener">Gallery</a>
      <a href="{{ route('admin.pastors.edit', $pastor) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('admin.pastors.destroy', $pastor) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this pastor?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection