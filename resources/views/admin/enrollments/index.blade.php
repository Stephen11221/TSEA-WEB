@extends('admin.layouts.admin')

@section('title', 'Student Enrollments')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Student Enrollments</h1>
        <p class="page-subtitle">View enrollments per program and track each student's enrollment status.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
            <i class="fas fa-tasks"></i> Manage Programs
        </a>
    </div>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-value">{{ $stats['total_enrollments'] }}</div>
        <div class="kpi-label">Total Program Enrollments</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-value">{{ $stats['unique_students'] }}</div>
        <div class="kpi-label">Unique Enrolled Students</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-value">{{ $stats['programs_with_enrollments'] }}</div>
        <div class="kpi-label">Programs With Enrollments</div>
    </div>
</div>

<div class="card" style="margin-bottom: 20px;">
    <h2 style="font-size: 18px; margin-bottom: 12px; color: var(--color-primary);">Programs</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
        <a href="{{ route('admin.enrollments.index') }}"
           class="enrollment-program-card {{ empty($selectedProgramId) ? 'is-active' : '' }}">
            <strong>All Programs</strong>
            <div style="font-size: 12px; color: var(--color-text-muted); margin-top: 4px;">View all student enrollments</div>
        </a>

        @foreach($programs as $program)
            <a href="{{ route('admin.enrollments.index', ['program_id' => $program->id]) }}"
               class="enrollment-program-card {{ (int) $selectedProgramId === (int) $program->id ? 'is-active' : '' }}">
                <strong>{{ $program->title }}</strong>
                <div style="font-size: 12px; color: var(--color-text-muted); margin-top: 4px;">
                    {{ (int) ($programCounts[$program->id] ?? 0) }} student{{ (int) ($programCounts[$program->id] ?? 0) === 1 ? '' : 's' }}
                </div>
            </a>
        @endforeach
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.enrollments.index') }}" method="GET" style="display: grid; grid-template-columns: 1fr 1fr 2fr auto; gap: 10px; margin-bottom: 18px;">
        <select name="program_id" style="padding: 10px; border-radius: 6px; border: 1px solid var(--color-border);">
            <option value="">All Programs</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}" @selected((string) $selectedProgramId === (string) $program->id)>{{ $program->title }}</option>
            @endforeach
        </select>

        <select name="status" style="padding: 10px; border-radius: 6px; border: 1px solid var(--color-border);">
            <option value="">All Statuses</option>
            <option value="pending" @selected($status === 'pending')>Pending</option>
            <option value="approved" @selected($status === 'approved')>Approved</option>
            <option value="rejected" @selected($status === 'rejected')>Rejected</option>
        </select>

        <input type="text" name="search" value="{{ $search }}" placeholder="Search student name or email..."
               style="padding: 10px; border-radius: 6px; border: 1px solid var(--color-border);">

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-filter"></i> Filter
        </button>
    </form>

    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Program</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $enrollment->user->name ?? 'Unknown Student' }}</div>
                            <div style="font-size: 12px; color: var(--color-text-muted);">{{ $enrollment->user->email ?? 'No email' }}</div>
                        </td>
                        <td>{{ $enrollment->program->title ?? 'N/A' }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'pending' => 'badge-warning',
                                    'approved' => 'badge-success',
                                    'rejected' => 'badge-danger',
                                ][$enrollment->status] ?? 'badge-info';
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($enrollment->status ?? 'unknown') }}</span>
                        </td>
                        <td>
                            {{ optional($enrollment->submitted_at ?? $enrollment->created_at)->format('M d, Y') }}
                        </td>
                        <td style="max-width: 280px; white-space: normal;">
                            {{ \Illuminate\Support\Str::limit($enrollment->cover_letter ?? 'No notes provided', 120) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--color-text-muted);">No enrollments found for the selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 14px;">
        {{ $enrollments->links() }}
    </div>
</div>

<style>
    .enrollment-program-card {
        display: block;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid var(--color-border);
        text-decoration: none;
        color: var(--color-text);
        background: white;
        transition: all 0.2s ease;
    }

    .enrollment-program-card:hover {
        transform: translateY(-1px);
    }

    .enrollment-program-card.is-active {
        background: rgba(197,160,89,0.14);
        border-color: rgba(197,160,89,0.45);
    }
</style>
@endsection
