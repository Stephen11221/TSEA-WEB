@extends('admin.layouts.employer')

@section('title', 'My Job Postings')

@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold" style="color: #1e40af;">My Job Postings</h1>
            <p class="text-muted">Manage your active listings and track candidate interest.</p>
        </div>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Post New Job
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8f9fa; color: #1e40af;">
                    <tr>
                        <th class="ps-4 py-3">Job Details</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Applications</th>
                        <th>Deadline</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $job->title }}</div>
                            <small class="text-muted">Posted on {{ $job->created_at->format('M d, Y') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-primary border">{{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</span>
                        </td>
                        <td><i class="fas fa-map-marker-alt text-muted me-1"></i> {{ $job->location }}</td>
                        <td>
                            @if($job->status === 'open')
                                <span class="badge bg-success-subtle text-success border border-success px-3">Active</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 text-uppercase">{{ $job->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}" class="btn btn-sm btn-light rounded-pill px-3">
                                <i class="fas fa-users me-1 text-primary"></i> {{ $job->applications_count }}
                            </a>
                        </td>
                        <td class="small">{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'N/A' }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm rounded">
                                <a href="{{ route('employer.jobs.show', $job->id) }}" class="btn btn-sm btn-white text-primary" title="Preview"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-white text-secondary" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this job posting?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-white text-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted mb-3"><i class="fas fa-briefcase fa-3x opacity-25"></i></div>
                            <p class="mb-0">You haven't posted any jobs yet.</p>
                            <a href="{{ route('employer.jobs.create') }}" class="btn btn-link text-primary">Post your first job now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection