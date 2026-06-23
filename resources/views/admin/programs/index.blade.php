@extends('admin.layouts.admin')

@section('title', 'Program Management')

@section('content')
@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 16px;">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 16px;">
        <ul style="margin: 0; padding-left: 18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="page-header">
    <div>
        <h1 class="page-title">Program Management</h1>
        <p class="page-subtitle">Activate, deactivate, or schedule visibility for Academies and Specializations.</p>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-primary" onclick="showCreateModal()"><i class="fas fa-plus"></i> Create New Program</button>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px; margin-bottom: 30px; align-items: stretch;">
    <div class="kpi-grid" style="margin-bottom: 0;">
        <div class="kpi-card">
            <div class="kpi-value">{{ $stats['published'] }}</div>
            <div class="kpi-label">Live on Website</div>
            <div style="font-size: 11px; color: var(--color-secondary); margin-top: 5px;"><i class="fas fa-circle"></i> Active & Published</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value" style="color: var(--color-gold);">{{ $stats['coming_soon'] }}</div>
            <div class="kpi-label">Coming Soon</div>
            <div style="font-size: 11px; color: var(--color-text-muted); margin-top: 5px;"><i class="fas fa-clock"></i> Future Scheduled</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value" style="color: #dc3545;">{{ $stats['unavailable'] }}</div>
            <div class="kpi-label">Hidden / Disabled</div>
            <div style="font-size: 11px; color: var(--color-text-muted); margin-top: 5px;"><i class="fas fa-eye-slash"></i> Not visible to public</div>
        </div>
    </div>

    <div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h3 style="font-size: 13px; font-weight: 700; color: var(--color-primary); margin-bottom: 15px; text-align: center;">Visibility Breakdown</h3>
        <div style="width: 100%; height: 160px;">
            <canvas id="programVisibilityChart"></canvas>
        </div>
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
            
            <div class="topbar-search" style="max-width: 300px; display: flex; gap: 8px; align-items: center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search programs..." style="border: 1px solid var(--color-border); color: var(--color-text);">
                <button type="submit" formaction="{{ route('admin.programs.index') }}" formmethod="GET" class="btn btn-secondary">Search</button>
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
                            <button
                                type="button"
                                class="btn-icon"
                                title="Edit Program"
                                data-id="{{ $program->id }}"
                                data-title="{{ e($program->title) }}"
                                data-description="{{ e($program->description) }}"
                                data-icon="{{ e($program->icon) }}"
                                data-category="{{ e($program->category) }}"
                                data-level="{{ e($program->level) }}"
                                data-status="{{ $program->status }}"
                                data-scheduled-activation="{{ optional($program->scheduled_activation_at)->format('Y-m-d') }}"
                                data-scheduled-deactivation="{{ optional($program->scheduled_deactivation_at)->format('Y-m-d') }}"
                                onclick="showEditModal(this)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete Program" onclick="return confirm('Delete this program? This action cannot be undone.')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <div style="margin-top: 16px;">
        {{ $programs->links() }}
    </div>
</div>

<!-- Create Program Modal -->
<div id="createModal" class="modal" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div class="card" style="width:min(780px, 95vw); max-height:90vh; overflow:auto; background:white; padding:25px; border-radius:12px; position:relative;">
        <h2 style="color:var(--color-primary); margin-bottom:15px; font-size:1.2rem;">Create Program</h2>
        <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.programs.partials.form', ['program' => null])
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Create Program</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Program Modal -->
<div id="editModal" class="modal" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div class="card" style="width:min(780px, 95vw); max-height:90vh; overflow:auto; background:white; padding:25px; border-radius:12px; position:relative;">
        <h2 style="color:var(--color-primary); margin-bottom:15px; font-size:1.2rem;">Edit Program</h2>
        <form id="editProgramForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.programs.partials.form', ['program' => null, 'isEdit' => true])
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
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

    function showCreateModal() {
        document.getElementById('createModal').style.display = 'flex';
    }

    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    function showEditModal(button) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editProgramForm');
        const routeTemplate = '{{ route('admin.programs.update', ['program' => '__ID__']) }}';
        const id = button.dataset.id;

        form.action = routeTemplate.replace('__ID__', id);
        form.querySelector('[name="title"]').value = button.dataset.title || '';
        form.querySelector('[name="description"]').value = button.dataset.description || '';
        form.querySelector('[name="icon"]').value = button.dataset.icon || '';
        form.querySelector('[name="category"]').value = button.dataset.category || '';
        form.querySelector('[name="level"]').value = button.dataset.level || '';
        form.querySelector('[name="status"]').value = button.dataset.status || 'inactive';
        form.querySelector('[name="scheduled_activation_at"]').value = button.dataset.scheduledActivation || '';
        form.querySelector('[name="scheduled_deactivation_at"]').value = button.dataset.scheduledDeactivation || '';

        modal.style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Program Visibility Pie Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('programVisibilityChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Published', 'Coming Soon', 'Unavailable'],
                datasets: [{
                    data: [{{ $stats['published'] }}, {{ $stats['coming_soon'] }}, {{ $stats['unavailable'] }}],
                    backgroundColor: ['#0B1D33', '#C5A059', '#dc3545'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0B1D33',
                        padding: 10,
                        displayColors: false
                    }
                }
            }
        });
    });
</script>
@endsection