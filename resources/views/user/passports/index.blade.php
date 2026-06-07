@extends('layouts.app')

@section('title', 'My Passports - TSEA')
@section('description', 'View your passports')

@section('content')
<section class="section">
    <div class="container">
        <h1>My Passports</h1>

        @if (count($passports) === 0)
            <div class="card">
                <p>You haven't created any passports yet.</p>
                <a href="{{ route('user.passport.create') }}" class="btn btn-primary">Create Your First Passport</a>
            </div>
        @else
            <div class="grid two">
                @foreach ($passports as $passport)
                    <article class="card">
                        <h3>{{ $passport->name ?? 'Passport #' . $passport->id }}</h3>
                        <p>{{ $passport->description ?? 'No description' }}</p>
                        <div class="button-group">
                            <a href="#" class="btn btn-secondary">View</a>
                            <a href="#" class="btn btn-secondary">Edit</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="button-group">
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</section>
@endsection
