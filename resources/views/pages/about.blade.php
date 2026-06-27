@extends('layouts.app')

@section('title', 'About TSEA - Africa’s Workforce Passport')

@section('content')
<section class="abt-hero">
    <div class="container abt-hero-grid">
        <div class="abt-copy">
            <span class="abt-kicker">{{ $about->hero_label }}</span>
            <h1>{{ $about->hero_title }}</h1>
            <p>{{ $about->hero_description }}</p>
            <p class="abt-slogan">
                <span>Your Identity</span>
                <span>Your Opportunity</span>
                <span>Your Future</span>
            </p>
        </div>
        <aside class="card abt-hero-card">
            <h2>TSEA Infrastructure</h2>
            <ul>
                <li><i class="fas fa-id-card"></i> Workforce Passport™</li>
                <li><i class="fas fa-chart-line"></i> ERI™ Readiness Index</li>
                <li><i class="fas fa-users"></i> Verified Talent Marketplace</li>
                <li><i class="fas fa-database"></i> Workforce Intelligence™</li>
            </ul>
        </aside>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="abt-head">
            <span>Mission</span>
            <h2>Why TSEA Exists</h2>
        </div>
        <div class="abt-grid one">
            @foreach($missionCards as $card)
                <article class="card abt-card">
                    <h3>{{ $card['title'] }}</h3>
                    <p>{{ $card['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section abt-alt">
    <div class="container">
        <div class="abt-head">
            <span>Core System</span>
            <h2>Built As Workforce Infrastructure</h2>
        </div>
        <div class="abt-grid three">
            @foreach($infraCards as $card)
                <article class="card abt-card abt-card-icon">
                    <i class="fas fa-cubes"></i>
                    <h3>{{ $card['title'] }}</h3>
                    <p>{{ $card['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="abt-head">
            <span>Impact</span>
            <h2>Measurable Change Across The Ecosystem</h2>
        </div>
        <div class="abt-grid three">
            @foreach($impactCards as $card)
                <article class="card abt-card">
                    <h3>{{ $card['title'] }}</h3>
                    <p>{{ $card['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<style>
    .abt-hero {
        background:
            radial-gradient(circle at 18% 20%, rgba(229, 138, 0, .16), transparent 32%),
            radial-gradient(circle at 78% 22%, rgba(0, 141, 59, .14), transparent 30%),
            linear-gradient(140deg, #061428, #0b1d33 58%, #10315a);
        color: #fff;
        padding: clamp(2.4rem, 6vw, 4.8rem) 0;
    }

    .abt-hero-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 1rem;
        align-items: center;
    }

    .abt-kicker {
        display: inline-flex;
        font-size: .76rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #fbbf24;
        font-weight: 900;
    }

    .abt-copy h1 {
        margin: .65rem 0 1rem;
        color: #fff;
        font-size: clamp(2rem, 4.8vw, 3.8rem);
        line-height: 1.03;
        max-width: 14ch;
    }

    .abt-copy p {
        margin: 0;
        color: #dbeafe;
        line-height: 1.7;
        font-weight: 600;
        max-width: 62ch;
    }

    .abt-slogan {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: .55rem;
    }

    .abt-slogan span {
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 999px;
        padding: .34rem .7rem;
        font-size: .74rem;
        font-weight: 800;
        background: rgba(2, 6, 23, .34);
    }

    .abt-hero-card {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .2);
        backdrop-filter: blur(10px);
    }

    .abt-hero-card h2 {
        margin: 0 0 .8rem;
        color: #fff;
        font-size: 1.05rem;
    }

    .abt-hero-card ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: .55rem;
    }

    .abt-hero-card li {
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: .5rem;
        font-weight: 700;
        font-size: .86rem;
    }

    .abt-hero-card i { color: #fbbf24; }

    .abt-head {
        margin-bottom: 1rem;
    }

    .abt-head span {
        display: inline-flex;
        text-transform: uppercase;
        font-size: .75rem;
        letter-spacing: .06em;
        font-weight: 900;
        color: #0f9d58;
    }

    .abt-head h2 {
        margin: .45rem 0 0;
        color: #0b1f52;
        font-size: clamp(1.45rem, 3vw, 2.3rem);
    }

    .abt-grid {
        display: grid;
        gap: .9rem;
    }

    .abt-grid.one { grid-template-columns: 1fr; }
    .abt-grid.three { grid-template-columns: repeat(3, minmax(0, 1fr)); }

    .abt-card {
        border-radius: 10px;
        border: 1px solid #d5deea;
    }

    .abt-card h3 {
        margin: 0 0 .45rem;
        color: #0b1f52;
        font-size: 1rem;
    }

    .abt-card p {
        margin: 0;
        color: #475569;
        line-height: 1.62;
        font-size: .9rem;
    }

    .abt-card-icon i {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        margin-bottom: .65rem;
        color: #fff;
        background: linear-gradient(135deg, #0b1d33, #0f9d58);
    }

    .abt-alt {
        background: #f8fafc;
    }

    @media (max-width: 980px) {
        .abt-hero-grid,
        .abt-grid.three {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection