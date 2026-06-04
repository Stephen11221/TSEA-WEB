@extends('layouts.app')

@section('title', 'TSEA - Africa’s Workforce Passport')
@section('description', 'Africa’s Workforce Passport for Skills, Identity and Opportunity.')

@section('content')
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow">Taifa Skills & Employability Academy</span>
            <h1>Africa’s Workforce Passport for Skills, Identity & Opportunity</h1>
            <p>Building Africa’s most trusted workforce infrastructure for learners, employers, institutions and governments.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="{{ route('passport.create') }}">Create Workforce Passport</a>
                <a class="btn btn-secondary" href="{{ route('contact') }}">Partner With TSEA</a>
            </div>
        </div>
        <div class="dashboard-preview" aria-label="TSEA dashboard preview">
            <article class="card score-card">
                <h2>ERI™ Score</h2>
                @include('partials.charts', ['type' => 'gauge', 'score' => 82])
            </article>
            <article class="card passport-card">
                <h2>Your Passport</h2>
                <div class="profile-row">
                    <span class="avatar"></span>
                    <div><strong>Jane Mwangi</strong><small>Verified workforce profile</small></div>
                </div>
                <div class="mini-metrics">
                    <span><strong>12</strong> Skills</span>
                    <span><strong>24</strong> Matches</span>
                    <span><strong>6</strong> Applications</span>
                </div>
            </article>
            <article class="card wide-card">
                <h2>Workforce Insights</h2>
                @include('partials.charts')
            </article>
            <article class="card">
                <h2>Top Skills</h2>
                @include('partials.charts', ['type' => 'bars'])
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => 'The Workforce Visibility Gap', 'title' => 'Every stakeholder needs trusted workforce evidence'])
        <div class="grid four">
            @foreach ([
                ['Learners', 'Cannot prove readiness', 'fa-user-graduate'],
                ['Employers', 'Cannot verify talent', 'fa-building'],
                ['Institutions', 'Cannot track outcomes', 'fa-university'],
                ['Governments', 'Cannot see workforce trends', 'fa-landmark'],
            ] as [$title, $copy, $icon])
                <article class="card problem-card"><div class="icon-dot"><i class="fas {{ $icon }}" aria-hidden="true"></i></div><h3>{{ $title }}</h3><p>{{ $copy }}</p></article>
            @endforeach
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => 'Integrated Solution', 'title' => 'A complete infrastructure for skills, identity and opportunity'])
        <div class="grid four">
            @foreach ([
                ['ERI™', 'Measure, benchmark and improve workforce readiness.', 'fa-tachometer-alt'],
                ['Workforce Passport™', 'Digital workforce identity that verifies skills, credentials and experience.', 'fa-id-card'],
                ['Talent Marketplace™', 'Connect verified talent with employers and opportunities.', 'fa-users'],
                ['Workforce Intelligence™', 'Real-time labour market insights for better decisions.', 'fa-chart-line'],
            ] as [$title, $copy, $icon])
                <article class="card solution-card"><span class="solution-icon"><i class="fas {{ $icon }}" aria-hidden="true"></i></span><h3>{{ $title }}</h3><p>{{ $copy }}</p></article>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => 'Built For Every Stakeholder', 'title' => 'One platform, role-specific value'])
        <div class="grid five">
            @foreach ([
                ['Learners', 'Build identity and unlock opportunities.', 'fa-user'],
                ['Employers', 'Find and hire ready talent faster.', 'fa-briefcase'],
                ['Institutions', 'Measure outcomes and improve employability.', 'fa-school'],
                ['Governments', 'Make data-driven workforce policy decisions.', 'fa-landmark'],
                ['Partners', 'Collaborate to build a skilled Africa.', 'fa-handshake'],
            ] as [$title, $copy, $icon])
                <article class="compact-card"><i class="fas {{ $icon }}" aria-hidden="true"></i><strong>{{ $title }}</strong><span>{{ $copy }}</span></article>
            @endforeach
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => 'Impact At A Glance', 'title' => 'Trusted workforce infrastructure across Africa'])
        <div class="metrics-row">
            @include('partials.metric-card', ['value' => '1M+', 'label' => 'Workforce Passports™ Created'])
            @include('partials.metric-card', ['value' => '500K+', 'label' => 'ERI™ Assessments Completed'])
            @include('partials.metric-card', ['value' => '10K+', 'label' => 'Employers Onboarded'])
            @include('partials.metric-card', ['value' => '700+', 'label' => 'Partner Institutions Across Africa'])
            @include('partials.metric-card', ['value' => '54', 'label' => 'African Countries Impacted'])
        </div>
        <div class="partner-strip" aria-label="Trusted partners">
            @foreach (range(1, 7) as $logo)
                <span>LOGO</span>
            @endforeach
        </div>
    </div>
</section>
@endsection
