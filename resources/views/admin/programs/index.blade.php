@extends('admin.layouts.admin')

@section('title', 'Program Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Program Management</h1>
        <p class="page-subtitle">Activate, deactivate, or schedule visibility for Academies and Specializations.</p>
    </div>
    <div class="btn-group">
        <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Create New Program</a>
    </div>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
    <form action="{{ route('admin.programs.bulk') }}" method="POST" id="bulkActionForm">
        @csrf
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 10px;">
            <div style="display: flex; gap: 10px; align-items: center;">
                <select name="action" class="form-control" style="width: 200px; padding: 8px; border-radius: 6px; border: 1px solid var(--color-border);">
                    <option value="">Bulk Actions</option>
                    <option value="activate">Set to Active</option>
                    <option value="deactivate">Temporarily Disable</option>
                    <option value="archive">Archive Selected</option>
                </select>
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Apply this action to all selected programs?')">Apply</button>
            </div>
            
            <div class="topbar-search" style="max-width: 300px;">
                <input type="text" placeholder="Search programs..." style="border: 1px solid var(--color-border); color: var(--color-text);">
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Program / Academy</th>
                    <th>Status</th>
                    <th>Scheduling</th>
                    <th>Last Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programs as $program)
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{{ $program->id }}"></td>
                    <td>
                        <div style="font-weight: 600; color: var(--color-primary);">{{ $program->title }}</div>
                        <small style="color: var(--color-text-muted);">{{ ucfirst($program->category) }}</small>
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'active' => 'badge-success',
                                'published' => 'badge-success',
                                'disabled' => 'badge-danger',
                                'inactive' => 'badge-warning',
                                'archived' => 'badge-info'
                            ][$program->status] ?? 'badge-secondary';
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ strtoupper($program->status) }}</span>
                    </td>
                    <td>
                        @if($program->scheduled_activation_at)
                            <div style="font-size: 11px;">
                                <i class="fas fa-calendar-check" style="color: var(--color-gold);"></i> Start: {{ \Carbon\Carbon::parse($program->scheduled_activation_at)->format('M d, Y') }}
                            </div>
                        @endif
                        @if($program->scheduled_deactivation_at)
                            <div style="font-size: 11px;">
                                <i class="fas fa-calendar-times" style="color: var(--color-text-muted);"></i> End: {{ \Carbon\Carbon::parse($program->scheduled_deactivation_at)->format('M d, Y') }}
                            </div>
                        @endif
                        @if(!$program->scheduled_activation_at && !$program->scheduled_deactivation_at)
                            <span style="color: #ccc; font-size: 11px;">No schedule set</span>
                        @endif
                    </td>
                    <td>{{ $program->updated_at->diffForHumans() }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-icon" title="Edit Status" 
                                    onclick="showStatusModal('{{ $program->id }}', '{{ $program->status }}')">
                                <i class="fas fa-toggle-on"></i>
                            </button>
                            <a href="#" class="btn-icon"><i class="fas fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>

<!-- Status Management Modal -->
<div id="statusModal" class="modal" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div class="card" style="width:450px; background:white; padding:25px; border-radius:12px; position:relative;">
        <h2 style="color:var(--color-primary); margin-bottom:15px; font-size:1.2rem;">Update Program Status</h2>
        <form id="statusUpdateForm" method="POST">
            @csrf
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Status</label>
                <select name="status" id="modalStatusSelect" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
                    <option value="active">Active</option>
                    <option value="disabled">Disabled</option>
                    <option value="published">Published</option>
                    <option value="unpublished">Unpublished</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Schedule Activation (Optional)</label>
                <input type="date" name="scheduled_activation_at" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:600;">Schedule Deactivation (Optional)</label>
                <input type="date" name="scheduled_deactivation_at" class="form-control" style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--color-border);">
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" class="btn btn-secondary" onclick="closeStatusModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-icon {
        background: none;
        border: 1px solid var(--color-border);
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        color: var(--color-primary);
        transition: all 0.2s;
    }
    .btn-icon:hover {
        background: var(--color-gold);
        color: white;
    }
</style>

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    function showStatusModal(id, currentStatus) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusUpdateForm');
        const select = document.getElementById('modalStatusSelect');
        
        // Set the dynamic action URL
        form.action = `/admin/programs/${id}/status`;
        select.value = currentStatus;
        
        modal.style.display = 'flex';
    }

    function closeStatusModal() {
        document.getElementById('statusModal').style.display = 'none';
    }
</script>
@endsection