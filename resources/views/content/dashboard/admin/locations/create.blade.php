@extends('layouts/contentNavbarLayout')
@section('title', 'Add Location')
@section('content')
<div class="card">
  <form action="{{ url('/locations') }}" method="POST">
    @csrf
    @include('content.dashboard.admin.locations.form')
    <button class="btn" type="submit">Save Location</button>
  </form>
</div>
@endsection