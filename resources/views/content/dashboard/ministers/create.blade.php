@extends('layouts/contentNavbarLayout')

@section('content')
<div class="card">
  <form action="{{ route('admin.ministers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('content.dashboard.ministers.form')
    <button class="btn" type="submit">Save</button>
  </form>
</div>
@endsection