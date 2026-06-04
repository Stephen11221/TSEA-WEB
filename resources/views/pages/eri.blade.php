@extends('layouts.app')
@section('title', 'ERI™ - TSEA')

@section('content')
<section class="page-hero centered">
    <div class="container">
        <span class="eyebrow">Employability Readiness Index</span>
        <h1>Measure Workforce Readiness</h1>
        <p>Benchmark learner readiness across competencies, career behaviours and opportunity alignment.</p>
    </div>
</section>
<section class="section">
    <div class="container dashboard-grid">
        <article class="card score-card"><h2>Your ERI™ Score</h2>@include('partials.charts', ['type' => 'gauge', 'score' => 82, 'label' => 'Above Average'])<p>You are ready for greater opportunities.</p></article>
        <article class="card wide-card"><h2>Competency Radar</h2>@include('partials.charts', ['type' => 'radar'])</article>
        <article class="card wide-card"><h2>Competency Breakdown</h2><div class="metrics-row compact">@include('partials.metric-card', ['value' => '75', 'label' => 'Communication']) @include('partials.metric-card', ['value' => '80', 'label' => 'Problem Solving']) @include('partials.metric-card', ['value' => '85', 'label' => 'Digital Literacy']) @include('partials.metric-card', ['value' => '78', 'label' => 'Professionalism'])</div></article>
        <article class="card"><h2>Top Recommendations</h2><ul class="check-list"><li>Improve leadership skills to increase readiness score.</li><li>Enroll in advanced communication program.</li><li>Complete a verified portfolio project.</li></ul></article>
    </div>
</section>
@endsection
