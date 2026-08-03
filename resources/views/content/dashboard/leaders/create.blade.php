@extends('layouts/contentNavbarLayout')

@section('title', 'Add Leader')

@section('content')

<div class="card">

  <h3>Add Leader</h3>

  <form action="{{ route('admin.leaders.store') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    @include('content.dashboard.leaders.form')

    <button class="btn" type="submit">
      Save
    </button>

  </form>

</div>

@endsection