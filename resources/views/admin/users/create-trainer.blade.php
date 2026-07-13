@extends('admin.layouts.admin')

@section('title', 'Create Trainer Account')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Trainer</h1>
        <p class="page-subtitle">Add a new trainer account (role: instructor).</p>
    </div>
</div>

<div class="card" style="max-width: 760px;">
    <form action="{{ route('admin.trainers.store') }}" method="POST">
        @csrf

        <div style="display: grid; gap: 12px;">
            <div>
                <label style="font-weight: 600; display:block; margin-bottom: 6px;">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required style="width:100%; padding: 10px; border:1px solid var(--color-border); border-radius: 8px;">
                @error('name')<small style="color:#dc2626;">{{ $message }}</small>@enderror
            </div>

            <div>
                <label style="font-weight: 600; display:block; margin-bottom: 6px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding: 10px; border:1px solid var(--color-border); border-radius: 8px;">
                @error('email')<small style="color:#dc2626;">{{ $message }}</small>@enderror
            </div>

            <div>
                <label style="font-weight: 600; display:block; margin-bottom: 6px;">Password</label>
                <input type="password" name="password" required style="width:100%; padding: 10px; border:1px solid var(--color-border); border-radius: 8px;">
                @error('password')<small style="color:#dc2626;">{{ $message }}</small>@enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Create Trainer Account
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
