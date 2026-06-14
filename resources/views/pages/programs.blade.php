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
        font-size: 3rem;
        color: var(--color-primary, #0F4C81);
    }

    .program-card .btn {
        margin-top: auto;
        align-self: flex-start;
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
        <div class="grid three">
            @foreach ($programs as $program)
                <article class="card program-card">
                    <div class="program-image">
                        @if(!empty($program->image))
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas {{ $program->icon ?? 'fa-graduation-cap' }}" aria-hidden="true"></i>
                        @endif
                    </div>
                    <h2>{{ $program->title }}</h2>
                    <div class="description-container">
                        <p class="description-short">{{ \Illuminate\Support\Str::words($program->description, 12) }}</p>
                        <p class="description-full" style="display: none;">{{ $program->description }}</p>
                    </div>
                    @if(strlen($program->description) > strlen(\Illuminate\Support\Str::words($program->description, 12)))
                        <button class="btn btn-primary read-more-toggle">Read More</button>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.read-more-toggle');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const currentCard = this.closest('.program-card');
            const shortText = currentCard.querySelector('.description-short');
            const fullText = currentCard.querySelector('.description-full');
            const isCurrentlyExpanded = fullText.style.display === 'block';

            // Collapse any other expanded cards before expanding this one
            if (!isCurrentlyExpanded) {
                buttons.forEach(otherButton => {
                    const otherCard = otherButton.closest('.program-card');
                    if (otherCard !== currentCard) {
                        otherCard.querySelector('.description-full').style.display = 'none';
                        otherCard.querySelector('.description-short').style.display = 'block';
                        otherButton.textContent = 'Read More';
                    }
                });
            }

            fullText.style.display = isCurrentlyExpanded ? 'none' : 'block';
            shortText.style.display = isCurrentlyExpanded ? 'block' : 'none';
            this.textContent = isCurrentlyExpanded ? 'Read More' : 'Read Less';
        });
    });
});
</script>
@endsection
