@extends('layouts.app')
@section('title', 'Contact TSEA')

@section('content')
<section class="page-hero centered"><div class="container"><span class="eyebrow">{{ $contact->hero_label }}</span><h1>{{ $contact->hero_title }}</h1><p>{{ $contact->hero_description }}</p></div></section>
<section class="section">
    <div class="container contact-grid">
        <form class="card contact-form">
            @if($contact->form_title)
                <h2>{{ $contact->form_title }}</h2>
            @endif
            <label>Full Name<input type="text" placeholder="Full Name"></label>
            <label>Email Address<input type="email" placeholder="Email Address"></label>
            <label>Phone Number<input type="tel" placeholder="Phone Number"></label>
            <label>Organization<input type="text" placeholder="Organization"></label>
            <label>Message<textarea rows="5" placeholder="Message"></textarea></label>
            <button class="btn btn-primary" type="submit">{{ $contact->submit_button_text }}</button>
        </form>
        <aside class="card">
            <h2>{{ $contact->stakeholder_title }}</h2>
            <div class="radio-list">
                @foreach($contact->stakeholders ?? [] as $stakeholder)
                    <label><input type="radio" name="stakeholder"> {{ $stakeholder }}</label>
                @endforeach
            </div>
            <h2>{{ $contact->connect_title }}</h2>
            <p>{{ $contact->email }}</p><p>{{ $contact->phone }}</p><p>{{ $contact->address }}</p>
        </aside>
    </div>
</section>
@endsection
