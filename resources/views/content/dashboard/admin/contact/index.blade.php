@extends('layouts/contentNavbarLayout')
@section('title', 'Contact')

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-3" style="display:none">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <div>
    <h4 class="mb-1">Contact</h4>
    <p class="text-muted mb-0">Edit contact details shown on the website and review visitor messages.</p>
  </div>
  @if($unreadCount > 0)
    <span class="badge bg-danger">{{ $unreadCount }} unread</span>
  @endif
</div>

<div class="card mb-4">
  <div class="card-body">
    <h5 class="mb-3">Contact Information</h5>
    <form action="{{ route('admin.contact.settings') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" placeholder="+63 ...">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" placeholder="cnciregion1@gmail.com">
      </div>
      <div class="form-group">
        <label>Address / Location</label>
        <input type="text" name="contact_address" value="{{ old('contact_address', $settings->contact_address) }}" placeholder="Region 1, Philippines">
      </div>
      <div class="form-group">
        <label>Office Hours</label>
        <input type="text" name="contact_hours" value="{{ old('contact_hours', $settings->contact_hours) }}" placeholder="Mon–Fri 9am–4pm">
      </div>
      <div class="form-group">
        <label>Website</label>
        <input type="text" name="contact_website" value="{{ old('contact_website', $settings->contact_website) }}" placeholder="church.org">
      </div>

      <div class="cnci-form-actions">
        <button class="btn btn-primary" type="submit">Save Contact Info</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="mb-3">Messages from Website</h5>
    <table>
      <tr>
        <th>Status</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
      @forelse($messages as $message)
      <tr style="{{ $message->is_read ? '' : 'font-weight:700;' }}">
        <td>{{ $message->is_read ? 'Read' : 'New' }}</td>
        <td>{{ $message->name }}</td>
        <td>{{ $message->email ?: '—' }}</td>
        <td>{{ $message->subject ?: '—' }}</td>
        <td>{{ $message->created_at->format('M d, Y g:i A') }}</td>
        <td class="actions">
          <a href="{{ route('admin.contact.show', $message) }}" class="btn btn-secondary">View</a>
          <form action="{{ route('admin.contact.destroy', $message) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this message?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6">No messages yet. Submissions from the home Contact form will appear here.</td>
      </tr>
      @endforelse
    </table>

    <div class="mt-3">
      {{ $messages->links() }}
    </div>
  </div>
</div>
@endsection
