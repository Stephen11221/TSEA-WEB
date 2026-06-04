@extends('layouts.app')
@section('title', 'Institutions - TSEA')

@section('content')
<section class="page-hero centered"><div class="container"><span class="eyebrow">Institutions</span><h1>Measure Graduate Employability</h1><p>Track outcomes, benchmark readiness and align programs with labour market demand.</p></div></section>
<section class="section">
    <div class="container dashboard-grid">
        @include('partials.metric-card', ['value' => '76%', 'label' => 'Placement Rate'])
        @include('partials.metric-card', ['value' => '74', 'label' => 'ERI™ Average'])
        @include('partials.metric-card', ['value' => '68%', 'label' => 'Graduate Employment'])
        @include('partials.metric-card', ['value' => '82%', 'label' => 'Industry Alignment'])
        <article class="card wide-card"><h2>Outcomes Overview</h2>@include('partials.charts')</article>
        <article class="card"><h2>ERI™ Trend</h2>@include('partials.charts', ['type' => 'bars', 'items' => ['Jan' => 52, 'Feb' => 60, 'Mar' => 67, 'Apr' => 74, 'May' => 78]])</article>
        <article class="card wide-card"><h2>Benefits</h2><div class="grid three tight"><div>Track Outcomes</div><div>Benchmark Performance</div><div>Employer Connections</div></div></article>
    </div>
</section>
@endsection
