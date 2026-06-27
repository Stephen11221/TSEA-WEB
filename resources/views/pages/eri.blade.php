@extends('layouts.app')

@section('title', 'ERI™ - TSEA')

@section('content')
<section class="eri-hero">
    <div class="container eri-hero-grid">
        <div class="eri-copy">
            <span class="eri-kicker">{{ $eri->hero_eyebrow }}</span>
            <h1>{{ $eri->hero_title }}</h1>
            <p>{{ $eri->hero_description }}</p>
            <div class="eri-actions">
                <a href="{{ route('passport') }}" class="btn btn-gold">Explore Workforce Passport</a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">Request ERI Briefing</a>
            </div>
        </div>

        <aside class="card eri-score-panel">
            <h2>Your ERI™ Score</h2>
            @include('partials.charts', [
                'type' => 'gauge',
                'score' => $eri->eri_score,
                'label' => $eri->score_label
            ])
            <p>{{ $eri->score_message }}</p>
        </aside>
    </div>
</section>

<section class="section eri-board">
    <div class="container eri-grid">
        <article class="card eri-wide">
            <div class="eri-head">
                <h2>Competency Breakdown</h2>
                <span>Live readiness metrics by capability</span>
            </div>
            <div class="metrics-row compact">
                @foreach($eri->competencies ?? [] as $competency)
                    @include('partials.metric-card', [
                        'value' => $competency['value'],
                        'label' => $competency['label']
                    ])
                @endforeach
            </div>
        </article>

        <article class="card">
            <div class="eri-head">
                <h2>Top Recommendations</h2>
                <span>Priority actions to improve score</span>
            </div>
            <ul class="check-list">
                @foreach($eri->recommendations ?? [] as $recommendation)
                    <li>{{ $recommendation }}</li>
                @endforeach
            </ul>
        </article>

        <article class="card">
            <div class="eri-head">
                <h2>Readiness Trend</h2>
                <span>Progress trajectory over recent cycles</span>
            </div>
            @include('partials.charts')
        </article>
    </div>
</section>

<style>
    .eri-hero {
        background:
            radial-gradient(circle at 18% 20%, rgba(0, 141, 59, .14), transparent 32%),
            radial-gradient(circle at 78% 16%, rgba(229, 138, 0, .17), transparent 30%),
            linear-gradient(140deg, #051427, #0b1d33 58%, #10315a);
        color: #fff;
        padding: clamp(2.4rem, 6vw, 4.8rem) 0;
    }

    .eri-hero-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 1rem;
        align-items: center;
    }

    .eri-kicker {
        display: inline-flex;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-size: .76rem;
        font-weight: 900;
        color: #fbbf24;
    }

    .eri-copy h1 {
        margin: .62rem 0 1rem;
        color: #fff;
        font-size: clamp(2rem, 4.8vw, 3.8rem);
        line-height: 1.03;
        max-width: 14ch;
    }

    .eri-copy p {
        margin: 0;
        color: #dbeafe;
        line-height: 1.7;
        font-weight: 600;
        max-width: 62ch;
    }

    .eri-actions {
        margin-top: 1.2rem;
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
    }

    .eri-actions .btn-secondary {
        color: #fff;
        border-color: rgba(255, 255, 255, .34);
        background: rgba(255, 255, 255, .08);
    }

    .eri-score-panel {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .2);
        backdrop-filter: blur(10px);
    }

    .eri-score-panel h2 { color: #fff; }
    .eri-score-panel p { color: #e2e8f0; }

    .eri-board {
        background: #f8fafc;
    }

    .eri-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
    }

    .eri-wide { grid-column: span 2; }

    .eri-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: .8rem;
        margin-bottom: .8rem;
    }

    .eri-head h2 {
        margin: 0;
        color: #0b1f52;
    }

    .eri-head span {
        color: #64748b;
        font-size: .76rem;
        font-weight: 700;
    }

    @media (max-width: 980px) {
        .eri-hero-grid,
        .eri-grid {
            grid-template-columns: 1fr;
        }

        .eri-wide {
            grid-column: auto;
        }
    }

    @media (max-width: 760px) {
        .eri-actions .btn {
            width: 100%;
        }

        .eri-head {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

@endsection