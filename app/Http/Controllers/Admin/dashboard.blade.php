@extends('layouts.app')

@section('title', 'Employer Dashboard - TSEA')

@section('content')
<div class="container-fluid py-5 px-lg-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold" style="color: #0047AB;">Employer Dashboard</h1>
            <p class="text-muted">Welcome back! Manage your job postings and review top talent applications.</p>
        </div>
        <div>
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-plus me-2"></i>Post New Job
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-primary-subtle p-3 rounded-3 text-primary">
                            <i class="fas fa-briefcase fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Total Jobs</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total_jobs'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-success-subtle p-3 rounded-3 text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Active Jobs</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['active_jobs'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-info-subtle p-3 rounded-3 text-info">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Applications</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total_applications'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-warning-subtle p-3 rounded-3 text-warning">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Pending Review</h6>
                            <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_applications'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white py-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0" style="color: #333;">Recent Applications</h5>
                    <a href="{{ route('employer.applications.index') }}" class="text-primary fw-bold text-decoration-none small">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Applicant</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentApplications as $application)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $application->user->name }}</div>
                                </td>
                                <td>{{ $application->job->title }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary px-3 py-2">
                                        {{ strtoupper($application->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('employer.applications.show', $application->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Review</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No recent applications found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection