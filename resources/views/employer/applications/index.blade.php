@extends('admin.layouts.employer')

@section('title', 'Candidate Applications - TSEA')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold h3 mb-1" style="color: #1e40af;">Candidate Applications</h1>
            <p class="text-muted small">Review and manage candidates who applied for your positions.</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Total Received</div>
                    <h2 class="stat-value">{{ $applications->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Pending Review</div>
                    <h2 class="stat-value text-warning">{{ $applications->where('status', 'pending')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Shortlisted</div>
                    <h2 class="stat-value text-primary">{{ $applications->where('status', 'shortlisted')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body p-4">
                    <div class="stat-label">Hired</div>
                    <h2 class="stat-value text-success">{{ $applications->where('status', 'accepted')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm main-table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Candidate</th>
                        <th>Applied For</th>
                        <th>Date Applied</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $application->user->avatar ? asset('storage/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&background=eff6ff&color=1e40af' }}" 
                                     class="rounded-circle me-3" width="40" height="40" alt="">
                                <div>
                                    <div class="fw-bold text-dark">{{ $application->user->name }}</div>
                                    <div class="small text-muted">{{ $application->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{{ $application->job->title }}</div>
                            <div class="small text-muted">{{ $application->job->location }}</div>
                        </td>
                        <td>
                            <div class="text-dark">{{ $application->created_at->format('M d, Y') }}</div>
                            <div class="small text-muted">{{ $application->created_at->diffForHumans() }}</div>
                        </td>
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
                            <a href="{{ route('employer.applications.show', $application->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                View Profile
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="mb-3">
                                <i class="fas fa-user-friends fa-3x opacity-25"></i>
                            </div>
                            <h5>No applications received yet</h5>
                            <p>Once candidates apply for your jobs, they will appear here.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
@endsection