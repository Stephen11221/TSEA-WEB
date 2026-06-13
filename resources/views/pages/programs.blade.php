@extends('layouts.app')
@section('title', 'Programs - TSEA')

@section('content')
<section class="page-hero centered"><div class="container"><span class="eyebrow">{{ $page->hero_label }}</span><h1>{{ $page->hero_title }}</h1><p>{{ $page->hero_description }}</p></div></section>
<section class="section">
    <div class="container">
        <form class="filter-bar" aria-label="Program filters"><input type="search" placeholder="Search programs..."><select><option>All Categories</option><option>Digital Skills</option><option>Leadership</option></select><select><option>All Levels</option><option>Beginner</option><option>Advanced</option></select><button class="btn btn-primary btn-sm">Search</button></form>
        <div class="grid three">
            @foreach ($programs as $program)
                <article class="card program-card"><div class="program-image"><i class="fas {{ $program->icon ?? 'fa-graduation-cap' }}" aria-hidden="true"></i></div><h2>{{ $program->title }}</h2><p>{{ $program->description }}</p><a class="text-link" href="{{ route('contact') }}">View Program</a></article>
            @endforeach
        </div>
    </div>
</section>
@endsection
