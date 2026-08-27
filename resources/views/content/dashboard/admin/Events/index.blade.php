  @extends('layouts/contentNavbarLayout')
  @section('title', 'Manage Events')

  @section('content')
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1>Events</h1>
      <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Event
      </a>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Tag</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($events as $event)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  @if($event->image_url)
                  <img src="{{ $event->image_url }}" alt="{{ $event->title }}" width="50" height="50" style="object-fit:cover;border-radius:8px;">
                  @else
                  <div class="bg-light rounded" style="width:50px;height:50px;display:flex;align-items:center;justify-content:center;color:#ccc;">
                    <i class="fas fa-image"></i>
                  </div>
                  @endif
                </td>
                <td>
                  <strong>{{ $event->title }}</strong>
                  <small class="d-block text-muted">{{ Str::limit($event->description, 60) }}</small>
                </td>
                <td>
                  @if($event->tag)
                  <span class="badge bg-info">{{ $event->tag }}</span>
                  @endif
                </td>
                <td>
                  {{ $event->date ?? 'TBD' }}
                  @if($event->time)
                  <small class="d-block text-muted">{{ $event->time }}</small>
                  @endif
                </td>
                <td>
                  <span class="badge bg-{{ $event->is_active ? 'success' : 'danger' }}">
                    {{ $event->is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                      data-id="{{ $event->id }}"
                      data-title="{{ $event->title }}">
                      <i class="fas fa-trash"></i>
                    </button>
                    <a href="{{ route('admin.events.toggle', $event) }}"
                      class="btn btn-sm btn-{{ $event->is_active ? 'secondary' : 'success' }} toggle-btn"
                      data-id="{{ $event->id }}"
                      data-title="{{ $event->title }}"
                      data-status="{{ $event->is_active ? 'deactivate' : 'activate' }}">
                      <i class="fas fa-{{ $event->is_active ? 'eye-slash' : 'eye' }}"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <p class="text-muted mb-0">No events found. <a href="{{ route('admin.events.create') }}">Create your first event</a></p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{ $events->links() }}
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Delete confirmation with SweetAlert
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const eventId = this.dataset.id;
          const eventTitle = this.dataset.title;

          Swal.fire({
            title: 'Delete Event?',
            html: `Are you sure you want to delete <strong>"${eventTitle}"</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
              popup: 'cnci-swal',
              confirmButton: 'cnci-confirm',
              cancelButton: 'cnci-cancel',
            },
          }).then((result) => {
            if (result.isConfirmed) {
              // Create a form and submit it
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = `{{ url('admin/events') }}/${eventId}`;
              form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
              document.body.appendChild(form);

              // Show loading state
              Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                  Swal.showLoading();
                }
              });

              form.submit();
            }
          });
        });
      });

      // Toggle status with SweetAlert
      document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const eventId = this.dataset.id;
          const eventTitle = this.dataset.title;
          const status = this.dataset.status;
          const action = status === 'activate' ? 'activate' : 'deactivate';
          const icon = status === 'activate' ? 'success' : 'warning';

          Swal.fire({
            title: `${action.charAt(0).toUpperCase() + action.slice(1)} Event?`,
            html: `Are you sure you want to <strong>${action}</strong> "<strong>${eventTitle}</strong>"?`,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: status === 'activate' ? '#28a745' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: `Yes, ${action} it!`,
            cancelButtonText: 'Cancel',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `{{ url('admin/events') }}/${eventId}/toggle`;
            }
          });
        });
      });
    });
  </script>
  @endpush
  @endsection