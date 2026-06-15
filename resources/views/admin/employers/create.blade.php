@extends('admin.layouts.admin')

@section('title', 'Add New Employer')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Add New Employer</h1>
        <p class="page-subtitle">Register a new employer account.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto;">
    <form action="{{ route('admin.employers.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Employer Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Acme Corp" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @error('name') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Status</label>
                <select name="status" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    <option value="pending">Pending</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="employer@example.com" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @error('email') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+123..." style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @error('phone') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="padding-top: 20px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Employer
            </button>
        </div>
    </form>
</div>
@endsection