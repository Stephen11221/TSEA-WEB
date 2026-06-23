@extends('admin.layouts.admin')


@section('title', 'Edit Student - TSEA Admin')
@section('description', 'Edit student information')

@section('content')
<section class="section">
    <div class="container">
        <h1>Edit Student</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="employer" {{ old('role', $user->role) === 'employer' ? 'selected' : '' }}>Employer</option>
                    <option value="instructor" {{ old('role', $user->role) === 'instructor' ? 'selected' : '' }}>Instructor</option>
                </select>
                @error('role')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

        <hr style="margin: 24px 0; border: 0; border-top: 1px solid #e5e7eb;">

        <h2 style="margin-bottom: 12px;">Reset Student Password</h2>
        <p style="margin-bottom: 16px; color: #6b7280;">Set a new password for this student account.</p>

        <form action="{{ route('admin.users.password.update', $user) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Reset password for this student?')">Update Password</button>
            </div>
        </form>
    </div>
</section>
@endsection
