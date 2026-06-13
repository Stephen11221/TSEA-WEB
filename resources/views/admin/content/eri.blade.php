@extends('admin.layouts.admin')

@section('content')
<div class="container py-4">

    <h2>ERI Dashboard Editor</h2>

    <form method="POST" action="{{ route('admin.content.eri.update') }}">
        @csrf

        <div class="card p-3 mb-3">
            <h5>Hero Section</h5>

            <input class="form-control mb-2" name="hero_eyebrow"
                   value="{{ $eri->hero_eyebrow }}" placeholder="Eyebrow">

            <input class="form-control mb-2" name="hero_title"
                   value="{{ $eri->hero_title }}" placeholder="Title">

            <textarea class="form-control" name="hero_description">
                {{ $eri->hero_description }}
            </textarea>
        </div>

        <div class="card p-3 mb-3">
            <h5>Score</h5>

            <input type="number" class="form-control mb-2"
                   name="eri_score" value="{{ $eri->eri_score }}">

            <input class="form-control mb-2"
                   name="score_label" value="{{ $eri->score_label }}">

            <textarea class="form-control"
                      name="score_message">{{ $eri->score_message }}</textarea>
        </div>

        <div class="card p-3 mb-3">
            <h5>Competencies (JSON)</h5>
            <textarea class="form-control" name="competencies">{{ json_encode($eri->competencies, JSON_PRETTY_PRINT) }}</textarea>
        </div>

        <div class="card p-3 mb-3">
            <h5>Recommendations (JSON)</h5>
            <textarea class="form-control" name="recommendations">{{ json_encode($eri->recommendations, JSON_PRETTY_PRINT) }}</textarea>
        </div>

        <button class="btn btn-primary">Update ERI Page</button>
    </form>

</div>
@endsection