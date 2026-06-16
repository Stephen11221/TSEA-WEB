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

    <div class="mt-4">
        <a href="{{ route('user.opportunities.apply.form', $opportunity->id) }}" class="btn btn-primary">Apply for this Position</a>
    </div>
</div>
@endsection