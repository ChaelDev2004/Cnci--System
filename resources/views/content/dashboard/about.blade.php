@extends('layouts/contentNavbarLayout')

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

  .minimal-form-group input[type="file"] {
    padding: 0.5rem 0;
    border: none;
    font-size: 0.85rem;
    color: #666;
  }

  .minimal-form-group input[type="file"]::file-selector-button {
    background: transparent;
    border: 1px solid #e0e0e0;
    padding: 0.4rem 1rem;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    color: #555;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .minimal-form-group input[type="file"]::file-selector-button:hover {
    background: #f5f5f5;
    border-color: #ccc;
  }

  .preview {
    margin-top: 0.75rem;
    padding: 0.5rem 0;
  }

  .preview img {
    max-width: 120px;
    height: auto;
    display: block;
    border: 1px solid #f0f0f0;
    padding: 4px;
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

  .minimal-table .thumb {
    width: 40px;
    height: 40px;
    object-fit: cover;
    display: block;
    border: 1px solid #f0f0f0;
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

  /* Add button */
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

    .minimal-table .thumb {
      width: 30px;
      height: 30px;
    }

    .table-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.75rem;
    }
  }
</style>

<!-- ABOUT SECTION -->
<div class="minimal-card">
  <h2 class="section-title">About Content</h2>

  <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="minimal-form-group">
      <label>Hero Title</label>
      <input type="text" name="hero_title" value="{{ old('hero_title', $content->hero_title) }}" placeholder="Enter hero title">
    </div>

    <div class="minimal-form-group">
      <label>Hero Eyebrow</label>
      <textarea name="hero_eyebrow" placeholder="Subheading under title">{{ old('hero_eyebrow', $content->hero_eyebrow) }}</textarea>
    </div>

    <div class="minimal-form-group">
      <label>Hero Sub Text</label>
      <textarea name="hero_subtext" placeholder="Additional hero text">{{ old('hero_subtext', $content->hero_subtext) }}</textarea>
    </div>

    <div class="minimal-form-group">
      <label>Hero Background Image</label>
      <input type="file" name="hero_bg_image">
      @if($content->hero_bg_image)
      <div class="preview">
        <img src="{{ asset('storage/'.$content->hero_bg_image) }}" alt="Hero background">
      </div>
      @endif
    </div>

    <div class="minimal-form-group">
      <label>Our Story — Paragraph 1</label>
      <textarea name="story_paragraph_1" placeholder="First paragraph of your story">{{ old('story_paragraph_1', $content->story_paragraph_1) }}</textarea>
    </div>

    <div class="minimal-form-group">
      <label>Our Story — Paragraph 2</label>
      <textarea name="story_paragraph_2" placeholder="Second paragraph of your story">{{ old('story_paragraph_2', $content->story_paragraph_2) }}</textarea>
    </div>

    <div class="minimal-form-group">
      <label>Our Story Image</label>
      <input type="file" name="story_image">
      @if($content->story_image)
      <div class="preview">
        <img src="{{ asset('storage/'.$content->story_image) }}" alt="Story image">
      </div>
      @endif
    </div>

    <button class="btn-minimal btn-minimal-primary" type="submit">
      Save About Changes
    </button>

  </form>
</div>

<hr class="minimal-divider">

<!-- LEADERSHIP SECTION -->
<div class="minimal-card">

  <div class="table-header">
    <h3>Leadership</h3>
    <a href="{{ route('admin.leaders.create') }}" class="add-link">+ Add Leader</a>
  </div>

  <table class="minimal-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Title</th>
        <th>Subtitle</th>
        <th>Order</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($leaders as $leader)
      <tr>
        <td>
          @if($leader->image)
          <img class="thumb" src="{{ asset('storage/'.$leader->image) }}" alt="{{ $leader->name }}">
          @endif
        </td>
        <td>{{ $leader->name }}</td>
        <td>{{ $leader->title }}</td>
        <td>{{ $leader->subtitle }}</td>
        <td>{{ $leader->sort_order }}</td>
        <td class="actions">
          <a href="{{ route('admin.leaders.edit', $leader) }}" class="btn-minimal btn-minimal-secondary">Edit</a>
          <form action="{{ route('admin.leaders.destroy', $leader) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this leader?')">
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

<!-- PASTORS SECTION -->
<div class="minimal-card">

  <div class="table-header">
    <h3>Pastors</h3>
    <a href="{{ route('content.dashboard.pastors.create') }}" class="add-link">+ Add Pastor</a>
  </div>

  <table class="minimal-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Role</th>
        <th>Church</th>
        <th>Order</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pastors as $pastor)
      <tr>
        <td>
          @if($pastor->image)
          <img class="thumb" src="{{ asset('storage/'.$pastor->image) }}" alt="{{ $pastor->name }}">
          @endif
        </td>
        <td>{{ $pastor->name }}</td>
        <td>{{ $pastor->role }}</td>
        <td>{{ $pastor->church }}</td>
        <td>{{ $pastor->sort_order }}</td>
        <td class="actions">
          <a href="{{ route('admin.pastors.edit', $pastor) }}" class="btn-minimal btn-minimal-secondary">Edit</a>
          <form action="{{ route('admin.pastors.destroy', $pastor) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this pastor?')">
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

<!-- MINISTERS SECTION -->
<div class="minimal-card">

  <div class="table-header">
    <h3>Gospel Ministers</h3>
    <a href="{{ route('content.dashboard.ministers.create') }}" class="add-link">+ Add Minister</a>
  </div>

  <table class="minimal-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Role</th>
        <th>Subrole</th>
        <th>Order</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($ministers as $minister)
      <tr>
        <td>
          @if($minister->image)
          <img class="thumb" src="{{ asset('storage/'.$minister->image) }}" alt="{{ $minister->name }}">
          @endif
        </td>
        <td>{{ $minister->name }}</td>
        <td>{{ $minister->role }}</td>
        <td>{{ $minister->subrole }}</td>
        <td>{{ $minister->sort_order }}</td>
        <td class="actions">
          <a href="{{ route('content.dashboard.ministers.edit', $minister) }}" class="btn-minimal btn-minimal-secondary">Edit</a>
          <form action="{{ route('admin.ministers.destroy', $minister) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this minister?')">
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