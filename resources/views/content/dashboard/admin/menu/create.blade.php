@extends('layouts/contentNavbarLayout')
@section('title', 'Add Menu Item')

@section('content')
<div class="card">
  <form action="{{ route('admin.menu.store') }}" method="POST">
    @csrf
    @include('content.dashboard.admin.menu.form')
    <button class="btn" type="submit">Save Menu Item</button>
  </form>
</div>
@endsection
