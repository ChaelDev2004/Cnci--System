@extends('layouts/contentNavbarLayout')

@section('title', 'Index')

@section('content')

<style>
  /* Minimalist Reset & Base */
  .minimal-card {
    background: #ffffff;
    border: none;
    border-radius: 0;
    padding: 2.5rem 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    transition: box-shadow 0.2s ease;
  }

  .minimal-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  }

  .minimal-divider {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 2.5rem 0;
  }

  .section-title {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #888;
    font-weight: 500;
    margin-bottom: 1.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f0f0f0;
  }

  .subsection-title {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #999;
    font-weight: 500;
    margin: 1.75rem 0 1rem 0;
    padding-bottom: 0.25rem;
    border-bottom: 1px solid #f5f5f5;
  }

  /* Form Elements */
  .minimal-form-group {
    margin-bottom: 1.5rem;
  }

  .minimal-form-group label {
    display: block;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #999;
    margin-bottom: 0.4rem;
    font-weight: 500;
  }

  .minimal-form-group input,
  .minimal-form-group textarea {
    width: 100%;
    padding: 0.6rem 0;
    border: none;
    border-bottom: 1px solid #e8e8e8;
    background: transparent;
    font-size: 0.95rem;
    color: #222;
    transition: border-color 0.2s ease;
    outline: none;
    font-family: inherit;
    resize: vertical;
  }

  .minimal-form-group input:focus,
  .minimal-form-group textarea:focus {
    border-bottom-color: #222;
  }

  .minimal-form-group textarea {
    min-height: 80px;
  }

  .minimal-form-group textarea[style*="min-height:120px"] {
    min-height: 120px;
  }

  /* Buttons */
  .btn-minimal {
    background: transparent;
    border: 1px solid #d0d0d0;
    padding: 0.5rem 1.5rem;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
  }

  .btn-minimal:hover {
    background: #222;
    color: #fff;
    border-color: #222;
  }

  .btn-minimal-primary {
    background: #222;
    border-color: #222;
    color: #fff;
  }

  .btn-minimal-primary:hover {
    background: #000;
    border-color: #000;
    color: #fff;
  }

  .btn-minimal-danger {
    border-color: #e8e8e8;
    color: #999;
  }

  .btn-minimal-danger:hover {
    background: transparent;
    border-color: #d32f2f;
    color: #d32f2f;
  }

  .btn-minimal-secondary {
    border-color: #e8e8e8;
    color: #666;
  }

  .btn-minimal-secondary:hover {
    background: #f5f5f5;
    border-color: #ccc;
    color: #333;
  }

  .add-link {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #888;
    text-decoration: none;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 2px;
    transition: all 0.2s ease;
  }

  .add-link:hover {
    color: #222;
    border-bottom-color: #222;
  }

  /* Tables */
  .minimal-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
  }

  .minimal-table th {
    text-align: left;
    font-size: 0.6rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #aaa;
    font-weight: 500;
    padding: 0.75rem 0.5rem 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
  }

  .minimal-table td {
    padding: 0.75rem 0.5rem 0.75rem 0;
    border-bottom: 1px solid #f5f5f5;
    color: #444;
    vertical-align: middle;
  }

  .minimal-table tr:last-child td {
    border-bottom: none;
  }

  .minimal-table .actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .minimal-table .actions .btn-minimal {
    padding: 0.25rem 0.75rem;
    font-size: 0.6rem;
  }

  .minimal-table .badge-active {
    font-size: 0.75rem;
    color: #2e7d32;
  }

  .minimal-table .badge-inactive {
    font-size: 0.75rem;
    color: #999;
  }

  .minimal-table .badge-default {
    font-size: 0.65rem;
    letter-spacing: 0.05em;
    color: #888;
  }

  .table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
  }

  .table-header h3 {
    font-size: 0.85rem;
    font-weight: 500;
    color: #333;
    margin: 0;
    letter-spacing: 0.02em;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .minimal-card {
      padding: 1.5rem 1rem;
    }

    .minimal-table {
      font-size: 0.75rem;
    }

    .minimal-table th,
    .minimal-table td {
      padding: 0.5rem 0.25rem 0.5rem 0;
    }

    .table-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.75rem;
    }
  }
</style>

