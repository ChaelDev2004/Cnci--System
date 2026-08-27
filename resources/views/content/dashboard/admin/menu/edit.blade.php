@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Menu Item')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Menu Item</h4>
  <p class="text-muted mb-0">{{ $item->name }}</p>
</div>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.menu.update', $item) }}" method="POST">
      @csrf
      @method('PUT')
      @include('content.dashboard.admin.menu.form', ['item' => $item, 'parents' => $parents])
      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Update Menu Item</button>
        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
