@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Branch Account')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Edit Branch Account</h4>
  <p class="text-muted mb-0">{{ $branch->email }}</p>
</div>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.branches.update', $branch) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Branch / User Name</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $branch->name) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $branch->email) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Assign Pastor</label>
          <select name="pastor_id" class="form-select" required>
            @foreach($pastors as $pastor)
              <option value="{{ $pastor->id }}" @selected(old('pastor_id', $branch->pastor_id) == $pastor->id)>
                {{ $pastor->name }}{{ $pastor->church ? ' — '.$pastor->church : '' }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone', $branch->phone) }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">New Password (optional)</label>
          <input type="text" name="password" class="form-control" placeholder="Leave blank to keep current">
        </div>
        <div class="col-md-6 d-flex align-items-end">
          <div class="form-check mb-2">
            <input type="hidden" name="resend_email" value="0">
            <input class="form-check-input" type="checkbox" name="resend_email" value="1" id="resend_email">
            <label class="form-check-label" for="resend_email">Reset password (if blank) and email credentials</label>
          </div>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
