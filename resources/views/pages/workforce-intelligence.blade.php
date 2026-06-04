@extends('layouts.app')
@section('title', 'Workforce Intelligence™ - TSEA')

@section('content')
<section class="page-hero"><div class="container split"><div><span class="eyebrow">Workforce Intelligence™</span><h1>Labour Market Dashboards for Africa</h1><p>Use workforce evidence, demand signals and readiness analytics to guide decisions.</p></div><div class="card">@include('partials.charts', ['type' => 'heatmap'])</div></div></section>
<section class="section">
    <div class="container dashboard-grid">
        @include('partials.metric-card', ['value' => '68%', 'label' => 'Graduate Employment'])
        @include('partials.metric-card', ['value' => '78', 'label' => 'Skills Demand Index'])
        @include('partials.metric-card', ['value' => '65', 'label' => 'Sector Readiness'])
        @include('partials.metric-card', ['value' => '82', 'label' => 'Regional Opportunity'])
        <article class="card wide-card"><h2>Skills Demand Heat Map</h2>@include('partials.charts', ['type' => 'heatmap'])</article>
        <article class="card wide-card"><h2>Skills Demand Trend</h2>@include('partials.charts')</article>
        <article class="card"><h2>Top In-Demand Skills</h2>@include('partials.charts', ['type' => 'bars', 'items' => ['Digital Literacy' => 92, 'Data Analysis' => 82, 'Cybersecurity' => 71, 'Communication' => 78]])</article>
    </div>
</section>
@endsection
