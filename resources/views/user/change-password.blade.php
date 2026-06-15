@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Change Password</h1>
    <div class="card">
        <form action="{{ route('user.change-password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
            <a href="{{ route('user.profile') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection