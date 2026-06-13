@extends('layouts.app')
@section('title', 'Employer Registration - TSEA')

@section('content')
<section class="section" style="background: var(--color-light); min-height: 100vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 600px;">
        <div class="card" style="padding: 40px; border-radius: 16px; background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="text-align: center; margin-bottom: 30px;">
                <span class="eyebrow">Join the Network</span>
                <h1 style="font-size: 28px; font-weight: 800; margin-top: 10px;">Employer Registration</h1>
                <p style="color: var(--color-text-muted);">Create your organization profile to start accessing verified talent.</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <input type="hidden" name="role" value="employer">

                <div style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Company Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Acme Tech Solutions" style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px;">
                        @error('name') <span style="color: var(--color-accent); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Contact Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="hr@company.com" style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+254..." style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px;">
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Company Website</label>
                        <input type="url" name="company_website" value="{{ old('company_website') }}" placeholder="https://..." style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px;">
                        @error('company_website') <span style="color: var(--color-accent); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Industry</label>
                            <select name="industry" style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px; background: white;">
                                <option value="">Select Industry</option>
                                <option value="Technology">Technology</option>
                                <option value="Finance">Finance</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Education">Education</option>
                                <option value="Energy">Energy</option>
                                <option value="Agriculture">Agriculture</option>
                            </select>
                            @error('industry') <span style="color: var(--color-accent); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Company Size</label>
                            <select name="company_size" style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px; background: white;">
                                <option value="">Select Size</option>
                                <option value="1-10">1-10 employees</option>
                                <option value="11-50">11-50 employees</option>
                                <option value="51-200">51-200 employees</option>
                                <option value="201-500">201-500 employees</option>
                                <option value="500+">500+ employees</option>
                            </select>
                            @error('company_size') <span style="color: var(--color-accent); font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Organization Bio</label>
                        <textarea name="bio" rows="3" placeholder="Tell us about your organization..." style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px;">{{ old('bio') }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Password</label>
                            <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px;">Confirm Password</label>
                            <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: 8px;">
                        </div>
                    </div>

                    <div style="margin-top: 10px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="agree_terms" required>
                            <span style="font-size: 13px;">I agree to the <a href="#" style="color: var(--color-primary);">Terms of Service</a>.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; justify-content: center; font-size: 16px;">
                        Create Employer Account
                    </button>
                </div>
            </form>

            <p style="text-align: center; margin-top: 25px; font-size: 14px;">Already have an account? <a href="{{ route('login') }}" style="color: var(--color-primary); font-weight: 700;">Log in</a></p>
        </div>
    </div>
</section>
@endsection