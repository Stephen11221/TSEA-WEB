@extends('layouts.app')

@section('title', 'Admin Dashboard - TSEA')
@section('description', 'TSEA Admin Dashboard')

@section('content')
<section class="section">
    <div class="container">
        <h1>Admin Dashboard</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid four">
            <article class="card">
                <h3>Total Users</h3>
                <p class="stat">{{ $totalUsers }}</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Manage Users</a>
            </article>

            <article class="card">
                <h3>Admins</h3>
                <p class="stat">{{ $totalAdmins }}</p>
            </article>

            <article class="card">
                <h3>Passports Created</h3>
                <p class="stat">{{ $totalPassports }}</p>
                <a href="{{ route('admin.passports') }}" class="btn btn-secondary">View Passports</a>
            </article>

            <article class="card">
                <h3>Account</h3>
                <ul>
                    <li><a href="{{ route('user.profile') }}">View Profile</a></li>
                    <li><a href="{{ route('admin.change-password') }}">Change Password</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" target="_self" style="display: inline;">
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
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">View All Users</a>
                <a href="{{ route('admin.passports') }}" class="btn btn-primary">View All Passports</a>
                <a href="{{ route('admin.pages.edit', 'home') }}" class="btn btn-primary">Edit Homepage</a>
            </div>
        </div>
    </div>
</section>
@endsection
