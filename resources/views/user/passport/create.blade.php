@extends('layouts.app')

@section('title', 'Create Passport - TSEA')
@section('description', 'Create your workforce passport')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-container">
            <h1>Create Your Workforce Passport</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.passport.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="skills">Skills</label>
                    <textarea id="skills" name="skills" placeholder="List your skills, separated by commas" required></textarea>
                    @error('skills')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="experience">Experience</label>
                    <textarea id="experience" name="experience" placeholder="Describe your work experience" required></textarea>
                    @error('experience')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="education">Education</label>
                    <textarea id="education" name="education" placeholder="Describe your educational background" required></textarea>
                    @error('education')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Create Passport</button>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
