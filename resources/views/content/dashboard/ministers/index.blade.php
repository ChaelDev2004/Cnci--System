@extends('layouts/contentNavbarLayout')
@section('content')
<a href="{{ route('content.dashboard.ministers.create') }}" class="btn">+ Add Member</a>
<br><br>

<h3>Gospel Ministers</h3>
<table>
  <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Role</th>
    <th>Order</th>
    <th>Actions</th>
  </tr>
  @foreach($ministers as $m)
  <tr>
    <td>@if($m->image)<img class="thumb" src="{{ asset('storage/'.$m->image) }}">@endif</td>
    <td>{{ $m->name }}</td>
    <td>{{ $m->role }}</td>
    <td>{{ $m->sort_order }}</td>
    <td class="actions">
      <a href="{{ route('content.dashboard.ministers.edit', $m) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('admin.ministers.destroy', $m) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this member?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>

<br>
<h3>Region 1 Staff</h3>
<table>
  <tr>
    <th>Image</th>
    <th>Name</th>
    <th>Role</th>
    <th>Subrole</th>
    <th>Order</th>
    <th>Actions</th>
  </tr>
  @foreach($staff as $s)
  <tr>
    <td>@if($s->image)<img class="thumb" src="{{ asset('storage/'.$s->image) }}">@endif</td>
    <td>{{ $s->name }}</td>
    <td>{{ $s->role }}</td>
    <td>{{ $s->subrole }}</td>
    <td>{{ $s->sort_order }}</td>
    <td class="actions">
      <a href="{{ route('content.dashboard.ministers.edit', $s) }}" class="btn btn-secondary">Edit</a>
      <form action="{{ route('admin.ministers.destroy', $s) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this member?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
@endsection