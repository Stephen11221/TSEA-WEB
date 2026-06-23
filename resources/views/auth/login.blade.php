@extends('layouts.auth')

@section('title', 'Sign In - TSEA')
@section('description', 'Login to your TSEA account')

@section('content')
<style>
    .tsea-login-page.section {
        padding: 0;
    }

    .tsea-login-page.tsea-corp-auth-wrap {
        min-height: 100vh;
    }

    .tsea-login-page .container {
        width: 100%;
        max-width: none;
        margin: 0;
        padding: 0;
    }

    .tsea-login-page .tsea-corp-auth-shell {
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

    .tsea-login-page .tsea-corp-brand-panel {
        background: linear-gradient(160deg, #0B1F3A 0%, #102A56 55%, #173D7A 100%);
        color: #ffffff;
        padding: clamp(1.7rem, 4vw, 3rem);
        position: relative;
        isolation: isolate;
        display: grid;
    }

    .tsea-login-page .tsea-corp-brand-panel::before,
    .tsea-login-page .tsea-corp-brand-panel::after {
        content: "";
        position: absolute;
        pointer-events: none;
        opacity: 0.26;
    }

    .tsea-login-page .tsea-corp-brand-panel::before {
        width: 88px;
        height: 88px;
        border: 1px solid rgba(212, 175, 55, 0.6);
        transform: rotate(45deg);
        top: 16%;
        right: 18%;
    }

    .tsea-login-page .tsea-corp-brand-panel::after {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.25), rgba(212, 175, 55, 0));
        bottom: -80px;
        left: -60px;
    }

    .tsea-login-page .tsea-corp-form-logo {
        width: 100%;
        display: grid;
        place-items: center;
        margin-bottom: .35rem;
    }

    .tsea-login-page .tsea-corp-form-logo img {
        width: min(170px, 62%);
        height: auto;
        object-fit: contain;
    }

    .tsea-login-page .tsea-corp-signup-btn {
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

    .tsea-login-page .tsea-corp-signup-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 28px rgba(16, 42, 86, 0.32);
    }

    .tsea-login-page .tsea-corp-signup-btn:active {
        transform: translateY(0px);
    }

    /* Form Input Styling */
    .tsea-login-page .tsea-corp-input-wrap {
        position: relative;
        display: grid;
        gap: .45rem;
        grid-column: auto;
    }

    .tsea-login-page .tsea-corp-input-wrap label {
        display: block;
        font-size: .85rem;
        font-weight: 600;
        color: #102A56;
        letter-spacing: .3px;
    }

    .tsea-login-page .tsea-corp-input-wrap > div {
        position: relative;
        display: flex;
        align-items: center;
    }

    .tsea-login-page .tsea-corp-input-wrap i {
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

    .tsea-login-page .tsea-corp-input-wrap input {
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

    .tsea-login-page .tsea-corp-input-wrap input::placeholder {
        color: #a0afc0;
        font-weight: 400;
    }

    .tsea-login-page .tsea-corp-input-wrap input:hover {
        border-color: #c5d3e5;
        background: #fcfeff;
    }

    .tsea-login-page .tsea-corp-input-wrap input:focus {
        outline: 0;
        border-color: #173D7A;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(23, 61, 122, 0.12);
    }

    .tsea-login-page .tsea-corp-input-wrap > div:has(input:focus) i {
        color: #173D7A;
    }

    /* Error Message Styling */
    .tsea-login-page .error {
        color: #b42318;
        font-size: .8rem;
        font-weight: 500;
        margin-top: -.3rem;
        margin-bottom: .3rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .tsea-login-page .error::before {
        content: "⚠";
        font-size: .75rem;
    }

    /* Alert Box Styling */
    .tsea-login-page .alert {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #7f1d1d;
        padding: .85rem 1rem;
        border-radius: 10px;
        font-size: .9rem;
        margin-bottom: .5rem;
    }

    .tsea-login-page .alert ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tsea-login-page .alert li {
        margin-bottom: .35rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .tsea-login-page .alert li::before {
        content: "✕";
        font-weight: bold;
        font-size: .8rem;
    }

    /* Form Panel Styling */
    .tsea-login-page .tsea-corp-form-panel {
        background: #ffffff;
        display: grid;
        place-items: center;
        padding: clamp(1.25rem, 3.5vw, 2.8rem);
    }

    .tsea-login-page .tsea-corp-form-inner {
        width: min(420px, 100%);
        display: grid;
        gap: 1.2rem;
        text-align: center;
    }

    .tsea-login-page .tsea-corp-form-inner h2 {
        margin: 0;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        color: #102A56;
        font-weight: 800;
    }

    .tsea-login-page .tsea-corp-form-subtitle {
        margin: 0;
        color: #687892;
        font-size: .92rem;
        line-height: 1.5;
    }

    /* Social Icons */
    .tsea-login-page .tsea-corp-social {
        display: flex;
        justify-content: center;
        gap: .7rem;
        margin-top: .2rem;
    }

    .tsea-login-page .tsea-corp-social a {
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

    .tsea-login-page .tsea-corp-social a:hover {
        color: #173D7A;
        border-color: #173D7A;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(16, 42, 86, 0.18);
    }

    /* Brand/Logo Styling */
    .tsea-login-page .tsea-corp-logo {
        display: block;
        margin-bottom: .5rem;
    }

    .tsea-login-page .tsea-corp-logo img {
        width: min(200px, 80%);
        height: auto;
        object-fit: contain;
        border-radius: 8px;
    }

    .tsea-login-page .tsea-corp-brand-content {
        display: grid;
        align-content: center;
        gap: 1rem;
    }

    .tsea-login-page .tsea-corp-brand-content h1 {
        margin: 0;
        font-size: clamp(2rem, 3.8vw, 2.9rem);
        line-height: 1.05;
        font-weight: 800;
    }

    .tsea-login-page .tsea-corp-brand-content p {
        margin: 0;
        max-width: 32ch;
        color: rgba(255, 255, 255, 0.92);
        line-height: 1.75;
    }

    .tsea-login-page .tsea-corp-signin-btn {
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

    .tsea-login-page .tsea-corp-signin-btn:hover {
        background: rgba(255, 255, 255, 0.14);
        transform: translateY(-1px);
    }

    .tsea-login-page .tsea-corp-brand-glass {
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

    /* Remember me & auth-switch */
    .tsea-login-page .auth-check {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .88rem;
        color: #687892;
        cursor: pointer;
        text-align: left;
    }

    .tsea-login-page .auth-check input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #173D7A;
        cursor: pointer;
        flex-shrink: 0;
    }

    .tsea-login-page .auth-switch {
        margin: 0;
        color: #687892;
        font-size: .9rem;
        text-align: center;
    }

    .tsea-login-page .auth-switch a {
        color: #173D7A;
        font-weight: 600;
        text-decoration: none;
    }

    .tsea-login-page .auth-switch a:hover {
        text-decoration: underline;
    }

    .tsea-login-page .tsea-corp-form-grid {
        display: grid;
        gap: .9rem;
        text-align: left;
    }

    @media (max-width: 760px) {
        .tsea-login-page .tsea-corp-auth-shell {
            grid-template-columns: 1fr;
            min-height: 100vh;
        }

        .tsea-login-page .tsea-corp-brand-panel,
        .tsea-login-page .tsea-corp-form-panel {
            padding: 1.4rem;
        }

        .tsea-login-page .tsea-corp-form-inner {
            width: 100%;
        }

        .tsea-login-page .tsea-corp-signin-btn {
            width: 100%;
        }

        .tsea-login-page .tsea-corp-form-logo img {
            width: min(140px, 55%);
        }
    }
</style>

<section class="section tsea-corp-auth-wrap tsea-login-page">
    <div class="container">
        <div class="tsea-float tshape-one" aria-hidden="true"></div>
        <div class="tsea-float tshape-two" aria-hidden="true"></div>
        <div class="tsea-float tshape-three" aria-hidden="true"></div>

        <div class="tsea-corp-auth-shell" role="region" aria-label="TSEA login">
            <aside class="tsea-corp-brand-panel">
                <div class="tsea-corp-brand-glass" aria-hidden="true"></div>
                <div class="tsea-corp-brand-content">
                    <div class="tsea-corp-logo" aria-label="TSEA logo">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="TSEA - Taifa Skills &amp; Employability Academy">
                    </div>

                    <h1>Welcome Back!</h1>
                    <p>To stay connected with us, please login with your personal information.</p>

                    <a href="{{ route('register') }}" class="tsea-corp-signin-btn">Create Account</a>
                </div>
            </aside>

            <div class="tsea-corp-form-panel">
                <div class="tsea-corp-form-inner">
                    <div class="tsea-corp-form-logo" aria-label="TSEA mark">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="TSEA logo">
                    </div>

                    <h2>Sign In</h2>

                    <div class="tsea-corp-social" aria-label="Social login options">
                        <a href="#" aria-label="Continue with Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Continue with Google"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" aria-label="Continue with LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>

                    <p class="tsea-corp-form-subtitle">or use your account credentials:</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST" class="tsea-corp-form-grid" novalidate>
                        @csrf

                        <div class="tsea-corp-input-wrap">
                            <label for="email">Email Address</label>
                            <div>
                                <i class="far fa-envelope" aria-hidden="true"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus autocomplete="email">
                            </div>
                        </div>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror

                        <div class="tsea-corp-input-wrap">
                            <label for="password">Password</label>
                            <div>
                                <i class="fas fa-lock" aria-hidden="true"></i>
                                <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                            </div>
                        </div>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror

                        <label class="auth-check" for="remember">
                            <input type="checkbox" id="remember" name="remember">
                            <span>Remember me</span>
                        </label>

                        <button type="submit" class="tsea-corp-signup-btn">Sign In</button>
                    </form>

                    <p class="auth-switch">Need an account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
