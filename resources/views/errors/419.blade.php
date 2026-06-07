@extends('layouts.app')

@section('title', 'Session Expired - TSEA')
@section('description', 'Your session has expired')

@section('content')
<section class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-code">419</div>
            <h1>Session Expired</h1>
            <p class="error-message">Your session has expired. Please refresh and try again.</p>
            <div class="error-actions">
                <a href="{{ route('login') }}" class="btn btn-primary">Login Again</a>
                <a href="{{ url('/') }}" class="btn btn-secondary">Go Home</a>
            </div>
        </div>
    </div>
</section>

<style>
    .error-page {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 600px;
        background: linear-gradient(135deg, rgba(0, 31, 143, 0.05) 0%, rgba(0, 141, 59, 0.05) 100%);
    }
    
    .error-content {
        text-align: center;
        max-width: 600px;
    }
    
    .error-code {
        font-size: 5rem;
        font-weight: 900;
        color: #001F8F;
        line-height: 1;
        margin-bottom: 1rem;
        opacity: 0.1;
    }
    
    .error-page h1 {
        color: #001F8F;
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .error-message {
        color: #64748B;
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
</style>
@endsection
