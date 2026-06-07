@extends('layouts.app')

@section('title', 'Dashboard - TSEA')
@section('description', 'Your TSEA Dashboard')

@section('content')
<section class="section">
    <div class="container">
        <h1>Welcome, {{ auth()->user()->name }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid four">
            <article class="card">
                <h3>My Passports</h3>
                <p class="stat">{{ count($passports) }}</p>
                <a href="{{ route('user.passports') }}" class="btn btn-secondary">View Passports</a>
            </article>

            <article class="card">
                <h3>Applications</h3>
                <p class="stat">0</p>
                <p class="text-muted">Coming soon</p>
            </article>

            <article class="card">
                <h3>Opportunities</h3>
                <a href="{{ route('user.opportunities.search') }}" class="btn btn-secondary">Search Now</a>
            </article>

            <article class="card">
                <h3>Account</h3>
                <ul>
                    <li><a href="{{ route('user.profile') }}">View Profile</a></li>
                    <li><a href="{{ route('user.change-password') }}">Change Password</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </article>
        </div>

        <div class="section">
            <h2>Quick Actions</h2>
            <div class="grid three">
                <a href="{{ route('user.passport.create') }}" class="btn btn-primary">Create Passport</a>
                <a href="{{ route('user.opportunities.search') }}" class="btn btn-primary">Search Opportunities</a>
                <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</section>
@endsection
