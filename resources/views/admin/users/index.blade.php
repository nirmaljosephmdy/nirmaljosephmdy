@extends('layouts.app')
@section('header', 'Users')
@section('content')
<div class="card-layer">
 @foreach($users as $u)
  <div class="card mb-4">{{ $u->name }} ({{ $u->email }})</div>
 @endforeach
</div>
@endsection