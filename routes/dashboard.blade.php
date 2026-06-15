@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold" style="color: #0047AB;">Employer Dashboard</h1>
            <p class="text-muted">Overview of your job postings and applications.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus-circle me-2"></i>Post New Job
            </a>
            <a href="{{ route('employer.applications.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-file-alt me-2"></i>View All Applications
            </a>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-primary-subtle text-primary me-3">
                            <i class="fas fa-briefcase fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Jobs Posted</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total_jobs'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-success-subtle text-success me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Active Job Postings</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['active_jobs'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-info-subtle text-info me-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Applications</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total_applications'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-square bg-warning-subtle text-warning me-3">
                            <i class="fas fa-hourglass-half fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending Applications</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['pending_applications'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold" style="color: #333;">Recent Applications</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('employer.applications.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">View All</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8f9fa; color: #0047AB;">
                    <tr>
                        <th class="ps-4">Applicant</th>
                        <th>Job Title</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentApplications as $application)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $application->user->avatar ? asset('storage/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&background=E0E0E0&color=0047AB' }}" 
                                     class="rounded-circle me-3" width="40" height="40" alt="">
                                <div>
                                    <div class="fw-bold">{{ $application->user->name }}</div>
                                    <small class="text-muted">{{ $application->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                        <td>
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-warning-subtle text-warning border-warning',
                                    'reviewed' => 'bg-info-subtle text-info border-info',
                                    'shortlisted' => 'bg-primary-subtle text-primary border-primary',
                                    'rejected' => 'bg-danger-subtle text-danger border-danger',
                                    'accepted' => 'bg-success-subtle text-success border-success',
                                ];
                                $class = $statusClasses[strtolower($application->status)] ?? 'bg-secondary-subtle text-secondary';
                            @endphp
                            <span class="badge border py-2 px-3 {{ $class }}">
                                {{ strtoupper($application->status) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('employer.applications.show', $application->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No recent applications.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .icon-square {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table thead th { font-size: 0.85rem; letter-spacing: 0.5px; text-transform: uppercase; font-weight: 700; }
    .badge { font-weight: 600; font-size: 0.75rem; letter-spacing: 0.3px; }
</style>
@endsection
