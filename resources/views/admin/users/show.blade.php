@extends('admin.layouts.admin')

@section('title', 'User Details - TSEA Admin')
@section('description', 'View user details')

@section('content')
<section class="section">
    <div class="container">
        <h1>User Details</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> <span class="badge {{ $user->isAdmin() ? 'badge-admin' : 'badge-user' }}">{{ ucfirst($user->role) }}</span></p>
                <p><strong>Created:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                <p><strong>Last Updated:</strong> {{ $user->updated_at->format('Y-m-d H:i:s') }}</p>

                <div class="button-group">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit User</a>
                    @if (auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete User</button>
                        </form>
                    @endif
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
