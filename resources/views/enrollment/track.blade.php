@extends('layouts.app')

@section('title', 'Enrollment Step ' . $currentStep . ' - ' . $program->title)

@section('content')
@php
    $completed = !empty($existingEnrollment) || session('enrollment_completed_program_id') === $program->id;

    $steps = [
        1 => ['title' => 'Create Account', 'icon' => 'fa-user-plus'],
        2 => ['title' => 'Complete Profile', 'icon' => 'fa-id-card'],
        3 => ['title' => 'Career Assessment', 'icon' => 'fa-compass'],
        4 => ['title' => 'Choose Program', 'icon' => 'fa-graduation-cap'],
        5 => ['title' => 'Enroll & Pay', 'icon' => 'fa-file-invoice-dollar'],
        6 => ['title' => 'Verify & Onboard', 'icon' => 'fa-shield-halved'],
        7 => ['title' => 'Start Learning', 'icon' => 'fa-rocket'],
    ];

    $stepUrl = fn ($step) => route('user.enrollment.step', ['id' => $program->id, 'step' => $step]);
@endphp

<section class="flow-wrap">
    <div class="flow-shell">
        @if(session('success'))
            <div class="flow-alert success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="flow-alert danger">Please check the form fields and try again.</div>
        @endif

        <header class="flow-header">
            <h1>Student Course Enrollment Process</h1>
            <p>
                <span class="c-blue">Simple.</span>
                <span class="c-green">Guided.</span>
                <span class="c-gold">Purposeful.</span>
            </p>
        </header>

        <div class="stepper">
            @foreach($steps as $number => $meta)
                <a href="{{ $stepUrl($number) }}" class="step-chip {{ $currentStep === $number ? 'active' : '' }} {{ $currentStep > $number ? 'done' : '' }}">
                    <span>{{ $number }}</span>
                    <i class="fas {{ $meta['icon'] }}"></i>
                    <strong>{{ $meta['title'] }}</strong>
                </a>
            @endforeach
        </div>

        <article class="step-card">
            @if($currentStep === 1)
                <h2>Step 1: Create Account</h2>
                <p>Your account is active and ready for enrollment.</p>
                <div class="info-box">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ auth()->user()->email }}</small>
                </div>
                <div class="actions">
                    <a class="btn primary" href="{{ $stepUrl(2) }}">Continue</a>
                </div>
            @endif

            @if($currentStep === 2)
                <h2>Step 2: Complete Profile</h2>
                <p>Review your profile details before proceeding.</p>
                <div class="info-grid">
                    <div><label>Name</label><strong>{{ auth()->user()->name }}</strong></div>
                    <div><label>Email</label><strong>{{ auth()->user()->email }}</strong></div>
                    <div><label>Phone</label><strong>{{ auth()->user()->phone ?: 'Not Provided' }}</strong></div>
                </div>
                <div class="actions">
                    <a class="btn ghost" href="{{ $stepUrl(1) }}">Back</a>
                    <a class="btn primary" href="{{ $stepUrl(3) }}">Continue</a>
                </div>
            @endif

            @if($currentStep === 3)
                <h2>Step 3: Career Assessment</h2>
                <p>Assessment status: Complete (sample score preview).</p>
                <div class="info-box">
                    <strong>Top strengths</strong>
                    <small>Problem Solving, Communication, Adaptability</small>
                </div>
                <div class="actions">
                    <a class="btn ghost" href="{{ $stepUrl(2) }}">Back</a>
                    <a class="btn primary" href="{{ $stepUrl(4) }}">Continue</a>
                </div>
            @endif

            @if($currentStep === 4)
                <h2>Step 4: Choose Program</h2>
                <p>You selected the following program track.</p>
                <div class="info-box">
                    <strong>{{ $program->title }}</strong>
                    <small>{{ $program->description }}</small>
                </div>
                <div class="actions">
                    <a class="btn ghost" href="{{ $stepUrl(3) }}">Back</a>
                    <a class="btn primary" href="{{ $stepUrl(5) }}">Continue</a>
                </div>
            @endif

            @if($currentStep === 5)
                <h2>Step 5: Enroll & Pay</h2>
                <p>Submit enrollment and confirm terms.</p>

                @if($completed)
                    <div class="info-box">
                        <strong>Already Enrolled</strong>
                        <small>Your enrollment has already been submitted for this program.</small>
                    </div>
                    <div class="actions">
                        <a class="btn primary" href="{{ $stepUrl(7) }}">Go to Final Step</a>
                    </div>
                @else
                    <form action="{{ route('user.enrollment.store', $program->id) }}" method="POST" enctype="multipart/form-data" class="form-stack">
                        @csrf
                        <label for="coverLetter">Motivation / Comments</label>
                        <textarea id="coverLetter" name="cover_letter" rows="4" placeholder="Tell us why you want to join this program...">{{ old('cover_letter') }}</textarea>

                        <label for="enrollmentFile">Upload Attachment (Optional)</label>
                        <input id="enrollmentFile" type="file" name="enrollment_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">

                        <label class="check-row">
                            <input type="checkbox" name="terms_accepted" value="1" required>
                            <span>I confirm my details are correct and I accept the program terms.</span>
                        </label>

                        <div class="actions">
                            <a class="btn ghost" href="{{ $stepUrl(4) }}">Back</a>
                            <button class="btn success" type="submit">Upload & Enroll Now</button>
                        </div>
                    </form>
                @endif
            @endif

            @if($currentStep === 6)
                <h2>Step 6: Verify & Onboard</h2>
                @if($completed)
                    <p>Enrollment confirmed. Verification and onboarding are complete.</p>
                    <ul class="list-check">
                        <li>Identity Verified</li>
                        <li>Email Verified</li>
                        <li>Enrollment Confirmed</li>
                    </ul>
                    <div class="actions">
                        <a class="btn primary" href="{{ $stepUrl(7) }}">Continue</a>
                    </div>
                @else
                    <p>Complete enrollment in Step 5 before verification.</p>
                    <div class="actions">
                        <a class="btn primary" href="{{ $stepUrl(5) }}">Go to Step 5</a>
                    </div>
                @endif
            @endif

            @if($currentStep === 7)
                <h2>Step 7: Start Learning</h2>
                @if($completed)
                    <p>You are all set. Access your dashboard and begin your learning journey.</p>
                @else
                    <p>Finish enrollment first to unlock your learning dashboard.</p>
                @endif
                <div class="actions">
                    @if($completed)
                        <a class="btn primary" href="{{ route('user.dashboard') }}">Go to Dashboard</a>
                    @else
                        <a class="btn primary" href="{{ $stepUrl(5) }}">Finish Enrollment</a>
                    @endif
                </div>
            @endif
        </article>
    </div>
