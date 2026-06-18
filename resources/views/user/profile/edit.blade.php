@php
    $user = auth()->user();
    $role = $user->role;
    
    // Dynamically determine the layout
    $layout = match($role) {
        'admin' => 'admin.layouts.admin',
        'employer' => 'admin.layouts.employer',
        default => 'layouts.app',
    };

    // Dynamically determine the update route
    $updateRoute = match($role) {
        'admin' => 'admin.profile.update',
        'employer' => 'employer.profile.update',
        default => 'user.profile.update',
    };
@endphp

@extends($layout)

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="fw-bold mb-0 text-primary">Edit Account Details</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route($updateRoute) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=eff6ff&color=1e40af' }}" 
                                     class="rounded-circle border border-4 shadow-sm"
                                     style="width: 120px; height: 120px; object-fit: cover; border-color: #fff !important;">
                            </div>
                            <div class="mt-3">
                                <label for="avatar" class="form-label fw-bold small">Change Profile Picture</label>
                                <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection