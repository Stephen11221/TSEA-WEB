@extends('layouts.app')
@section('title', 'Workforce Passport™ - TSEA')

@section('content')
<section class="page-hero">
    <div class="container split">
        <div>
            <span class="eyebrow">{{ $passport->hero_label }}</span>
            <h1>{{ $passport->hero_title }}</h1>
            <p>{{ $passport->hero_description }}</p>
            <a class="btn btn-primary" href="{{ route('contact') }}">{{ $passport->cta_text }}</a>
        </div>
        <article class="card passport-profile">
            <div class="profile-row"><span class="avatar large"></span><div><strong>{{ $passport->profile_name ?? 'Jane Mwangi' }}</strong><small>{{ $passport->profile_location ?? 'Nairobi, Kenya' }}</small></div></div>
            <div class="passport-score">@include('partials.charts', ['type' => 'gauge', 'score' => $passport->passport_score ?? 82])</div>
        </article>
    </div>
</section>
<section class="section">
    <div class="container dashboard-grid">
        @php
            $skills = [];
            for ($i = 1; $i <= 5; $i++) {
                $name = $passport->{'skill_name_'.$i} ?: ['Digital Literacy', 'Communication', 'Problem Solving', 'Leadership', 'Adaptability'][$i - 1];
                $skills[$name] = $passport->{'skill_score_'.$i} ?: [92, 84, 78, 72, 88][$i - 1];
            }
        @endphp
        <article class="card wide-card"><h2>Verified Skills</h2>@include('partials.charts', ['type' => 'bars', 'items' => $skills])</article>
        <article class="card"><h2>Credentials</h2><ul class="check-list">@for($i = 1; $i <= 4; $i++)<li>{{ $passport->{'credential_'.$i} ?: ['National ID verified', 'Diploma credential verified', 'Digital skills badge issued', 'Work experience endorsed'][$i - 1] }}</li>@endfor</ul></article>
        <article class="card"><h2>Readiness Indicators</h2><div class="status-list">@for($i = 1; $i <= 3; $i++)<span>{{ $passport->{'readiness_'.$i} ?: ['Career ready', 'Interview ready', 'Opportunity matched'][$i - 1] }}</span>@endfor</div></article>
        <article class="card wide-card"><h2>Passport Benefits</h2><div class="grid three tight">@for($i = 1; $i <= 6; $i++)<div>{{ $passport->{'benefit_'.$i} ?: ['Verified Identity', 'Verified Skills', 'Verified Credentials', 'Verified Experience', 'Verified Readiness', 'Verified Opportunities'][$i - 1] }}</div>@endfor</div></article>
    </div>
</section>
@endsection
