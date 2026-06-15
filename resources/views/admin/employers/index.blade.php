@extends('admin.layouts.admin')

@section('title', 'Employer Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Employer Management</h1>
        <p class="page-subtitle">Manage registered employer accounts and approvals.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.employers.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add New Employer
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background-color: rgba(0, 179, 89, 0.1); color: var(--color-secondary); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--color-secondary);">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employers ?? [] as $employer)
                <tr>
                    <td>
                        <strong>{{ $employer->name }}</strong>
                    </td>
                    <td>{{ $employer->email }}</td>
                    <td>{{ $employer->phone ?? 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $employer->status === 'active' ? 'badge-success' : ($employer->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ ucfirst($employer->status) }}
                        </span>
                    </td>
                    <td>{{ $employer->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="btn-group">
                            @if($employer->status === 'pending')
                                <form action="{{ route('admin.employers.approve', $employer) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; background-color: var(--color-secondary); border-color: var(--color-secondary);">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('admin.employers.edit', $employer) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.employers.destroy', $employer) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this employer account?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px; background-color: #dc3545; border-color: #dc3545; color: white;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--color-text-muted);">No employers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 20px;">
        @if(isset($employers))
            {{ $employers->links() }}
        @endif
    </div>
</div>
@endsection