@extends('admin.layouts.admin')

@section('title', 'Create a Job')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create a Job</h1>
        <p class="page-subtitle">Post a new opportunity on behalf of an employer.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto;">
    <form action="{{ route('admin.jobs.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Select Employer</label>
            <select name="employer_id" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                <option value="">-- Choose Employer --</option>
                @foreach($employers as $employer)
                    <option value="{{ $employer->id }}">{{ $employer->name }} ({{ $employer->email }})</option>
                @endforeach
            </select>
            @error('employer_id') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Job Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Senior Software Engineer" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @error('title') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Job Type</label>
                <select name="job_type" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    <option value="full-time">Full-time</option>
                    <option value="part-time">Part-time</option>
                    <option value="contract">Contract</option>
                    <option value="internship">Internship</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" required placeholder="e.g. Nairobi, Kenya or Remote" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @error('location') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Salary Min</label>
                <input type="number" name="salary_min" value="{{ old('salary_min') }}" placeholder="0.00" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Salary Max</label>
                <input type="number" name="salary_max" value="{{ old('salary_max') }}" placeholder="0.00" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>
        </div>

        <div class="form-field" style="margin-bottom: 24px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Job Description</label>
            <textarea name="description" rows="8" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit;">{{ old('description') }}</textarea>
            @error('description') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="padding-top: 20px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Job Posting
            </button>
        </div>
    </form>
</div>
@endsection