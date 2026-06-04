@extends('layouts.app')
@section('title', 'Workforce Passport™ - TSEA')

@section('content')
<section class="page-hero">
    <div class="container split">
        <div>
            <span class="eyebrow">Workforce Passport™</span>
            <h1>Your Workforce Identity</h1>
            <p>One verified profile for identity, skills, credentials, readiness and opportunity across the workforce ecosystem.</p>
            <a class="btn btn-primary" href="{{ route('contact') }}">Create Your Passport</a>
        </div>
        <article class="card passport-profile">
            <div class="profile-row"><span class="avatar large"></span><div><strong>Jane Mwangi</strong><small>Nairobi, Kenya</small></div></div>
            <div class="passport-score">@include('partials.charts', ['type' => 'gauge', 'score' => 82])</div>
        </article>
    </div>
</section>
<section class="section">
    <div class="container dashboard-grid">
        <article class="card wide-card"><h2>Verified Skills</h2>@include('partials.charts', ['type' => 'bars', 'items' => ['Digital Literacy' => 92, 'Communication' => 84, 'Problem Solving' => 78, 'Leadership' => 72, 'Adaptability' => 88]])</article>
        <article class="card"><h2>Credentials</h2><ul class="check-list"><li>National ID verified</li><li>Diploma credential verified</li><li>Digital skills badge issued</li><li>Work experience endorsed</li></ul></article>
        <article class="card"><h2>Readiness Indicators</h2><div class="status-list"><span>Career ready</span><span>Interview ready</span><span>Opportunity matched</span></div></article>
        <article class="card wide-card"><h2>Passport Benefits</h2><div class="grid three tight"><div>Verified Identity</div><div>Verified Skills</div><div>Verified Credentials</div><div>Verified Experience</div><div>Verified Readiness</div><div>Verified Opportunities</div></div></article>
    </div>
</section>
@endsection
