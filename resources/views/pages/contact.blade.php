@extends('layouts.app')
@section('title', 'Contact TSEA')

@section('content')
<section class="page-hero centered"><div class="container"><span class="eyebrow">Contact</span><h1>Let’s Build Africa’s Workforce Future</h1><p>Connect with TSEA for partnerships, programs, talent discovery and workforce intelligence.</p></div></section>
<section class="section">
    <div class="container contact-grid">
        <form class="card contact-form">
            <label>Full Name<input type="text" placeholder="Full Name"></label>
            <label>Email Address<input type="email" placeholder="Email Address"></label>
            <label>Phone Number<input type="tel" placeholder="Phone Number"></label>
            <label>Organization<input type="text" placeholder="Organization"></label>
            <label>Message<textarea rows="5" placeholder="Message"></textarea></label>
            <button class="btn btn-primary" type="submit">Submit Message</button>
        </form>
        <aside class="card">
            <h2>I am a...</h2>
            <div class="radio-list"><label><input type="radio" name="stakeholder"> Employer</label><label><input type="radio" name="stakeholder"> Institution</label><label><input type="radio" name="stakeholder"> Government</label><label><input type="radio" name="stakeholder"> Development Partner</label><label><input type="radio" name="stakeholder"> Learner</label></div>
            <h2>Other Ways To Connect</h2>
            <p>info@tsea.africa</p><p>+254 700 123 456</p><p>Nairobi, Kenya</p>
        </aside>
    </div>
</section>
@endsection
