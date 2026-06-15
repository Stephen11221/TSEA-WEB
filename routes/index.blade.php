@extends('layouts.app')

@section('title', 'All Applications - Admin Dashboard')

@section('content')
<div class="container-fluid py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold" style="color: #0047AB;">Global Job Applications</h1>
            <p class="text-muted">Monitor and track all student applications across the platform.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary"><i class="fas fa-download me-2"></i>Export Report</button>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold" style="color: #333;">Recent Submissions</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" class="form-control" placeholder="Search applications...">
                        <span class="input-group-text bg-primary text-white border-primary"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8f9fa; color: #0047AB;">
                    <tr>
                        <th class="ps-4">Applicant</th>
                        <th>Opportunity</th>
                        <th>Employer</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $application->user->avatar ? asset('storage/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&background=E0E0E0&color=0047AB' }}" 
                                     class="rounded-circle me-3" width="40" height="40" alt="">
                                <div>
                                    <div class="fw-bold">{{ $application->user->name }}</div>
                                    <small class="text-muted">ID: {{ $application->user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $application->job->title }}</div>
                            <small class="badge bg-light text-primary border">{{ $application->job->category }}</small>
                        </td>
                        <td>{{ $application->job->employer->company_name ?? 'N/A' }}</td>
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
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-pill border shadow-sm" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v px-1"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item" href="{{ route('admin.users.show', $application->user->id) }}"><i class="fas fa-user me-2 text-primary"></i>View Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-briefcase me-2 text-primary"></i>Job Details</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Remove Record</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-25"></i>
                            No applications found in the database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
        <div class="card-footer bg-white py-3 border-0">
            {{ $applications->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .table thead th { font-size: 0.85rem; letter-spacing: 0.5px; text-transform: uppercase; font-weight: 700; }
    .badge { font-weight: 600; font-size: 0.75rem; letter-spacing: 0.3px; }
</style>
@endsection