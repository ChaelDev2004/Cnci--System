@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Leader')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Leader</h4>
  <p class="text-muted mb-0">{{ $leader->name }}</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.leaders.update', $leader) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('content.dashboard.leaders.form', ['leader' => $leader])
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Update</button>
        <a href="{{ route('admin.content.dashboard.about') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
