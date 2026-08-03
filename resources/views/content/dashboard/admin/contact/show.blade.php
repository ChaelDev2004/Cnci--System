@extends('layouts/contentNavbarLayout')
@section('title', 'Contact Message')

@section('content')
<div class="mb-3">
  <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">← Back to Contact</a>
</div>

<div class="card">
  <div class="card-body">
    <h4 class="mb-3">{{ $message->subject ?: 'No subject' }}</h4>

    <p><strong>From:</strong> {{ $message->name }}</p>
    <p><strong>Email:</strong>
      @if($message->email)
        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
      @else
        —
      @endif
    </p>
    <p><strong>Received:</strong> {{ $message->created_at->format('F d, Y g:i A') }}</p>

    <hr>
    <p style="white-space:pre-wrap;">{{ $message->message }}</p>

    <div class="mt-4 d-flex gap-2">
      @if($message->email)
        <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject ?: 'Your message') }}" class="btn">Reply by Email</a>
      @endif
      <form action="{{ route('admin.contact.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </div>
  </div>
</div>
@endsection
