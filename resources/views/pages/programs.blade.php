@extends('layouts.app')
@section('title', 'Programs - TSEA')

@section('content')
<section class="page-hero centered"><div class="container"><span class="eyebrow">{{ $page->hero_label }}</span><h1>{{ $page->hero_title }}</h1><p>{{ $page->hero_description }}</p></div></section>
<section class="section">
    <div class="container">
        <form class="filter-bar" action="{{ route('programs') }}" method="GET" aria-label="Program filters">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search programs...">
            <select name="category">
                <option value="">All Categories</option>
                @foreach(['Digital Skills', 'Leadership', 'Entrepreneurship', 'Career Readiness', 'Future Skills', 'Executive Programs'] as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <select name="level">
                <option value="">All Levels</option>
                <option value="Beginner" {{ request('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                <option value="Advanced" {{ request('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
        </form>
        <div class="grid three">
            @foreach ($programs as $program)
                <article class="card program-card">
                    <div class="program-image">
                        @if(!empty($program->image))
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                        @else
                            <i class="fas {{ $program->icon ?? 'fa-graduation-cap' }}" aria-hidden="true"></i>
                        @endif
                    </div>
                    <h2>{{ $program->title }}</h2>
                    <p>{{ $program->description }}</p>
                    <a class="text-link" href="{{ route('contact') }}">View Program</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
