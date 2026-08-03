@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Location')

@section('content')
<div class="card">
  <form action="{{ route('admin.locations.update', $location) }}" method="POST">
    @csrf
    @method('PUT')
    @include('content.dashboard.admin.locations.form', ['location' => $location, 'pastors' => $pastors])
    <button class="btn" type="submit">Update Location</button>
  </form>
</div>
@endsection
