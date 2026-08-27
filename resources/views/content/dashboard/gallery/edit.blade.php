@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Gallery Image')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Gallery Image</h4>
  <p class="text-muted mb-0">Update image details or replace the file.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.gallery.update', $image) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('content.dashboard.gallery.form', ['image' => $image, 'pastors' => $pastors])
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Update Gallery Image</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
