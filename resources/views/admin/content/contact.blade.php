@extends('admin.layouts.admin')

@section('title', 'Edit Contact Page')

@section('content')
@php
    $oldStakeholders = old('stakeholders', $contact->stakeholders ?? []);
    $stakeholders = is_array($oldStakeholders) ? implode("\n", $oldStakeholders) : $oldStakeholders;
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
        <h1 class="page-title">Edit Contact Page</h1>
        <p class="page-subtitle">Update the public Contact Us hero, form labels and contact details.</p>
    </div>
    <div class="btn-group">
        <form method="POST" action="{{ route('admin.content.contact.restore') }}" onsubmit="return confirm('Restore the contact page defaults?')">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-rotate-left"></i>
                Restore Content
            </button>
        </form>
        <a href="{{ route('contact') }}" class="btn btn-secondary">
            <i class="fas fa-eye"></i>
            View Contact Page
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-error">Please check the contact page fields and try again.</div>
@endif

<form method="POST" action="{{ route('admin.content.contact.update') }}" class="content-editor">
    @csrf

    <section class="editor-card">
        <h2>Hero</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="hero_label">Hero Label</label>
                <input id="hero_label" name="hero_label" value="{{ old('hero_label', $contact->hero_label) }}">
            </div>
            <div class="form-field">
                <label for="hero_title">Hero Title</label>
                <input id="hero_title" name="hero_title" value="{{ old('hero_title', $contact->hero_title) }}" required>
            </div>
        </div>
        <div class="form-field">
            <label for="hero_description">Hero Description</label>
            <textarea id="hero_description" name="hero_description" rows="4">{{ old('hero_description', $contact->hero_description) }}</textarea>
        </div>
    </section>

    <section class="editor-card">
        <h2>Form And Stakeholders</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="form_title">Form Title</label>
                <input id="form_title" name="form_title" value="{{ old('form_title', $contact->form_title) }}">
            </div>
            <div class="form-field">
                <label for="submit_button_text">Submit Button Text</label>
                <input id="submit_button_text" name="submit_button_text" value="{{ old('submit_button_text', $contact->submit_button_text) }}">
            </div>
            <div class="form-field">
                <label for="stakeholder_title">Stakeholder Title</label>
                <input id="stakeholder_title" name="stakeholder_title" value="{{ old('stakeholder_title', $contact->stakeholder_title) }}">
            </div>
        </div>
        <div class="form-field">
            <label for="stakeholders">Stakeholder Options</label>
            <textarea id="stakeholders" name="stakeholders" rows="6">{{ $stakeholders }}</textarea>
        </div>
    </section>

    <section class="editor-card">
        <h2>Contact Details</h2>
        <div class="form-grid">
            <div class="form-field">
                <label for="connect_title">Details Title</label>
                <input id="connect_title" name="connect_title" value="{{ old('connect_title', $contact->connect_title) }}">
            </div>
            <div class="form-field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $contact->email) }}">
            </div>
            <div class="form-field">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" value="{{ old('phone', $contact->phone) }}">
            </div>
            <div class="form-field">
                <label for="address">Address</label>
                <input id="address" name="address" value="{{ old('address', $contact->address) }}">
            </div>
        </div>
    </section>

    <button class="btn btn-primary" type="submit">
        <i class="fas fa-save"></i>
        Save Contact Page
    </button>
</form>
@endsection
