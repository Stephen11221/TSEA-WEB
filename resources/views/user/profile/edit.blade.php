@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Edit Profile</h1>
    <div class="card">
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
            </div>
            {{-- Add more fields as needed --}}
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ route('user.profile') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection