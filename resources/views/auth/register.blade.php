@extends('layouts.auth')

@section('title', 'Sign Up - TSEA')
@section('description', 'Create your TSEA account')

@section('content')
<style>
    .tsea-register-page.section {
        padding: 0;
    }

    .tsea-register-page.tsea-corp-auth-wrap {
        min-height: 100vh;
    }

    .tsea-register-page .container {
        width: 100%;
        max-width: none;
        margin: 0;
        padding: 0;
    }

    .tsea-register-page .tsea-corp-auth-shell {
        display: grid;
        grid-template-columns: minmax(300px, 5fr) minmax(0, 7fr);
        align-items: stretch;
        min-height: 100vh;
        border-radius: 0;
        overflow: hidden;
        border: 0;
        background: #ffffff;
        box-shadow: none;
    }

    .tsea-register-page .tsea-corp-brand-panel {
        background: linear-gradient(160deg, #0B1F3A 0%, #102A56 55%, #173D7A 100%);
        color: #ffffff;
        padding: clamp(1.7rem, 4vw, 3rem);
        position: relative;
        isolation: isolate;
        display: grid;
    }

    .tsea-register-page .tsea-corp-brand-panel::before,
    .tsea-register-page .tsea-corp-brand-panel::after {
        content: "";
        position: absolute;
        pointer-events: none;
        opacity: 0.26;
    }

    .tsea-register-page .tsea-corp-brand-panel::before {
        width: 88px;
        height: 88px;
        border: 1px solid rgba(212, 175, 55, 0.6);
        transform: rotate(45deg);
        top: 16%;
        right: 18%;
    }

    .tsea-register-page .tsea-corp-brand-panel::after {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.25), rgba(212, 175, 55, 0));
        bottom: -80px;
        left: -60px;
    }

    .tsea-register-page .tsea-corp-form-logo {
        width: 100%;
        display: grid;
        place-items: center;
        margin-bottom: .35rem;
    }

    .tsea-register-page .tsea-corp-form-logo img {
        width: min(170px, 62%);
        height: auto;
        object-fit: contain;
    }

    .tsea-register-page .tsea-register-form {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .9rem 1rem;
        text-align: left;
    }

    .tsea-register-page .tsea-register-form .tsea-corp-signup-btn,
    .tsea-register-page .tsea-register-form .alert {
        grid-column: 1 / -1;
    }

    .tsea-register-page .tsea-register-form .error {
        grid-column: 1 / -1;
    }

    .tsea-register-page .tsea-corp-signup-btn {
        background: linear-gradient(90deg, #102A56 0%, #173D7A 72%, #D4AF37 100%);
        box-shadow: 0 12px 26px rgba(16, 42, 86, 0.24);
        width: 100%;
        min-height: 50px;
        border: 0;
        border-radius: 999px;
        color: #ffffff;
        font-weight: 700;
        font-size: .9rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        cursor: pointer;
        transition: all .25s ease;
        margin-top: .2rem;
    }

    .tsea-register-page .tsea-corp-signup-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 28px rgba(16, 42, 86, 0.32);
    }

    .tsea-register-page .tsea-corp-signup-btn:active {
        transform: translateY(0px);
    }

    /* Role Selector */
    .tsea-register-page .tsea-role-selector {
        grid-column: 1 / -1;
        display: grid;
        gap: .45rem;
    }

    .tsea-register-page .tsea-role-selector > label {
        font-size: .85rem;
        font-weight: 600;
        color: #102A56;
        letter-spacing: .3px;
    }

    .tsea-register-page .tsea-role-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .65rem;
    }

    .tsea-register-page .tsea-role-card {
        position: relative;
    }

    .tsea-register-page .tsea-role-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .tsea-register-page .tsea-role-card label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .4rem;
        padding: .85rem .5rem;
        border: 1.5px solid #d8e0ee;
        border-radius: 12px;
        background: #f9fbff;
        color: #687892;
        font-size: .78rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .22s ease;
        text-align: center;
        letter-spacing: .2px;
    }

    .tsea-register-page .tsea-role-card label i {
        font-size: 1.3rem;
        color: #7285a5;
        transition: color .22s ease;
    }

    .tsea-register-page .tsea-role-card label:hover {
        border-color: #173D7A;
        background: #f0f5ff;
        color: #173D7A;
    }

    .tsea-register-page .tsea-role-card label:hover i {
        color: #173D7A;
    }

    .tsea-register-page .tsea-role-card input[type="radio"]:checked + label {
        border-color: #173D7A;
        background: linear-gradient(135deg, #eef3ff 0%, #f0f5ff 100%);
        color: #102A56;
        box-shadow: 0 0 0 3px rgba(23, 61, 122, 0.12);
    }

    .tsea-register-page .tsea-role-card input[type="radio"]:checked + label i {
        color: #173D7A;
    }

    @media (max-width: 480px) {
        .tsea-register-page .tsea-role-cards {
            grid-template-columns: 1fr;
        }
    }

    /* Form Input Styling */
    .tsea-register-page .tsea-corp-input-wrap {
        position: relative;
        display: grid;
        gap: .45rem;
        grid-column: auto;
    }

    .tsea-register-page .tsea-corp-input-wrap label {
        display: block;
        font-size: .85rem;
        font-weight: 600;
        color: #102A56;
        letter-spacing: .3px;
    }

    .tsea-register-page .tsea-corp-input-wrap > div {
        position: relative;
        display: flex;
        align-items: center;
    }

    .tsea-register-page .tsea-corp-input-wrap i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .95rem;
        color: #7285a5;
        pointer-events: none;
        transition: color .25s ease;
        z-index: 2;
    }

    .tsea-register-page .tsea-corp-input-wrap input {
        width: 100%;
        padding: .95rem 1rem .95rem 2.7rem;
        border: 1.5px solid #d8e0ee;
        border-radius: 12px;
        background: #f9fbff;
        color: #0B1F3A;
        font-size: .95rem;
        font-family: 'Poppins', 'Inter', system-ui, sans-serif;
        transition: all .25s ease;
        -webkit-appearance: none;
        appearance: none;
    }

    .tsea-register-page .tsea-corp-input-wrap input::placeholder {
        color: #a0afc0;
        font-weight: 400;
    }

    .tsea-register-page .tsea-corp-input-wrap input:hover {
        border-color: #c5d3e5;
        background: #fcfeff;
    }

    .tsea-register-page .tsea-corp-input-wrap input:focus {
        outline: 0;
        border-color: #173D7A;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(23, 61, 122, 0.12);
    }

    .tsea-register-page .tsea-corp-input-wrap > div:has(input:focus) i {
        color: #173D7A;
    }

    /* Error Message Styling */
    .tsea-register-page .error {
        grid-column: 1 / -1;
        color: #b42318;
        font-size: .8rem;
        font-weight: 500;
        margin-top: -.6rem;
        margin-bottom: .3rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .tsea-register-page .error::before {
        content: "⚠";
        font-size: .75rem;
    }

    /* Alert Box Styling */
    .tsea-register-page .alert {
        grid-column: 1 / -1;
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #7f1d1d;
        padding: .85rem 1rem;
        border-radius: 10px;
        font-size: .9rem;
        margin-bottom: .5rem;
    }

    .tsea-register-page .alert ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tsea-register-page .alert li {
        margin-bottom: .35rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .tsea-register-page .alert li::before {
        content: "✕";
        font-weight: bold;
        font-size: .8rem;
    }

    /* Form Panel Styling */
    .tsea-register-page .tsea-corp-form-panel {
        background: #ffffff;
        display: grid;
        place-items: center;
        padding: clamp(1.25rem, 3.5vw, 2.8rem);
    }

    .tsea-register-page .tsea-corp-form-inner {
        width: min(460px, 100%);
        display: grid;
        gap: 1.2rem;
        text-align: center;
    }

    .tsea-register-page .tsea-corp-form-inner h2 {
        margin: 0;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        color: #102A56;
        font-weight: 800;
    }

    .tsea-register-page .tsea-corp-form-subtitle {
        margin: 0;
        color: #687892;
        font-size: .92rem;
        line-height: 1.5;
    }

    /* Social Icons */
    .tsea-register-page .tsea-corp-social {
        display: flex;
        justify-content: center;
        gap: .7rem;
        margin-top: .2rem;
    }

    .tsea-register-page .tsea-corp-social a {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1px solid #d6dfec;
        color: #0B1F3A;
        display: inline-grid;
        place-items: center;
        background: #ffffff;
        transition: all .25s ease;
    }

    .tsea-register-page .tsea-corp-social a:hover {
        color: #173D7A;
        border-color: #173D7A;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(16, 42, 86, 0.18);
    }

    /* Brand/Logo Styling */
    .tsea-register-page .tsea-corp-logo {
        display: block;
        margin-bottom: .5rem;
    }

    .tsea-register-page .tsea-corp-logo img {
        width: min(200px, 80%);
        height: auto;
        object-fit: contain;
        border-radius: 8px;
    }

    .tsea-register-page .tsea-corp-brand-content {
        display: grid;
        align-content: center;
        gap: 1rem;
    }

    .tsea-register-page .tsea-corp-brand-content h1 {
        margin: 0;
        font-size: clamp(2rem, 3.8vw, 2.9rem);
        line-height: 1.05;
        font-weight: 800;
    }

    .tsea-register-page .tsea-corp-brand-content p {
        margin: 0;
        max-width: 32ch;
        color: rgba(255, 255, 255, 0.92);
        line-height: 1.75;
    }

    .tsea-register-page .tsea-corp-signin-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        width: 188px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.88);
        color: #ffffff;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        font-size: .8rem;
        transition: all .25s ease;
    }

    .tsea-register-page .tsea-corp-signin-btn:hover {
        background: rgba(255, 255, 255, 0.14);
        transform: translateY(-1px);
    }

    .tsea-register-page .tsea-corp-brand-glass {
        position: absolute;
        inset: auto 8% 14% auto;
        width: 130px;
        height: 130px;
        border-radius: 28px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(7px);
        transform: rotate(24deg);
        z-index: -1;
    }


    @media (max-width: 760px) {
        .tsea-register-page .tsea-corp-auth-shell {
            grid-template-columns: 1fr;
            min-height: 100vh;
        }

        .tsea-register-page .tsea-corp-brand-panel,
        .tsea-register-page .tsea-corp-form-panel {
            padding: 1.4rem;
        }

        .tsea-register-page .tsea-register-form {
            grid-template-columns: 1fr;
            gap: .75rem;
        }

        .tsea-register-page .tsea-corp-form-inner {
            width: 100%;
        }

        .tsea-register-page .tsea-corp-signin-btn {
            width: 100%;
        }

        .tsea-register-page .tsea-corp-form-logo img {
            width: min(140px, 55%);
        }
    }
