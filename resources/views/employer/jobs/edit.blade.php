@extends('admin.layouts.employer')

@section('title', 'Edit Job Posting - ' . $job->title . ' - TSEA')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-sm job-form-card">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0 text-primary">Edit Job Posting</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('employer.dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fas fa-th-large me-1"></i> Dashboard
                        </a>
                        <a href="{{ route('employer.jobs.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Back to List</a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('employer.jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $job->title) }}" placeholder="e.g. Software Engineer" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Job Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Describe the role, responsibilities and requirements..." required>{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $job->location) }}" placeholder="e.g. Nairobi, Kenya" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="job_type" class="form-label">Job Type</label>
                                <select name="job_type" id="job_type" class="form-select @error('job_type') is-invalid @enderror" required>
                                    <option value="" disabled>Select type...</option>
                                    <option value="full-time" {{ old('job_type', $job->job_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ old('job_type', $job->job_type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="contract" {{ old('job_type', $job->job_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ old('job_type', $job->job_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                                @error('job_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="salary_min" class="form-label">Minimum Salary (Optional)</label>
                                <input type="number" name="salary_min" id="salary_min" class="form-control @error('salary_min') is-invalid @enderror" value="{{ old('salary_min', $job->salary_min) }}" step="0.01">
                                @error('salary_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="salary_max" class="form-label">Maximum Salary (Optional)</label>
                                <input type="number" name="salary_max" id="salary_max" class="form-control @error('salary_max') is-invalid @enderror" value="{{ old('salary_max', $job->salary_max) }}" step="0.01">
                                @error('salary_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="form-label">Application Deadline (Optional)</label>
                            <input type="date" name="deadline" id="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', $job->deadline ? $job->deadline->format('Y-m-d') : '') }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i>Update Job Opportunity
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
