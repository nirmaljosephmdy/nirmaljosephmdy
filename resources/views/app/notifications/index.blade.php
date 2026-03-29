@extends('layouts.app')
@section('header', 'Notifications')
@section('content')
<div class="card-layer">
 @forelse($notifications as $n)
  <div class="card mb-4">Notification</div>
 @empty
 <div class="card mt-4">No notifications.</div>
 @endforelse
</div>
@endsection