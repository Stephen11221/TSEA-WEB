@extends('admin.layouts.admin')

@section('title', 'Edit Job Posting')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Job Posting</h1>
        <p class="page-subtitle">Updating listing: {{ $job->title }}</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 900px; margin: 0 auto;">
    <form action="{{ route('admin.jobs.update', $job) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Employer</label>
            <select name="employer_id" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @foreach($employers as $employer)
                    <option value="{{ $employer->id }}" {{ $job->employer_id == $employer->id ? 'selected' : '' }}>
                        {{ $employer->name }} ({{ $employer->email }})
                    </option>
                @endforeach
            </select>
            @error('employer_id') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Job Title</label>
                <input type="text" name="title" value="{{ old('title', $job->title) }}" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                @error('title') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Status</label>
                <select name="status" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    <option value="open" {{ $job->status === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ $job->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="filled" {{ $job->status === 'filled' ? 'selected' : '' }}>Filled</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Location</label>
                <input type="text" name="location" value="{{ old('location', $job->location) }}" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Job Type</label>
                <select name="job_type" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                    <option value="full-time" {{ $job->job_type === 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ $job->job_type === 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="contract" {{ $job->job_type === 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="internship" {{ $job->job_type === 'internship' ? 'selected' : '' }}>Internship</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Salary Min</label>
                <input type="number" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>
            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Salary Max</label>
                <input type="number" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>
        </div>

        <div class="form-field" style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Deadline</label>
            <input type="date" name="deadline" value="{{ old('deadline', $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') : '') }}" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
        </div>

        <div class="form-field" style="margin-bottom: 24px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px;">Job Description</label>
            <textarea name="description" rows="8" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px; font-family: inherit;">{{ old('description', $job->description) }}</textarea>
            @error('description') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="padding-top: 20px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection