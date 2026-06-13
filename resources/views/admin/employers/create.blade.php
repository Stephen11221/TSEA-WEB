@extends('admin.layouts.admin')

@section('title', 'Add Employer')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Add New Employer</h1>
        <p class="page-subtitle">Create a new partner account to post jobs and manage talent.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.employers.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 16px; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 8px;">Organization Details</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Company/Employer Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Acme Corp" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    @error('name') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+254..." style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    @error('phone') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 16px; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 8px;">Login Credentials</h3>
            <div class="form-field" style="margin-bottom: 20px;">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="employer@example.com" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @error('email') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Password</label>
                    <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    @error('password') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Confirm Password</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>
            </div>
        </div>

        <div style="padding-top: 20px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check"></i> Create Employer Account
            </button>
        </div>
    </form>
</div>
@endsection