@extends('layouts.app')
@section('title', 'Programs - TSEA')

@section('content')
<section class="page-hero centered"><div class="container"><span class="eyebrow">Programs</span><h1>Workforce Programs</h1><p>Discover readiness, digital skills, leadership and entrepreneurship programs aligned to market demand.</p></div></section>
<section class="section">
    <div class="container">
        <form class="filter-bar" aria-label="Program filters"><input type="search" placeholder="Search programs..."><select><option>All Categories</option><option>Digital Skills</option><option>Leadership</option></select><select><option>All Levels</option><option>Beginner</option><option>Advanced</option></select><button class="btn btn-primary btn-sm">Search</button></form>
        <div class="grid three">
            @foreach ([['Career Readiness', 'Build interview confidence, CV quality and workplace behaviours.', 'fa-user-tie'], ['Digital Skills', 'Gain practical tools for modern work and AI-enabled productivity.', 'fa-laptop-code'], ['Future Skills', 'Develop problem solving, adaptability and communication.', 'fa-lightbulb'], ['Leadership', 'Prepare for team contribution and professional growth.', 'fa-chess-king'], ['Entrepreneurship', 'Validate ideas, business models and market pathways.', 'fa-rocket'], ['Executive Programs', 'Institution and employer workforce transformation tracks.', 'fa-chart-pie']] as [$title, $copy, $icon])
                <article class="card program-card"><div class="program-image"><i class="fas {{ $icon }}" aria-hidden="true"></i></div><h2>{{ $title }}</h2><p>{{ $copy }}</p><a class="text-link" href="{{ route('contact') }}">View Program</a></article>
            @endforeach
        </div>
    </div>
</section>
@endsection
