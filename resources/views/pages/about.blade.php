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

{{-- Mission Section --}}
<section class="section">
    <div class="container grid one">

        @foreach($missionCards as $card)
            <article class="card">
                <h2>{{ $card['title'] }}</h2>
                <p>{{ $card['text'] }}</p>
            </article>
        @endforeach

    </div>
</section>

{{-- Infrastructure Section --}}
<section class="section">
    <div class="container grid three">

        @foreach($infraCards as $card)
            <article class="card">
                <h2>{{ $card['title'] }}</h2>
                <p>{{ $card['text'] }}</p>
            </article>
        @endforeach

    </div>
</section>

{{-- Impact Section --}}
<section class="section">
    <div class="container grid three">

        @foreach($impactCards as $card)
            <article class="card">
                <h2>{{ $card['title'] }}</h2>
                <p>{{ $card['text'] }}</p>
            </article>
        @endforeach

    </div>
</section>

@endsection