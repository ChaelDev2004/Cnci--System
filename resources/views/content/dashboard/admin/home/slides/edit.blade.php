@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Slide')
@section('content')
<div class="card">
  <form action="{{ route('slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('content.dashboard.admin.home.slides.form', ['slide' => $slide])
    <button class="btn" type="submit">Update Slide</button>
  </form>
</div>
@endsection