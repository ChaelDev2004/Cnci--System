@extends('layouts/contentNavbarLayout')

@section('title', 'Calendar')

@section('vendor-style')
@vite('resources/assets/vendor/libs/fullcalendar/fullcalendar.scss')
@endsection

@section('page-style')
<style>
  .app-calendar-wrapper .card {
    height: 100%;
  }
  #calendar {
    min-height: 700px;
  }
  #calendarSidebarDate {
    width: 100%;
    border: 1px solid #d9dee3;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
  }
</style>
@endsection

@section('content')
<div class="card app-calendar-wrapper">
  <div class="row g-0">
    {{-- Sidebar --}}
    <div class="col-lg-3 col-12 border-end">
      <div class="p-4">
        <button class="btn btn-primary w-100 mb-4" type="button" id="btnAddEvent">
          <i class="bx bx-plus me-1"></i> Add Event
        </button>

        <div class="mb-4">
          <label class="form-label" for="calendarSidebarDate">Jump to date</label>
          <input type="date" id="calendarSidebarDate" class="form-control" value="{{ now()->format('Y-m-d') }}">
        </div>

        <h6 class="mb-3">Event Filters</h6>
        <div class="event-filter-item">
          <input class="form-check-input" type="checkbox" id="selectAll" checked>
          <label class="form-check-label" for="selectAll">View All</label>
        </div>

        @foreach($categories as $name => $color)
        <div class="event-filter-item">
          <input
            class="form-check-input input-filter"
            type="checkbox"
            id="filter-{{ Str::slug($name) }}"
            data-value="{{ $name }}"
            checked>
          <span class="event-filter-dot" style="background:{{ $color }}"></span>
          <label class="form-check-label" for="filter-{{ Str::slug($name) }}">{{ $name }}</label>
        </div>
        @endforeach

        <hr class="my-4">
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary w-100 btn-sm">
          Manage Events List
        </a>
      </div>
    </div>

    {{-- Calendar --}}
    <div class="col-lg-9 col-12">
      <div class="p-4">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
</div>

{{-- Add / Edit Modal --}}
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="eventForm">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalTitle">Add Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="eventId" name="id">

          <div class="mb-3">
            <label class="form-label" for="eventTitle">Title</label>
            <input type="text" id="eventTitle" name="title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="eventLabel">Label</label>
            <select id="eventLabel" name="tag" class="form-select" required>
              @foreach($categories as $name => $color)
              <option value="{{ $name }}">{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label" for="eventStart">Start date &amp; time</label>
            <input type="datetime-local" id="eventStart" name="event_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="eventLocation">Location</label>
            <input type="text" id="eventLocation" name="location" class="form-control" placeholder="Optional">
          </div>

          <div class="mb-3">
            <label class="form-label" for="eventDescription">Description</label>
            <textarea id="eventDescription" name="description" class="form-control" rows="3" placeholder="Optional"></textarea>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="eventActive" name="is_active" checked>
            <label class="form-check-label" for="eventActive">Active</label>
          </div>

          <div id="eventFormError" class="text-danger small mt-3 d-none"></div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-danger d-none" id="btnDeleteEvent">Delete</button>
          <div class="ms-auto">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="btnSaveEvent">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/fullcalendar/fullcalendar.js')
@endsection

@section('page-script')
<script>
  window.calendarConfig = {
    eventsUrl: @json(route('admin.calendar.events')),
    storeUrl: @json(route('admin.calendar.store')),
    updateUrlTemplate: @json(url('/admin/calendar/events')),
    csrfToken: @json(csrf_token()),
    categories: @json($categories),
  };
</script>
@vite('resources/assets/js/app-calendar.js')
@endsection
