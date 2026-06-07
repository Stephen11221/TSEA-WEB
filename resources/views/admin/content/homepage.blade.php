@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Homepage</h1>

    <form method="POST" action="{{ route('admin.content.homepage') }}">
        @csrf

        <div class="mb-3">
            <label>Hero Eyebrow</label>
            <input type="text"
                   name="hero_eyebrow"
                   class="form-control"
                   value="{{ $homepage->hero_eyebrow ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Hero Title</label>
            <input type="text"
                   name="hero_title"
                   class="form-control"
                   value="{{ $homepage->hero_title ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="hero_description"
                      class="form-control"
                      rows="4">{{ $homepage->hero_description ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label>Primary Button Text</label>
            <input type="text"
                   name="primary_button_text"
                   class="form-control"
                   value="{{ $homepage->primary_button_text ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Primary Button Link</label>
            <input type="text"
                   name="primary_button_link"
                   class="form-control"
                   value="{{ $homepage->primary_button_link ?? '' }}">
        </div>

        <button class="btn btn-primary">
            Save Changes
        </button>
    </form>
</div>
@endsection
