@extends('layouts.app')
@section('title', 'Programs - TSEA')

@section('content')
@php
    $journey = [
        ['label' => 'Mindset Re-Engineering™', 'icon' => 'fa-brain', 'tone' => 'gold'],
        ['label' => 'Employability Foundation', 'icon' => 'fa-bullseye', 'tone' => 'green'],
        ['label' => 'Specialization Academy', 'icon' => 'fa-medal', 'tone' => 'blue'],
        ['label' => 'Workplace Application', 'icon' => 'fa-briefcase', 'tone' => 'gold'],
        ['label' => 'Workforce Passport™', 'icon' => 'fa-shield-halved', 'tone' => 'green'],
        ['label' => 'Employer Visibility', 'icon' => 'fa-id-badge', 'tone' => 'blue'],
    ];

    $foundationModules = [
        ['number' => 1, 'title' => 'Human Potential Activation™', 'icon' => 'fa-brain', 'tone' => 'gold'],
        ['number' => 2, 'title' => 'Career Clarity & Future Self Design™', 'icon' => 'fa-bullseye', 'tone' => 'green'],
        ['number' => 3, 'title' => 'Professional Identity Development™', 'icon' => 'fa-user-tie', 'tone' => 'blue'],
        ['number' => 4, 'title' => 'Communication & Collaboration', 'icon' => 'fa-people-group', 'tone' => 'gold'],
        ['number' => 5, 'title' => 'Workplace Readiness', 'icon' => 'fa-briefcase', 'tone' => 'green'],
        ['number' => 6, 'title' => 'AI Productivity & Future of Work', 'icon' => 'fa-microchip', 'tone' => 'blue'],
    ];

    $academyStyles = [
        ['name' => 'Technology Academy™', 'icon' => 'fa-laptop-code', 'class' => 'technology'],
        ['name' => 'Digital Economy Academy™', 'icon' => 'fa-chart-line', 'class' => 'digital'],
        ['name' => 'Commercial Excellence Academy™', 'icon' => 'fa-handshake', 'class' => 'commercial'],
        ['name' => 'Professional Excellence Academy™', 'icon' => 'fa-user-tie', 'class' => 'professional'],
    ];

    $trackTiles = [
        ['title' => 'Data Analytics', 'icon' => 'fa-chart-simple', 'items' => ['Excel', 'SQL', 'Power BI', 'Dashboard Design', 'Data Storytelling']],
        ['title' => 'Cybersecurity', 'icon' => 'fa-shield-halved', 'items' => ['Security Fundamentals', 'Risk Assessment', 'Digital Safety', 'Security Operations']],
        ['title' => 'Software Development', 'icon' => 'fa-code', 'items' => ['HTML', 'CSS', 'JavaScript', 'Databases', 'APIs']],
        ['title' => 'AI & Prompt Engineering', 'icon' => 'fa-microchip', 'items' => ['Prompt Design', 'Workflow Automation', 'AI Systems Integration']],
        ['title' => 'Digital Marketing', 'icon' => 'fa-bullhorn', 'items' => ['Content Strategy', 'Social Media Marketing', 'SEO', 'Email Marketing', 'Analytics']],
        ['title' => 'Graphic Design', 'icon' => 'fa-paintbrush', 'items' => ['Visual Communication', 'Branding', 'Canva', 'Adobe Tools']],
    ];

    $programCards = $available->take(4)->values();
@endphp

<section class="programs-hero">
    <div class="programs-shell programs-hero-grid">
        <div class="programs-hero-copy">
            <span class="programs-kicker">{{ $page->hero_label ?? 'Programs' }}</span>
            <h1>{{ $page->hero_title ?: 'Build workforce readiness before graduation.' }}</h1>
            <p>{{ $page->hero_description ?: 'TSEA programs combine mindset re-engineering, employability development, future skills, workplace application and employer visibility into one 12-week Workforce Transition Journey™.' }}</p>
            <div class="programs-actions">
                <a href="{{ auth()->check() ? route('user.dashboard') : route('register') }}" class="programs-btn programs-btn-gold">Start Employability Assessment</a>
                <a href="#academies" class="programs-btn programs-btn-outline">Explore Academies</a>
            </div>
        </div>

        <div class="programs-hero-visual" aria-label="TSEA workforce readiness journey">
            <div class="student-cluster">
                <div class="student-card primary">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="TSEA">
                </div>
                <div class="student-card small one"><i class="fas fa-user-graduate"></i></div>
                <div class="student-card small two"><i class="fas fa-wheelchair-move"></i></div>
                <div class="student-card small three"><i class="fas fa-laptop-code"></i></div>
            </div>
        </div>

        <aside class="journey-panel">
            <h2>The TSEA Journey</h2>
            @foreach($journey as $step)
                <div class="journey-row {{ $step['tone'] }}">
                    <span><i class="fas {{ $step['icon'] }}"></i></span>
                    <strong>{{ $step['label'] }}</strong>
                </div>
                @unless($loop->last)
                    <i class="fas fa-arrow-down journey-arrow"></i>
                @endunless
            @endforeach
        </aside>
    </div>