<!-- SETTINGS FORM -->
<div class="minimal-card">
  <h2 class="section-title">Site Settings</h2>

  <form action="{{ route('content.dashboard.home.update') }}" method="POST">
    @csrf
    @method('PUT')

    <h3 class="subsection-title">Mission & Purpose</h3>

    <div class="minimal-form-group">
      <label>Mission Text</label>
      <textarea name="mission_text" placeholder="Enter your mission statement">{{ old('mission_text', $settings->mission_text) }}</textarea>
    </div>

    <div class="minimal-form-group">
      <label>Purpose Text</label>
      <textarea name="purpose_text" placeholder="Enter your purpose statement">{{ old('purpose_text', $settings->purpose_text) }}</textarea>
    </div>

    <h3 class="subsection-title">About Us</h3>

    <div class="minimal-form-group">
      <label>About Text</label>
      <textarea name="about_text" style="min-height:120px;" placeholder="Tell your story...">{{ old('about_text', $settings->about_text) }}</textarea>
    </div>

    <h3 class="subsection-title">Contact Info Panel</h3>

    <div class="minimal-form-group">
      <label>Phone</label>
      <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" placeholder="+1 (555) 123-4567">
    </div>

    <div class="minimal-form-group">
      <label>Email</label>
      <input type="text" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" placeholder="info@yourchurch.org">
    </div>

    <div class="minimal-form-group">
      <label>Address</label>
      <input type="text" name="contact_address" value="{{ old('contact_address', $settings->contact_address) }}" placeholder="123 Main St, City, State">
    </div>

    <div class="minimal-form-group">
      <label>Office Hours</label>
      <input type="text" name="contact_hours" value="{{ old('contact_hours', $settings->contact_hours) }}" placeholder="Mon–Fri 9:00am–5:00pm">
    </div>

    <div class="minimal-form-group">
      <label>Website</label>
      <input type="text" name="contact_website" value="{{ old('contact_website', $settings->contact_website) }}" placeholder="https://yourchurch.org">
    </div>

    <button class="btn-minimal btn-minimal-primary" type="submit">Save Settings</button>
  </form>
</div>

<hr class="minimal-divider">

<!-- SLIDES SECTION -->
<div class="minimal-card">
  <div class="table-header">
    <h3>Slides</h3>
    <a href="{{ route('content.dashboard.admin.home.slides.create') }}" class="add-link">+ Add Slide</a>
  </div>

  <table class="minimal-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Layout</th>
        <th>Heading</th>
        <th>Type</th>
        <th>Active</th>
        <th>Order</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($slides as $slide)
      <tr>
        <td>{{ $slide->id }}</td>
        <td>{{ ucfirst($slide->layout) }}</td>
        <td>{{ Str::limit($slide->heading, 40) }}</td>
        <td>{{ ucfirst($slide->bg_type) }}</td>
        <td>
          <span class="{{ $slide->active ? 'badge-active' : 'badge-inactive' }}">
            {{ $slide->active ? '✓ Active' : '○ Inactive' }}
          </span>
        </td>
        <td>{{ $slide->sort_order }}</td>
        <td class="actions">
          <a href="{{ route('slides.edit', $slide) }}" class="btn-minimal btn-minimal-secondary">Edit</a>
          <form action="{{ route('slides.destroy', $slide) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete slide?')">
            @csrf
            @method('DELETE')
            <button class="btn-minimal btn-minimal-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<hr class="minimal-divider">

<!-- LOCATIONS SECTION -->
<div class="minimal-card">
  <div class="table-header">
    <h3>Locations</h3>
    <a href="{{ route('content.dashboard.admin.locations.create') }}" class="add-link">+ Add Location</a>
  </div>

  <table class="minimal-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>City</th>
        <th>Address</th>
        <th>Service Time</th>
        <th>Default</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($locations as $loc)
      <tr>
        <td>{{ $loc->name }}</td>
        <td>{{ $loc->city }}</td>
        <td>{{ $loc->address }}</td>
        <td>{{ $loc->service_time }}</td>
        <td>
          @if($loc->is_default)
          <span class="badge-default">★ Default</span>
          @endif
        </td>
        <td class="actions">
          <a href="{{ route('locations.edit', $loc) }}" class="btn-minimal btn-minimal-secondary">Edit</a>
          <form action="{{ route('locations.destroy', $loc) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete location?')">
            @csrf
            @method('DELETE')
            <button class="btn-minimal btn-minimal-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection