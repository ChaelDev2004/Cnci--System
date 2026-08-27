@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Slide')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Slide</h4>
  <p class="text-muted mb-0">Update homepage carousel slide.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('content.dashboard.admin.home.slides.form', ['slide' => $slide])
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Update Slide</button>
        <a href="{{ route('slides.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
