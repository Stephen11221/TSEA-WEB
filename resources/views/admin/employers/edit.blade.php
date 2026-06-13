@extends('admin.layouts.admin')

@section('title', 'Edit Employer')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Employer</h1>
        <p class="page-subtitle">Modify profile details and account status for {{ $employer->name }}.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.employers.update', $employer) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 16px; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 8px;">Organization Profile</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Employer Name</label>
                    <input type="text" name="name" value="{{ old('name', $employer->name) }}" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    @error('name') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Contact Email</label>
                    <input type="email" name="email" value="{{ old('email', $employer->email) }}" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    @error('email') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $employer->phone) }}" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    @error('phone') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Account Status</label>
                    <select name="status" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px; background: white;">
                        <option value="active" {{ old('status', $employer->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $employer->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ old('status', $employer->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div style="padding: 15px; background: #fff8f5; border: 1px dashed var(--color-accent); border-radius: 8px; margin-bottom: 24px;">
            <p style="font-size: 13px; color: #854d0e;">
                <i class="fas fa-info-circle"></i> To change the employer's password, please use the User Management section or the password reset utility.
            </p>
        </div>

        <div style="padding-top: 20px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.employers.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection