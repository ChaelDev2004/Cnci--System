@extends('layouts/contentNavbarLayout')
@section('title', 'Add Leader')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Leader</h4>
  <p class="text-muted mb-0">Add a leader shown on the About page.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.leaders.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @include('content.dashboard.leaders.form')
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save</button>
        <a href="{{ route('admin.content.dashboard.about') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
