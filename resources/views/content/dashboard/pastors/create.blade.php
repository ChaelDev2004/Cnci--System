@extends('layouts/contentNavbarLayout')
@section('title', 'Add Pastor')

@section('content')
<div class="card">
  <form action="{{ route('admin.pastors.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('content.dashboard.pastors.form')
    <button class="btn" type="submit">Save</button>
  </form>
</div>
@endsection