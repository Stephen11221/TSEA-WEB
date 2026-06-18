@extends('layouts.app')

@section('title', 'Student Enrollment - ' . $program->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Progress Tracker -->
            <div class="enrollment-tracker mb-5 px-4">
                <div class="d-flex justify-content-between position-relative">
                    <div class="tracker-line" style="position: absolute; top: 20px; left: 0; right: 0; height: 2px; background: #e2e8f0; z-index: 1;"></div>
                    <div class="tracker-step active" data-step="1" style="position: relative; z-index: 2; text-align: center; width: 120px;">
                        <div class="step-icon">1</div>
                        <span class="d-block small fw-bold mt-2">Selected Program</span>
                    </div>
                    <div class="tracker-step" data-step="2" style="position: relative; z-index: 2; text-align: center; width: 120px;">
                        <div class="step-icon">2</div>
                        <span class="d-block small mt-2">Your Details</span>
                    </div>
                    <div class="tracker-step" data-step="3" style="position: relative; z-index: 2; text-align: center; width: 120px;">
                        <div class="step-icon">3</div>
                        <span class="d-block small mt-2">Payment</span>
                    </div>
                    <div class="tracker-step" data-step="4" style="position: relative; z-index: 2; text-align: center; width: 120px;">
                        <div class="step-icon">4</div>
                        <span class="d-block small mt-2">Confirmation</span>
                    </div>
                </div>
            </div>

            <!-- Step Contents -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <!-- Step 1: Selected Program -->
                    <div class="enrollment-step-content" id="step-1-content">
                        <h2 class="fw-bold mb-4" style="color: #001F5B;">Step 1: Selected Program</h2>
                        <div class="p-4 bg-light rounded-3 mb-4" style="border-left: 5px solid #0B1D33;">
                            <h4 class="fw-bold">{{ $program->title }}</h4>
                            <p class="text-dark mb-0" style="line-height: 1.6;">{{ $program->description }}</p>
                        </div>
                        <button class="btn btn-primary px-5 rounded-pill fw-bold next-step" data-next="2">Continue to Step 2</button>
                    </div>

                    <!-- Step 2: Your Details -->
                    <div class="enrollment-step-content d-none" id="step-2-content">
                        <h2 class="fw-bold mb-4" style="color: #0B1D33;">Step 2: Your Details</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Motivation / Comments</label>
                                <textarea class="form-control" rows="4" placeholder="Briefly describe why you want to enroll in this program..."></textarea>
                            </div>
                        </div>
                        <div class="mt-5 d-flex gap-2">
                            <button class="btn btn-light rounded-pill px-4 prev-step" data-prev="1">Back</button>
                            <button class="btn btn-primary rounded-pill px-5 fw-bold next-step" data-next="3">Proceed to Payment</button>
                        </div>
                    </div>

                    <!-- Step 3: Payment -->
                    <div class="enrollment-step-content d-none" id="step-3-content">
                        <h2 class="fw-bold mb-4" style="color: #0B1D33;">Step 3: Payment</h2>
                        <div class="p-5 text-center bg-light rounded-4 mb-4">
                            <i class="fas fa-credit-card fa-3x mb-3 text-muted"></i>
                            <p class="mb-0">Secure payment processing for <strong>{{ $program->title }}</strong></p>
                            <p class="small text-muted">A payment gateway interface would be integrated here.</p>
                        </div>
                        <div class="mt-5 d-flex gap-2">
                            <button class="btn btn-light rounded-pill px-4 prev-step" data-prev="2">Back</button>
                            <button class="btn btn-primary rounded-pill px-5 fw-bold next-step" data-next="4">Complete Enrollment</button>
                        </div>
                    </div>

                    <!-- Step 4: Confirmation -->
                    <div class="enrollment-step-content d-none" id="step-4-content">
                        <div class="text-center py-4">
                            <div class="mb-4 d-inline-block p-4 rounded-circle bg-success bg-opacity-10">
                                <i class="fas fa-check-circle fa-4x text-success"></i>
                            </div>
                            <h2 class="fw-bold mb-3" style="color: #0B1D33;">Enrollment Confirmed!</h2>
                            <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">Congratulations! You are now enrolled in <strong>{{ $program->title }}</strong>. Our team will contact you shortly with the next steps.</p>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary rounded-pill px-5 fw-bold">Go to My Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-weight: bold;
        color: #64748b;
        transition: all 0.3s ease;
    }
    .tracker-step.active .step-icon {
        background: #0B1D33; /* Primary Corporate Navy */
        border-color: #0B1D33; /* Primary Corporate Navy */
        color: #fff;
    }
    .tracker-step.active span {
        color: #001F5B !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');

    function updateTracker(step) {
        document.querySelectorAll('.tracker-step').forEach(el => {
            const s = parseInt(el.dataset.step);
            if (s <= step) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');
            }
        });
        document.querySelectorAll('.enrollment-step-content').forEach(el => el.classList.add('d-none'));
        document.getElementById(`step-${step}-content`).classList.remove('d-none');
    }

    nextBtns.forEach(btn => btn.addEventListener('click', () => updateTracker(parseInt(btn.dataset.next))));
    prevBtns.forEach(btn => btn.addEventListener('click', () => updateTracker(parseInt(btn.dataset.prev))));
});
</script>
@endsection
