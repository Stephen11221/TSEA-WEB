@extends('admin.layouts.admin')

@section('title', 'Job Applications - TSEA Admin')

@section('content')

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 16px;">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 16px;">
        <ul style="margin: 0; padding-left: 18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="page-header">
    <div>
        <h1 class="page-title">Job Applications</h1>
        <p class="page-subtitle">Review and manage all student job applications across the platform.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
    <div class="kpi-card">
        <div class="kpi-value">{{ $applications->total() }}</div>
        <div class="kpi-label">Total Applications</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-value" style="color: #fbbf24;">{{ $applications->where('status', 'pending')->count() }}</div>
        <div class="kpi-label">Pending Review</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-value" style="color: #34d399;">{{ $applications->where('status', 'approved')->count() }}</div>
        <div class="kpi-label">Approved</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-value" style="color: #f87171;">{{ $applications->where('status', 'rejected')->count() }}</div>
        <div class="kpi-label">Rejected</div>
    </div>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
    <div style="margin-bottom: 20px;">
        <input type="text" id="searchApplications" placeholder="Search by student name, job title, email..." 
               style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
    </div>

    <div class="table-responsive">
        <table class="data-table" id="applicationsTable">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $application->user->name }}</div>
                    </td>
                    <td>
                        <small style="color: #666;">{{ $application->user->email }}</small>
                    </td>
                    <td>
                        @if($application->job)
                            {{ $application->job->title }}
                        @else
                            <span style="color: #ccc;">N/A</span>
                        @endif
                    </td>
                    <td>
                        @if($application->job && $application->job->employer)
                            {{ $application->job->employer->name ?? 'Unknown' }}
                        @else
                            <span style="color: #ccc;">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'pending' => 'badge-warning',
                                'approved' => 'badge-success',
                                'rejected' => 'badge-danger'
                            ][$application->status] ?? 'badge-secondary';
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($application->status) }}</span>
                    </td>
                    <td>
                        <small>{{ optional($application->submitted_at)->format('M d, Y') ?? 'N/A' }}</small>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.applications.show', $application) }}" class="btn-icon" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        No applications found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $applications->links() }}
    </div>
</div>

<style>
    .page-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .page-subtitle {
        color: #666;
        font-size: 14px;
    }
    .kpi-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-left: 4px solid var(--color-primary);
    }
    .kpi-value {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .kpi-label {
        font-size: 13px;
        color: #666;
    }
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .table-responsive {
        overflow-x: auto;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background: #f9fafb;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 1px solid #e5e7eb;
    }
    .data-table td {
        padding: 15px;
        border-bottom: 1px solid #e5e7eb;
    }
    .data-table tbody tr:hover {
        background: #f9fafb;
    }
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    .badge-warning {
        background: #fef3c7;
        color: #b45309;
    }
    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    .badge-secondary {
        background: #e5e7eb;
        color: #374151;
    }
    .btn-icon {
        background: none;
        border: 1px solid var(--color-border);
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        color: var(--color-primary);
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-icon:hover {
        background: var(--color-primary);
        color: white;
    }
</style>

<script>
document.getElementById('searchApplications').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#applicationsTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>

@endsection
