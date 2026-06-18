@extends('admin.layouts.employer')

@section('title', 'Student Application - ' . $application->user->name)

@section('content')
<div class="mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('employer.applications.index') }}" class="btn btn-light rounded-circle me-3">
            <i class="fas fa-arrow-left" style="color: #001F5B;"></i>
        </a>
        <div>
            <h1 class="fw-bold h3 mb-1" style="color: #0B1D33;">Student Profile</h1>
            <p class="text-muted small">Reviewing application for <strong>{{ $application->job->title }}</strong></p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sidebar: Applicant Identity -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4 stat-card">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <img src="{{ $application->user->avatar ? asset('storage/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&background=FFFFFF&color=0B1D33' }}" 
                         class="rounded-circle border border-4" style="width: 120px; border-color: #0B1D33 !important;">
                </div>
                <h4 class="fw-bold mb-0 text-dark">{{ $application->user->name }}</h4>
                <p class="text-muted small mb-3">{{ $application->user->email }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
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
                </div>
                
                <hr class="my-4 opacity-50">
                
                <div class="d-grid gap-2">
                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($application->resume_path) }}" target="_blank" class="btn btn-primary rounded-pill py-2">
                        <i class="fas fa-file-pdf me-2"></i>View Resume (CV)
                    </a>
                    <button type="button" class="btn btn-outline-primary rounded-pill py-2" data-bs-toggle="modal" data-bs-target="#passportModal">
                        <i class="fas fa-id-card me-2"></i>Workforce Passport
                    </button>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm stat-card">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold" style="color: #0B1D33;">Status Management</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('employer.applications.updateStatus', $application->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Update Application Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlist Student</option>
                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accept / Hire</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Reject Application</option>
                            <option value="closed" {{ $application->status == 'closed' ? 'selected' : '' }}>Close Application</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
                        Confirm Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content: Cover Letter & Passport Details -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4 main-table-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color: #0B1D33;">Cover Letter</h5>
                <div class="p-4 bg-light rounded-3 text-dark" style="white-space: pre-wrap; font-style: italic; line-height: 1.8; border-left: 4px solid #0B1D33;">
                    {{ $application->cover_letter ?? 'No cover letter provided.' }}
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm main-table-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4" style="color: #0B1D33;">Professional Summary</h5>
                @if($application->user->passport)
                    <div class="row g-4">
                        <div class="col-md-12">
                            <h6 class="fw-bold text-dark"><i class="fas fa-history me-2" style="color: #0B1D33;"></i>Work Experience</h6>
                            <p class="text-muted" style="line-height: 1.6;">{{ $application->user->passport->experience }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-bold text-dark"><i class="fas fa-graduation-cap me-2" style="color: #0B1D33;"></i>Educational Background</h6>
                            <p class="text-muted" style="line-height: 1.6;">{{ $application->user->passport->education }}</p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-bold text-dark"><i class="fas fa-tools me-2" style="color: #0B1D33;"></i>Top Skills</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $application->user->passport->skills ?? '') as $skill)
                                    @if(trim($skill))
                                        <span class="badge bg-light border px-3 py-2" style="color: #0B1D33;">{{ trim($skill) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-id-card-alt fa-3x text-light mb-3"></i>
                        <p class="text-muted">Applicant has not completed their workforce passport yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Passport Preview Modal (Aesthetic) -->
<div class="modal fade" id="passportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 d-flex justify-content-center">
                 <div class="passport-id-card" style="max-width: 400px; width: 100%;">
                    <div class="accent-top"></div>
                    <div class="card-inner bg-white rounded-4 overflow-hidden shadow-lg">
                        <div class="card-header text-center py-4" style="background: #FFFFFF;">
                            <div class="logo-wrapper mb-2" style="color: #0B1D33;"><i class="fas fa-graduation-cap fa-2x"></i></div>
                            <h2 class="h5 fw-bold mb-0" style="color: #0B1D33;">TSEA WORKFORCE</h2>
                        </div>
                        <div class="profile-section text-center py-4">
                            <div class="profile-circle mx-auto mb-3" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #FFFFFF; overflow: hidden;">
                                <img src="{{ $application->user->avatar ? asset('storage/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&background=FFFFFF&color=0B1D33' }}" class="w-100 h-100 object-fit-cover">
                            </div>
                        </div>
                        <div class="name-banner text-center py-3" style="background: #0B1D33;">
                            <h3 class="h5 fw-bold text-white mb-0 text-uppercase">{{ $application->user->name }}</h3>
                        </div>
                        <div class="info-section text-center p-4">
                             <p class="fw-bold mb-1 text-uppercase" style="color: #001F5B;">{{ $application->user->passport->skills ?? 'Verified Member' }}</p>
                             <small class="text-muted">Student ID: 
                                @php $id_num = $application->user->passport->passport_number ?? 'STU-' . str_pad($application->user->id, 6, '0', STR_PAD_LEFT); @endphp
                                {{ $id_num }}
                             </small>
                        </div>
                    </div>
                    <div class="accent-bottom"></div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection