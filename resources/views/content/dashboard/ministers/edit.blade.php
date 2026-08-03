@extends('layouts/contentNavbarLayout')

@section('content')
<div class="card">
  <form action="{{ route('admin.ministers.update', $minister) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('content.dashboard.ministers.form', ['minister' => $minister])
    <button class="btn" type="submit">Update</button>
  </form>
</div>
@endsection