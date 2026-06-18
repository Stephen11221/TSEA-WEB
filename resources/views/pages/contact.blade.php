@extends('layouts.app')
@section('title', 'Contact TSEA')

@section('content')
<section class="page-hero centered"><div class="container"><span class="eyebrow">{{ $contact->hero_label }}</span><h1>{{ $contact->hero_title }}</h1><p>{{ $contact->hero_description }}</p></div></section>
<section class="section">
    <div class="container contact-grid">
        <form class="card contact-form" action="{{ route('contact.send') }}" method="POST">
            @csrf
            @if(session('success'))
                <div class="alert alert-success" style="background: #D4F0E0; color: #009444; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #80D2A7;">
                    {{ session('success') }}
                </div>
            @endif

            @if($contact->form_title)
                <h2>{{ $contact->form_title }}</h2>
            @endif

            <label>Full Name<input type="text" name="name" placeholder="Full Name" required></label>
            <label>Email Address<input type="email" name="email" placeholder="Email Address" required></label>
            <label>Phone Number<input type="tel" name="phone" placeholder="Phone Number"></label>
            <label>Organization<input type="text" name="organization" placeholder="Organization"></label>
            
            <div style="margin: 1.5rem 0;">
                <h3 style="font-size: 1.1rem; margin-bottom: 10px;">{{ $contact->stakeholder_title }}</h3>
                <div class="radio-list">
                    @foreach($contact->stakeholders ?? [] as $stakeholder)
                        <label style="display: block; margin-bottom: 5px; cursor: pointer;">
                            <input type="radio" name="stakeholder" value="{{ $stakeholder }}" required> {{ $stakeholder }}
                        </label>
                    @endforeach
                </div>
            </div>

            <label>Message<textarea name="message" rows="5" placeholder="Message" required></textarea></label>
            <button class="btn btn-primary" type="submit">{{ $contact->submit_button_text }}</button>
        </form>
        <aside class="card">
            <h2>{{ $contact->connect_title }}</h2>
            <p>{{ $contact->email }}</p><p>{{ $contact->phone }}</p><p>{{ $contact->address }}</p>
        </aside>
    </div>
</section>
@endsection
