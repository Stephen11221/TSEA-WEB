@extends('layouts.app')
@section('title', 'Contact TSEA')

@section('content')
@php
    $stakeholders = collect($contact->stakeholders ?? [])->filter()->values();
@endphp

<section class="ctc-hero">
    <div class="container ctc-hero-grid">
        <div class="ctc-copy">
            <span class="ctc-kicker">{{ $contact->hero_label }}</span>
            <h1>{{ $contact->hero_title }}</h1>
            <p>{{ $contact->hero_description }}</p>

            @if($stakeholders->isNotEmpty())
                <div class="ctc-tags" aria-label="Supported stakeholder groups">
                    @foreach($stakeholders->take(5) as $stakeholder)
                        <span>{{ $stakeholder }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <aside class="ctc-panel card" aria-label="Contact information">
            <h2>{{ $contact->connect_title }}</h2>
            <ul>
                @if(!empty($contact->email))
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                    </li>
                @endif
                @if(!empty($contact->phone))
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ preg_replace('/\s+/', '', $contact->phone) }}">{{ $contact->phone }}</a>
                    </li>
                @endif
                @if(!empty($contact->address))
                    <li>
                        <i class="fas fa-location-dot"></i>
                        <span>{{ $contact->address }}</span>
                    </li>
                @endif
            </ul>
        </aside>
    </div>
</section>

