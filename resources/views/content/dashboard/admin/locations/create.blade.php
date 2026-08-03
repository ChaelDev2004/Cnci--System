@extends('layouts/contentNavbarLayout')
@section('title', 'Add Location')

@section('content')
<div class="card">
  <form action="{{ route('admin.locations.store') }}" method="POST">
    @csrf
    @include('content.dashboard.admin.locations.form')
    <button class="btn" type="submit">Save Location</button>
  </form>
</div>
@endsection
