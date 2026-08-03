@extends('layouts/contentNavbarLayout')
@section('title', 'Add Gallery Image')

@section('content')
<div class="card">
  <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('content.dashboard.gallery.form')
    <button class="btn" type="submit">Save Gallery Image(s)</button>
  </form>
</div>
@endsection
