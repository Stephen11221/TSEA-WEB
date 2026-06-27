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
        ->map(fn ($items, $category) => [
            'name' => $category,
            'share' => round(($items->count() / max(1, $activePrograms->count())) * 100, 1),
        ])
        ->sortByDesc('share')
        ->values();

    $passportScore = (float) ($categoryShares->avg('share') ?: 80.0);
    $skillItems = $categoryShares->take(5)->mapWithKeys(fn ($row) => [$row['name'] => $row['share']])->toArray();

    if (empty($skillItems)) {
        $skillItems = [
            'Technology' => 90.0,
            'Commercial' => 85.0,
            'Digital Economy' => 80.0,
            'Professional' => 75.0,
            'General' => 70.0,
        ];
    }
@endphp
<section class="wfp-lite-hero">
    <div class="container split">
        <div>
            <span class="eyebrow">Workforce Passport™</span>
            <h1>Your Workforce Identity</h1>
            <p>One verified profile for identity, skills, credentials, readiness and opportunity across the workforce ecosystem.</p>
            <a class="btn btn-gold" href="{{ route('contact') }}">Create Your Passport</a>
        </div>
        <article class="card passport-profile wfp-lite-card">
            <div class="profile-row"><span class="avatar large"></span><div><strong>Jane Mwangi</strong><small>Nairobi, Kenya</small></div></div>
            <div class="passport-score">@include('partials.charts', ['type' => 'gauge', 'score' => round($passportScore, 1)])</div>
        </article>
    </div>
</section>

<section class="section wfp-lite-board">
    <div class="container dashboard-grid">
        <article class="card wide-card"><h2>Verified Skills</h2>@include('partials.charts', ['type' => 'bars', 'items' => $skillItems])</article>
        <article class="card"><h2>Credentials</h2><ul class="check-list"><li>National ID verified</li><li>Diploma credential verified</li><li>Digital skills badge issued</li><li>Work experience endorsed</li></ul></article>
        <article class="card"><h2>Readiness Indicators</h2><div class="status-list"><span>Career ready</span><span>Interview ready</span><span>Opportunity matched</span></div></article>
        <article class="card wide-card"><h2>Passport Benefits</h2><div class="grid three tight"><div>Verified Identity</div><div>Verified Skills</div><div>Verified Credentials</div><div>Verified Experience</div><div>Verified Readiness</div><div>Verified Opportunities</div></div></article>
    </div>
</section>

<style>
    .wfp-lite-hero {
        background:
            radial-gradient(circle at 18% 20%, rgba(229, 138, 0, .16), transparent 32%),
            radial-gradient(circle at 80% 18%, rgba(0, 141, 59, .14), transparent 30%),
            linear-gradient(140deg, #061428, #0b1d33 58%, #10315a);
        color: #fff;
        padding: clamp(2.3rem, 5.8vw, 4.6rem) 0;
    }

    .wfp-lite-hero h1,
    .wfp-lite-hero p {
        color: #fff;
    }

    .wfp-lite-hero p {
        color: #dbeafe;
    }

    .wfp-lite-card {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .2);
        backdrop-filter: blur(10px);
    }

    .wfp-lite-card strong,
    .wfp-lite-card small {
        color: #fff;
    }

    .wfp-lite-board {
        background: #f8fafc;
    }
</style>
@endsection