</section>

<style>
    .flow-wrap {
        background: radial-gradient(circle at 20% 0%, #0c2f63 0, #06172e 38%, #031124 100%);
        color: #fff;
        padding: 24px 0 36px;
    }

    .flow-shell {
        width: min(100% - 24px, 1180px);
        margin: 0 auto;
    }

    .flow-alert {
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .flow-alert.success { background: rgba(0, 166, 81, .2); border: 1px solid rgba(0, 166, 81, .4); }
    .flow-alert.danger { background: rgba(220, 53, 69, .2); border: 1px solid rgba(220, 53, 69, .4); }

    .flow-header {
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 14px;
    }

    .flow-header h1 {
        margin: 0;
        font-size: clamp(1.2rem, 2.6vw, 2rem);
        font-weight: 900;
    }

    .flow-header p {
        margin: 6px 0 0;
        display: flex;
        gap: 10px;
        font-weight: 800;
    }

    .c-blue { color: #3d8bff; }
    .c-green { color: #18b663; }
    .c-gold { color: #ffc107; }

    .stepper {
        display: grid;
        grid-template-columns: repeat(7, minmax(110px, 1fr));
        gap: 8px;
        margin-bottom: 14px;
    }

    .step-chip {
        text-decoration: none;
        color: #d6e4ff;
        border: 1px solid rgba(255,255,255,.16);
        background: rgba(255,255,255,.03);
        border-radius: 10px;
        padding: 10px 8px;
        min-height: 110px;
        display: grid;
        justify-items: center;
        align-content: start;
        gap: 5px;
        transition: all .2s ease;
    }

    .step-chip span {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,.35);
        display: grid;
        place-items: center;
        font-weight: 900;
    }

    .step-chip strong {
        text-align: center;
        font-size: .75rem;
        line-height: 1.2;
    }

    .step-chip.active {
        border-color: #ffc107;
        background: rgba(255, 193, 7, .12);
        color: #fff;
    }

    .step-chip.done span,
    .step-chip.active span {
        background: #ffc107;
        color: #0b2342;
        border-color: #ffc107;
    }

    .step-card {
        background: #f8fbff;
        border-radius: 12px;
        padding: 18px;
        color: #102749;
        border: 1px solid #d2e0f3;
    }

    .step-card h2 {
        margin: 0 0 8px;
        font-size: 1.35rem;
        font-weight: 900;
    }

    .step-card p {
        margin: 0 0 12px;
        color: #2f4f7a;
    }

    .info-box {
        background: #eef4ff;
        border: 1px solid #cad9ef;
        border-radius: 8px;
        padding: 12px;
        display: grid;
        gap: 4px;
        margin-bottom: 12px;
    }

    .info-box small { color: #4f6f97; }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }

    .info-grid div {
        background: #eef4ff;
        border: 1px solid #cad9ef;
        border-radius: 8px;
        padding: 10px;
        display: grid;
        gap: 3px;
    }

    .info-grid label {
        font-size: .72rem;
        color: #4f6f97;
        text-transform: uppercase;
        font-weight: 700;
    }

    .form-stack {
        display: grid;
        gap: 8px;
    }

    .form-stack label {
        font-size: .8rem;
        color: #2f4f7a;
        font-weight: 700;
    }

    .form-stack textarea {
        width: 100%;
        border: 1px solid #cad9ef;
        border-radius: 8px;
        padding: 10px;
        resize: vertical;
    }

    .form-stack input[type="file"] {
        width: 100%;
        border: 1px solid #cad9ef;
        border-radius: 8px;
        padding: 8px;
        background: #fff;
        color: #2f4f7a;
    }

    .check-row {
        display: grid;
        grid-template-columns: 16px 1fr;
        gap: 8px;
        align-items: start;
        color: #2f4f7a;
        font-size: .82rem;
    }

    .list-check {
        margin: 0 0 12px;
        padding-left: 18px;
        color: #2f4f7a;
        line-height: 1.6;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn {
        border: 0;
        text-decoration: none;
        border-radius: 8px;
        min-height: 38px;
        padding: 10px 16px;
        font-weight: 800;
        font-size: .83rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn.primary { background: #1e5dd2; color: #fff; }
    .btn.success { background: #0ea846; color: #fff; }
    .btn.ghost { background: #e7eef9; color: #2f4f7a; }

    @media (max-width: 1024px) {
        .stepper {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .stepper {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>
@endsection
