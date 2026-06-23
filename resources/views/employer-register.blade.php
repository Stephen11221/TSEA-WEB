@extends('layouts.auth')
@section('title', 'Employer Registration - TSEA')
@section('description', 'Create your employer account')

@section('content')
<section class="section auth-wrap">
    <div class="container">
        <div class="auth-shell auth-shell-register">
            <aside class="auth-panel auth-panel-brand">
                <span class="auth-chip">TSEA</span>
                <h1>Employer Onboarding</h1>
                <p>Create an employer profile to publish opportunities and connect with verified talent.</p>
                <a href="{{ route('login') }}" class="auth-outline-btn">Sign In</a>
            </aside>

            <div class="auth-panel auth-panel-form">
                <div class="auth-heading">
                    <h2>Register Employer</h2>
                    <p>Set up your organization profile</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="auth-form-grid auth-form-grid-register">
                    @csrf
                    <input type="hidden" name="role" value="employer">

                    <div class="form-group auth-span-full">
                        <label for="name">Company Name *</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Acme Tech Solutions">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Contact Email *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="hr@company.com">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+254 700 000 000">
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group auth-span-full">
                        <label for="company_website">Company Website</label>
                        <input id="company_website" type="url" name="company_website" value="{{ old('company_website') }}" placeholder="https://example.com">
                        @error('company_website')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="industry">Industry</label>
                        <select id="industry" name="industry">
                            <option value="">Select Industry</option>
                            <option value="Technology" @if(old('industry') === 'Technology') selected @endif>Technology</option>
                            <option value="Finance" @if(old('industry') === 'Finance') selected @endif>Finance</option>
                            <option value="Healthcare" @if(old('industry') === 'Healthcare') selected @endif>Healthcare</option>
                            <option value="Education" @if(old('industry') === 'Education') selected @endif>Education</option>
                            <option value="Energy" @if(old('industry') === 'Energy') selected @endif>Energy</option>
                            <option value="Agriculture" @if(old('industry') === 'Agriculture') selected @endif>Agriculture</option>
                        </select>
                        @error('industry')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_size">Company Size</label>
                        <select id="company_size" name="company_size">
                            <option value="">Select Size</option>
                            <option value="1-10" @if(old('company_size') === '1-10') selected @endif>1-10 employees</option>
                            <option value="11-50" @if(old('company_size') === '11-50') selected @endif>11-50 employees</option>
                            <option value="51-200" @if(old('company_size') === '51-200') selected @endif>51-200 employees</option>
                            <option value="201-500" @if(old('company_size') === '201-500') selected @endif>201-500 employees</option>
                            <option value="500+" @if(old('company_size') === '500+') selected @endif>500+ employees</option>
                        </select>
                        @error('company_size')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group auth-span-full">
                        <label for="bio">Organization Bio</label>
                        <textarea id="bio" name="bio" rows="4" placeholder="Tell us about your organization...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input id="password" type="password" name="password" required placeholder="At least 8 characters">
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password *</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Repeat password">
                    </div>

                    <label class="auth-check auth-span-full" for="agree_terms">
                        <input type="checkbox" id="agree_terms" name="agree_terms" value="1" @if(old('agree_terms')) checked @endif required>
                        <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                    </label>
                    @error('agree_terms')
                        <span class="error auth-span-full">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn auth-cta auth-span-full">Create Employer Account</button>
                </form>

                <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>
    </div>
</section>
@endsection