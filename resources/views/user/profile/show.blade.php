@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Profile</h1>
    <div class="card">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
        <p><strong>Bio:</strong> {{ $user->bio ?? 'N/A' }}</p>
        {{-- Display other user profile details --}}
        <div class="mt-4">
            <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            <a href="{{ route('user.change-password') }}" class="btn btn-secondary">Change Password</a>
        </div>
    </div>
</div>
@endsection