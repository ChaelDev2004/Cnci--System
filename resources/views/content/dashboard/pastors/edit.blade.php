@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Pastor')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Pastor</h4>
  <p class="text-muted mb-0">{{ $pastor->name }}</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.pastors.update', $pastor) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('content.dashboard.pastors.form', ['pastor' => $pastor])
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Update</button>
        <a href="{{ route('admin.pastors.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
