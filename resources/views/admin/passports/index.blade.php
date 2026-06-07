@extends('layouts.app')

@section('title', 'All Passports - TSEA Admin')
@section('description', 'View all created passports')

@section('content')
<section class="section">
    <div class="container">
        <h1>All Passports</h1>

        <div class="card">
            <p>Passports management feature coming soon. This will display all workforce passports created by users in the system.</p>
            
            <div class="button-group">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
</section>
@endsection
