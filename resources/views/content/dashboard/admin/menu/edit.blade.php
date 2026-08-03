@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Menu Item')

@section('content')
<div class="card">
  <form action="{{ route('admin.menu.update', $item) }}" method="POST">
    @csrf
    @method('PUT')
    @include('content.dashboard.admin.menu.form', ['item' => $item, 'parents' => $parents])
    <button class="btn" type="submit">Update Menu Item</button>
  </form>
</div>
@endsection
