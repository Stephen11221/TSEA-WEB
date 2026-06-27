@extends('layouts.app')
@section('title', 'Workforce Passport™ - TSEA')

@section('content')
@php
    $activePrograms = \App\Models\Program::query()
        ->whereIn('status', ['active', 'published'])
        ->where('is_active', true)
        ->get();

    $categoryShares = $activePrograms
        ->groupBy(fn ($program) => $program->category ?: 'General')
        ->map(fn ($items) => round(($items->count() / max(1, $activePrograms->count())) * 100, 1))
        ->sortDesc()
        ->values();

    $fallbackScores = [
        $categoryShares->get(0, 88.0),
        $categoryShares->get(1, 82.0),
        $categoryShares->get(2, 76.0),
        $categoryShares->get(3, 72.0),
        $categoryShares->get(4, 68.0),
    ];

    $skills = [];
    for ($i = 1; $i <= 5; $i++) {
        $name = $passport->{'skill_name_'.$i} ?: ['Digital Literacy', 'Communication', 'Problem Solving', 'Leadership', 'Adaptability'][$i - 1];
        $skills[$name] = round((float) ($passport->{'skill_score_'.$i} ?: $fallbackScores[$i - 1]), 1);
    }

    $passportScore = round((float) ($passport->passport_score ?: collect($skills)->avg()), 1);
@endphp

<section class="wfp-hero">
    <div class="container wfp-hero-grid">
        <div class="wfp-copy">
            <span class="wfp-kicker">{{ $passport->hero_label }}</span>
            <h1>{{ $passport->hero_title }}</h1>
            <p>{{ $passport->hero_description }}</p>
            <a class="btn btn-gold" href="{{ route('contact') }}">{{ $passport->cta_text }}</a>
        </div>

        <article class="card wfp-profile-card">
            <div class="profile-row">
                <span class="avatar large"></span>
                <div>
                    <strong>{{ $passport->profile_name ?? 'Jane Mwangi' }}</strong>
                    <small>{{ $passport->profile_location ?? 'Nairobi, Kenya' }}</small>
                </div>
            </div>
            <div class="passport-score">
                @include('partials.charts', ['type' => 'gauge', 'score' => $passportScore])
            </div>
        </article>
    </div>
</section>

<section class="section wfp-board">
    <div class="container dashboard-grid">
        <article class="card wide-card">
            <h2>Verified Skills</h2>
            @include('partials.charts', ['type' => 'bars', 'items' => $skills])
        </article>
        <article class="card">
            <h2>Credentials</h2>
            <ul class="check-list">
                @for($i = 1; $i <= 4; $i++)
                    <li>{{ $passport->{'credential_'.$i} ?: ['National ID verified', 'Diploma credential verified', 'Digital skills badge issued', 'Work experience endorsed'][$i - 1] }}</li>
                @endfor
            </ul>
        </article>
        <article class="card">
            <h2>Readiness Indicators</h2>
            <div class="status-list">
                @for($i = 1; $i <= 3; $i++)
                    <span>{{ $passport->{'readiness_'.$i} ?: ['Career ready', 'Interview ready', 'Opportunity matched'][$i - 1] }}</span>
                @endfor
            </div>
        </article>
        <article class="card wide-card">
            <h2>Passport Benefits</h2>
            <div class="grid three tight">
                @for($i = 1; $i <= 6; $i++)
                    <div>{{ $passport->{'benefit_'.$i} ?: ['Verified Identity', 'Verified Skills', 'Verified Credentials', 'Verified Experience', 'Verified Readiness', 'Verified Opportunities'][$i - 1] }}</div>
                @endfor
            </div>
        </article>
    </div>
</section>

<section class="journey-timeline">
    <div class="container">
        <h2 class="wfp-timeline-title">12-Week Workforce Transition Journey</h2>
        <div class="grid two">
            <div class="journey-step">
                <h3>Weeks 1-4: Foundation & Identity</h3>
                <p>Establishing the Workforce Passport™, verifying basic credentials, and ERI™ initial assessment.</p>
            </div>
            <div class="journey-step">
                <h3>Weeks 5-8: Core Competency Building</h3>
                <p>Focus on digital literacy, communication, and problem-solving tracks with instructor-led sessions.</p>
            </div>
            <div class="journey-step">
                <h3>Weeks 9-12: Market Placement & Readiness</h3>
                <p>Interview simulations, employer matchmaking, and final Workforce Passport™ endorsement.</p>
            </div>
            <div class="journey-step">
                <h3>Graduation: Certified Readiness</h3>
                <p>Issuance of the TSEA Verified Readiness Certificate and priority access to the Talent Marketplace.</p>
            </div>
        </div>
    </div>
</section>

<style>
    .wfp-hero {
        background:
            radial-gradient(circle at 18% 20%, rgba(229, 138, 0, .16), transparent 32%),
            radial-gradient(circle at 79% 20%, rgba(0, 141, 59, .14), transparent 30%),
            linear-gradient(140deg, #061428, #0b1d33 58%, #10315a);
        color: #fff;
        padding: clamp(2.4rem, 6vw, 4.8rem) 0;
    }

    .wfp-hero-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 1rem;
        align-items: center;
    }

    .wfp-kicker {
        display: inline-flex;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-size: .76rem;
        font-weight: 900;
        color: #fbbf24;
    }

    .wfp-copy h1 {
        margin: .65rem 0 1rem;
        color: #fff;
        font-size: clamp(2rem, 4.8vw, 3.8rem);
        line-height: 1.03;
        max-width: 14ch;
    }

    .wfp-copy p {
        margin: 0 0 1.2rem;
        color: #dbeafe;
        line-height: 1.72;
        font-weight: 600;
        max-width: 62ch;
    }

    .wfp-profile-card {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .2);
        backdrop-filter: blur(10px);
    }

    .wfp-profile-card strong,
    .wfp-profile-card small {
        color: #fff;
    }

    .wfp-board {
        background: #f8fafc;
    }

    .journey-timeline {
        padding: 4rem 0;
        background: #fff;
    }

    .wfp-timeline-title {
        color: #0b1d33;
        font-weight: 800;
        margin-bottom: 2rem;
        text-align: center;
    }

    .journey-step {
        border-left: 3px solid #c5a059;
        padding: 0 0 2rem 2rem;
        position: relative;
    }

    .journey-step::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 0;
        width: 17px;
        height: 17px;
        background: #0b1d33;
        border: 2px solid #c5a059;
        border-radius: 50%;
    }

    .journey-step h3 {
        color: #c5a059;
        margin: 0 0 .45rem;
    }

    .journey-step p {
        margin: 0;
        color: #475569;
        line-height: 1.58;
    }

    @media (max-width: 980px) {
        .wfp-hero-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
