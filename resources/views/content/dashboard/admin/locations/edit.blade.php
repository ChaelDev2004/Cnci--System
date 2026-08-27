@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Location')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Location</h4>
  <p class="text-muted mb-0">Update church location details for Find Us.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.locations.update', $location) }}" method="POST">
      @csrf
      @method('PUT')
      @include('content.dashboard.admin.locations.form', ['location' => $location, 'pastors' => $pastors])
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Update Location</button>
        <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
