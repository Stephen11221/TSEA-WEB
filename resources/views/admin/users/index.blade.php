@extends('admin.layouts.admin')

@section('title', 'Manage Users - TSEA Admin')
@section('description', 'Manage TSEA Users')

@section('content')

<style>
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #0F4C81;
        margin-bottom: .25rem;
    }

    .card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .table-responsive {
        padding: 1rem;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 10px;
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border: none;
        white-space: nowrap;
    }

    .table tbody tr {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        transition: all .2s ease;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .table tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border: none;
    }

    .table tbody tr td:first-child {
        border-radius: 12px 0 0 12px;
    }

    .table tbody tr td:last-child {
        border-radius: 0 12px 12px 0;
    }

    .badge {
        padding: .55rem .9rem;
        border-radius: 50px;
        font-size: .75rem;
        font-weight: 600;
    }

    .bg-admin {
        background: #dc3545;
        color: #fff;
    }

    .bg-user {
        background: #0d6efd;
        color: #fff;
    }

    .btn {
        border-radius: 8px;
        padding: .45rem .9rem;
        font-size: .875rem;
    }

    .action-buttons {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #6c757d;
    }

    .pagination {
        margin: 0;
    }

    .card-footer {
        background: #fff;
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    @media (max-width: 768px) {
        .table thead th,
        .table tbody td {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<section class="section">
    <div class="container-fluid">

```
    <!-- Header -->
    <div class="mb-4">
        <h1 class="page-title">Manage Users</h1>
        <p class="text-muted mb-0">
            View, update and manage all registered users.
        </p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Users Card -->
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">User Directory</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Created Date</th>
                        <th width="250">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>

                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                @if($user->isAdmin())
                                    <span class="badge bg-admin">
                                        Admin
                                    </span>
                                @else
                                    <span class="badge bg-user">
                                        User
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $user->created_at->format('M d, Y') }}
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn btn-outline-info">
                                        View
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="btn btn-outline-warning">
                                        Edit
                                    </a>

                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.delete', $user) }}"
                                              method="POST"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <h5>No Users Found</h5>
                                    <p class="mb-0">
                                        Registered users will appear here.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif

    </div>

</div>
```

</section>

@endsection
