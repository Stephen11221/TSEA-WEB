@extends('layouts.app')
@section('title', 'For Employers & Partners - TSEA')

@section('content')
@php
    $employerPartners = \App\Models\User::where('role', 'employer')
        ->where('status', 'active')
        ->latest()
        ->take(8)
        ->get();

    $opportunities = \App\Models\JobPosting::where('status', 'open')->with('employer')->latest()->take(9)->get();
@endphp

<section class="emp-hero">
    <div class="container emp-hero-grid">
        <div class="emp-copy">
            <span class="emp-kicker">Employers & Partners</span>
            <h1>Access Africa's Verified Workforce</h1>
            <p>Connect with talent whose skills, identity, and readiness are independently verified through TSEA infrastructure.</p>
            <div class="emp-actions">
                <a href="{{ route('register.employer') }}" class="btn btn-gold">Join As Employer</a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">Request Demo</a>
            </div>
        </div>

        <aside class="card emp-panel">
            <h2>Talent Readiness Index</h2>
            @include('partials.charts', ['type' => 'bars', 'items' => [
                'Digital Skills' => 88,
                'Technical Proficiency' => 79,
                'Soft Skills' => 92,
                'Market Alignment' => 81
            ]])
        </aside>
    </div>
</section>

<section class="section emp-partners">
    <div class="container">
        <div class="emp-head">
            <span>Our Network</span>
            <h2>Verified Employer Partners</h2>
            <p>Join organizations already using workforce evidence to hire faster and reduce mismatch risk.</p>
        </div>

        <div class="emp-partner-grid">
            @forelse ($employerPartners as $partner)
                <article class="card emp-partner-card">
                    <span class="emp-partner-icon"><i class="fas fa-building"></i></span>
                    <h3>{{ $partner->name }}</h3>
                    <small>Verified Partner</small>
                </article>
            @empty
                @foreach (['Safcom Tech', 'Equity Hub', 'Kawi Energy', 'Kilimo Plus', 'Afya Systems'] as $mock)
                    <article class="card emp-partner-card muted">
                        <span class="emp-partner-icon"><i class="fas fa-building"></i></span>
                        <h3>{{ $mock }}</h3>
                        <small>Partner</small>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="emp-jobs-head">
            <div>
                <span class="eyebrow">Talent Discovery</span>
                <h2>Browse Verified Jobs</h2>
            </div>
            <a href="{{ route('register.employer') }}" class="text-link">Register to view full pipeline <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="grid three">
            @forelse ($opportunities as $opportunity)
                <article class="card emp-job-card">
                    <h3>{{ $opportunity->title }}</h3>
                    <p><strong>Employer:</strong> {{ $opportunity->employer->name }}</p>
                    <p><strong>Location:</strong> {{ $opportunity->location }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($opportunity->job_type) }}</p>
                    @if($opportunity->salary_min && $opportunity->salary_max)
                        <p><strong>Salary:</strong> ${{ number_format($opportunity->salary_min) }} - ${{ number_format($opportunity->salary_max) }}</p>
                    @endif
                    <p><strong>Deadline:</strong> {{ $opportunity->deadline ? \Carbon\Carbon::parse($opportunity->deadline)->format('M d, Y') : 'N/A' }}</p>
                    <p class="desc">{{ \Illuminate\Support\Str::limit($opportunity->description, 100) }}</p>
                    <a href="{{ auth()->check() ? route('user.opportunities.show', $opportunity->id) : route('login') }}" class="btn btn-primary">View Details</a>
                </article>
            @empty
                <article class="card emp-empty">
                    <h3>No open opportunities right now</h3>
                    <p>Register as an employer to publish jobs and start receiving verified applications.</p>
                    <a href="{{ route('register.employer') }}" class="btn btn-primary">Register Organization</a>
                </article>
            @endforelse
        </div>
    </div>
</section>

<section class="section emp-cta">
    <div class="container emp-cta-shell">
        <h2>Ready to Hire Better?</h2>
        <p>Move from guesswork to evidence-based hiring with verified readiness data.</p>
        <div class="emp-actions center">
            <a href="{{ route('register.employer') }}" class="btn btn-gold">Register Organization</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary">Contact Partnerships</a>
        </div>
    </div>
</section>

