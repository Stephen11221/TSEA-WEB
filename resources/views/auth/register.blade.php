@extends('layouts.app')

@section('title', 'Register - TSEA')
@section('description', 'Create your TSEA account')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-container">
            <h1>Create Your Account</h1>
            <p style="color: #666; margin-bottom: 20px;">Join TSEA and unlock your workforce potential</p>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 123-4567">
                    @error('phone')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" placeholder="At least 8 characters" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>

                <div class="form-group">
                    <label for="role">Account Type *</label>
                    <select id="role" name="role" required>
                        <option value="">-- Select Account Type --</option>
                        <option value="user" @if(old('role') === 'user') selected @endif>Job Seeker</option>
                        <option value="employer" @if(old('role') === 'employer') selected @endif>Employer / Recruiter</option>
                        <option value="instructor" @if(old('role') === 'instructor') selected @endif>Instructor / Trainer</option>
                    </select>
                    <small style="color: #666;">Choose the account type that best fits your needs</small>
                    @error('role')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bio">Bio / About You</label>
                    <textarea id="bio" name="bio" placeholder="Tell us about yourself..." style="min-height: 80px; font-family: inherit; padding: 8px; border: 1px solid #ccc; border-radius: 4px; width: 100%; resize: vertical;">{{ old('bio') }}</textarea>
                    <small style="color: #666;">Maximum 500 characters</small>
                    @error('bio')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="agree_terms" value="1" @if(old('agree_terms')) checked @endif required>
                        I agree to the <a href="#" style="color: #0066CC;">Terms of Service</a> and <a href="#" style="color: #0066CC;">Privacy Policy</a> *
                    </label>
                    @error('agree_terms')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; margin-top: 10px;">Create Account</button>
            </form>

            <p style="text-align: center; margin-top: 20px; color: #666;">Already have an account? <a href="{{ route('login') }}" style="color: #0066CC; text-decoration: none; font-weight: 600;">Login here</a></p>
        </div>
    </div>
</section>
@endsection
