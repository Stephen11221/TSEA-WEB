@extends('admin.layouts.admin')

@section('title', 'Employer Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Employer Management</h1>
        <p class="page-subtitle">Manage and approve employer registrations.</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.employers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Employer
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
                <th>Company</th>
                <th>Industry</th>
                <th>Status</th>
                <th>Verification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employers as $employer)
                <tr>
                    <td>
                        <div style="display: flex; flex-direction: column;">
                            <strong>{{ $employer->name }}</strong>
                            <span style="font-size: 12px; color: var(--color-text-muted);">{{ $employer->email }}</span>
                        </div>
                    </td>
                    <td>{{ $employer->employer->industry ?? 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $employer->status === 'active' ? 'badge-success' : ($employer->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ ucfirst($employer->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $employer->is_verified ? 'badge-info' : 'badge-danger' }}">
                            {{ $employer->is_verified ? 'Verified' : 'Unverified' }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            @if($employer->status === 'pending')
                                <form action="{{ route('admin.employers.approve', $employer) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.employers.edit', $employer) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--color-text-muted);">No employer registrations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $employers->links() }}
    </div>
</div>
@endsection