<style>
    .emp-hero {
        background:
            radial-gradient(circle at 18% 20%, rgba(229, 138, 0, .16), transparent 32%),
            radial-gradient(circle at 79% 18%, rgba(0, 141, 59, .14), transparent 30%),
            linear-gradient(140deg, #061428, #0b1d33 58%, #10315a);
        color: #fff;
        padding: clamp(2.4rem, 6vw, 4.8rem) 0;
    }

    .emp-hero-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 1rem;
        align-items: center;
    }

    .emp-kicker {
        display: inline-flex;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-size: .76rem;
        font-weight: 900;
        color: #fbbf24;
    }

    .emp-copy h1 {
        margin: .65rem 0 1rem;
        color: #fff;
        font-size: clamp(2rem, 4.8vw, 3.8rem);
        line-height: 1.03;
        max-width: 14ch;
    }

    .emp-copy p {
        margin: 0;
        color: #dbeafe;
        line-height: 1.72;
        font-weight: 600;
        max-width: 62ch;
    }

    .emp-actions {
        margin-top: 1.2rem;
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
    }

    .emp-actions.center {
        justify-content: center;
    }

    .emp-actions .btn-secondary {
        color: #fff;
        border-color: rgba(255, 255, 255, .34);
        background: rgba(255, 255, 255, .08);
    }

    .emp-panel {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .2);
        backdrop-filter: blur(10px);
    }

    .emp-panel h2 {
        color: #fff;
        margin-bottom: .8rem;
    }

    .emp-partners {
        background: #f8fafc;
    }

    .emp-head {
        margin: 0 auto 1.2rem;
        text-align: center;
        max-width: 820px;
    }

    .emp-head span {
        display: inline-flex;
        text-transform: uppercase;
        font-size: .74rem;
        letter-spacing: .06em;
        font-weight: 900;
        color: #0f9d58;
    }

    .emp-head h2 {
        margin: .45rem 0 .6rem;
        color: #0b1f52;
        font-size: clamp(1.5rem, 3.4vw, 2.4rem);
    }

    .emp-head p {
        margin: 0;
        color: #64748b;
        line-height: 1.65;
    }

    .emp-partner-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .8rem;
    }

    .emp-partner-card {
        text-align: center;
        border-radius: 10px;
    }

    .emp-partner-card.muted {
        opacity: .75;
    }

    .emp-partner-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto .65rem;
        border-radius: 10px;
        display: grid;
        place-items: center;
        color: #0b1f52;
        background: rgba(0, 31, 143, .08);
    }

    .emp-partner-card h3 {
        margin: 0 0 .2rem;
        font-size: .92rem;
        color: #0b1f52;
    }

    .emp-partner-card small {
        color: #64748b;
        text-transform: uppercase;
        font-size: .68rem;
        font-weight: 900;
    }

    .emp-jobs-head {
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: .8rem;
    }

    .emp-jobs-head h2 {
        margin: .45rem 0 0;
        color: #0b1f52;
        font-size: clamp(1.4rem, 3vw, 2.2rem);
    }

    .emp-job-card h3 {
        margin: 0 0 .7rem;
        color: #0b1f52;
        font-size: 1.05rem;
    }

    .emp-job-card p {
        margin: 0 0 .42rem;
        color: #334155;
        font-size: .84rem;
    }

    .emp-job-card .desc {
        margin: .7rem 0 .9rem;
        color: #64748b;
        line-height: 1.55;
    }

    .emp-job-card .btn {
        width: 100%;
        justify-content: center;
    }

    .emp-empty {
        grid-column: span 3;
    }

    .emp-empty h3 {
        margin-top: 0;
        color: #0b1f52;
    }

    .emp-empty p {
        color: #64748b;
        margin-bottom: .9rem;
    }

    .emp-cta {
        background: #0b1d33;
        color: #fff;
    }

    .emp-cta-shell {
        text-align: center;
    }

    .emp-cta-shell h2 {
        margin: 0 0 .45rem;
        color: #fff;
        font-size: clamp(1.5rem, 3vw, 2.4rem);
    }

    .emp-cta-shell p {
        margin: 0;
        color: #dbeafe;
    }

    @media (max-width: 1080px) {
        .emp-hero-grid,
        .emp-partner-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .emp-hero-grid,
        .emp-partner-grid,
        .emp-jobs-head {
            grid-template-columns: 1fr;
            display: grid;
        }

        .emp-actions .btn {
            width: 100%;
        }

        .emp-empty {
            grid-column: auto;
        }
    }
</style>
@endsection