<section class="section ctc-section">
    <div class="container ctc-grid">
        <form class="card ctc-form" action="{{ route('contact.send') }}" method="POST">
            @csrf

            <h2>{{ $contact->form_title ?: 'Send Us A Message' }}</h2>

            @if(session('success'))
                <div class="ctc-alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="ctc-alert error">
                    Please check your input and try again.
                </div>
            @endif

            <div class="ctc-field-grid">
                <label>
                    Full Name
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
                    @error('name')<small>{{ $message }}</small>@enderror
                </label>

                <label>
                    Email Address
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                    @error('email')<small>{{ $message }}</small>@enderror
                </label>

                <label>
                    Phone Number
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                    @error('phone')<small>{{ $message }}</small>@enderror
                </label>

                <label>
                    Organization
                    <input type="text" name="organization" value="{{ old('organization') }}" placeholder="Organization">
                    @error('organization')<small>{{ $message }}</small>@enderror
                </label>
            </div>

            @if($stakeholders->isNotEmpty())
                <fieldset class="ctc-stakeholder-group">
                    <legend>{{ $contact->stakeholder_title ?: 'I am a...' }}</legend>
                    <div class="ctc-radio-grid">
                        @foreach($stakeholders as $stakeholder)
                            <label>
                                <input type="radio" name="stakeholder" value="{{ $stakeholder }}" {{ old('stakeholder') === $stakeholder ? 'checked' : '' }} required>
                                <span>{{ $stakeholder }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('stakeholder')<small>{{ $message }}</small>@enderror
                </fieldset>
            @endif

            <label>
                Message
                <textarea name="message" rows="5" placeholder="Tell us how we can help" required>{{ old('message') }}</textarea>
                @error('message')<small>{{ $message }}</small>@enderror
            </label>

            <button class="btn btn-primary" type="submit">{{ $contact->submit_button_text ?: 'Send Message' }}</button>
        </form>

        <aside class="card ctc-side-info">
            <h3>What Happens Next</h3>
            <ol>
                <li>Our team reviews your message and context.</li>
                <li>We route your request to the right TSEA team.</li>
                <li>You receive a direct response with next steps.</li>
            </ol>
            <div class="ctc-note">
                <i class="fas fa-clock"></i>
                <span>Typical response time: within 1 business day.</span>
            </div>
        </aside>
    </div>
</section>

<style>
    .ctc-hero {
        background:
            radial-gradient(circle at 15% 15%, rgba(229, 138, 0, .16), transparent 32%),
            radial-gradient(circle at 80% 10%, rgba(0, 141, 59, .14), transparent 28%),
            linear-gradient(138deg, #061428, #0b1d33 58%, #10315a);
        color: #fff;
        padding: clamp(2.4rem, 6vw, 4.8rem) 0;
    }

    .ctc-hero-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 1rem;
        align-items: center;
    }

    .ctc-kicker {
        display: inline-flex;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-weight: 900;
        font-size: .76rem;
        color: #fbbf24;
    }

    .ctc-copy h1 {
        margin: .6rem 0 1rem;
        color: #fff;
        font-size: clamp(2rem, 4.7vw, 3.8rem);
        line-height: 1.04;
        max-width: 14ch;
    }

    .ctc-copy p {
        margin: 0;
        color: #dbeafe;
        line-height: 1.72;
        max-width: 60ch;
        font-weight: 600;
    }

    .ctc-tags {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .ctc-tags span {
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 999px;
        padding: .35rem .65rem;
        font-size: .72rem;
        font-weight: 800;
        color: #f8fafc;
        background: rgba(2, 6, 23, .32);
    }

    .ctc-panel {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .2);
        color: #fff;
        backdrop-filter: blur(8px);
    }

    .ctc-panel h2 {
        margin: 0 0 .9rem;
        color: #fff;
        font-size: 1.05rem;
    }

    .ctc-panel ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: grid;
        gap: .7rem;
    }

    .ctc-panel li {
        display: flex;
        align-items: flex-start;
        gap: .55rem;
        color: #e2e8f0;
        line-height: 1.45;
    }

    .ctc-panel i {
        margin-top: .2rem;
        color: #fbbf24;
    }

    .ctc-panel a {
        color: #fff;
    }

    .ctc-section {
        background: #f8fafc;
    }

    .ctc-grid {
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 1rem;
    }

    .ctc-form {
        display: grid;
        gap: .95rem;
    }

    .ctc-form h2 {
        margin: 0;
        color: #0b1f52;
        font-size: 1.2rem;
    }

    .ctc-field-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem;
    }

    .ctc-form label {
        display: grid;
        gap: .42rem;
        color: #0b1f52;
        font-size: .82rem;
        font-weight: 800;
    }

    .ctc-form input,
    .ctc-form textarea {
        border: 1px solid #d5deea;
        border-radius: 8px;
        background: #fff;
        min-height: 52px;
        padding: .9rem 1rem;
        font-size: .98rem;
    }

    .ctc-form textarea {
        min-height: 150px;
        resize: vertical;
    }

    .ctc-form small {
        color: #b42318;
        font-weight: 700;
        font-size: .72rem;
    }

    .ctc-stakeholder-group {
        border: 1px solid #d5deea;
        border-radius: 8px;
        padding: .8rem;
        margin: 0;
    }

    .ctc-stakeholder-group legend {
        padding: 0 .35rem;
        font-size: .82rem;
        font-weight: 900;
        color: #0b1f52;
    }

    .ctc-radio-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .4rem .75rem;
    }

    .ctc-radio-grid label {
        display: flex;
        align-items: center;
        gap: .45rem;
        color: #334155;
        font-size: .79rem;
        font-weight: 700;
        cursor: pointer;
    }

    .ctc-radio-grid input {
        width: auto;
    }

    .ctc-alert {
        border-radius: 8px;
        padding: .7rem .85rem;
        font-size: .82rem;
        font-weight: 800;
    }

    .ctc-alert.success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
    }

    .ctc-alert.error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .ctc-side-info h3 {
        margin: 0 0 .75rem;
        color: #0b1f52;
        font-size: 1rem;
    }

    .ctc-side-info ol {
        margin: 0;
        padding-left: 1.1rem;
        color: #475569;
        line-height: 1.6;
        display: grid;
        gap: .45rem;
        font-size: .86rem;
    }

    .ctc-note {
        margin-top: .95rem;
        padding: .7rem;
        border: 1px solid #d5deea;
        border-radius: 8px;
        background: #f8fafc;
        display: flex;
        gap: .55rem;
        align-items: center;
        color: #334155;
        font-size: .82rem;
        font-weight: 700;
    }

    .ctc-note i {
        color: #0b1f52;
    }

    @media (max-width: 980px) {
        .ctc-hero-grid,
        .ctc-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .ctc-field-grid,
        .ctc-radio-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
