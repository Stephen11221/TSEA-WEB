@extends('layouts.app')

@section('title', 'TSEA - Africa’s Workforce Passport')
@section('description', 'Africa’s Workforce Passport for Skills, Identity and Opportunity.')

@section('content')
@php
    $homepageContent = $homepageContent ?? \App\Models\Homepage::defaults();
    $hero = [
        'eyebrow' => $homepage->hero_eyebrow ?? 'Taifa Skills & Employability Academy',
        'title' => $homepage->hero_title ?? 'Africa’s Workforce Passport for Skills, Identity & Opportunity',
        'description' => $homepage->hero_description ?? 'Building Africa’s most trusted workforce infrastructure for learners, employers, institutions and governments.',
        'primary_text' => $homepage->primary_button_text ?? 'Create Workforce Passport',
        'primary_link' => $homepage->primary_button_link ?? route('passport.create'),
        'secondary_text' => $homepage->secondary_button_text ?? 'Join as Employer',
        'secondary_link' => $homepage->secondary_button_link ?? route('register.employer'),
    ];

    $problemItems = collect($homepageContent['problem']['items'] ?? [])->values();
    $solutionItems = collect($homepageContent['solution']['items'] ?? [])->values();
    $stakeholderItems = collect($homepageContent['stakeholders']['items'] ?? [])->values();
    $impactMetrics = collect($homepageContent['impact']['metrics'] ?? [])->values();
    $partnerItems = collect($homepageContent['impact']['partners'] ?? [])
        ->filter(function ($partner) {
            $name = trim((string) ($partner['name'] ?? ''));
            $logo = trim((string) ($partner['logo'] ?? ''));

            // Hide empty/default placeholders and show only configured partner entries.
            if ($name === '' && $logo === '') {
                return false;
            }

            if (strtolower($name) === 'partner name' && $logo === '') {
                return false;
            }

            return true;
        })
        ->values();
    $documents = collect($homepageContent['documents']['items'] ?? [])->filter(fn ($document) => !empty($document['path']))->values();

    $dashboard = $homepageContent['dashboard'] ?? [];
@endphp

<section class="homex-hero">
    <div class="container homex-hero-grid">
        <div class="homex-copy">
            <span class="homex-kicker">{{ $hero['eyebrow'] }}</span>
            <h1>{{ $hero['title'] }}</h1>
            <p>{{ $hero['description'] }}</p>
            <div class="homex-actions">
                <a class="btn btn-gold" href="{{ $hero['primary_link'] }}">{{ $hero['primary_text'] }}</a>
                <a class="btn btn-secondary" href="{{ $hero['secondary_link'] }}">{{ $hero['secondary_text'] }}</a>
            </div>

            <div class="homex-signals" aria-label="Platform signals">
                <article>
                    <span>{{ $dashboard['skills_count'] ?? 'N/A' }}</span>
                    <small>{{ $dashboard['skills_label'] ?? 'Skills' }}</small>
                </article>
                <article>
                    <span>{{ $dashboard['matches_count'] ?? 'N/A' }}</span>
                    <small>{{ $dashboard['matches_label'] ?? 'Matches' }}</small>
                </article>
                <article>
                    <span>{{ $dashboard['applications_count'] ?? 'N/A' }}</span>
                    <small>{{ $dashboard['applications_label'] ?? 'Applications' }}</small>
                </article>
            </div>
        </div>

        <aside class="homex-command card">
            <header>
                <strong>{{ $dashboard['passport_title'] ?? 'Workforce Passport™' }}</strong>
                <small>Live Readiness View</small>
            </header>

            <div class="homex-command-grid">
                <article class="card homex-mini">
                    <h2>{{ $dashboard['score_title'] ?? 'ERI Score' }}</h2>
                    @include('partials.charts', ['type' => 'gauge', 'score' => $dashboard['score'] ?? 82])
                </article>

                <article class="card homex-mini">
                    <h2>{{ $dashboard['insights_title'] ?? 'Market Insights' }}</h2>
                    @include('partials.charts')
                </article>
            </div>

            <div class="homex-persona">
                <span class="avatar"></span>
                <div>
                    <strong>{{ $dashboard['profile_name'] ?? 'TSEA Learner' }}</strong>
                    <small>{{ $dashboard['profile_caption'] ?? 'Career-Ready Candidate' }}</small>
                </div>
            </div>

            <div class="homex-skillbars">
                <h3>{{ $dashboard['top_skills_title'] ?? 'Top Skills' }}</h3>
                @include('partials.charts', ['type' => 'bars'])
            </div>
        </aside>
    </div>
