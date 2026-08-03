@extends('layouts/contentNavbarLayout')
@section('title', 'Branch Accounts')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div>
    <h4 class="mb-1">CNCI Branch Accounts</h4>
    <p class="text-muted mb-0">Create branch logins, assign a pastor, and email their password via Gmail SMTP.</p>
  </div>
  <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
    <i class="bx bx-plus"></i> Add Branch Account
  </a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Assigned Pastor</th>
          <th>Phone</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($branches as $branch)
          <tr>
            <td class="fw-semibold">{{ $branch->name }}</td>
            <td>{{ $branch->email }}</td>
            <td>
              @if($branch->pastor)
                {{ $branch->pastor->name }}
                @if($branch->pastor->church)
                  <small class="text-muted d-block">{{ $branch->pastor->church }}</small>
                @endif
              @else
                <span class="text-danger">Unassigned</span>
              @endif
            </td>
            <td>{{ $branch->phone ?: '—' }}</td>
            <td class="text-end">
              <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-sm btn-outline-primary">Edit</a>
              <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this branch account?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-4">No branch accounts yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
