@extends('layouts/contentNavbarLayout')
@section('title', 'Add Slide')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Slide</h4>
  <p class="text-muted mb-0">Upload a homepage carousel slide.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('slides.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @include('content.dashboard.admin.home.slides.form')
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save Slide</button>
        <a href="{{ route('slides.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
