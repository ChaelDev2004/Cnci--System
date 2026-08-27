@extends('layouts/contentNavbarLayout')
@section('title', 'Add Gallery Image')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Gallery Image</h4>
  <p class="text-muted mb-0">Upload images and assign them to a pastor.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @include('content.dashboard.gallery.form')
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save Gallery Image(s)</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
