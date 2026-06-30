@extends('admin.layouts.admin')

@section('title', 'Edit Program')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Program</h1>
        <p class="page-subtitle">Update details for the "{{ $program->title }}" workforce track.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.content.program') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto;">
    <form action="{{ route('admin.content.program.update-single', $program) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Program Title</label>
                    <input type="text" name="title" value="{{ old('title', $program->title) }}" required 
                           style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>
                
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Program Icon</label>
                    <select name="icon" id="edit-program-icon" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                        <option value="">Select an icon</option>
                        @foreach($iconOptions as $iconClass => $iconLabel)
                            <option value="{{ $iconClass }}" @selected(old('icon', $program->icon) === $iconClass)>
                                {{ $iconLabel }} ({{ $iconClass }})
                            </option>
                        @endforeach
                    </select>
                    <div id="edit-program-icon-preview" style="margin-top: 8px; display: inline-flex; align-items: center; gap: 8px; color: var(--color-primary);">
                        <i class="fas {{ old('icon', $program->icon ?: 'fa-graduation-cap') }}" style="font-size: 16px;"></i>
                        <small style="color: var(--color-text-muted);">Icon preview</small>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Category</label>
                    <input type="text" name="category" value="{{ old('category', $program->category) }}" placeholder="e.g. Digital"
                           style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>

                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Level</label>
                    <input type="text" name="level" value="{{ old('level', $program->level) }}" placeholder="e.g. Beginner"
                           style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                </div>

                <div class="form-field">
                    <label style="font-weight: 600; display: block; margin-bottom: 8px;">Status</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">
                        <option value="active" @selected(old('status', $program->status) === 'active')>Active</option>
                        <option value="published" @selected(old('status', $program->status) === 'published')>Published</option>
                        <option value="unpublished" @selected(old('status', $program->status) === 'unpublished')>Coming Soon</option>
                        <option value="inactive" @selected(old('status', $program->status) === 'inactive')>Inactive</option>
                        <option value="archived" @selected(old('status', $program->status) === 'archived')>Archived</option>
                        <option value="disabled" @selected(old('status', $program->status) === 'disabled')>Disabled</option>
                    </select>
                </div>
            </div>

            <div class="form-field" style="margin-bottom: 20px;">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Description</label>
                <textarea name="description" rows="4" required 
                          style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 6px;">{{ old('description', $program->description) }}</textarea>
            </div>

            <div class="form-field">
                <label style="font-weight: 600; display: block; margin-bottom: 8px;">Program Image</label>
                <div style="display: flex; align-items: flex-start; gap: 20px;">
                    @if($program->image)
                        <div style="width: 150px; height: 100px; border-radius: 8px; overflow: hidden; border: 1px solid var(--color-border);">
                            <img src="{{ asset('storage/' . $program->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @else
                        <div style="width: 150px; height: 100px; border-radius: 8px; background: #f0f7ff; display: flex; align-items: center; justify-content: center; color: var(--color-primary); border: 1px solid var(--color-border);">
                            <i class="fas {{ $program->icon ?? 'fa-graduation-cap' }}" style="font-size: 32px; opacity: 0.5;"></i>
                        </div>
                    @endif
                    
                    <div style="flex-grow: 1;">
                        <input type="file" name="image" style="font-size: 14px; width: 100%;">
                        <p style="font-size: 12px; color: var(--color-text-muted); margin-top: 5px;">Upload a new image to replace the current one. Max size 2MB.</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding-top: 20px; border-top: 1px solid var(--color-border); display: flex; justify-content: flex-end; gap: 12px;">
            <a href="{{ route('admin.content.program') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Program
            </button>
        </div>
    </form>
</div>

<script>
    (function () {
        const iconSelect = document.getElementById('edit-program-icon');
        const previewContainer = document.getElementById('edit-program-icon-preview');

        if (!iconSelect || !previewContainer) {
            return;
        }

        const previewIcon = previewContainer.querySelector('i');

        iconSelect.addEventListener('change', function () {
            const selected = this.value || 'fa-graduation-cap';
            previewIcon.className = 'fas ' + selected;
        });
    })();
</script>
@endsection
