@extends('admin.layouts.admin')

@section('title', 'Manage Students - TSEA Admin')

@section('content')

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
}

.page-container{
    padding:30px;
    background:#f8fafc;
    min-height:100vh;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.title{
    font-size:32px;
    font-weight:700;
    color:#111827;
}

.subtitle{
    color:#6b7280;
    margin-top:5px;
}

.btn-primary{
    background:#4f46e5;
    color:#fff;
    text-decoration:none;
    padding:12px 18px;
    border-radius:8px;
    font-weight:600;
}

.btn-primary:hover{
    background:#4338ca;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 2px 8px rgba(0,0,0,.05);
}

.stat-card h3{
    font-size:28px;
    margin-bottom:5px;
}

.stat-card p{
    color:#6b7280;
    font-size:14px;
}

.card{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 8px rgba(0,0,0,.05);
}

.card-header{
    padding:20px;
    border-bottom:1px solid #e5e7eb;
}

.search-box{
    padding:20px;
    border-bottom:1px solid #e5e7eb;
}

.search-input{
    width:100%;
    max-width:350px;
    padding:10px 15px;
    border:1px solid #d1d5db;
    border-radius:8px;
    outline:none;
}

.search-input:focus{
    border-color:#4f46e5;
}

.table-responsive{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f9fafb;
    text-align:left;
    padding:15px;
    font-size:13px;
}

td{
    padding:15px;
    border-top:1px solid #e5e7eb;
}

tr:hover{
    background:#f9fafb;
}

.user-info{
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#e0e7ff;
    color:#4338ca;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.admin{
    background:#f3e8ff;
    color:#7c3aed;
}

.user{
    background:#dbeafe;
    color:#2563eb;
}

.employer{
    background:#ccfbf1;
    color:#0f766e;
}

.actions{
    display:flex;
    gap:8px;
}

.btn{
    border:none;
    padding:8px 10px;
    border-radius:6px;
    cursor:pointer;
    text-decoration:none;
}

.view{
    background:#dbeafe;
    color:#2563eb;
}

.edit{
    background:#fef3c7;
    color:#d97706;
}

.delete{
    background:#fee2e2;
    color:#dc2626;
}

.alert-success{
    background:#dcfce7;
    color:#166534;
    padding:15px;
    margin-bottom:20px;
    border-radius:8px;
}

.empty{
    text-align:center;
    padding:40px;
    color:#6b7280;
}

.pagination-wrapper{
    padding:20px;
}
</style>

<div class="page-container">

```
<div class="header">
    <div>
        <h1 class="title">Student Directory</h1>
        <p class="subtitle">Manage platform students, roles and permissions.</p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="btn-primary">
        + Add Student
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="stats">
    <div class="stat-card">
        <h3>{{ $users->total() }}</h3>
        <p>Total Students</p>
    </div>

    <div class="stat-card">
        <h3>{{ $users->where('status','active')->count() }}</h3>
        <p>Active Students</p>
    </div>

    <div class="stat-card">
        <h3>{{ $users->where('status','pending')->count() }}</h3>
        <p>Pending Students</p>
    </div>

    <div class="stat-card">
        <h3>{{ $users->where('status','inactive')->count() }}</h3>
        <p>Inactive Students</p>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h2>Manage Students</h2>
    </div>

    <div class="search-box">
        <input
            type="text"
            id="searchUsers"
            class="search-input"
            placeholder="Search students..."
        >
    </div>

    <div class="table-responsive">

        <table id="usersTable">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($users as $user)

                <tr>

                    <td>
                        <div class="user-info">
                            <div class="avatar">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>

                            <div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </div>
                    </td>

                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->isAdmin())
                            <span class="badge admin">Admin</span>
                        @elseif($user->role == 'employer')
                            <span class="badge employer">Employer</span>
                        @else
                            <span class="badge user">Student</span>
                        @endif
                    </td>

                    <td>{{ ucfirst($user->status ?? 'active') }}</td>

                    <td>{{ $user->created_at->format('M d, Y') }}</td>

                    <td>
                        <div class="actions">

                            <a href="{{ route('admin.users.show',$user) }}"
                               class="btn view">
                                View
                            </a>

                            <a href="{{ route('admin.users.edit',$user) }}"
                               class="btn edit">
                                Edit
                            </a>

                            @if(auth()->id() != $user->id)

                            <form action="{{ route('admin.users.delete',$user) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn delete delete-user">
                                    Delete
                                </button>

                            </form>

                            @endif

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6">
                        <div class="empty">
                            No students found.
                        </div>
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>

</div>
```

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const searchInput = document.getElementById('searchUsers');

    searchInput.addEventListener('keyup', function(){

        let value = this.value.toLowerCase();

        document.querySelectorAll('#usersTable tbody tr').forEach(function(row){

            let text = row.textContent.toLowerCase();

            row.style.display = text.includes(value)
                ? ''
                : 'none';

        });

    });

    document.querySelectorAll('.delete-user').forEach(function(btn){

        btn.addEventListener('click', function(e){

            if(!confirm('Are you sure you want to delete this student?')){
                e.preventDefault();
            }

        });

    });

});
</script>

@endsection
