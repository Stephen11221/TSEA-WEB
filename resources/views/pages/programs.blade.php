@extends('layouts.app')
@section('title', 'Programs - TSEA')

@section('content')
<style>
    .program-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .program-image {
        width: 100%;
        height: 200px; /* Fixed height for all images */
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .program-image i {
        font-size: 3rem; /* No change */
        color: var(--color-primary, #0B1D33); /* Primary Corporate Navy fallback */
    }

    .program-card .btn {
        margin-top: auto;
        align-self: flex-start;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-primary);
        margin: 3rem 0 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--color-border);
    }
</style>
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

        {{-- Available Programs --}}
        <h2 class="section-title">Available Programs</h2>
        <div class="grid three">
            @forelse ($available as $program)
                @include('partials.program-card', ['program' => $program, 'type' => 'available'])
            @empty
                <p style="grid-column: span 3; text-align: center; color: var(--color-text-muted); padding: 2rem;">No programs are currently available for enrollment.</p>
            @endforelse
        </div>

        {{-- Coming Soon Programs --}}
        @if($comingSoon->isNotEmpty())
            <h2 class="section-title" style="color: var(--color-gold);">Coming Soon</h2>
            <div class="grid three">
                @foreach ($comingSoon as $program)
                    @include('partials.program-card', ['program' => $program, 'type' => 'coming_soon'])
                @endforeach
            </div>
        @endif

        {{-- Not Available Programs --}}
        @if($notAvailable->isNotEmpty())
            <h2 class="section-title" style="color: var(--color-text-muted);">Currently Not Available</h2>
            <div class="grid three" style="opacity: 0.7;">
                @foreach ($notAvailable as $program)
                    @include('partials.program-card', ['program' => $program, 'type' => 'unavailable'])
                @endforeach
            </div>
        @endif
    </div>
</section>
<script>
</script>
@endsection
