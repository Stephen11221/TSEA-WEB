@extends('layouts.app')

@section('title', 'ERI™ - TSEA')

@section('content')

<section class="page-hero centered">
    <div class="container">
        <span class="eyebrow">{{ $eri->hero_eyebrow }}</span>

        <h1>{{ $eri->hero_title }}</h1>

        <p>{{ $eri->hero_description }}</p>
    </div>
</section>

<section class="section">
    <div class="container dashboard-grid">

        <article class="card score-card">
            <h2>Your ERI™ Score</h2>

            @include('partials.charts', [
                'type' => 'gauge',
                'score' => $eri->eri_score,
                'label' => $eri->score_label
            ])

            <p>{{ $eri->score_message }}</p>
        </article>

        <article class="card wide-card">
            <h2>Competency Breakdown</h2>

            <div class="metrics-row compact">

                @foreach($eri->competencies ?? [] as $competency)

                    @include('partials.metric-card', [
                        'value' => $competency['value'],
                        'label' => $competency['label']
                    ])

                @endforeach

            </div>
        </article>

        <article class="card">
            <h2>Top Recommendations</h2>

            <ul class="check-list">

                @foreach($eri->recommendations ?? [] as $recommendation)
                    <li>{{ $recommendation }}</li>
                @endforeach

            </ul>

        </article>

    </div>
</section>

@endsection