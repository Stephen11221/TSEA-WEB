@extends('admin.layouts.admin')

@section('title', 'Job Postings Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Job Postings</h1>
        <p class="page-subtitle">Manage all active and closed job listings across the platform.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Job
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background-color: rgba(0, 179, 89, 0.1); color: var(--color-secondary); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--color-secondary);">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Employer</th>
                <th>Location</th>
                <th>Type</th>
                <th>Status</th>
                <th>Posted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs ?? [] as $job)
                <tr>
                    <td>
                        <strong>{{ $job->title }}</strong>
                    </td>
                    <td>{{ $job->employer->name ?? 'Unknown' }}</td>
                    <td>{{ $job->location }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($job->job_type) }}</span></td>
                    <td>
                        <span class="badge {{ $job->status === 'open' ? 'badge-success' : ($job->status === 'closed' ? 'badge-danger' : 'badge-warning') }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </td>
                    <td>{{ $job->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this job posting?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px; background-color: #dc3545; border-color: #dc3545; color: white;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--color-text-muted);">No job postings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 20px;">
        @if(isset($jobs))
            {{ $jobs->links() }}
        @endif
    </div>
</div>
@endsection