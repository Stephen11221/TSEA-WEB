@extends('layouts.app')

@section('title', 'Apply for ' . $opportunity->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body p-5">
                    <h1 class="h3 fw-bold mb-2" style="color: #1e40af;">Submit Your Application</h1>
                    <p class="text-muted mb-4">Applying for <strong>{{ $opportunity->title }}</strong> at {{ $opportunity->employer->name }}</p>

                    <hr class="mb-4 opacity-50">

                    <form action="{{ route('user.opportunities.apply', $opportunity->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="cover_letter" class="form-label fw-bold">Cover Letter</label>
                            <textarea name="cover_letter" id="cover_letter" class="form-control @error('cover_letter') is-invalid @enderror" 
                                      rows="6" placeholder="Tell the employer why you are a great fit..." required>{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted small">Minimum 50 characters.</div>
                        </div>

                        <div class="mb-4">
                            <label for="cv" class="form-label fw-bold">Upload CV / Resume</label>
                            <input type="file" name="cv" id="cv" class="form-control @error('cv') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
                            @error('cv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted small">Accepted formats: PDF, DOC, DOCX. Max size: 2MB.</div>
                        </div>

                        <div class="d-flex gap-3 pt-3">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">Submit Application</button>
                            <a href="{{ route('user.opportunities.show', $opportunity->id) }}" class="btn btn-light px-4 py-2 rounded-pill">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection