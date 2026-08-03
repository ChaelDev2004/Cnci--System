@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Gallery Image')

@section('content')
<div class="card">
  <form action="{{ route('admin.gallery.update', $image) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('content.dashboard.gallery.form', ['image' => $image, 'pastors' => $pastors])
    <button class="btn" type="submit">Update Gallery Image</button>
  </form>
</div>
@endsection
