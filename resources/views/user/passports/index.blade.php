@extends('layouts.app')

@section('title', 'My Workforce Passports')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Workforce Passports</h1>
    <div class="card">
        @if($passports)
            <p>This page will display details of your Workforce Passport.</p>
            <p>Passport Number: {{ $passports->passport_number }}</p>
            <p>Status: {{ ucfirst($passports->status) }}</p>
            {{-- Display more passport details here --}}
        @else
            <p>You don't have a Workforce Passport yet. <a href="{{ route('user.passport.create') }}">Create one now!</a></p>
        @endif
    </div>
</div>
@endsection