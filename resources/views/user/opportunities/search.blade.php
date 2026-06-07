@extends('layouts.app')

@section('title', 'Search Opportunities - TSEA')
@section('description', 'Search for job and learning opportunities')

@section('content')
<section class="section">
    <div class="container">
        <h1>Search Opportunities</h1>

        <div class="search-form">
            <form action="{{ route('user.opportunities.search') }}" method="GET" class="form-inline">
                <div class="form-group">
                    <input type="text" name="q" placeholder="Search opportunities..." value="{{ $query ?? '' }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

        @if (count($opportunities) === 0)
            <div class="card">
                @if (!empty($query))
                    <p>No opportunities found for "{{ $query }}"</p>
                @else
                    <p>Start searching for opportunities</p>
                @endif
            </div>
        @else
            <div class="grid two">
                @foreach ($opportunities as $opportunity)
                    <article class="card">
                        <h3>{{ $opportunity->title ?? 'Opportunity' }}</h3>
                        <p>{{ $opportunity->description ?? 'No description' }}</p>
                        <p><strong>Location:</strong> {{ $opportunity->location ?? 'Not specified' }}</p>
                        <div class="button-group">
                            <a href="{{ route('user.opportunities.show', $opportunity->id) }}" class="btn btn-secondary">View</a>
                            <form action="{{ route('user.opportunities.apply', $opportunity->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">Apply</button>
                            </form>
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
