@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar: Applicant Identity -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <img src="{{ $application->user->avatar ? asset('storage/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name) }}" 
                             class="rounded-circle border border-4" style="width: 120px; border-color: #0047AB !important;">
                    </div>
                    <h4 class="fw-bold mb-0">{{ $application->user->name }}</h4>
                    <p class="text-muted small">{{ $application->user->email }}</p>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="btn btn-primary rounded-pill">
                            <i class="fas fa-file-pdf me-2"></i>View Resume (CV)
                        </a>
                        <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#passportModal">
                            <i class="fas fa-id-card me-2"></i>View Workforce Passport
                        </button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold" style="color: #0047AB;">Action Center</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('employer.applications.updateStatus', $application->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Update Application Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlist</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accept / Hire</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                <option value="closed" {{ $application->status == 'closed' ? 'selected' : '' }}>Close Application</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 rounded-pill">Update Status</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content: Cover Letter & Passport Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #0047AB;">Cover Letter</h5>
                    <div class="p-4 bg-light rounded-3" style="white-space: pre-wrap; font-style: italic;">
                        {{ $application->cover_letter ?? 'No cover letter provided.' }}
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #0047AB;">Passport Skills & Experience</h5>
                    @if($application->user->passport)
                        <div class="row g-4">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Experience</h6>
                                <p>{{ $application->user->passport->experience }}</p>
                            </div>
                            <div class="col-md-12">
                                <h6 class="fw-bold">Education</h6>
                                <p>{{ $application->user->passport->education }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">Applicant has not completed their workforce passport yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Passport Preview Modal (Aesthetic) -->
<div class="modal fade" id="passportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 d-flex justify-content-center">
                 <!-- Reusing your Passport Aesthetic here -->
                 <div class="passport-id-card">
                    <div class="accent-top"></div>
                    <div class="card-inner">
                        <div class="card-header text-center mt-4">
                            <div class="logo-wrapper text-white"><i class="fas fa-graduation-cap"></i></div>
                            <h2 class="org-name text-white">TSEA ACADEMY</h2>
                        </div>
                        <div class="profile-section text-center">
                            <div class="profile-circle">
                                <img src="{{ $application->user->avatar ? asset('storage/'.$application->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name) }}">
                            </div>
                        </div>
                        <div class="name-banner text-center py-2" style="background: #0047AB;">
                            <h3 class="full-name text-white mb-0">{{ strtoupper($application->user->name) }}</h3>
                        </div>
                        <div class="info-section text-center mt-3">
                             <p class="job-title fw-bold text-primary">{{ strtoupper($application->user->passport->skills ?? 'PROFESSIONAL') }}</p>
                        </div>
                    </div>
                    <div class="accent-bottom"></div>
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection