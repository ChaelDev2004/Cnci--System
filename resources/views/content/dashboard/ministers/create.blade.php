@extends('layouts/contentNavbarLayout')
@section('title', 'Add Minister')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Minister / Staff</h4>
  <p class="text-muted mb-0">Add a gospel minister or region staff member.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.ministers.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @include('content.dashboard.ministers.form')
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save</button>
        <a href="{{ route('admin.ministers.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
