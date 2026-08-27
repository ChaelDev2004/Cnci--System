@extends('layouts/contentNavbarLayout')
@section('title', 'Add Pastor')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Pastor</h4>
  <p class="text-muted mb-0">Create a pastor profile for the website and Find Us.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.pastors.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @include('content.dashboard.pastors.form')
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save</button>
        <a href="{{ route('admin.pastors.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