</section>

<section class="section homex-problem-solution">
    <div class="container homex-dual-grid">
        <article class="homex-panel danger">
            <div class="homex-panel-header">
                <span>{{ $homepageContent['problem']['eyebrow'] }}</span>
                <h2>{{ $homepageContent['problem']['title'] }}</h2>
            </div>
            <div class="homex-card-grid">
                @foreach ($problemItems as $item)
                    <article class="homex-item-card">
                        <i class="fas {{ $item['icon'] }}" aria-hidden="true"></i>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </article>

        <article class="homex-panel success">
            <div class="homex-panel-header">
                <span>{{ $homepageContent['solution']['eyebrow'] }}</span>
                <h2>{{ $homepageContent['solution']['title'] }}</h2>
            </div>
            <div class="homex-card-grid">
                @foreach ($solutionItems as $item)
                    <article class="homex-item-card">
                        <i class="fas {{ $item['icon'] }}" aria-hidden="true"></i>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </article>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="homex-headline">
            <span>{{ $homepageContent['stakeholders']['eyebrow'] }}</span>
            <h2>{{ $homepageContent['stakeholders']['title'] }}</h2>
        </div>
        <div class="homex-stakeholders">
            @foreach ($stakeholderItems as $item)
                <article class="compact-card homex-stake-card">
                    <i class="fas {{ $item['icon'] }}" aria-hidden="true"></i>
                    <strong>{{ $item['title'] }}</strong>
                    <span>{{ $item['copy'] }}</span>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if ($documents->isNotEmpty())
<section class="section homex-docs">
    <div class="container">
        <div class="homex-headline">
            <span>{{ $homepageContent['documents']['eyebrow'] }}</span>
            <h2>{{ $homepageContent['documents']['title'] }}</h2>
        </div>
        <div class="homex-document-grid">
            @foreach ($documents as $document)
                <article class="card document-card homex-document-card">
                    <i class="fas fa-file-lines" aria-hidden="true"></i>
                    <h3>{{ $document['title'] ?: ($document['original_name'] ?: 'Homepage document') }}</h3>
                    @if (! empty($document['description']))
                        <p>{{ $document['description'] }}</p>
                    @endif
                    <a class="text-link" href="{{ asset('storage/' . $document['path']) }}" target="_blank" rel="noopener">View document</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section homex-impact">
    <div class="container">
        <div class="homex-headline light">
            <span>{{ $homepageContent['impact']['eyebrow'] }}</span>
            <h2>{{ $homepageContent['impact']['title'] }}</h2>
        </div>

        <div class="metrics-row compact homex-impact-metrics">
            @foreach ($impactMetrics as $metric)
                @include('partials.metric-card', ['value' => $metric['value'], 'label' => $metric['label']])
            @endforeach
        </div>

        <h3 class="homex-partner-heading">Partners</h3>
        <div class="partner-strip homex-partner-strip" id="homePartners" aria-label="Trusted partners">
            @foreach ($partnerItems as $partner)
                @php
                    $logo = trim((string) ($partner['logo'] ?? ''));
                    $logoSrc = \Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/']) ? $logo : ($logo ? asset('storage/' . $logo) : '');
                @endphp
                <article @class(['partner-logo-card', 'homex-partner-card', 'partner-hidden' => $loop->index >= 4])>
                    @if ($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $partner['name'] }} logo">
                    @else
                        <span>{{ $partner['name'] }}</span>
                    @endif
                    @if (! empty($partner['name']))
                        <strong>{{ $partner['name'] }}</strong>
                    @endif
                </article>
            @endforeach
        </div>
        @if ($partnerItems->count() > 4)
            <button type="button" class="btn btn-secondary btn-sm homex-partner-toggle" id="togglePartners" aria-expanded="false" aria-controls="homePartners">
                Expand Partners
            </button>
        @endif
    </div>
</section>

