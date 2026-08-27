@extends('layouts/contentNavbarLayout')
@section('title', 'Add Menu Item')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Menu Item</h4>
  <p class="text-muted mb-0">Add a sidebar link or section divider.</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.menu.store') }}" method="POST">
      @csrf
      @include('content.dashboard.admin.menu.form')
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save Menu Item</button>
        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
