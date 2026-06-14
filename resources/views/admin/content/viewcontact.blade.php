@extends('admin.layouts.admin')

@section('title', 'Contact Submissions - TSEA Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Contact Submissions</h1>
            <p class="text-muted">View and manage messages from the contact form.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Inbound Messages</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0 px-4" style="width: 120px;">Date</th>
                            <th class="border-top-0" style="width: 150px;">Name</th>
                            <th class="border-top-0" style="width: 200px;">Email</th>
                            <th class="border-top-0" style="width: 120px;">Phone</th>
                            <th class="border-top-0" style="width: 150px;">Organization</th>
                            <th class="border-top-0">Stakeholder</th>
                            <th class="border-top-0" style="width: 300px;">Message</th> {{-- Removed max-width for better expansion --}}
                            <th class="border-top-0 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                            <tr>
                                <td class="px-4 text-muted" style="white-space: nowrap;">
                                    {{ $submission->created_at->format('M d, Y') }}<br>
                                    <small>{{ $submission->created_at->format('h:i A') }}</small>
                                </td>
                                <td style="vertical-align: top;">
                                    <strong>{{ $submission->name }}</strong>
                                </td>
                                <td style="vertical-align: top;">
                                    <small class="text-muted">{{ $submission->email }}</small>
                                </td>
                                <td style="vertical-align: top;">
                                    @if($submission->phone)<small class="text-muted">{{ $submission->phone }}</small>@else N/A @endif
                                </td>
                                <td style="vertical-align: top;">
                                    @if($submission->organization)<div class="small text-muted">{{ $submission->organization }}</div>@else N/A @endif
                                </td>
                                <td style="vertical-align: top;">
                                    <span class="badge bg-info text-white">{{ $submission->stakeholder }}</span>
                                </td>
                                <td style="vertical-align: top; ">
                                    {{-- Added max-height and overflow-y for better message display without breaking layout --}}
                                    <div style="font-size: 0.9rem; max-height: 100px; overflow-y: auto; padding-right: 5px;">
                                        {{ $submission->message }}
                                    </div>
                                </td>
                                <td class="text-end px-4">
                                    <form action="{{ route('admin.contact.submissions.delete', $submission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-envelope-open fa-3x mb-3 opacity-25"></i>
                                    <p>No contact submissions found yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($submissions->hasPages())
            <div class="card-footer bg-white">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection