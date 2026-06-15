@extends('layouts.app')

@section('title', 'My Workforce Passports')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold" style="color: var(--color-dark);">Workforce Passport</h1>
            <p class="text-muted">Your verified digital identity and readiness credentials.</p>
        </div>
        @if($passports)
            <button onclick="window.print()" class="btn btn-secondary shadow-sm">
                <i class="fas fa-print"></i> Download PDF
            </button>
        @endif
    </div>

    @if($passports)
        <div class="id-card-container">
            <!-- Modern Professional ID Card -->
            <div class="passport-id-card">
                <!-- Geometric Accents Top -->
                <div class="accent-top"></div>
                <div class="accent-top-poly"></div>
                
                <div class="card-inner">
                    <!-- Header -->
                    <div class="card-header text-center mt-4">
                        <div class="logo-wrapper">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h2 class="org-name">TSEA ACADEMY</h2>
                        <span class="org-subtitle">WORKFORCE INFRASTRUCTURE</span>
                    </div>

                    <!-- Profile Photo -->
                    <div class="profile-section text-center">
                        <div class="profile-circle">
                            <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=E0E0E0&color=0066CC&size=200' }}" alt="Profile Photo">
                        </div>
                    </div>

                    <!-- Name Banner -->
                    <div class="name-banner">
                        <h3 class="full-name">{{ strtoupper(auth()->user()->name) }}</h3>
                    </div>

                    <!-- Job Title / Status -->
                    <div class="info-section text-center">
                        <div class="divider"></div>
                        <p class="job-title">VERIFIED PROFESSIONAL</p>
                        <span class="badge {{ $passports->status === 'approved' ? 'badge-success' : 'badge-warning' }} mt-1">
                            {{ strtoupper($passports->status) }}
                        </span>
                    </div>

                    <!-- Barcode Section -->
                    <div class="barcode-footer">
                        <div class="barcode-wrapper">
                            <div class="barcode-lines"></div>
                            <span class="id-number">{{ $passports->passport_number }}</span>
                        </div>
                    </div>
                </div>

                <!-- Geometric Accents Bottom -->
                <div class="accent-bottom"></div>
            </div>
        </div>
    @else
        <div class="card text-center py-5 shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-body">
                <div class="mb-4">
                    <i class="fas fa-id-card fa-4x" style="color: var(--color-border);"></i>
                </div>
                <h3>No Passport Found</h3>
                <p class="text-muted">You haven't generated your workforce identity yet.</p>
                <a href="{{ route('user.passport.create') }}" class="btn btn-primary mt-3 px-4 py-2">
                    <i class="fas fa-plus"></i> Create Passport Now
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    .id-card-container {
        display: flex;
        justify-content: center;
        padding: 20px 0;
        perspective: 1000px;
    }

    .passport-id-card {
        width: 350px;
        height: 550px;
        background: #ffffff;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        border: 1px solid #f0f0f0;
        background-image: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
    }

    .accent-top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 120px;
        background: var(--color-primary);
        clip-path: polygon(0 0, 100% 0, 100% 40%, 0 85%);
        z-index: 1;
    }

    .accent-top-poly {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        clip-path: polygon(100% 0, 0% 100%, 100% 100%);
        z-index: 2;
    }

    .card-inner {
        position: relative;
        z-index: 10;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .logo-wrapper { font-size: 2.5rem; color: white; margin-bottom: 5px; }
    .org-name { font-size: 1.4rem; font-weight: 800; color: white; margin: 0; letter-spacing: 2px; }
    .org-subtitle { font-size: 0.65rem; color: rgba(255,255,255,0.8); font-weight: 600; letter-spacing: 1px; }

    .profile-section { margin-top: 35px; }
    .profile-circle {
        width: 160px;
        height: 160px;
        margin: 0 auto;
        border-radius: 50%;
        border: 6px solid #0047AB; /* Royal Blue Border */
        padding: 4px;
        background: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .profile-circle img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }

    .name-banner {
        background: #0047AB;
        margin-top: 30px;
        padding: 12px 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .full-name { color: white; font-size: 1.3rem; font-weight: 800; margin: 0; letter-spacing: 1px; }

    .divider { width: 40px; height: 3px; background: #0047AB; margin: 15px auto 10px; border-radius: 2px; }
    .job-title { color: #0047AB; font-weight: 700; font-size: 0.9rem; margin-bottom: 0; letter-spacing: 1px; }

    .barcode-footer { margin-top: auto; padding-bottom: 40px; text-align: center; }
    .barcode-lines {
        width: 180px;
        height: 40px;
        margin: 0 auto 5px;
        background: repeating-linear-gradient(90deg, #333, #333 2px, transparent 2px, transparent 5px);
        opacity: 0.8;
    }
    .id-number { font-family: 'Courier New', Courier, monospace; font-size: 0.9rem; font-weight: 700; color: #555; }

    .accent-bottom {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 60px;
        background: var(--color-primary);
        clip-path: polygon(100% 100%, 0 100%, 0 80%, 100% 20%);
        z-index: 1;
    }
</style>
@endsection