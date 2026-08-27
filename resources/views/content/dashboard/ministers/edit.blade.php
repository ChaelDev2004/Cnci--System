@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Minister')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Minister / Staff</h4>
  <p class="text-muted mb-0">{{ $minister->name }}</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.ministers.update', $minister) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('content.dashboard.ministers.form', ['minister' => $minister])
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Update</button>
        <a href="{{ route('admin.ministers.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
