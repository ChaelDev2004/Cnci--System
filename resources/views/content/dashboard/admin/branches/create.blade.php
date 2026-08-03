@extends('layouts/contentNavbarLayout')
@section('title', 'Add Branch Account')

@section('content')
<div class="mb-3">
  <h4 class="mb-1">Add Branch Account</h4>
  <p class="text-muted mb-0">They will only manage the gallery and details for the assigned pastor.</p>
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
    <form action="{{ route('admin.branches.store') }}" method="POST">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Branch / User Name</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="CNCI Manila Branch">
        </div>
        <div class="col-md-6">
          <label class="form-label">Email (Gmail login)</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="branch@gmail.com">
        </div>
        <div class="col-md-6">
          <label class="form-label">Assign Pastor</label>
          <select name="pastor_id" class="form-select" required>
            <option value="">Select pastor / branch</option>
            @foreach($pastors as $pastor)
              <option value="{{ $pastor->id }}" @selected(old('pastor_id') == $pastor->id)>
                {{ $pastor->name }}{{ $pastor->church ? ' — '.$pastor->church : '' }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone (optional)</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Password (optional)</label>
          <input type="text" name="password" class="form-control" value="{{ old('password') }}" placeholder="Leave blank to auto-generate">
          <small class="text-muted">If blank, a secure password is generated and emailed.</small>
        </div>
        <div class="col-md-6 d-flex align-items-end">
          <div class="form-check mb-2">
            <input type="hidden" name="send_email" value="0">
            <input class="form-check-input" type="checkbox" name="send_email" value="1" id="send_email" @checked(old('send_email', '1') == '1')>
            <label class="form-check-label" for="send_email">Send password to their Gmail</label>
          </div>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Create &amp; Send</button>
        <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
