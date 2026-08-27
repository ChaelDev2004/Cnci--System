@extends('layouts/contentNavbarLayout')
@section('title', 'Add Location')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Location</h4>
  <p class="text-muted mb-0">Add a church location shown on Find Us.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.locations.store') }}" method="POST">
      @csrf
      @include('content.dashboard.admin.locations.form')
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save Location</button>
        <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
