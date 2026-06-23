<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 14px;">
    <div style="grid-column: span 2;">
        <label style="display:block; margin-bottom:6px; font-weight:600;">Title</label>
        <input type="text" name="title" value="{{ old('title', $program->title ?? '') }}" required class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
    </div>

    <div style="grid-column: span 2;">
        <label style="display:block; margin-bottom:6px; font-weight:600;">Description</label>
        <textarea name="description" required rows="4" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">{{ old('description', $program->description ?? '') }}</textarea>
    </div>

    <div>
        <label style="display:block; margin-bottom:6px; font-weight:600;">Icon (FontAwesome class)</label>
        <input type="text" name="icon" value="{{ old('icon', $program->icon ?? '') }}" class="form-control" placeholder="fa-laptop-code" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
    </div>

    <div>
        <label style="display:block; margin-bottom:6px; font-weight:600;">Image</label>
        <input type="file" name="image" accept="image/*" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
    </div>

    <div>
        <label style="display:block; margin-bottom:6px; font-weight:600;">Category</label>
        <input type="text" name="category" value="{{ old('category', $program->category ?? '') }}" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
    </div>

    <div>
        <label style="display:block; margin-bottom:6px; font-weight:600;">Level</label>
        <input type="text" name="level" value="{{ old('level', $program->level ?? '') }}" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
    </div>

    <div>
        <label style="display:block; margin-bottom:6px; font-weight:600;">Status</label>
        <select name="status" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
            @php $selectedStatus = old('status', $program->status ?? 'inactive'); @endphp
            <option value="active" @selected($selectedStatus === 'active')>Active</option>
            <option value="inactive" @selected($selectedStatus === 'inactive')>Inactive</option>
            <option value="published" @selected($selectedStatus === 'published')>Published</option>
            <option value="unpublished" @selected($selectedStatus === 'unpublished')>Unpublished</option>
            <option value="archived" @selected($selectedStatus === 'archived')>Archived</option>
            <option value="disabled" @selected($selectedStatus === 'disabled')>Disabled</option>
        </select>
    </div>

    <div>
        <label style="display:block; margin-bottom:6px; font-weight:600;">Scheduled Activation</label>
        <input type="date" name="scheduled_activation_at" value="{{ old('scheduled_activation_at', optional($program->scheduled_activation_at ?? null)->format('Y-m-d')) }}" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
    </div>

    <div>
        <label style="display:block; margin-bottom:6px; font-weight:600;">Scheduled Deactivation</label>
        <input type="date" name="scheduled_deactivation_at" value="{{ old('scheduled_deactivation_at', optional($program->scheduled_deactivation_at ?? null)->format('Y-m-d')) }}" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
    </div>
</div>
