@extends('admin.layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Programs Dashboard</h1>
        <p class="page-subtitle">Configure the public programs page and manage specific workforce tracks.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('programs') }}" class="btn btn-secondary" target="_blank">
            <i class="fas fa-eye"></i> View Public Page
        </a>
        <form action="{{ route('admin.content.program.restore') }}" method="POST" onsubmit="return confirm('Restore default programs? Current data will be lost.')">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-undo"></i> Restore Defaults
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" style="background: rgba(0, 179, 89, 0.12); color: #08763f; border: 1px solid rgba(0, 179, 89, 0.24); padding: 12px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" style="background: rgba(255, 107, 53, 0.1); color: #a42626; border: 1px solid rgba(255, 107, 53, 0.2); padding: 12px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-triangle"></i> Please check the form fields and try again.
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
    {{-- PAGE HERO SETTINGS --}}
    <div class="card">
        <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--color-primary);">
            <i class="fas fa-heading"></i> Page Hero Settings
        </h2>

        <form action="{{ route('admin.content.program.update') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Hero Label</label>
                <input type="text" name="hero_label" value="{{ old('hero_label', $page->hero_label) }}" 
                       style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Hero Title</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $page->hero_title) }}" required 
                       style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Hero Description</label>
                <textarea name="hero_description" rows="3" 
                          style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">{{ old('hero_description', $page->hero_description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fas fa-save"></i> Save Page Settings
            </button>
        </form>
    </div>

    {{-- ADD NEW PROGRAM --}}
    <div class="card">
        <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--color-primary);">
            <i class="fas fa-plus-circle"></i> Add New Program
        </h2>

        <form action="{{ route('admin.content.program.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Title</label>
                    <input type="text" name="title" required placeholder="e.g. Digital Skills" 
                           style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">FA Icon Class</label>
                    <input type="text" name="icon" placeholder="fa-laptop-code" 
                           style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Description</label>
                <textarea name="description" required rows="2" 
                          style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px;">Program Image</label>
                <input type="file" name="image" style="font-size: 13px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fas fa-plus"></i> Create Program
            </button>
        </form>
    </div>
</div>

<h2 style="font-size: 20px; font-weight: 700; margin: 40px 0 20px; color: var(--color-primary); border-left: 4px solid var(--color-secondary); padding-left: 15px;">Published Programs</h2>
<p style="color: var(--color-text-muted); margin-bottom: 20px; margin-top: -15px;">These programs are currently visible in the "Available" section of the website.</p>
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
    @foreach($publishedPrograms as $program)
        <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
            @if($program->image)
                <div style="height: 160px; overflow: hidden;">
                    <img src="{{ asset('storage/'.$program->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @else
                <div style="height: 160px; background: #f0f7ff; display: flex; align-items: center; justify-content: center; color: var(--color-primary);">
                    <i class="fas {{ $program->icon ?? 'fa-graduation-cap' }}" style="font-size: 48px; opacity: 0.5;"></i>
                </div>
            @endif
            
            <div style="padding: 20px; flex-grow: 1;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: var(--color-text);">{{ $program->title }}</h3>
                    @if($program->icon)
                        <i class="fas {{ $program->icon }}" style="color: var(--color-primary);"></i>
                    @endif
                </div>
                <p style="font-size: 14px; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 15px;">
                    {{ Str::limit($program->description, 100) }}
                </p>
                <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                    <span class="badge badge-info">{{ $program->category ?? 'General' }}</span>
                    <div class="btn-group" style="display: flex; gap: 5px;">
                        <a href="{{ route('admin.content.program.edit-single', $program) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.content.program.delete', $program) }}" method="POST" onsubmit="return confirm('Delete this program?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; color: var(--color-accent);">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if($hiddenPrograms->isNotEmpty())
<h2 style="font-size: 20px; font-weight: 700; margin: 50px 0 20px; color: var(--color-text-muted); border-left: 4px solid #ccc; padding-left: 15px;">Drafts & Hidden Programs</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; opacity: 0.8;">
    @foreach($hiddenPrograms as $program)
        <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; border-style: dashed;">
            <div style="padding: 20px; flex-grow: 1;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: var(--color-text);">{{ $program->title }}</h3>
                    <span class="badge badge-warning">{{ strtoupper($program->status) }}</span>
                </div>
                <p style="font-size: 14px; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 15px;">
                    {{ Str::limit($program->description, 80) }}
                </p>
                <div style="margin-top: auto; display: flex; justify-content: flex-end; gap: 5px;">
                    <a href="{{ route('admin.content.program.edit-single', $program) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                        <i class="fas fa-edit"></i> Edit Content
                    </a>
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                        <i class="fas fa-toggle-on"></i> Change Status
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
@endsection
