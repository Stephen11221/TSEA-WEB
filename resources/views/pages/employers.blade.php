@extends('layouts.app')
@section('title', 'Employers - TSEA')

@section('content')
<section class="page-hero"><div class="container split"><div><span class="eyebrow">Employers</span><h1>Discover Verified Talent</h1><p>Search ready candidates with verified identities, skills, ERI™ scores and opportunity fit.</p></div><div class="card">@include('partials.charts', ['type' => 'bars', 'items' => ['Software Support' => 84, 'Data Analysis' => 79, 'Sales Operations' => 72, 'Project Delivery' => 81]])</div></div></section>
<section class="section">
    <div class="container">
        <form class="filter-bar" aria-label="Talent filters"><input type="search" placeholder="Keywords"><select><option>Skills</option></select><select><option>Location</option></select><select><option>ERI™ Score</option></select><button class="btn btn-primary btn-sm">Search</button></form>
        <div class="grid three">
            @foreach ([['John Emoru', 'Full Stack Developer', 84], ['Amina Hassan', 'Data Analyst', 79], ['David Kiplagat', 'Project Manager', 81]] as [$name, $role, $score])
                <article class="card candidate-card"><div class="profile-row"><span class="avatar"></span><div><strong>{{ $name }}</strong><small>{{ $role }}</small></div></div><span class="score-pill">ERI™ {{ $score }}</span>@include('partials.charts', ['type' => 'bars', 'items' => ['Skills match' => $score, 'Experience' => $score - 8]])</article>
            @endforeach
        </div>
    </div>
</section>
@endsection
