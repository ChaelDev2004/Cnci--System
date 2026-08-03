@extends('layouts/contentNavbarLayout')
@section('title', 'Add Slide')
@section('content')
<div class="card">
  <form action="{{ route('slides.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('content.dashboard.admin.home.slides.form')
    <button class="btn btn-primary" type="submit">Save Slide</button>
  </form>
</div>
@endsection