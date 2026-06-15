@extends('layouts.app')
@section('title', 'For Employers & Partners - TSEA')

@section('content')
<section class="page-hero">
    <div class="container split">
        <div>
            <span class="eyebrow">Employers & Partners</span>
            <h1>Access Africa's Verified Workforce</h1>
            <p>Connect with talent whose skills, identity, and readiness have been independently verified through the Workforce Passport™ infrastructure.</p>
            <div class="hero-actions" style="margin-top: 24px; display: flex; gap: 15px;">
                <a href="{{ route('register.employer') }}" class="btn btn-primary">Join as Employer</a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">Request Demo</a>
            </div>
        </div>
        <div class="card" style="padding: 24px; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
            <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 700; color: var(--color-primary);">Talent Readiness Index</h3>
            @include('partials.charts', ['type' => 'bars', 'items' => [
                'Digital Skills' => 88, 
                'Technical Proficiency' => 79, 
                'Soft Skills' => 92, 
                'Market Alignment' => 81
            ]])
        </div>
    </div>
</section>

<section class="section" style="background: var(--color-light);">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto 50px;">
            <span class="eyebrow">Our Network</span>
            <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 16px;">Verified Employer Partners</h2>
            <p>Join a growing ecosystem of forward-thinking organizations using data-driven talent matching to build resilient teams.</p>
        </div>

        <div class="grid five" style="gap: 20px;">
            {{-- This dynamically displays employers managed by the admin --}}
            @php
                $employerPartners = \App\Models\User::where('role', 'employer')
                    ->where('status', 'active')
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp

            @forelse ($employerPartners as $partner)
                <div class="card" style="text-align: center; padding: 25px; border-radius: 12px; border: 1px solid var(--color-border);">
                    <div style="width: 50px; height: 50px; background: rgba(0, 102, 204, 0.05); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: var(--color-primary);">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 4px;">{{ $partner->name }}</h3>
                    <span style="font-size: 11px; color: var(--color-secondary); font-weight: 600; text-transform: uppercase;">Verified Partner</span>
                </div>
            @empty
                {{-- Fallback mock data if no employers are registered yet --}}
                @foreach (['Safcom Tech', 'Equity Hub', 'Kawi Energy', 'Kilimo Plus', 'Afya Systems'] as $mock)
                    <div class="card" style="text-align: center; padding: 25px; border-radius: 12px; opacity: 0.7;">
                        <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: #ccc;">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 4px;">{{ $mock }}</h3>
                        <span style="font-size: 11px; color: #999; font-weight: 600; text-transform: uppercase;">Partner</span>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <span class="eyebrow">Talent Discovery</span>
                <h2 style="font-size: 32px; font-weight: 800;">Browse Verified Jobs</h2>
            </div>
            <a href="{{ route('register.employer') }}" class="text-link">Register to see all <i class="fas fa-arrow-right"></i></a>
        </div>

        <form class="filter-bar" aria-label="Talent filters" style="margin-bottom: 30px; background: var(--color-light); padding: 15px; border-radius: 12px;">
            <input type="search" placeholder="Keywords (e.g. UI/UX, Cloud, Sales)" style="flex: 2;">
            <select><option>Industry Focus</option></select>
            <select><option>Location</option></select>
            <select><option>Min ERI™ Score</option></select>
            <button class="btn btn-primary">Search Talent</button>
        </form>

        <div class="grid three">
            @php
                $opportunities = \App\Models\JobPosting::where('status', 'open')->latest()->take(3)->get();
            @endphp

            @foreach ($opportunities as $opportunity)
                <article class="card" style="padding: 24px; border-radius: 12px; border: 1px solid var(--color-border);">
                    <h3 class="mb-2" style="font-size: 18px; font-weight: 700;">{{ $opportunity->title }}</h3>
                <p>Employer: {{ $opportunity->employer->name }}</p>
                <p>Location: {{ $opportunity->location }}</p>
                <p>Job Type: {{ ucfirst($opportunity->job_type) }}</p>
                    @if($opportunity->salary_min && $opportunity->salary_max)
                        <p>Salary: ${{ number_format($opportunity->salary_min) }} - ${{ number_format($opportunity->salary_max) }}</p>
                    @endif
                    <p>Deadline: {{ $opportunity->deadline ? \Carbon\Carbon::parse($opportunity->deadline)->format('M d, Y') : 'N/A' }}</p>
                
                    <p style="margin: 15px 0; font-size: 14px; color: var(--color-text-muted);">{{ \Illuminate\Support\Str::limit($opportunity->description, 100) }}</p>

                    <a href="{{ route('user.opportunities.show', $opportunity->id) }}" class="btn btn-primary" style="width: 100%; justify-content: center;">View Details</a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section alt" style="background: var(--color-dark); color: white; text-align: center;">
    <div class="container">
        <h2 style="font-size: 32px; font-weight: 800; margin-bottom: 20px;">Ready to Hire Better?</h2>
        <p style="font-size: 18px; opacity: 0.8; max-width: 600px; margin: 0 auto 30px;">Stop guessing and start hiring based on verified data, skills, and readiness scores. Join the TSEA network today.</p>
        <div style="display: flex; justify-content: center; gap: 20px;">
            <a href="{{ route('register.employer') }}" class="btn btn-primary" style="padding: 15px 40px;">Register Organization</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary" style="padding: 15px 40px; background: transparent; border: 1px solid white; color: white;">Contact Partnerships</a>
        </div>
    </div>
</section>
@endsection