</style>

<section class="section tsea-corp-auth-wrap tsea-register-page">
    <div class="container">
        <div class="tsea-float tshape-one" aria-hidden="true"></div>
        <div class="tsea-float tshape-two" aria-hidden="true"></div>
        <div class="tsea-float tshape-three" aria-hidden="true"></div>

        <div class="tsea-corp-auth-shell" role="region" aria-label="TSEA registration">
            <aside class="tsea-corp-brand-panel">
                <div class="tsea-corp-brand-glass" aria-hidden="true"></div>
                <div class="tsea-corp-brand-content">
                    <div class="tsea-corp-logo" aria-label="TSEA logo">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="TSEA - Taifa Skills &amp; Employability Academy">
                    </div>

                    <h1>Welcome Back!</h1>
                    <p>To stay connected with us, please sign in with your personal information.</p>

                    <a href="{{ route('login') }}" class="tsea-corp-signin-btn">Sign In</a>
                </div>
            </aside>

            <div class="tsea-corp-form-panel">
                <div class="tsea-corp-form-inner">
                    <div class="tsea-corp-form-logo" aria-label="TSEA mark">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="TSEA logo">
                    </div>
                    <h2>Create Account</h2>

                    <div class="tsea-corp-social" aria-label="Social registration options">
                        <a href="#" aria-label="Continue with Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Continue with Google"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" aria-label="Continue with LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>

                    <p class="tsea-corp-form-subtitle">or use your email for registration:</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.store') }}" method="POST" class="tsea-corp-form-grid tsea-register-form" novalidate>
                        @csrf
                        <input type="hidden" name="agree_terms" value="1">

                        <div class="tsea-role-selector">
                            <label>I am registering as</label>
                            <div class="tsea-role-cards">
                                <div class="tsea-role-card">
                                    <input type="radio" id="role_student" name="role" value="student" {{ old('role', 'student') === 'student' ? 'checked' : '' }} required>
                                    <label for="role_student">
                                        <i class="fas fa-user-graduate"></i>
                                        Student
                                    </label>
                                </div>
                                <div class="tsea-role-card">
                                    <input type="radio" id="role_employer" name="role" value="employer" {{ old('role') === 'employer' ? 'checked' : '' }}>
                                    <label for="role_employer">
                                        <i class="fas fa-briefcase"></i>
                                        Employer
                                    </label>
                                </div>
                                <div class="tsea-role-card">
                                    <input type="radio" id="role_instructor" name="role" value="instructor" {{ old('role') === 'instructor' ? 'checked' : '' }}>
                                    <label for="role_instructor">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        Instructor
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('role')
                            <span class="error" style="grid-column: 1/-1;">{{ $message }}</span>
                        @enderror

                        <div class="tsea-corp-input-wrap">
                            <label for="name">Full Name</label>
                            <div>
                                <i class="far fa-user" aria-hidden="true"></i>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required autocomplete="name" autofocus>
                            </div>
                        </div>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror

                        <div class="tsea-corp-input-wrap">
                            <label for="email">Email Address</label>
                            <div>
                                <i class="far fa-envelope" aria-hidden="true"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email">
                            </div>
                        </div>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror

                        <div class="tsea-corp-input-wrap">
                            <label for="password">Password</label>
                            <div>
                                <i class="fas fa-lock" aria-hidden="true"></i>
                                <input type="password" id="password" name="password" placeholder="Enter password" required autocomplete="new-password">
                            </div>
                        </div>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror

                        <div class="tsea-corp-input-wrap">
                            <label for="password_confirmation">Confirm Password</label>
                            <div>
                                <i class="fas fa-lock" aria-hidden="true"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" class="tsea-corp-signup-btn">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
