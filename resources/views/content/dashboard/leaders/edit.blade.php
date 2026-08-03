@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Leader')

@section('content')
<div class="card">
  <form action="{{ route('admin.leaders.update', $leader) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.leaders.form', ['leader' => $leader])
    <button class="btn" type="submit">Update</button>
  </form>
</div>
@endsection