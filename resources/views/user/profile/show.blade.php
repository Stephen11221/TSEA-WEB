@extends('layouts.app')

@section('title', 'My Profile - TSEA')
@section('description', 'View your profile')

@section('content')
<section class="section">
    <div class="container">
        <h1>My Profile</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Member Since:</strong> {{ $user->created_at->format('F d, Y') }}</p>

                <div class="button-group">
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
