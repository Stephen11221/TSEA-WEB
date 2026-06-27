@extends('admin.layouts.admin')

@section('title', 'Edit Homepage')

@section('content')
@php
    $fieldValue = fn ($key, $fallback = '') => old($key, data_get($homepageContent, $key, $fallback));
@endphp

<style>
    .content-editor {
        display: grid;
        gap: 24px;
    }

    .editor-card {
        background: #ffffff;
        border: 1px solid var(--color-border);
        border-radius: 8px;
        padding: 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .editor-card h2 {
        font-size: 18px;
        margin-bottom: 16px;
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
    .form-field textarea {
        width: 100%;
        border: 1px solid var(--color-border);
        border-radius: 6px;
        padding: 10px 12px;
        font: inherit;
    }

    .repeater-row {
        display: grid;
        grid-template-columns: minmax(140px, 0.8fr) minmax(220px, 1.4fr) minmax(130px, 0.7fr);
        gap: 12px;
        align-items: end;
        padding: 14px 0;
        border-top: 1px solid var(--color-border);
    }

    .metric-row {
        grid-template-columns: minmax(120px, 0.7fr) minmax(220px, 1.3fr);
    }

    .partner-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 12px;
    }

    .partner-editor {
        border: 1px solid var(--color-border);
        border-radius: 8px;
        padding: 14px;
    }

    .document-editor {
        border: 1px solid var(--color-border);
        border-radius: 8px;
        padding: 14px;
        margin-top: 12px;
    }

    .current-file {
        color: var(--color-text-muted);
        font-size: 13px;
        margin-top: -6px;
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

    @media (max-width: 900px) {
        .repeater-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Homepage</h1>
        <p class="page-subtitle">Update the text, cards, metrics, buttons and partner labels shown on the public homepage.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.content.partner.new') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            New Partner
        </a>
        <form method="POST" action="{{ route('admin.content.homepage.restore') }}" onsubmit="return confirm('Restore the homepage to the default TSEA content?')">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-rotate-left"></i>
                Restore Content
            </button>
        </form>
        <a href="{{ route('home') }}" class="btn btn-secondary">
            <i class="fas fa-eye"></i>
            View Homepage
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-error">Please check the highlighted homepage fields and try again.</div>
@endif

<form method="POST" action="{{ route('admin.content.homepage.update') }}" class="content-editor" enctype="multipart/form-data">
    @csrf

    <section class="editor-card">
        <h2>Hero</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="hero_eyebrow">Eyebrow</label>
                <input id="hero_eyebrow" type="text" name="hero_eyebrow" value="{{ old('hero_eyebrow', $homepage->hero_eyebrow) }}">
            </div>
            <div class="form-field">
                <label for="hero_title">Title</label>
                <input id="hero_title" type="text" name="hero_title" value="{{ old('hero_title', $homepage->hero_title) }}">
            </div>
        </div>
        <div class="form-field">
            <label for="hero_description">Description</label>
            <textarea id="hero_description" name="hero_description" rows="3">{{ old('hero_description', $homepage->hero_description) }}</textarea>
        </div>
        <div class="form-grid">
            <div class="form-field">
                <label for="primary_button_text">Primary Button Text</label>
                <input id="primary_button_text" type="text" name="primary_button_text" value="{{ old('primary_button_text', $homepage->primary_button_text) }}">
            </div>
            <div class="form-field">
                <label for="primary_button_link">Primary Button Link</label>
                <input id="primary_button_link" type="text" name="primary_button_link" value="{{ old('primary_button_link', $homepage->primary_button_link) }}">
            </div>
            <div class="form-field">
                <label for="secondary_button_text">Secondary Button Text</label>
                <input id="secondary_button_text" type="text" name="secondary_button_text" value="{{ old('secondary_button_text', $homepage->secondary_button_text) }}">
            </div>
            <div class="form-field">
                <label for="secondary_button_link">Secondary Button Link</label>
                <input id="secondary_button_link" type="text" name="secondary_button_link" value="{{ old('secondary_button_link', $homepage->secondary_button_link) }}">
            </div>
        </div>
    </section>

    <section class="editor-card">
        <h2>Hero Preview Cards</h2>
        <div class="form-grid">
            @foreach ([
                'dashboard.score_title' => 'Score Card Title',
                'dashboard.score' => 'Score Value',
                'dashboard.passport_title' => 'Passport Card Title',
                'dashboard.profile_name' => 'Profile Name',
                'dashboard.profile_caption' => 'Profile Caption',
                'dashboard.skills_count' => 'Skills Count',
                'dashboard.skills_label' => 'Skills Label',
                'dashboard.matches_count' => 'Matches Count',
                'dashboard.matches_label' => 'Matches Label',
                'dashboard.applications_count' => 'Applications Count',
                'dashboard.applications_label' => 'Applications Label',
                'dashboard.insights_title' => 'Insights Card Title',
                'dashboard.top_skills_title' => 'Top Skills Card Title',
            ] as $key => $label)
                <div class="form-field">
                    <label for="content_{{ str_replace('.', '_', $key) }}">{{ $label }}</label>
                    <input id="content_{{ str_replace('.', '_', $key) }}" type="{{ $key === 'dashboard.score' ? 'number' : 'text' }}" name="content[{{ str_replace('.', '][', $key) }}]" value="{{ $fieldValue($key) }}" @if ($key === 'dashboard.score') min="0" max="100" @endif>
                </div>
            @endforeach
        </div>
    </section>

    @foreach ([
        'problem' => 'Workforce Visibility Gap',
        'solution' => 'Integrated Solution',
        'stakeholders' => 'Stakeholders',
    ] as $section => $heading)
        <section class="editor-card">
            <h2>{{ $heading }}</h2>
            <div class="form-grid">
                <div class="form-field">
                    <label for="{{ $section }}_eyebrow">Section Eyebrow</label>
                    <input id="{{ $section }}_eyebrow" type="text" name="content[{{ $section }}][eyebrow]" value="{{ $fieldValue($section . '.eyebrow') }}">
                </div>
                <div class="form-field">
                    <label for="{{ $section }}_title">Section Title</label>
                    <input id="{{ $section }}_title" type="text" name="content[{{ $section }}][title]" value="{{ $fieldValue($section . '.title') }}">
                </div>
            </div>

            @foreach ($homepageContent[$section]['items'] as $index => $item)
                <div class="repeater-row">
                    <div class="form-field">
                        <label for="{{ $section }}_{{ $index }}_title">Card Title</label>
                        <input id="{{ $section }}_{{ $index }}_title" type="text" name="content[{{ $section }}][items][{{ $index }}][title]" value="{{ old("content.$section.items.$index.title", $item['title']) }}">
                    </div>
                    <div class="form-field">
                        <label for="{{ $section }}_{{ $index }}_copy">Card Copy</label>
                        <input id="{{ $section }}_{{ $index }}_copy" type="text" name="content[{{ $section }}][items][{{ $index }}][copy]" value="{{ old("content.$section.items.$index.copy", $item['copy']) }}">
                    </div>
                    <div class="form-field">
                        <label for="{{ $section }}_{{ $index }}_icon">Font Awesome Icon</label>
                        <input id="{{ $section }}_{{ $index }}_icon" type="text" name="content[{{ $section }}][items][{{ $index }}][icon]" value="{{ old("content.$section.items.$index.icon", $item['icon']) }}">
                    </div>
                </div>
            @endforeach
        </section>
    @endforeach

    <section class="editor-card">
        <h2>Impact</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="impact_eyebrow">Section Eyebrow</label>
                <input id="impact_eyebrow" type="text" name="content[impact][eyebrow]" value="{{ $fieldValue('impact.eyebrow') }}">
            </div>
            <div class="form-field">
                <label for="impact_title">Section Title</label>
                <input id="impact_title" type="text" name="content[impact][title]" value="{{ $fieldValue('impact.title') }}">
            </div>
        </div>

        @foreach ($homepageContent['impact']['metrics'] as $index => $metric)
            <div class="repeater-row metric-row">
                <div class="form-field">
                    <label for="metric_{{ $index }}_value">Metric Value</label>
                    <input id="metric_{{ $index }}_value" type="text" name="content[impact][metrics][{{ $index }}][value]" value="{{ old("content.impact.metrics.$index.value", $metric['value']) }}">
                </div>
                <div class="form-field">
                    <label for="metric_{{ $index }}_label">Metric Label</label>
                    <input id="metric_{{ $index }}_label" type="text" name="content[impact][metrics][{{ $index }}][label]" value="{{ old("content.impact.metrics.$index.label", $metric['label']) }}">
                </div>
            </div>
        @endforeach

        <h2>Partners</h2>
        <div class="partner-grid">
            @foreach ($homepageContent['impact']['partners'] as $index => $partner)
                <div class="partner-editor">
                    <div class="form-field">
                        <label for="partner_{{ $index }}_name">Partner Name {{ $index + 1 }}</label>
                        <input id="partner_{{ $index }}_name" type="text" name="content[impact][partners][{{ $index }}][name]" value="{{ old("content.impact.partners.$index.name", $partner['name'] ?? '') }}">
                    </div>
                    <div class="form-field">
                        <label for="partner_{{ $index }}_logo">Logo URL or Path</label>
                        <input id="partner_{{ $index }}_logo" type="text" name="content[impact][partners][{{ $index }}][logo]" value="{{ old("content.impact.partners.$index.logo", $partner['logo'] ?? '') }}" placeholder="/images/logo.jpeg">
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="editor-card">
        <h2>Homepage Documents</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="documents_eyebrow">Section Eyebrow</label>
                <input id="documents_eyebrow" type="text" name="content[documents][eyebrow]" value="{{ $fieldValue('documents.eyebrow') }}">
            </div>
            <div class="form-field">
                <label for="documents_title">Section Title</label>
                <input id="documents_title" type="text" name="content[documents][title]" value="{{ $fieldValue('documents.title') }}">
            </div>
        </div>

        @foreach ($homepageContent['documents']['items'] as $index => $document)
            <div class="document-editor">
                <div class="form-grid">
                    <div class="form-field">
                        <label for="document_{{ $index }}_title">Document Title {{ $index + 1 }}</label>
                        <input id="document_{{ $index }}_title" type="text" name="content[documents][items][{{ $index }}][title]" value="{{ old("content.documents.items.$index.title", $document['title']) }}">
                    </div>
                    <div class="form-field">
                        <label for="document_{{ $index }}_file">Upload Document</label>
                        <input id="document_{{ $index }}_file" type="file" name="content[documents][items][{{ $index }}][file]" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip">
                    </div>
                </div>
                <div class="form-field">
                    <label for="document_{{ $index }}_description">Document Description</label>
                    <textarea id="document_{{ $index }}_description" name="content[documents][items][{{ $index }}][description]" rows="2">{{ old("content.documents.items.$index.description", $document['description']) }}</textarea>
                </div>
                <input type="hidden" name="content[documents][items][{{ $index }}][path]" value="{{ old("content.documents.items.$index.path", $document['path']) }}">
                <input type="hidden" name="content[documents][items][{{ $index }}][original_name]" value="{{ old("content.documents.items.$index.original_name", $document['original_name']) }}">
                @if (! empty($document['path']))
                    <p class="current-file">
                        Current file: {{ $document['original_name'] ?: basename($document['path']) }}
                    </p>
                @endif
            </div>
        @endforeach
    </section>

    <div class="btn-group">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Save Homepage
        </button>
        <a href="{{ route('home') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-up-right-from-square"></i>
            View Public Page
        </a>
    </div>
</form>
@endsection
