@extends('admin.layouts.admin')
    
@section('title', 'Manage About Page')

@section('content')
<div class="container-fluid py-4">


    <form id="aboutForm" action="{{ route('admin.content.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Hero Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Hero Section</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Section Label</label>
                    <input type="text"
                           class="form-control"
                           name="hero_label"
                           value="{{ old('hero_label', $about->hero_label ?? 'ABOUT TSEA') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Main Heading</label>
                    <textarea class="form-control"
                              rows="3"
                              name="hero_title">{{ old('hero_title', $about->hero_title ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control"
                              rows="4"
                              name="hero_description">{{ old('hero_description', $about->hero_description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tagline</label>
                    <input type="text"
                           class="form-control"
                           name="hero_tagline"
                           value="{{ old('hero_tagline', $about->hero_tagline ?? '') }}">
                </div>

            </div>
        </div>

        <!-- Mission -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Mission Card</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text"
                           class="form-control"
                           name="mission_title"
                           value="{{ $about->mission_title ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea class="form-control"
                              rows="3"
                              name="mission_description">{{ $about->mission_description ?? '' }}</textarea>
                </div>

            </div>
        </div>

        <!-- Infrastructure -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Infrastructure Card</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text"
                           class="form-control"
                           name="infrastructure_title"
                           value="{{ $about->infrastructure_title ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea class="form-control"
                              rows="3"
                              name="infrastructure_description">{{ $about->infrastructure_description ?? '' }}</textarea>
                </div>

            </div>
        </div>

        <!-- Impact -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Impact Card</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text"
                           class="form-control"
                           name="impact_title"
                           value="{{ $about->impact_title ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea class="form-control"
                              rows="3"
                              name="impact_description">{{ $about->impact_description ?? '' }}</textarea>
                </div>

            </div>
        </div>

        <!-- Image Upload -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Hero Image</h5>
            </div>

            <div class="card-body">

                <input type="file"
                       class="form-control"
                       name="hero_image">

                @if(!empty($about->hero_image))
                    <img src="{{ asset('storage/'.$about->hero_image) }}"
                         class="img-fluid mt-3 rounded"
                         style="max-height:200px;">
                @endif

            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary btn-lg">
                Save About Page
            </button>
            <button type="submit" formaction="{{ route('admin.content.about.restore') }}" class="btn btn-outline-warning">
                Restore Default
            </button>

        </div>

    </form>

</div>
@endsection