</section>

<section class="journey-board">
    <div class="programs-shell">
        <div class="journey-title">
            <span></span>
            <h2>12-Week Workforce Transition Journey™</h2>
            <span></span>
        </div>

        <div class="foundation-grid">
            <div class="foundation-intro">
                <small>Weeks 1-4</small>
                <h3>Workforce Foundation™</h3>
                <p>Required for every learner. Build the mindset, skills and confidence that employers value.</p>
            </div>
            @foreach($foundationModules as $module)
                <article class="module-card {{ $module['tone'] }}">
                    <span>{{ $module['number'] }}</span>
                    <small>Module {{ $module['number'] }}</small>
                    <strong>{{ $module['title'] }}</strong>
                    <i class="fas {{ $module['icon'] }}"></i>
                </article>
            @endforeach
        </div>

        <div class="academy-strip" id="academies">
            <span>Weeks 5-12</span>
            <strong>Choose Your Academy</strong>
            <i class="fas fa-arrow-right"></i>
        </div>

        <div class="academy-grid">
            @forelse($programCards as $program)
                @php $style = $academyStyles[$loop->index] ?? $academyStyles[0]; @endphp
                <article class="academy-card {{ $style['class'] }}">
                    <div class="academy-header">
                        <span><i class="fas {{ $program->icon ?: $style['icon'] }}"></i></span>
                        <h3>{{ $program->title ?: $style['name'] }}</h3>
                    </div>
                    <div class="academy-image">
                        @if(!empty($program->image))
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}">
                        @else
                            <i class="fas {{ $style['icon'] }}"></i>
                        @endif
                    </div>
                    <p>{{ \Illuminate\Support\Str::limit($program->description, 95) }}</p>
                    @if(!empty($program->id))
                        <a href="{{ route('user.enrollment.show', $program->id) }}">Enroll Now</a>
                    @else
                        <a href="{{ route('register') }}">Apply Now</a>
                    @endif
                </article>
            @empty
                @foreach($academyStyles as $style)
                    <article class="academy-card {{ $style['class'] }}">
                        <div class="academy-header">
                            <span><i class="fas {{ $style['icon'] }}"></i></span>
                            <h3>{{ $style['name'] }}</h3>
                        </div>
                        <div class="academy-image"><i class="fas {{ $style['icon'] }}"></i></div>
                        <p>Build targeted workforce skills for your selected career pathway.</p>
                        <a href="{{ route('register') }}">Apply Now</a>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="track-section">
    <div class="programs-shell">
        <div class="journey-title compact">
            <span></span>
            <h2>Explore Specialization Tracks</h2>
            <span></span>
        </div>

        <div class="track-grid">
            @foreach($trackTiles as $track)
                <article class="track-card">
                    <i class="fas {{ $track['icon'] }}"></i>
                    <div>
                        <h3>{{ $track['title'] }}</h3>
                        <ul>
                            @foreach($track['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        <a href="#academies">View Track <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="outcome-grid">
            <article class="outcome-card">
                <span><i class="fas fa-briefcase"></i></span>
                <div>
                    <h2>Workplace Application™</h2>
                    <p>Every learner completes a workplace-based project that demonstrates competence, discipline and problem-solving ability.</p>
                    <div class="mini-outcomes">
                        <small><i class="fas fa-diagram-project"></i> Workplace Impact Project™</small>
                        <small><i class="fas fa-folder-open"></i> Portfolio Evidence</small>
                        <small><i class="fas fa-user-check"></i> Supervisor Validation</small>
                        <small><i class="fas fa-chart-line"></i> ERI™ Contribution</small>
                        <small><i class="fas fa-shield-halved"></i> Passport Asset</small>
                    </div>
                </div>
            </article>

            <article class="outcome-card">
                <span><i class="fas fa-shield"></i></span>
                <div>
                    <h2>Certification & Passport™</h2>
                    <p>Graduate with industry-recognized credentials and employer visibility.</p>
                    <div class="mini-outcomes">
                        <small><i class="fas fa-award"></i> Track Certificate™</small>
                        <small><i class="fas fa-certificate"></i> Employability Certificate™</small>
                        <small><i class="fas fa-bullseye"></i> ERI™ Score</small>
                        <small><i class="fas fa-id-card"></i> Workforce Passport™</small>
                        <small><i class="fas fa-users"></i> Employer Visibility</small>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="programs-bottom-cta">
    <div class="programs-shell cta-row">
        <div>
            <h2>Ready to build your Workforce Passport™?</h2>
            <p>Take the first step toward employability, opportunity and a better future.</p>
        </div>
        <a href="{{ auth()->check() ? route('user.dashboard') : route('register') }}" class="programs-btn programs-btn-gold">Start Employability Assessment</a>
        <a href="#academies" class="programs-btn programs-btn-outline">Explore Programs</a>
    </div>
</section>

<style>
    .programs-shell {
        width: min(100% - 32px, 1280px);
        margin: 0 auto;
    }

    .programs-hero {
        background:
            radial-gradient(circle at 46% 28%, rgba(0, 84, 180, .35), transparent 28%),
            linear-gradient(130deg, #06182e 0%, #031124 62%, #071d3a 100%);
        color: #fff;
        overflow: hidden;
        position: relative;
        border-bottom: 1px solid rgba(255, 193, 7, .35);
    }

    .programs-hero:before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,.13) 1px, transparent 1px);
        background-size: 18px 18px;
        opacity: .22;
    }

    .programs-hero-grid {
        min-height: 470px;
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(280px, .95fr) minmax(320px, 1fr) 260px;
        align-items: end;
        gap: 28px;
        padding: 52px 0 0;
    }

    .programs-kicker {
        color: #ffc107;
        text-transform: uppercase;
        font-weight: 900;
        font-size: .78rem;
        letter-spacing: .08em;
    }

    .programs-hero h1 {
        max-width: 560px;
        margin: 14px 0 18px;
        font-size: clamp(2.5rem, 4.8vw, 4.65rem);
        line-height: 1.02;
        font-weight: 950;
        letter-spacing: 0;
    }

    .programs-hero h1:after {
        content: "";
        display: inline-block;
        width: .26em;
        height: .26em;
        margin-left: .08em;
        border-radius: 50%;
        background: #ffc107;
    }

    .programs-hero p {
        max-width: 550px;
        color: #eff6ff;
        line-height: 1.75;
        font-weight: 650;
    }

    .programs-actions,
    .cta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
    }

    .programs-actions {
        margin-top: 28px;
    }

    .programs-btn {
        min-height: 46px;
        border-radius: 6px;
        padding: 12px 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: .9rem;
        border: 1px solid transparent;
    }

    .programs-btn-gold {
        background: #ffc107;
        color: #06182e;
    }

    .programs-btn-outline {
        color: #fff;
        border-color: #d8a000;
        background: rgba(255,255,255,.03);
    }

    .programs-hero-visual {
        min-height: 430px;
        display: grid;
        align-items: end;
    }

    .student-cluster {
        height: 340px;
        position: relative;
        display: grid;
        place-items: center;
    }

    .student-card {
        border: 1px solid rgba(255,255,255,.22);
        background: linear-gradient(145deg, rgba(255,255,255,.14), rgba(255,255,255,.04));
        box-shadow: 0 25px 60px rgba(0,0,0,.35);
        display: grid;
        place-items: center;
        color: #ffc107;
    }

    .student-card.primary {
        width: min(78%, 300px);
        aspect-ratio: 1;
        border-radius: 50%;
        overflow: hidden;
        background: #fff;
    }

    .student-card.primary img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-card.small {
        position: absolute;
        width: 96px;
        height: 118px;
        border-radius: 12px;
        font-size: 2rem;
    }

    .student-card.one { left: 2%; bottom: 22px; color: #fff; }
    .student-card.two { right: 0; bottom: 6px; color: #5dd489; }
    .student-card.three { left: 34%; top: 6px; color: #4f8df7; }

    .journey-panel {
        align-self: center;
        margin-bottom: 30px;
        padding: 18px;
        border: 1px solid rgba(255,255,255,.24);
        border-radius: 10px;
        background: rgba(1, 17, 39, .82);
        box-shadow: 0 22px 45px rgba(0,0,0,.35);
    }

    .journey-panel h2 {
        text-align: center;
        text-transform: uppercase;
        font-size: .95rem;
        margin: 0 0 12px;
        font-weight: 950;
        letter-spacing: .06em;
    }

    .journey-row {
        display: grid;
        grid-template-columns: 42px 1fr;
        align-items: center;
        gap: 10px;
        min-height: 42px;
        padding: 8px 10px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,.16);
        background: rgba(255,255,255,.04);
    }

    .journey-row span {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        display: grid;
        place-items: center;
        border: 1px solid currentColor;
    }

    .journey-row strong {
        font-size: .78rem;
    }

    .journey-row.gold { color: #ffc107; }
    .journey-row.green { color: #00a651; }
    .journey-row.blue { color: #2d73ff; }
    .journey-arrow {
        display: block;
        text-align: center;
        color: #ffc107;
        font-size: .85rem;
        margin: 4px 0;
    }

    .journey-board,
    .track-section {
        background: #f8fafc;
        padding: 28px 0;
    }

    .journey-title {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 18px;
        margin: 0 0 18px;
        text-align: center;
    }

    .journey-title span {
        height: 2px;
        background: linear-gradient(90deg, transparent, #d8a000, transparent);
    }

    .journey-title h2 {
        color: #071832;
        font-size: clamp(1rem, 2vw, 1.35rem);
        text-transform: uppercase;
        font-weight: 950;
        margin: 0;
        letter-spacing: 0;
    }

    .foundation-grid {
        display: grid;
        grid-template-columns: 230px repeat(6, minmax(120px, 1fr));
        gap: 12px;
        align-items: stretch;
    }

    .foundation-intro {
        padding: 14px 6px;
    }

    .foundation-intro small,
    .academy-strip span {
        text-transform: uppercase;
        font-weight: 950;
        color: #071832;
        font-size: .72rem;
    }

    .foundation-intro h3 {
        color: #071832;
        font-size: 1.65rem;
        line-height: 1.05;
        font-weight: 950;
        margin: 7px 0;
    }

    .foundation-intro p {
        color: #0f172a;
        line-height: 1.45;
        font-weight: 650;
        font-size: .88rem;
    }

    .module-card {
        position: relative;
        min-height: 132px;
        background: #fff;
        border: 1px solid #d9e1ea;
        border-radius: 8px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
        padding: 14px;
        overflow: hidden;
    }

    .module-card span {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        color: #071832;
        font-weight: 950;
        margin-bottom: 18px;
    }

    .module-card.gold span { background: #ffc107; }
    .module-card.green span { background: #00a651; color: #fff; }
    .module-card.blue span { background: #0d6efd; color: #fff; }

    .module-card small,
    .module-card strong {
        display: block;
        color: #071832;
    }

    .module-card small {
        font-size: .62rem;
        font-weight: 850;
        margin-bottom: 4px;
    }

    .module-card strong {
        max-width: 78%;
        font-size: .76rem;
        line-height: 1.35;
        font-weight: 950;
    }

    .module-card > i {
        position: absolute;
        right: 12px;
        bottom: 16px;
        color: #071832;
        font-size: 2.1rem;
    }

    .academy-strip {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 22px;
        margin: 14px auto;
        padding: 10px 20px;
        max-width: 940px;
        border: 1px solid #d9e1ea;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 10px 22px rgba(15, 23, 42, .06);
    }

    .academy-strip strong {
        color: #071832;
        font-size: 1.35rem;
        font-weight: 950;
    }

    .academy-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .academy-card {
        overflow: hidden;
        border-radius: 8px;
        border: 1px solid #d9e1ea;
        background: #fff;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
    }

    .academy-header {
        min-height: 76px;
        display: grid;
        grid-template-columns: 58px 1fr;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: #fff;
    }

    .academy-card.technology .academy-header { background: linear-gradient(135deg, #05275a, #064fa7); }
    .academy-card.digital .academy-header { background: linear-gradient(135deg, #00652f, #00a651); }
    .academy-card.commercial .academy-header { background: linear-gradient(135deg, #946800, #d8a000); }
    .academy-card.professional .academy-header { background: linear-gradient(135deg, #003f9f, #0d6efd); }

    .academy-header span {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border: 1px solid rgba(255,255,255,.75);
        border-radius: 50%;
        font-size: 1.25rem;
    }

    .academy-header h3 {
        margin: 0;
        font-weight: 950;
        font-size: 1.02rem;
        line-height: 1.2;
    }

    .academy-image {
        height: 120px;
        display: grid;
        place-items: center;
        color: #071832;
        background:
            linear-gradient(135deg, rgba(6,24,46,.72), rgba(6,24,46,.15)),
            repeating-linear-gradient(90deg, #dbeafe 0 2px, #f8fafc 2px 14px);
        overflow: hidden;
    }

    .academy-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .academy-image i {
        color: #fff;
        font-size: 2.4rem;
    }

    .academy-card p {
        min-height: 74px;
        margin: 0;
        padding: 14px 16px 8px;
        color: #0f172a;
        line-height: 1.55;
        font-size: .88rem;
    }

    .academy-card a {
        margin: 0 16px 16px;
        display: inline-flex;
        min-height: 34px;
        padding: 8px 16px;
        border-radius: 5px;
        background: #064fa7;
        color: #fff;
        font-size: .78rem;
        font-weight: 900;
    }

    .academy-card.digital a { background: #008d3b; }
    .academy-card.commercial a { background: #d8a000; color: #071832; }

    .journey-title.compact {
        margin-top: 4px;
    }

    .track-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 10px;
    }

    .track-card {
        min-height: 124px;
        background: #fff;
        border: 1px solid #d9e1ea;
        border-radius: 8px;
        padding: 14px;
        display: grid;
        grid-template-columns: 46px 1fr;
        gap: 10px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
    }

    .track-card > i {
        color: #0d6efd;
        font-size: 1.9rem;
    }

    .track-card h3 {
        margin: 0 0 6px;
        color: #071832;
        font-size: .85rem;
        font-weight: 950;
    }

    .track-card ul {
        margin: 0 0 8px;
        padding-left: 14px;
        color: #0f172a;
        font-size: .72rem;
        line-height: 1.45;
    }

    .track-card a {
        color: #064fa7;
        font-size: .72rem;
        font-weight: 900;
    }

    .outcome-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 16px;
    }

    .outcome-card {
        display: grid;
        grid-template-columns: 82px 1fr;
        gap: 18px;
        padding: 20px;
        border: 1px solid #d9e1ea;
        border-radius: 8px;
        background: #fff;
    }

    .outcome-card > span {
        width: 68px;
        height: 68px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #06182e;
        color: #ffc107;
        font-size: 1.7rem;
    }

    .outcome-card h2 {
        color: #071832;
        margin: 0 0 5px;
        text-transform: uppercase;
        font-size: 1.1rem;
        font-weight: 950;
    }

    .outcome-card p {
        margin: 0 0 14px;
        color: #0f172a;
        font-size: .86rem;
        line-height: 1.55;
        font-weight: 650;
    }

    .mini-outcomes {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px;
        text-align: center;
    }

    .mini-outcomes small {
        color: #071832;
        font-size: .66rem;
        line-height: 1.25;
        font-weight: 850;
    }

    .mini-outcomes i {
        display: block;
        color: #0d6efd;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .programs-bottom-cta {
        background:
            linear-gradient(135deg, rgba(255,193,7,.18), transparent 18%),
            linear-gradient(135deg, #06182e, #031124);
        color: #fff;
        padding: 22px 0;
    }

    .cta-row {
        justify-content: space-between;
    }

    .cta-row h2 {
        margin: 0 0 5px;
        font-size: 1.45rem;
        font-weight: 950;
    }

    .cta-row p {
        margin: 0;
        color: #dbeafe;
    }

    @media (max-width: 1180px) {
        .programs-hero-grid {
            grid-template-columns: 1fr;
            padding-bottom: 28px;
        }

        .programs-hero-visual {
            min-height: 260px;
        }

        .student-cluster {
            height: 260px;
        }

        .journey-panel {
            width: min(100%, 520px);
            margin: 0;
        }

        .foundation-grid,
        .academy-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .foundation-intro {
            grid-column: 1 / -1;
        }

        .track-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .programs-shell {
            width: min(100% - 20px, 1280px);
        }

        .programs-hero-grid {
            min-height: 0;
            padding-top: 24px;
        }

        .programs-hero h1 {
            font-size: 2.45rem;
        }

        .programs-actions,
        .cta-row {
            flex-direction: column;
            align-items: stretch;
        }

        .programs-btn {
            width: 100%;
        }

        .foundation-grid,
        .academy-grid,
        .track-grid,
        .outcome-grid {
            grid-template-columns: 1fr;
        }

        .academy-strip {
            justify-content: flex-start;
            gap: 12px;
        }

        .academy-strip strong {
            font-size: 1rem;
        }

        .outcome-card {
            grid-template-columns: 1fr;
        }

        .mini-outcomes {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            text-align: left;
        }

        .student-card.primary {
            width: min(72%, 230px);
        }

        .student-card.small {
            width: 74px;
            height: 90px;
        }
    }
</style>
@endsection
