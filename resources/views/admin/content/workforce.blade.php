@extends('admin.layouts.admin')

@section('title', 'Manage Workforce Passport Page')

@section('content')
<div class="container-fluid py-4">

    <form action="{{ route('admin.content.workforce-passport.update') }}" method="POST">
        @csrf

        <!-- Hero Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Hero Section</h5>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Hero Label</label>
                    <input type="text"
                           name="hero_label"
                           class="form-control"
                           value="{{ old('hero_label', $passport->hero_label ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hero Title</label>
                    <input type="text"
                           name="hero_title"
                           class="form-control"
                           value="{{ old('hero_title', $passport->hero_title ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hero Description</label>
                    <textarea name="hero_description"
                              rows="4"
                              class="form-control">{{ old('hero_description', $passport->hero_description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">CTA Button Text</label>
                    <input type="text"
                           name="cta_text"
                           class="form-control"
                           value="{{ old('cta_text', $passport->cta_text ?? '') }}">
                </div>

            </div>
        </div>

        <!-- Profile Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Sample Profile</h5>
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Profile Name</label>
                    <input type="text"
                           name="profile_name"
                           class="form-control"
                           value="{{ old('profile_name', $passport->profile_name ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text"
                           name="profile_location"
                           class="form-control"
                           value="{{ old('profile_location', $passport->profile_location ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Passport Score</label>
                    <input type="number"
                           min="0"
                           max="100"
                           name="passport_score"
                           class="form-control"
                           value="{{ old('passport_score', $passport->passport_score ?? 82) }}">
                </div>

            </div>
        </div>

        <!-- Skills -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Skills</h5>
            </div>
            <div class="card-body">

                @for($i = 1; $i <= 5; $i++)
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Skill {{ $i }}"
                                   name="skill_name_{{ $i }}"
                                   value="{{ old('skill_name_'.$i, $passport->{'skill_name_'.$i} ?? '') }}">
                        </div>

                        <div class="col-md-4">
                            <input type="number"
                                   class="form-control"
                                   min="0"
                                   max="100"
                                   placeholder="Score"
                                   name="skill_score_{{ $i }}"
                                   value="{{ old('skill_score_'.$i, $passport->{'skill_score_'.$i} ?? '') }}">
                        </div>
                    </div>
                @endfor

            </div>
        </div>

        <!-- Credentials -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Credentials</h5>
            </div>
            <div class="card-body">

                @for($i = 1; $i <= 4; $i++)
                    <div class="mb-3">
                        <input type="text"
                               class="form-control"
                               name="credential_{{ $i }}"
                               value="{{ old('credential_'.$i, $passport->{'credential_'.$i} ?? '') }}"
                               placeholder="Credential {{ $i }}">
                    </div>
                @endfor

            </div>
        </div>

        <!-- Readiness -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Readiness Indicators</h5>
            </div>
            <div class="card-body">

                @for($i = 1; $i <= 3; $i++)
                    <div class="mb-3">
                        <input type="text"
                               class="form-control"
                               name="readiness_{{ $i }}"
                               value="{{ old('readiness_'.$i, $passport->{'readiness_'.$i} ?? '') }}"
                               placeholder="Indicator {{ $i }}">
                    </div>
                @endfor

            </div>
        </div>

        <!-- Benefits -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Passport Benefits</h5>
            </div>
            <div class="card-body">

                @for($i = 1; $i <= 6; $i++)
                    <div class="mb-3">
                        <input type="text"
                               class="form-control"
                               name="benefit_{{ $i }}"
                               value="{{ old('benefit_'.$i, $passport->{'benefit_'.$i} ?? '') }}"
                               placeholder="Benefit {{ $i }}">
                    </div>
                @endfor

            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary mt-1.5" type="submit">
                Save Workforce Passport Content
            </button>
        </div>

    </form>

</div>
@endsection