@extends('layouts.app')
@section('title', 'About TSEA - Africa’s Workforce Passport')

@section('content')

<section class="page-hero centered">
    <div class="container">

        <span class="eyebrow">
            {{ $about->hero_label }}
        </span>

        <h1>
            {{ $about->hero_title }}
        </h1>

        <p>
            {{ $about->hero_description }}
        </p>

        <p class="brand-statement large">
            <span>Your Identity</span> |
            <span>Your Opportunity</span> |
            <span>Your Future</span>
        </p>

    </div>
</section>

<section class="section">
    <div class="container grid three">

        <article class="card">
            <h2>{{ $about->mission_title }}</h2>
            <p>{{ $about->mission_description }}</p>
        </article>

        <article class="card">
            <h2>{{ $about->infrastructure_title }}</h2>
            <p>{{ $about->infrastructure_description }}</p>
        </article>

        <article class="card">
            <h2>{{ $about->impact_title }}</h2>
            <p>{{ $about->impact_description }}</p>
        </article>

    </div>
</section>

@endsection