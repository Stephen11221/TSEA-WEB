@extends('admin.layouts.employer')

@section('title', 'My Job Postings - TSEA')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold h3 mb-1" style="color: #1e40af;">My Job Postings</h1>
            <p class="text-muted small">Manage and track your active opportunities.</p>
        </div>
        <div class="d-flex gap-5">
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm btn-sm">
                <i class="fas fa-plus me-2"></i>Post New Job
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Total Jobs</div>
                    <h2 class="stat-value">{{ $jobs->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Active Postings</div>
                    <h2 class="stat-value text-primary">{{ $jobs->where('status', 'open')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Total Applications</div>
                    <h2 class="stat-value">{{ $jobs->sum('applications_count') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Pending Reviews</div>
                    <h2 class="stat-value text-warning">{{ $jobs->sum('pending_applications_count') ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm main-table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Job Details</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Applications</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $job->title }}</div>
                            <div class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1">{{ ucfirst($job->job_type) }}</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill {{ $job->status === 'open' ? 'bg-success-subtle text-success border-success' : 'bg-secondary-subtle text-secondary border-secondary' }} border px-3 py-2">
                                {{ strtoupper($job->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $job->applications_count ?? 0 }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job posting?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="mb-3">
                                <i class="fas fa-briefcase fa-3x opacity-25"></i>
                            </div>
                            <h5>No jobs posted yet</h5>
                            <p>Get started by creating your first job opportunity.</p>
                            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary rounded-pill px-4">Create Job Posting</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jobs->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
@endsection
