@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Pastor')

@section('content')
<div class="card">
  <form action="{{ route('admin.pastors.update', $pastor) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('content.dashboard.pastors.form', ['pastor' => $pastor])
    <button class="btn" type="submit">Update</button>
  </form>
</div>
@endsection