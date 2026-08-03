@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Location')
@section('content')
<div class="card">
  <form action="{{ route('admin.locations.update', $location) }}" method="POST">
    @csrf @method('PUT')
    @include('admin.locations.form', ['location' => $location])
    <button class="btn" type="submit">Update Location</button>
  </form>
</div>
@endsection