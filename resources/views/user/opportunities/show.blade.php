@extends('layouts.app')

@section('title', $opportunity->title . ' - Job Opportunity')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ $opportunity->title }}</h1>
    <p>Employer: {{ $opportunity->employer->name }}</p>
    <p>Location: {{ $opportunity->location }}</p>
    <p>Job Type: {{ ucfirst($opportunity->job_type) }}</p>
    <p>Salary: ${{ number_format($opportunity->salary_min) }} - ${{ number_format($opportunity->salary_max) }}</p>
    <p>Deadline: {{ \Carbon\Carbon::parse($opportunity->deadline)->format('M d, Y') }}</p>
    
    <h2 class="mt-4">Description</h2>
    <p>{{ $opportunity->description }}</p>

    <form action="{{ route('user.opportunities.apply', $opportunity->id) }}" method="GET" class="mt-4">
        @csrf
        {{-- The route expects a GET for showing the application form, and a POST for submitting it. --}}
        <button type="submit" class="btn btn-primary">Apply Now</button>
    </form>
</div>
@endsection