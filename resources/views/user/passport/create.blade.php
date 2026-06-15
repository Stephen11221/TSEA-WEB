@extends('layouts.app')

@section('title', 'Create Passport - TSEA')
@section('description', 'Create your workforce passport')

@section('content')
<section class="section">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="card shadow-lg border-0" style="border-radius: 24px; overflow: hidden; background: #ffffff;">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h1 class="fw-bold" style="color: #0047AB;">Create Your Workforce Passport</h1>
                            <p class="text-muted">Fill in your details to generate your digital professional identity.</p>
                        </div>
                    <form action="{{ route('user.passport.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <!-- Left side: Form fields -->
                            <div class="col-lg-7">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Profile Picture</label>
                                    <input type="file" name="avatar" class="form-control" accept="image/*">
                                    <small class="text-muted">Recommended: Square image, max 2MB.</small>
                                </div>
                                <div class="mb-4">
                                    <label for="skills" class="form-label fw-bold">Skills</label>
                                    <textarea id="skills" name="skills" class="form-control" rows="3" placeholder="e.g. Graphic Design, Project Management, PHP (separated by commas)" required>{{ old('skills') }}</textarea>
                                    @error('skills') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="experience" class="form-label fw-bold">Experience</label>
                                    <textarea id="experience" name="experience" class="form-control" rows="4" placeholder="Describe your work history..." required>{{ old('experience') }}</textarea>
                                    @error('experience') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="education" class="form-label fw-bold">Education</label>
                                    <textarea id="education" name="education" class="form-control" rows="3" placeholder="List your academic background..." required>{{ old('education') }}</textarea>
                                    @error('education') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-primary px-4 py-2">Create Passport</button>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary px-4 py-2">Cancel</a>
                                </div>
                            </div>

                            <!-- Right side: Aesthetic Preview -->
                            <div class="col-lg-5 d-none d-lg-block">
                                <div class="passport-id-card mx-auto" style="transform: scale(0.85); transform-origin: top center;">
                                    <div class="accent-top"></div>
                                    <div class="accent-top-poly"></div>
                                    <div class="card-inner">
                                        <div class="card-header text-center mt-4">
                                            <div class="logo-wrapper"><i class="fas fa-graduation-cap"></i></div>
                                            <h2 class="org-name">TSEA ACADEMY</h2>
                                            <span class="org-subtitle">WORKFORCE INFRASTRUCTURE</span>
                                        </div>
                                        <div class="profile-section text-center">
                                            <div class="profile-circle">
                                                <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=E0E0E0&color=0066CC&size=200' }}" alt="Profile Photo">
                                            </div>
                                        </div>
                                        <div class="name-banner">
                                            <h3 class="full-name">{{ strtoupper(auth()->user()->name) }}</h3>
                                        </div>
                                        <div class="info-section text-center">
                                            <div class="divider"></div>
                                            <p class="job-title">PREVIEW MODE</p>
                                        </div>
                                        <div class="barcode-footer">
                                            <div class="qr-code-wrapper text-center mb-3">
                                                {{-- Assuming 'user.profile' is a named route for the user's profile page. Adjust the route as necessary. --}}
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('user.profile', auth()->user()->id)) }}" alt="QR Code" class="qr-code-image">
                                            </div>
                                            <div class="barcode-wrapper">
                                                <div class="barcode-lines"></div>
                                                <span class="id-number">GEN-ID-XXXX</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accent-bottom"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<style>
    .passport-id-card {
        width: 350px;
        height: 550px;
        background: #ffffff;
        border-radius: 20px;
        position: relative; /* Keep relative for absolute positioning of accents */
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid #f0f0f0;
        background: #ffffff;
    }

    .accent-top {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 120px;
        background: #0047AB; /* Royal blue */
        clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%); /* Futuristic geometric shape */
        z-index: 1;
    }

    .accent-top-poly {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 120px; /* Slightly taller */
        background: rgba(255, 255, 255, 0.2); /* Lighter overlay */
        clip-path: polygon(0 0, 100% 0, 100% 50%, 0 80%); /* Another geometric shape for depth */
        z-index: 2;
    }

    .card-inner {
        position: relative;
        z-index: 10;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .logo-wrapper { font-size: 3rem; color: white; margin-bottom: 8px; } /* Larger logo */
    .org-name { font-size: 1.6rem; font-weight: 800; color: white; margin: 0; letter-spacing: 3px; } /* Larger, more corporate */
    .org-subtitle { font-size: 0.7rem; color: rgba(255,255,255,0.8); font-weight: 600; letter-spacing: 1.5px; }

    .profile-section { margin-top: 40px; } /* Adjusted margin */
    .profile-circle {
        width: 180px; /* Larger photo */
        height: 180px; /* Larger photo */
        margin: 0 auto;
        border-radius: 50%;
        border: 8px solid #0047AB; /* Bolder royal-blue border */
        padding: 5px; /* Adjusted padding */
        background: white;
    }
    .profile-circle img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }

    .name-banner {
        background: #0047AB;
        margin-top: 35px; /* Adjusted margin */
        padding: 15px 10px; /* Adjusted padding */
    }
    .full-name { color: white; font-size: 1.5rem; font-weight: 800; margin: 0; letter-spacing: 2px; } /* Larger text, more spacing */

    .divider { width: 50px; height: 4px; background: #0047AB; margin: 15px auto 10px; border-radius: 2px; } /* Thicker and wider divider */
    .job-title { color: #0047AB; font-weight: 800; font-size: 1rem; margin-bottom: 0; letter-spacing: 1.2px; } /* Bolder, slightly larger */

    .barcode-footer { margin-top: auto; padding-bottom: 30px; text-align: center; } /* Adjusted padding */
    .barcode-lines {
        width: 200px; /* Wider barcode */
        height: 50px; /* Taller barcode */
        margin: 0 auto 5px;
        background: repeating-linear-gradient(90deg, #333, #333 3px, transparent 3px, transparent 6px); /* Adjusted line thickness and spacing */
        opacity: 0.9; /* Slightly less opaque */
    }
    .id-number { font-family: 'Courier New', Courier, monospace; font-size: 1rem; font-weight: 800; color: #333; } /* Larger, bolder, darker color */
    .qr-code-image {
        display: block; /* Ensures the image can be centered with margin auto */
        margin: 0 auto; /* Centers the QR code image */
    }

    .accent-bottom {
        position: absolute;
        bottom: 0; right: 0; width: 100%; height: 80px; /* Taller accent */
        background: #0047AB; /* Royal blue */
        clip-path: polygon(0 0, 100% 30%, 100% 100%, 0 100%); /* Geometric shape, mirrored from top or new one */
        z-index: 1;
    }
</style>
@endsection
