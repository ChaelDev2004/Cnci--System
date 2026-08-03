@extends('layouts/contentNavbarLayout')
@section('title', 'Leadership')

@section('content')
<a href="{{ route('admin.leaders.create') }}" class="btn">+ Add Leader</a>
<br><br>
<table>
  <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Title</th>
    <th>Subtitle</th>
    <th>Order</th>
    <th>Actions</th>
  </tr>
  @foreach($leaders as $leader)
  <tr>
    <td>@if($leader->image)<img class="thumb" src="{{ asset('storage/'.$leader->image) }}">@endif</td>
    <td>{{ $leader->name }}</td>
    <td>{{ $leader->title }}</td>
    <td>{{ $leader->subtitle }}</td>
    <td>{{ $leader->sort_order }}</td>
    <td class="actions">
      <a href="{{ route('admin.leaders.edit', $leader) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('admin.leaders.destroy', $leader) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this leader?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection