@extends('admin.layouts.admin')

@section('title', 'Add New Student - TSEA Admin')

@section('content')

<style>
.page-container{
    padding:30px;
    background:#f8fafc;
    min-height:100vh;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:15px;
}

.page-title{
    font-size:32px;
    font-weight:700;
    color:#111827;
}

.page-subtitle{
    color:#6b7280;
    margin-top:5px;
}

.back-btn{
    background:#fff;
    color:#374151;
    border:1px solid #d1d5db;
    padding:12px 18px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
}

.back-btn:hover{
    background:#f9fafb;
}

.form-wrapper{
    max-width:800px;
    margin:auto;
}

.card{
    background:#fff;
    border-radius:16px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
    overflow:hidden;
}

.card-body{
    padding:40px;
}

.form-group{
    margin-bottom:25px;
}

.form-label{
    display:block;
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:#374151;
}

.form-control{
    width:100%;
    padding:12px 15px;
    border:1px solid #d1d5db;
    border-radius:8px;
    outline:none;
    font-size:14px;
}

.form-control:focus{
    border-color:#4f46e5;
}

.error-text{
    color:#dc2626;
    font-size:13px;
    margin-top:5px;
}

.helper-text{
    font-size:12px;
    color:#6b7280;
    margin-top:5px;
}

.form-footer{
    margin-top:30px;
    padding-top:20px;
    border-top:1px solid #e5e7eb;
    text-align:right;
}

.submit-btn{
    background:#4f46e5;
    color:#fff;
    border:none;
    padding:12px 24px;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}

.submit-btn:hover{
    background:#4338ca;
}
</style>

<div class="page-container">

```
<div class="page-header">
    <div>
        <h1 class="page-title">Add New Student</h1>
        <p class="page-subtitle">
            Create a new student account with specific roles and permissions.
        </p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="back-btn">
        ← Back to Student Directory
    </a>
</div>

<div class="form-wrapper">

    <div class="card">

        <div class="card-body">

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Full Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           placeholder="John Doe"
                           required>

                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control"
                           placeholder="john@example.com"
                           required>

                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">System Role</label>

                    <select name="role"
                            class="form-control"
                            required>
                        <option value="">Select Role</option>
                        <option value="student">Student</option>
                        <option value="employer">Employer</option>
                        <option value="instructor">Instructor</option>
                    </select>

                    @error('role')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Initial Password</label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           required>

                    <small class="helper-text">
                        Student will be created as active and verified.
                    </small>

                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <button type="submit" class="submit-btn">
                        Create Student Account
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>
```

</div>

@endsection
