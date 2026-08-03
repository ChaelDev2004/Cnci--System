@extends('layouts/contentNavbarLayout')
@section('title', 'Hero Slides')

@section('content')
<a href="{{ route('slides.create') }}" class="btn">+ Add Slide</a>
<br><br>
<table>
  <tr>
    <th>#</th>
    <th>Layout</th>
    <th>Heading</th>
    <th>Type</th>
    <th>Active</th>
    <th>Order</th>
    <th>Actions</th>
  </tr>
  @foreach($slides as $slide)
  <tr>
    <td>{{ $slide->id }}</td>
    <td>{{ ucfirst($slide->layout) }}</td>
    <td>{{ Str::limit($slide->heading, 40) }}</td>
    <td>{{ ucfirst($slide->bg_type) }}</td>
    <td>{{ $slide->active ? '✅' : '❌' }}</td>
    <td>{{ $slide->sort_order }}</td>
    <td class="actions">
      <a href="{{ route('slides.edit', $slide) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('slides.destroy', $slide) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete slide?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection