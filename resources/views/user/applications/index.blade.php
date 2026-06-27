@extends('layouts.app')

@section('title', 'My Applications - TSEA')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">My Applications</h1>
            <p class="text-muted mb-0">Track your program enrollments and job applications in one place.</p>
        </div>
        <a href="{{ route('programs') }}" class="btn btn-primary">Browse Programs</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Title</th>
                        <th scope="col">Company</th>
                        <th scope="col">Status</th>
                        <th scope="col">Submitted</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        @php
                            $isProgramEnrollment = !is_null($application->program_id);
                            $statusBadge = [
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                            ][$application->status] ?? 'secondary';
                        @endphp
                        <tr>
                            <td>
                                <span class="badge text-bg-{{ $isProgramEnrollment ? 'primary' : 'dark' }}">
                                    {{ $isProgramEnrollment ? 'Program Enrollment' : 'Job Application' }}
                                </span>
                            </td>
                            <td>
                                @if($isProgramEnrollment)
                                    {{ $application->program->title ?? 'Program removed' }}
                                @else
                                    {{ $application->job->title ?? 'Job removed' }}
                                @endif
                            </td>
                            <td>
                                @if($isProgramEnrollment)
                                    <span class="text-muted">TSEA</span>
                                @else
                                    {{ optional(optional($application->job)->employer)->name ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                <span class="badge text-bg-{{ $statusBadge }}">{{ ucfirst($application->status) }}</span>
                            </td>
                            <td>{{ optional($application->submitted_at ?? $application->created_at)->format('M d, Y') }}</td>
                            <td>
                                @if($isProgramEnrollment && $application->program_id)
                                    <a href="{{ route('user.enrollment.show', $application->program_id) }}" class="btn btn-sm btn-outline-primary">View Enrollment</a>
                                @elseif($application->job_posting_id)
                                    <a href="{{ route('user.opportunities.show', $application->job_posting_id) }}" class="btn btn-sm btn-outline-primary">View Job</a>
                                @else
                                    <span class="text-muted small">No action</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                You have not submitted any applications yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="p-3">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
