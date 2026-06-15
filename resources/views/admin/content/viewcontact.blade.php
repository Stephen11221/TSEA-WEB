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
    margin-bottom:25px;
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

.alert-success{
    background:#dcfce7;
    color:#166534;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.card-header{
    padding:20px;
    border-bottom:1px solid #e5e7eb;
}

.card-title{
    font-size:18px;
    font-weight:600;
    color:#4f46e5;
}

.table-wrapper{
    overflow-x:auto;
}

.contact-table{
    width:100%;
    border-collapse:collapse;
}

.contact-table th{
    background:#f9fafb;
    padding:15px;
    text-align:left;
    font-size:13px;
    font-weight:600;
    color:#374151;
    border-bottom:1px solid #e5e7eb;
}

.contact-table td{
    padding:15px;
    border-bottom:1px solid #e5e7eb;
    vertical-align:top;
}

.contact-table tr:hover{
    background:#f8fafc;
}

.date-cell{
    white-space:nowrap;
    color:#6b7280;
}

.email-text,
.small-text{
    color:#6b7280;
    font-size:13px;
}

.badge{
    display:inline-block;
    padding:6px 12px;
    background:#3b82f6;
    color:#fff;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.message-box{
    max-height:120px;
    overflow-y:auto;
    font-size:14px;
    line-height:1.5;
}

.delete-btn{
    border:none;
    background:#fee2e2;
    color:#dc2626;
    padding:10px 12px;
    border-radius:8px;
    cursor:pointer;
}

.delete-btn:hover{
    background:#fecaca;
}

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#6b7280;
}

.pagination-wrapper{
    padding:20px;
    border-top:1px solid #e5e7eb;
}

@media(max-width:768px){
    .page-header{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>

@extends('admin.layouts.admin')

@section('title', 'Contact Submissions - TSEA Admin')

@section('content')

<div class="page-container">

```
<div class="page-header">
    <div>
        <h1 class="page-title">Contact Submissions</h1>
        <p class="page-subtitle">
            View and manage messages from the contact form.
        </p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">

    <div class="card-header">
        <h2 class="card-title">Inbound Messages</h2>
    </div>

    <div class="table-wrapper">

        <table class="contact-table">

            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Organization</th>
                    <th>Stakeholder</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($submissions as $submission)

                <tr>

                    <td class="date-cell">
                        {{ $submission->created_at->format('M d, Y') }}
                        <br>
                        <small>{{ $submission->created_at->format('h:i A') }}</small>
                    </td>

                    <td>
                        <strong>{{ $submission->name }}</strong>
                    </td>

                    <td>
                        <span class="email-text">
                            {{ $submission->email }}
                        </span>
                    </td>

                    <td>
                        {{ $submission->phone ?: 'N/A' }}
                    </td>

                    <td>
                        {{ $submission->organization ?: 'N/A' }}
                    </td>

                    <td>
                        <span class="badge">
                            {{ $submission->stakeholder }}
                        </span>
                    </td>

                    <td>
                        <div class="message-box">
                            {{ $submission->message }}
                        </div>
                    </td>

                    <td>

                        <form action="{{ route('admin.contact.submissions.delete', $submission) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this submission?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-envelope-open fa-3x"></i>
                            <p>No contact submissions found yet.</p>
                        </div>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($submissions->hasPages())
        <div class="pagination-wrapper">
            {{ $submissions->links() }}
        </div>
    @endif

</div>


</div>

@endsection
