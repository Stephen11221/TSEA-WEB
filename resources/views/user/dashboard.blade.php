@extends('layouts.app')

@section('title', 'User Dashboard - TSEA')

@section('content')
<style>
    /* Reusing some admin styles for consistency */
    :root {
        --color-primary: #0066CC;
        --color-secondary: #00B359;
        --color-accent: #FF6B35;
        --color-dark: #1a1a1a;
        --color-light: #F8F9FA;
        --color-border: #E0E0E0;
        --color-text: #333333;
        --color-text-muted: #666666;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--color-text);
    }
    .page-subtitle {
        font-size: 14px;
        color: var(--color-text-muted);
        margin-top: 5px;
    }
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .kpi-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .kpi-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }
    .kpi-icon.primary { background-color: rgba(0,102,204,0.1); color: var(--color-primary); }
    .kpi-icon.success { background-color: rgba(0,179,89,0.1); color: var(--color-secondary); }
    .kpi-icon.warning { background-color: rgba(255,107,53,0.1); color: var(--color-accent); }
    .kpi-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--color-text);
        margin-bottom: 5px;
    }
    .kpi-label {
        font-size: 14px;
        color: var(--color-text-muted);
    }
    .card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .list-group {
        list-style: none;
        padding: 0;
    }
    .list-group-item {
        padding: 10px 0;
        border-bottom: 1px solid var(--color-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-pending { background-color: rgba(255,107,53,0.2); color: var(--color-accent); }
    .badge-approved { background-color: rgba(0,179,89,0.2); color: var(--color-secondary); }
    .badge-rejected { background-color: rgba(102,102,102,0.2); color: var(--color-text-muted); }

    .enrollment-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(3, 17, 36, 0.65);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .enrollment-modal-backdrop.is-open {
        display: flex;
    }

    .enrollment-modal {
        width: min(100%, 560px);
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 30px 60px rgba(0,0,0,0.22);
        border: 1px solid #d9e1ea;
    }

    .enrollment-modal-header {
        background: linear-gradient(135deg, #06182e 0%, #0b2e5a 100%);
        color: #ffffff;
        padding: 22px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .enrollment-modal-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
    }

    .enrollment-close {
        border: 0;
        background: rgba(255,255,255,0.16);
        color: #ffffff;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        cursor: pointer;
    }

    .enrollment-modal-body {
        padding: 24px;
    }

    .enrollment-account-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0, 102, 204, 0.1);
        color: var(--color-primary);
        border: 1px solid rgba(0, 102, 204, 0.2);
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .enrollment-cta-row {
        margin-top: 18px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .enrollment-cta-row .btn {
        min-width: 170px;
        justify-content: center;
    }
</style>

<div class="container py-5">
    <div class="page-header">
        <div>
            <h1 class="page-title">Welcome, {{ $user->name }}!</h1>
            <p class="page-subtitle">Your personalized dashboard for TSEA opportunities.</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('user.opportunities.search') }}" class="btn btn-primary">
                <i class="fas fa-search"></i> Find Opportunities
            </a>
            <a href="{{ route('user.learning.feed') }}" class="btn btn-secondary">
                <i class="fas fa-book-open"></i> Learning Feed
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: rgba(0, 179, 89, 0.1); color: var(--color-secondary); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--color-secondary);">
            {{ session('success') }}
        </div>
    @endif

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon primary"><i class="fas fa-id-card"></i></div>
            <div class="kpi-value">{{ $passports ? 'Active' : 'N/A' }}</div>
            <div class="kpi-label">Workforce Passport</div>
            <a href="{{ $passports ? route('user.passports') : route('user.passport.create') }}" class="text-link" style="font-size: 12px; margin-top: 10px; display: block;">
                {{ $passports ? 'View Passport' : 'Create Passport' }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon success"><i class="fas fa-file-alt"></i></div>
            <div class="kpi-value">{{ $user->applications->count() }}</div>
            <div class="kpi-label">Total Applications</div>
            <a href="#" class="text-link" style="font-size: 12px; margin-top: 10px; display: block;">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon warning"><i class="fas fa-briefcase"></i></div>
            <div class="kpi-value">{{ \App\Models\JobPosting::where('status', 'open')->count() }}</div>
            <div class="kpi-label">Open Opportunities</div>
            <a href="{{ route('user.opportunities.search') }}" class="text-link" style="font-size: 12px; margin-top: 10px; display: block;">Browse Now <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="grid two" style="gap: 30px;">
        <div class="card">
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Recent Applications</h2>
            <ul class="list-group">
                @forelse($applications as $application)
                    <li class="list-group-item">
                        <div>
                            <strong>{{ $application->program->title ?? $application->jobPosting->title ?? 'N/A' }}</strong>
                            <p style="font-size: 12px; color: var(--color-text-muted); margin-top: 2px;">Submitted: {{ optional($application->submitted_at ?? $application->created_at)->format('M d, Y') }}</p>
                        </div>
                        <span class="badge badge-{{ $application->status }}">{{ ucfirst($application->status) }}</span>
                    </li>
                @empty
                    <li class="list-group-item" style="justify-content: center; color: var(--color-text-muted);">No recent applications.</li>
                @endforelse
            </ul>
        </div>
        <div class="card">
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Recommended Programs</h2>
            <ul class="list-group">
                @forelse($recommendedPrograms as $program)
                    <li class="list-group-item">
                        <div>
                            <strong>{{ $program->title }}</strong>
                            <p style="font-size: 12px; color: var(--color-text-muted); margin-top: 2px;">{{ Str::limit($program->description, 50) }}</p>
                        </div>
                        <a href="{{ route('programs') }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">View</a>
                    </li>
                @empty
                    <li class="list-group-item" style="justify-content: center; color: var(--color-text-muted);">No programs recommended at this time.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@if(session('show_enrollment_popup'))
    <div class="enrollment-modal-backdrop" id="enrollmentModal" role="dialog" aria-modal="true" aria-labelledby="enrollmentModalTitle">
        <div class="enrollment-modal">
            <div class="enrollment-modal-header">
                <h3 id="enrollmentModalTitle">Enrollment Ready</h3>
                <button class="enrollment-close" type="button" id="closeEnrollmentModal" aria-label="Close enrollment popup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="enrollment-modal-body">
                <span class="enrollment-account-pill">
                    <i class="fas fa-user-circle"></i>
                    Account: {{ session('enrollment_account_name', $user->name) }}
                </span>
                <p style="margin: 0; color: var(--color-text); font-size: 15px; line-height: 1.65;">
                    Your account is active. Continue to choose your program track and complete enrollment.
                </p>
                <div class="enrollment-cta-row">
                    <a href="{{ route('programs') }}" class="btn btn-primary">
                        <i class="fas fa-graduation-cap"></i> Start Enrollment
                    </a>
                    <button class="btn btn-secondary" type="button" id="dismissEnrollmentModal">
                        Maybe Later
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('enrollmentModal');
            const closeBtn = document.getElementById('closeEnrollmentModal');
            const dismissBtn = document.getElementById('dismissEnrollmentModal');

            if (!modal) {
                return;
            }

            requestAnimationFrame(() => {
                modal.classList.add('is-open');
            });

            function closeModal() {
                modal.classList.remove('is-open');
            }

            closeBtn?.addEventListener('click', closeModal);
            dismissBtn?.addEventListener('click', closeModal);

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        })();
    </script>
@endif
@endsection
