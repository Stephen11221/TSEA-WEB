@extends('admin.layouts.admin')

@section('title', 'New Partner')

@section('content')
<style>
    .partner-create-shell {
        display: grid;
        gap: 20px;
    }

    .partner-card {
        background: #fff;
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .partner-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 14px;
    }

    .partner-field {
        display: grid;
        gap: 6px;
    }

    .partner-field label {
        font-size: 13px;
        font-weight: 700;
        color: var(--color-text-muted);
    }

    .partner-field input {
        width: 100%;
        border: 1px solid var(--color-border);
        border-radius: 6px;
        padding: 10px 12px;
        font: inherit;
    }

    .partner-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
    }

    .partner-preview-item {
        border: 1px solid var(--color-border);
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        background: #fff;
    }

    .partner-preview-item img {
        width: min(100%, 120px);
        height: 50px;
        object-fit: contain;
        display: block;
        margin: 0 auto 10px;
    }

    .partner-preview-item strong {
        color: var(--color-primary);
        font-size: 13px;
    }

    .helper-text {
        color: var(--color-text-muted);
        font-size: 12px;
        margin: 0;
    }

    .alert {
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 18px;
    }

    .alert-error {
        background: rgba(255, 51, 51, 0.1);
        color: #a42626;
        border: 1px solid rgba(255, 51, 51, 0.2);
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">New Partner</h1>
        <p class="page-subtitle">Upload a partner logo and add it to the homepage impact partners.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.content.homepage') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Homepage Content
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-error">Please complete all required fields and upload a valid image.</div>
@endif

<div class="partner-create-shell">
    <section class="partner-card">
        <h2>Add Partner</h2>
        <form method="POST" action="{{ route('admin.content.partner.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="partner-form-grid">
                <div class="partner-field">
                    <label for="partner_name">Partner Name</label>
                    <input id="partner_name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter partner name" required>
                </div>
                <div class="partner-field">
                    <label for="partner_logo">Partner Logo</label>
                    <input id="partner_logo" type="file" name="logo" accept="image/png,image/jpeg,image/webp,image/svg+xml" required>
                    <p class="helper-text">Accepted: JPG, JPEG, PNG, WEBP, SVG (max 2MB)</p>
                </div>
            </div>
            <div class="btn-group" style="margin-top: 14px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i>
                    Save Partner
                </button>
            </div>
        </form>
    </section>

    @if (count($partners))
        <section class="partner-card">
            <h2>Existing Partners</h2>
            <div class="partner-preview-grid">
                @foreach ($partners as $partner)
                    @php
                        $logo = trim((string) ($partner['logo'] ?? ''));
                        $logoSrc = \Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/']) ? $logo : ($logo ? asset('storage/' . $logo) : '');
                    @endphp
                    <article class="partner-preview-item">
                        @if ($logoSrc)
                            <img src="{{ $logoSrc }}" alt="{{ $partner['name'] }} logo">
                        @else
                            <div style="height: 50px; display: grid; place-items: center; color: var(--color-text-muted);">No logo</div>
                        @endif
                        <strong>{{ $partner['name'] ?: 'Unnamed Partner' }}</strong>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
