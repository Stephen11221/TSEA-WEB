@extends('layouts.app')

@section('title', 'TSEA - Africa’s Workforce Passport')
@section('description', 'Africa’s Workforce Passport for Skills, Identity and Opportunity.')

@section('content')
@php
    $homepageContent = $homepageContent ?? \App\Models\Homepage::defaults();
    $hero = [
        'eyebrow' => $homepage->hero_eyebrow ?? 'Taifa Skills & Employability Academy',
        'title' => $homepage->hero_title ?? 'Africa’s Workforce Passport for Skills, Identity & Opportunity',
        'description' => $homepage->hero_description ?? 'Building Africa’s most trusted workforce infrastructure for learners, employers, institutions and governments.',
        'primary_text' => $homepage->primary_button_text ?? 'Create Workforce Passport',
        'primary_link' => $homepage->primary_button_link ?? route('passport.create'),
        'secondary_text' => $homepage->secondary_button_text ?? 'Partner With TSEA',
        'secondary_link' => $homepage->secondary_button_link ?? route('contact'),
    ];
@endphp

<section class="hero">
    <div class="container hero-grid">

        <div class="hero-copy">

            <span class="eyebrow">
                {{ $hero['eyebrow'] }}
            </span>

            <h1>
                {{ $hero['title'] }}
            </h1>

            <p>
                {{ $hero['description'] }}
            </p>

            <div class="hero-actions">
                <a class="btn btn-primary" href="{{ $hero['primary_link'] }}">
                    {{ $hero['primary_text'] }}
                </a>

                <a class="btn btn-secondary" href="{{ $hero['secondary_link'] }}">
                    {{ $hero['secondary_text'] }}
                </a>
            </div>

        </div>

        <div class="dashboard-preview" aria-label="TSEA dashboard preview">

            <article class="card score-card">
                <h2>{{ $homepageContent['dashboard']['score_title'] }}</h2>
                @include('partials.charts', ['type' => 'gauge', 'score' => $homepageContent['dashboard']['score']])
            </article>

            <article class="card passport-card">
                <h2>{{ $homepageContent['dashboard']['passport_title'] }}</h2>

                <div class="profile-row">
                    <span class="avatar"></span>
                    <div>
                        <strong>{{ $homepageContent['dashboard']['profile_name'] }}</strong>
                        <small>{{ $homepageContent['dashboard']['profile_caption'] }}</small>
                    </div>
                </div>

                <div class="mini-metrics">
                    <span><strong>{{ $homepageContent['dashboard']['skills_count'] }}</strong> {{ $homepageContent['dashboard']['skills_label'] }}</span>
                    <span><strong>{{ $homepageContent['dashboard']['matches_count'] }}</strong> {{ $homepageContent['dashboard']['matches_label'] }}</span>
                    <span><strong>{{ $homepageContent['dashboard']['applications_count'] }}</strong> {{ $homepageContent['dashboard']['applications_label'] }}</span>
                </div>
            </article>

            <article class="card wide-card">
                <h2>{{ $homepageContent['dashboard']['insights_title'] }}</h2>
                @include('partials.charts')
            </article>

            <article class="card">
                <h2>{{ $homepageContent['dashboard']['top_skills_title'] }}</h2>
                @include('partials.charts', ['type' => 'bars'])
            </article>

        </div>

    </div>
</section>

<section class="section">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => $homepageContent['problem']['eyebrow'], 'title' => $homepageContent['problem']['title']])
        <div class="grid four">
            @foreach ($homepageContent['problem']['items'] as $item)
                <article class="card problem-card"><div class="icon-dot"><i class="fas {{ $item['icon'] }}" aria-hidden="true"></i></div><h3>{{ $item['title'] }}</h3><p>{{ $item['copy'] }}</p></article>
            @endforeach
        </div>
    </div>
</section>

@if (collect($homepageContent['documents']['items'])->contains(fn ($document) => ! empty($document['path'])))
<section class="section">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => $homepageContent['documents']['eyebrow'], 'title' => $homepageContent['documents']['title']])
        <div class="grid three">
            @foreach ($homepageContent['documents']['items'] as $document)
                @if (! empty($document['path']))
                    <article class="card document-card">
                        <i class="fas fa-file-lines" aria-hidden="true"></i>
                        <h3>{{ $document['title'] ?: ($document['original_name'] ?: 'Homepage document') }}</h3>
                        @if (! empty($document['description']))
                            <p>{{ $document['description'] }}</p>
                        @endif
                        <a class="text-link" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($document['path']) }}" target="_blank" rel="noopener">
                            View document
                        </a>
                    </article>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section alt">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => $homepageContent['solution']['eyebrow'], 'title' => $homepageContent['solution']['title']])
        <div class="grid four">
            @foreach ($homepageContent['solution']['items'] as $item)
                <article class="card solution-card"><span class="solution-icon"><i class="fas {{ $item['icon'] }}" aria-hidden="true"></i></span><h3>{{ $item['title'] }}</h3><p>{{ $item['copy'] }}</p></article>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => $homepageContent['stakeholders']['eyebrow'], 'title' => $homepageContent['stakeholders']['title']])
        <div class="grid five">
            @foreach ($homepageContent['stakeholders']['items'] as $item)
                <article class="compact-card"><i class="fas {{ $item['icon'] }}" aria-hidden="true"></i><strong>{{ $item['title'] }}</strong><span>{{ $item['copy'] }}</span></article>
            @endforeach
        </div>
    </div>
</section>

<section class="section alt">
    <div class="container">
        @include('partials.section-header', ['eyebrow' => $homepageContent['impact']['eyebrow'], 'title' => $homepageContent['impact']['title']])
        <div class="metrics-row">
            @foreach ($homepageContent['impact']['metrics'] as $metric)
                @include('partials.metric-card', ['value' => $metric['value'], 'label' => $metric['label']])
            @endforeach
        </div>
        <div class="partner-strip" aria-label="Trusted partners">
            @foreach ($homepageContent['impact']['partners'] as $partner)
                <article class="partner-logo-card">
                    @if (! empty($partner['logo']))
                        <img src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }} logo">
                    @else
                        <span>{{ $partner['name'] }}</span>
                    @endif
                    @if (! empty($partner['name']))
                        <strong>{{ $partner['name'] }}</strong>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
