@extends('admin.layouts.admin')

@section('title', 'Edit Institution Page')

@section('content')
@php
    $benefits = old('benefits', implode("\n", $institution->benefits ?? []));
    $metrics = old('metrics', $institution->metrics ?? []);
    $trendItems = old('trend_items', $institution->trend_items ?? []);
    $institutionRows = old('institutions', $institution->institutions ?? []);
@endphp

<style>
    .content-editor {
        display: grid;
        gap: 20px;
    }

    .editor-card {
        background: #ffffff;
        border: 1px solid var(--color-border);
        border-radius: 8px;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .form-field {
        display: grid;
        gap: 6px;
        margin-bottom: 16px;
    }

    .form-field label {
        font-size: 13px;
        font-weight: 700;
        color: var(--color-text-muted);
    }

    .form-field input,
    .form-field select,
    .form-field textarea {
        width: 100%;
        border: 1px solid var(--color-border);
        border-radius: 6px;
        padding: 10px 12px;
        font: inherit;
    }

    .alert {
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 18px;
    }

    .alert-success {
        background: rgba(0, 179, 89, 0.12);
        color: #08763f;
        border: 1px solid rgba(0, 179, 89, 0.24);
    }

    .alert-error {
        background: rgba(255, 51, 51, 0.1);
        color: #a42626;
        border: 1px solid rgba(255, 51, 51, 0.2);
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Institution Page</h1>
        <p class="page-subtitle">Update the public Institutions page directory, metrics, trend and benefits.</p>
    </div>
    <div class="btn-group">
        <form method="POST" action="{{ route('admin.content.institutions.restore') }}" onsubmit="return confirm('Restore the institution page defaults?')">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-rotate-left"></i>
                Restore Content
            </button>
        </form>
        <a href="{{ route('institutions') }}" class="btn btn-secondary">
            <i class="fas fa-eye"></i>
            View Institution Page
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-error">Please check the institution page fields and try again.</div>
@endif

<form method="POST" action="{{ route('admin.content.institutions.update') }}" class="content-editor">
    @csrf

    <section class="editor-card">
        <h2>Hero</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="hero_label">Hero Label</label>
                <input id="hero_label" name="hero_label" value="{{ old('hero_label', $institution->hero_label) }}">
            </div>
            <div class="form-field">
                <label for="hero_title">Hero Title</label>
                <input id="hero_title" name="hero_title" value="{{ old('hero_title', $institution->hero_title) }}" required>
            </div>
        </div>
        <div class="form-field">
            <label for="hero_description">Hero Description</label>
            <textarea id="hero_description" name="hero_description" rows="4">{{ old('hero_description', $institution->hero_description) }}</textarea>
        </div>
    </section>

    <section class="editor-card">
        <h2>Institution Directory</h2>
        @foreach($institutionRows as $index => $row)
            <div class="editor-card" style="box-shadow:none; margin-top:16px;">
                <h3>{{ $row['name'] ?? 'Institution' }}</h3>
                <div class="form-grid">
                    <div class="form-field">
                        <label for="institution_name_{{ $index }}">Name</label>
                        <input id="institution_name_{{ $index }}" name="institutions[{{ $index }}][name]" value="{{ $row['name'] ?? '' }}">
                    </div>
                    <div class="form-field">
                        <label for="institution_category_{{ $index }}">Category</label>
                        <input id="institution_category_{{ $index }}" name="institutions[{{ $index }}][category]" value="{{ $row['category'] ?? '' }}">
                    </div>
                    <div class="form-field">
                        <label for="institution_accent_{{ $index }}">Accent</label>
                        <select id="institution_accent_{{ $index }}" name="institutions[{{ $index }}][accent]">
                            @foreach(['blue', 'green', 'purple', 'gold', 'red'] as $accent)
                                <option value="{{ $accent }}" @selected(($row['accent'] ?? 'blue') === $accent)>{{ ucfirst($accent) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="institution_logo_{{ $index }}">Logo Path</label>
                        <input id="institution_logo_{{ $index }}" name="institutions[{{ $index }}][logo]" value="{{ $row['logo'] ?? '' }}" placeholder="images/logo.jpeg">
                    </div>
                    <div class="form-field">
                        <label for="institution_location_{{ $index }}">Location</label>
                        <input id="institution_location_{{ $index }}" name="institutions[{{ $index }}][location]" value="{{ $row['location'] ?? '' }}">
                    </div>
                    <div class="form-field">
                        <label for="institution_students_{{ $index }}">Student Count</label>
                        <input id="institution_students_{{ $index }}" name="institutions[{{ $index }}][students]" value="{{ $row['students'] ?? '' }}">
                    </div>
                </div>
                <div class="form-field">
                    <label for="institution_description_{{ $index }}">Description</label>
                    <textarea id="institution_description_{{ $index }}" name="institutions[{{ $index }}][description]" rows="3">{{ $row['description'] ?? '' }}</textarea>
                </div>
            </div>
        @endforeach
    </section>

    <section class="editor-card">
        <h2>Metrics</h2>
        <div class="form-grid">
            @foreach(($institution->metrics ?? []) as $index => $metric)
                <div>
                    <div class="form-field">
                        <label for="metric_value_{{ $index }}">Metric {{ $index + 1 }} Value</label>
                        <input id="metric_value_{{ $index }}" name="metrics[{{ $index }}][value]" value="{{ $metrics[$index]['value'] ?? $metric['value'] ?? '' }}">
                    </div>
                    <div class="form-field">
                        <label for="metric_label_{{ $index }}">Metric {{ $index + 1 }} Label</label>
                        <input id="metric_label_{{ $index }}" name="metrics[{{ $index }}][label]" value="{{ $metrics[$index]['label'] ?? $metric['label'] ?? '' }}">
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="editor-card">
        <h2>Charts And Benefits</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="outcomes_title">Outcomes Title</label>
                <input id="outcomes_title" name="outcomes_title" value="{{ old('outcomes_title', $institution->outcomes_title) }}">
            </div>
            <div class="form-field">
                <label for="trend_title">Trend Title</label>
                <input id="trend_title" name="trend_title" value="{{ old('trend_title', $institution->trend_title) }}">
            </div>
            <div class="form-field">
                <label for="benefits_title">Benefits Title</label>
                <input id="benefits_title" name="benefits_title" value="{{ old('benefits_title', $institution->benefits_title) }}">
            </div>
        </div>

        <div class="form-grid">
            @foreach(($institution->trend_items ?? []) as $month => $score)
                <div class="form-field">
                    <label for="trend_{{ $month }}">{{ $month }} Score</label>
                    <input id="trend_{{ $month }}" type="number" min="0" max="100" name="trend_items[{{ $month }}]" value="{{ $trendItems[$month] ?? $score }}">
                </div>
            @endforeach
        </div>

        <div class="form-field">
            <label for="benefits">Benefit Labels</label>
            <textarea id="benefits" name="benefits" rows="5">{{ $benefits }}</textarea>
        </div>
    </section>

    <button class="btn btn-primary" type="submit">
        <i class="fas fa-save"></i>
        Save Institution Page
    </button>
</form>
@endsection
