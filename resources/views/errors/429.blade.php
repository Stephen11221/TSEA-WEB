@extends('layouts.app')

@section('title', 'Too Many Requests - TSEA')
@section('description', 'You have made too many requests')

@section('content')
<section class="error-page">
    <div class="container">
        <div class="error-content">
            <div class="error-code">429</div>
            <h1>Too Many Requests</h1>
            <p class="error-message">You have made too many requests. Please wait a moment and try again.</p>
            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
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
