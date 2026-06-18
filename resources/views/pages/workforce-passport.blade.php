@extends('layouts.app')
@section('title', 'Workforce Passport™ - TSEA')

@section('content')
<style>
    :root {
        --tsea-navy: #0B1D33;
        --tsea-gold: #C5A059;
    }
    .journey-timeline {
        padding: 4rem 0;
        background: #fdfdfd;
    }
    .journey-step {
        border-left: 3px solid var(--tsea-gold);
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
        background: var(--tsea-navy);
        border: 2px solid var(--tsea-gold);
        border-radius: 50%;
    }
</style>
<section class="page-hero">
    <div class="container split">
        <div>
            <span class="eyebrow">{{ $passport->hero_label }}</span>
            <h1>{{ $passport->hero_title }}</h1>
            <p>{{ $passport->hero_description }}</p>
            <a class="btn btn-primary" href="{{ route('contact') }}">{{ $passport->cta_text }}</a>
        </div>
        <article class="card passport-profile">
            <div class="profile-row"><span class="avatar large"></span><div><strong>{{ $passport->profile_name ?? 'Jane Mwangi' }}</strong><small>{{ $passport->profile_location ?? 'Nairobi, Kenya' }}</small></div></div>
            <div class="passport-score">@include('partials.charts', ['type' => 'gauge', 'score' => $passport->passport_score ?? 82])</div>
        </article>
    </div>
</section>
<section class="section">
    <div class="container dashboard-grid">
        @php
            $skills = [];
            for ($i = 1; $i <= 5; $i++) {
                $name = $passport->{'skill_name_'.$i} ?: ['Digital Literacy', 'Communication', 'Problem Solving', 'Leadership', 'Adaptability'][$i - 1];
                $skills[$name] = $passport->{'skill_score_'.$i} ?: [92, 84, 78, 72, 88][$i - 1];
            }
        @endphp
        <article class="card wide-card"><h2>Verified Skills</h2>@include('partials.charts', ['type' => 'bars', 'items' => $skills])</article>
        <article class="card"><h2>Credentials</h2><ul class="check-list">@for($i = 1; $i <= 4; $i++)<li>{{ $passport->{'credential_'.$i} ?: ['National ID verified', 'Diploma credential verified', 'Digital skills badge issued', 'Work experience endorsed'][$i - 1] }}</li>@endfor</ul></article>
        <article class="card"><h2>Readiness Indicators</h2><div class="status-list">@for($i = 1; $i <= 3; $i++)<span>{{ $passport->{'readiness_'.$i} ?: ['Career ready', 'Interview ready', 'Opportunity matched'][$i - 1] }}</span>@endfor</div></article>
        <article class="card wide-card"><h2>Passport Benefits</h2><div class="grid three tight">@for($i = 1; $i <= 6; $i++)<div>{{ $passport->{'benefit_'.$i} ?: ['Verified Identity', 'Verified Skills', 'Verified Credentials', 'Verified Experience', 'Verified Readiness', 'Verified Opportunities'][$i - 1] }}</div>@endfor</div></article>
    </div>
</section>

<section class="journey-timeline">
    <div class="container">
        <h2 style="color: var(--tsea-navy); font-weight: 800; margin-bottom: 3rem; text-align: center;">12-Week Workforce Transition Journey</h2>
        <div class="grid two">
            <div class="journey-step">
                <h3 style="color: var(--tsea-gold);">Weeks 1-4: Foundation & Identity</h3>
                <p>Establishing the Workforce Passport™, verifying basic credentials, and ERI™ initial assessment.</p>
            </div>
            <div class="journey-step">
                <h3 style="color: var(--tsea-gold);">Weeks 5-8: Core Competency Building</h3>
                <p>Focus on digital literacy, communication, and problem-solving tracks with instructor-led sessions.</p>
            </div>
            <div class="journey-step">
                <h3 style="color: var(--tsea-gold);">Weeks 9-12: Market Placement & Readiness</h3>
                <p>Interview simulations, employer matchmaking, and final Workforce Passport™ endorsement.</p>
            </div>
            <div class="journey-step">
                <h3 style="color: var(--tsea-gold);">Graduation: Certified Readiness</h3>
                <p>Issuance of the TSEA Verified Readiness Certificate and priority access to the Talent Marketplace.</p>
            </div>
        </div>
    </div>
</section>
@endsection
