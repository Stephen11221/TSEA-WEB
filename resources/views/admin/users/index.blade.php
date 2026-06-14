@extends('admin.layouts.admin')

@section('title', 'Manage Users - TSEA Admin')
@section('description', 'Manage TSEA Users')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">User Directory</h1>
            <p class="text-sm text-gray-500 mt-1">Manage platform users, roles, and account permissions.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <i class="fas fa-plus mr-2"></i> Add New User
            </a>
        </div>
    </div>

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


    <!-- Header -->
    <div class="bg-gradient-primary text-black p-4 rounded-top mb-1 card-header top-header">
        <h1 class="page-title">Manage Users</h1>
        <p class="text-muted mb-0">
            View, update and manage all registered users.
        </p>
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-50 rounded-lg"><i class="fas fa-users text-blue-600"></i></div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $users->total() }}</h3>
            <p class="text-xs text-gray-500 mt-1 font-medium">Registered accounts</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-green-50 rounded-lg"><i class="fas fa-check-circle text-green-600"></i></div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $users->where('status', 'active')->count() }}</h3>
            <p class="text-xs text-green-600 mt-1 font-medium italic">Current users</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-yellow-50 rounded-lg"><i class="fas fa-clock text-yellow-600"></i></div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $users->where('status', 'pending')->count() }}</h3>
            <p class="text-xs text-yellow-600 mt-1 font-medium italic">Awaiting approval</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-red-50 rounded-lg"><i class="fas fa-user-slash text-red-600"></i></div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Inactive</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $users->where('status', 'inactive')->count() }}</h3>
            <p class="text-xs text-red-600 mt-1 font-medium italic">Suspended accounts</p>
        </div>
    </div>

    <!-- Success Message -->
    <!-- Success Alerts -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">
            {{ session('success') }}
        <div class="mb-6 p-4 rounded-xl bg-green-50 border-l-4 border-green-500 flex items-center shadow-sm">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Users Card -->
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">User Directory</h5>
    <!-- Main Content Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Search and Filter Bar -->
        <div class="px-6 py-4 border-bottom border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="relative w-full sm:max-w-xs">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" placeholder="Search users..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150">
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <select class="block w-full pl-3 pr-10 py-2 text-sm border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg bg-white transition duration-150">
                    <option>All Roles</option>
                    <option>Admin</option>
                    <option>Employer</option>
                    <option>User</option>
                </select>
                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Created Date</th>
                        <th width="250">Actions</th>
                    <tr class="bg-gray-50/80">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">User Profile</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Joined Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr>

                            <td>
                                <strong>{{ $user->name }}</strong>
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->isAdmin())
                                    <span class="badge bg-admin">
                                        Admin
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 shadow-sm border border-purple-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mr-1.5"></span> Admin
                                    </span>
                                @elseif($user->role === 'employer')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 shadow-sm border border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Employer
                                    </span>
                                @else
                                    <span class="badge bg-user">
                                        User
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 shadow-sm border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-500 mr-1.5"></span> User
                                    </span>
                                @endif
                            </td>

                            <td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusClasses = match($user->status ?? 'active') {
                                        'active' => 'bg-green-100 text-green-800 border-green-200',
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'inactive', 'suspended' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $statusClasses }}">
                                    {{ $user->status ?? 'Active' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn btn-outline-info">
                                        View
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-500 hover:text-indigo-700 p-2 bg-indigo-50 rounded-md transition-colors" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="btn btn-outline-warning">
                                        Edit
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-amber-500 hover:text-amber-700 p-2 bg-amber-50 rounded-md transition-colors" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.delete', $user) }}"
                                              method="POST"
                                              style="display:inline;">
                                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Archive this user account?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            <button type="submit" class="text-red-500 hover:text-red-700 p-2 bg-red-50 rounded-md transition-colors" title="Delete User">
                                                <i class="fas fa-trash-alt"></i>
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
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-3 bg-gray-100 rounded-full mb-3"><i class="fas fa-search text-gray-400"></i></div>
                                    <p class="text-gray-500 font-medium">No users found matching your criteria.</p>
                                    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 text-sm mt-1 hover:underline">Clear all filters</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="card-footer">
            <div class="px-6 py-4 bg-gray-50 border-top border-gray-100">
                {{ $users->links() }}
            </div>
        @endif

    </div>

</div>

</section>

@endsection
