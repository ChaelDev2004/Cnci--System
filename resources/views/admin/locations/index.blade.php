@extends('layouts.app')

@section('title', 'Manage Locations')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
      <span class="text-muted fw-light">Admin /</span> Church Locations
    </h4>
    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Add New Location
    </a>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">All Locations</h5>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Church Name</th>
            <th>City</th>
            <th>Pastor</th>
            <th>Service Time</th>
            <th>Default</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($locations as $location)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              <strong>{{ $location->name }}</strong>
            </td>
            <td>{{ $location->city }}</td>
            <td>
              @if($location->pastor)
              <span class="badge bg-success">
                <i class="fas fa-user-pastor"></i> {{ $location->pastor->name }}
              </span>
              @else
              <span class="badge bg-secondary">No Pastor Assigned</span>
              @endif
            </td>
            <td>{{ $location->service_time ?? 'N/A' }}</td>
            <td>
              @if($location->is_default)
              <span class="badge bg-primary">
                <i class="fas fa-check-circle"></i> Default
              </span>
              @else
              <span class="badge bg-secondary">No</span>
              @endif
            </td>
            <td>
              <div class="btn-group" role="group">
                <a href="{{ route('admin.locations.edit', $location) }}"
                  class="btn btn-sm btn-outline-primary">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.locations.destroy', $location) }}"
                  method="POST"
                  class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this location?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-4">
              <div class="text-muted">
                <i class="fas fa-church fa-3x mb-3 d-block"></i>
                <p>No locations found. Click "Add New Location" to create one.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .table td {
    vertical-align: middle;
  }
</style>
@endpush