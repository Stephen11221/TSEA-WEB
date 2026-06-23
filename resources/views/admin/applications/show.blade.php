@extends('admin.layouts.admin')

@section('title', 'Application Details - TSEA Admin')

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
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div>
            <a href="{{ route('admin.applications.index') }}" style="color: var(--color-primary); text-decoration: none; font-size: 14px;">
                <i class="fas fa-arrow-left"></i> Back to Applications
            </a>
            <h1 class="page-title" style="margin-top: 12px;">Application Details</h1>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Main Content -->
    <div>
        <!-- Student Information -->
        <div class="card" style="margin-bottom: 24px;">
            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Student Information</h3>
            </div>
            <div style="padding: 20px;">
                <div style="display: grid; gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 4px;">Name</label>
                        <div style="font-size: 15px;">{{ $application->user->name }}</div>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 4px;">Email</label>
                        <div>
                            <a href="mailto:{{ $application->user->email }}" style="color: var(--color-primary); text-decoration: none;">
                                {{ $application->user->email }}
                            </a>
                        </div>
                    </div>
                    @if($application->user->phone)
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 4px;">Phone</label>
                        <div>{{ $application->user->phone }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Job Information -->
        <div class="card" style="margin-bottom: 24px;">
            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Job Position</h3>
            </div>
            <div style="padding: 20px;">
                @if($application->job)
                <div style="display: grid; gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 4px;">Job Title</label>
                        <div style="font-size: 15px; font-weight: 600;">{{ $application->job->title }}</div>
                    </div>
                    @if($application->job->employer)
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 4px;">Company</label>
                        <div style="font-size: 15px;">{{ $application->job->employer->name }}</div>
                    </div>
                    @endif
                    @if($application->job->description)
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 4px;">Description</label>
                        <div style="font-size: 14px; line-height: 1.6; color: #333;">
                            {!! nl2br(e(Str::limit($application->job->description, 500))) !!}
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div style="color: #999; font-style: italic;">Job posting is no longer available</div>
                @endif
            </div>
        </div>

        <!-- Application Details -->
        <div class="card" style="margin-bottom: 24px;">
            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Application Details</h3>
            </div>
            <div style="padding: 20px;">
                <div style="display: grid; gap: 16px;">
                    @if($application->cover_letter)
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 8px;">Cover Letter</label>
                        <div style="background: #f9fafb; padding: 12px; border-radius: 6px; font-size: 14px; line-height: 1.6; color: #333;">
                            {!! nl2br(e($application->cover_letter)) !!}
                        </div>
                    </div>
                    @endif

                    @if($application->resume_path)
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 8px;">Resume</label>
                        <a href="{{ route('admin.applications.downloadResume', $application) }}" class="btn-primary">
                            <i class="fas fa-download"></i> Download Resume
                        </a>
                    </div>
                    @endif

                    @if($application->notes)
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 13px; color: #666; margin-bottom: 8px;">Notes</label>
                        <div style="background: #f9fafb; padding: 12px; border-radius: 6px; font-size: 14px; line-height: 1.6; color: #333;">
                            {!! nl2br(e($application->notes)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Status Card -->
        <div class="card" style="margin-bottom: 24px;">
            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0; font-size: 16px; font-weight: 600;">Status</h3>
            </div>
            <div style="padding: 20px;">
                <form method="POST" action="{{ route('admin.applications.updateStatus', $application) }}">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 16px;">
                        @php
                            $statusClass = [
                                'pending' => 'badge-warning',
                                'approved' => 'badge-success',
                                'rejected' => 'badge-danger'
                            ][$application->status] ?? 'badge-secondary';
                        @endphp
                        <span class="badge {{ $statusClass }}" style="display: inline-block; padding: 8px 16px;">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label for="status" style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 8px;">Update Status</label>
                        <select name="status" id="status" required style="width: 100%; padding: 8px; border: 1px solid #e5e7eb; border-radius: 6px;">
                            <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $application->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%;">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Metadata -->
        <div class="card">
            <div style="padding: 20px;">
                <div style="display: grid; gap: 16px; font-size: 13px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #666; margin-bottom: 4px;">Submitted</label>
                        <div>{{ optional($application->submitted_at)->format('M d, Y · h:i A') ?? 'N/A' }}</div>
                    </div>
                    
                    @if($application->reviewed_at)
                    <div>
                        <label style="display: block; font-weight: 600; color: #666; margin-bottom: 4px;">Reviewed</label>
                        <div>{{ $application->reviewed_at->format('M d, Y · h:i A') }}</div>
                    </div>
                    @endif

                    @if($application->rejection_reason)
                    <div>
                        <label style="display: block; font-weight: 600; color: #666; margin-bottom: 4px;">Rejection Reason</label>
                        <div>{{ $application->rejection_reason }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-title {
        font-size: 24px;
        font-weight: 700;
    }
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .badge {
        border-radius: 20px;
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
    .btn-primary {
        background: var(--color-primary);
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary:hover {
        background: #0052a3;
    }
</style>

@endsection