<style>
    .homex-hero {
        background:
            radial-gradient(circle at 16% 22%, rgba(229, 138, 0, .18), transparent 33%),
            radial-gradient(circle at 76% 18%, rgba(0, 141, 59, .14), transparent 31%),
            linear-gradient(138deg, #061428 0%, #0b1d33 55%, #0f2c4f 100%);
        color: #fff;
        padding: clamp(2.5rem, 6vw, 5rem) 0;
    }

    .homex-hero-grid {
        display: grid;
        grid-template-columns: minmax(320px, 1.1fr) minmax(320px, .9fr);
        gap: 1rem;
        align-items: center;
    }

    .homex-kicker {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        text-transform: uppercase;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: .05em;
        color: #f8fafc;
    }

    .homex-kicker:before {
        content: "";
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #f59e0b;
    }

    .homex-copy h1 {
        margin: .75rem 0 1rem;
        font-size: clamp(2.2rem, 5.3vw, 4.2rem);
        line-height: 1.02;
        color: #fff;
        max-width: 15ch;
    }

    .homex-copy p {
        margin: 0;
        color: #dbeafe;
        font-weight: 600;
        line-height: 1.75;
        max-width: 62ch;
    }

    .homex-actions {
        margin-top: 1.35rem;
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
    }

    .homex-actions .btn-secondary {
        color: #fff;
        border-color: rgba(255, 255, 255, .35);
        background: rgba(255, 255, 255, .08);
    }

    .homex-signals {
        margin-top: 1.15rem;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .7rem;
    }

    .homex-signals article {
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 10px;
        background: rgba(2, 6, 23, .35);
        padding: .75rem;
    }

    .homex-signals span {
        display: block;
        color: #fff;
        font-weight: 900;
        font-size: 1.2rem;
    }

    .homex-signals small {
        display: block;
        margin-top: .2rem;
        color: #bfdbfe;
        font-weight: 700;
        font-size: .75rem;
    }

    .homex-command {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .24);
        backdrop-filter: blur(10px);
        color: #fff;
        padding: 1rem;
    }

    .homex-command header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: .75rem;
    }

    .homex-command header strong {
        color: #fff;
    }

    .homex-command header small {
        color: #bfdbfe;
        font-size: .74rem;
    }

    .homex-command-grid {
        margin-top: .8rem;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem;
    }

    .homex-mini {
        background: rgba(2, 6, 23, .35);
        border-color: rgba(255, 255, 255, .18);
    }

    .homex-mini .line-chart,
    .homex-mini .bar-chart,
    .homex-mini .radar-chart,
    .homex-mini .africa-map {
        background: linear-gradient(180deg, #ffffff, #f3f7ff);
        border-color: #cfd9ea;
    }

    .homex-mini .bar-chart div,
    .homex-mini .bar-chart span {
        color: #1e293b;
    }

    .homex-mini .bar-chart i {
        background: #cfd8e7;
    }

    .homex-mini h2,
    .homex-skillbars h3 {
        color: #fff;
        font-size: .9rem;
        margin-bottom: .55rem;
    }

    .homex-persona {
        margin-top: .85rem;
        display: flex;
        align-items: center;
        gap: .7rem;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 10px;
        padding: .65rem;
        background: rgba(2, 6, 23, .28);
    }

    .homex-persona .avatar {
        border-color: rgba(255, 255, 255, .3);
        background: linear-gradient(145deg, #94a3b8, #f8fafc);
    }

    .homex-persona strong {
        display: block;
        color: #fff;
    }

    .homex-persona small {
        color: #bfdbfe;
    }

    .homex-skillbars {
        margin-top: .85rem;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 10px;
        padding: .8rem;
        background: rgba(2, 6, 23, .3);
    }

    .homex-skillbars .bar-chart {
        background: linear-gradient(180deg, #ffffff, #f3f7ff);
        border-color: #cfd9ea;
    }

    .homex-skillbars .bar-chart div,
    .homex-skillbars .bar-chart span {
        color: #1e293b;
    }

    .homex-skillbars .bar-chart i {
        background: #cfd8e7;
    }

    .homex-headline {
        margin-bottom: 1.1rem;
    }

    .homex-headline span {
        display: inline-flex;
        text-transform: uppercase;
        font-weight: 900;
        font-size: .75rem;
        letter-spacing: .06em;
        color: var(--green);
    }

    .homex-headline h2 {
        margin: .45rem 0 0;
        color: var(--blue);
        font-size: clamp(1.5rem, 3.2vw, 2.35rem);
    }

    .homex-dual-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .homex-panel {
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        background: #fff;
    }

    .homex-panel.danger {
        background: linear-gradient(180deg, #fff, #fff7ed);
    }

    .homex-panel.success {
        background: linear-gradient(180deg, #fff, #ecfdf5);
    }

    .homex-panel-header span {
        display: inline-flex;
        text-transform: uppercase;
        font-size: .72rem;
        font-weight: 900;
        letter-spacing: .06em;
        color: #475569;
    }

    .homex-panel-header h2 {
        margin: .45rem 0 .85rem;
        color: #0b1f52;
        font-size: 1.25rem;
    }

    .homex-card-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem;
    }

    .homex-item-card {
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: .85rem;
        background: rgba(255, 255, 255, .9);
    }

    .homex-item-card i {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border-radius: 7px;
        margin-bottom: .55rem;
        color: #fff;
        background: linear-gradient(135deg, #0b1d33, #0f9d58);
    }

    .homex-item-card h3 {
        margin: 0 0 .35rem;
        color: #0b1f52;
        font-size: .95rem;
    }

    .homex-item-card p {
        margin: 0;
        color: #475569;
        line-height: 1.5;
        font-size: .84rem;
    }

    .homex-stakeholders {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: .8rem;
    }

    .homex-stake-card {
        border-radius: 10px;
        border-color: #dbe2ea;
        background: #fff;
    }

    .homex-docs {
        background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
    }

    .homex-document-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .9rem;
    }

    .homex-document-card {
        min-height: 190px;
    }

    .homex-impact {
        background:
            radial-gradient(circle at 90% 15%, rgba(229, 138, 0, .16), transparent 26%),
            linear-gradient(140deg, #061428, #0b1d33 58%, #0f2c4f);
    }

    .homex-headline.light span {
        color: #f8fafc;
    }

    .homex-headline.light h2 {
        color: #fff;
    }

    .homex-impact .metric-card {
        background: rgba(255, 255, 255, .08);
        border: 1px solid white;
        border-color: rgba(255, 255, 255, .2);
        box-shadow: none;
    }

    .homex-impact .metric-card strong,
    .homex-impact .metric-card span {
        color: #fff;
    }

    .homex-impact-metrics {
        grid-template-columns: repeat(6, minmax(0, 1fr));
        grid-auto-flow: column;
        max-width: none;
    }

    .homex-partner-card {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .2);
        color: #e2e8f0;
    }

    .homex-partner-card strong {
        color: #fff;
    }

    .homex-partner-heading {
        margin: 1.35rem 0 .9rem;
        color: #f8fafc;
        font-size: .95rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        font-weight: 900;
        position: relative;
        padding: .85rem .35rem 0;
    }

    .homex-partner-heading::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg, #ffffff 0%, #f8b84d 48%, #ffffff 100%);
        background-size: 220% 100%;
        animation: homexPartnerTopLine 2.6s linear infinite;
    }

    .homex-partner-strip {
        margin-top: .55rem;
        padding-top: .35rem;
    }

    .homex-partner-strip .partner-hidden {
        display: none;
    }

    .homex-partner-strip.expanded .partner-hidden {
        display: grid;
    }

    .homex-partner-toggle {
        margin-top: .75rem;
    }

    @keyframes homexPartnerTopLine {
        0% { background-position: 0% 50%; }
        100% { background-position: 220% 50%; }
    }

    @media (max-width: 1120px) {
        .homex-hero-grid,
        .homex-dual-grid,
        .homex-document-grid {
            grid-template-columns: 1fr;
        }

        .homex-stakeholders {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .homex-actions {
            flex-direction: column;
        }

        .homex-actions .btn {
            width: 100%;
        }

        .homex-signals,
        .homex-command-grid,
        .homex-card-grid,
        .homex-stakeholders {
            grid-template-columns: 1fr;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const partnerGrid = document.getElementById('homePartners');
        const toggleButton = document.getElementById('togglePartners');

        if (!partnerGrid || !toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function () {
            const expanded = partnerGrid.classList.toggle('expanded');
            toggleButton.textContent = expanded ? 'Collapse Partners' : 'Expand Partners';
            toggleButton.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
    });
</script>
@endsection
