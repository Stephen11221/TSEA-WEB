@extends('layouts.app')

@section('title', 'Learning Feed - TSEA')

@section('content')
<div class="container py-5">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; gap:12px; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:30px; font-weight:800;">Student Learning Feed</h1>
            <p style="color:#64748b;">Class timetable, assignments, and trainer notes posted for students.</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px,1fr)); gap:16px;">
        <div class="card">
            <h2 style="font-size:20px; margin-bottom:12px;">Class Timetable</h2>
            @forelse($timetables as $item)
                <div style="padding:12px 0; border-bottom:1px solid #e5e7eb;">
                    <strong>{{ $item->title }}</strong>
                    <div style="font-size:13px; color:#64748b;">By {{ $item->trainer->name ?? 'Trainer' }} | {{ optional($item->scheduled_for)->format('M d, Y H:i') }}</div>
                    <div style="font-size:13px; color:#64748b;">{{ $item->program->title ?? 'All Students' }}</div>
                    @if($item->description)
                        <p style="margin:6px 0 0; color:#334155;">{{ $item->description }}</p>
                    @endif
                </div>
            @empty
                <p style="color:#64748b;">No timetable updates yet.</p>
            @endforelse
        </div>

        <div class="card">
            <h2 style="font-size:20px; margin-bottom:12px;">Assignments</h2>
            @forelse($assignments as $item)
                <div style="padding:12px 0; border-bottom:1px solid #e5e7eb;">
                    <strong>{{ $item->title }}</strong>
                    <div style="font-size:13px; color:#64748b;">By {{ $item->trainer->name ?? 'Trainer' }} | Due {{ optional($item->due_at)->format('M d, Y H:i') ?: 'Not set' }}</div>
                    <div style="font-size:13px; color:#64748b;">{{ $item->program->title ?? 'All Students' }}</div>
                    <p style="margin:6px 0 0; color:#334155;">{{ $item->description }}</p>
                    @if($item->attachment_path)
                        <a href="{{ asset('storage/' . $item->attachment_path) }}" target="_blank" style="font-size:13px;">Download attachment</a>
                    @endif
                </div>
            @empty
                <p style="color:#64748b;">No assignments posted yet.</p>
            @endforelse
        </div>

        <div class="card">
            <h2 style="font-size:20px; margin-bottom:12px;">Trainer Notes</h2>
            @forelse($notes as $item)
                <div style="padding:12px 0; border-bottom:1px solid #e5e7eb;">
                    <strong>{{ $item->title }}</strong>
                    <div style="font-size:13px; color:#64748b;">By {{ $item->trainer->name ?? 'Trainer' }} | {{ $item->program->title ?? 'All Students' }}</div>
                    <p style="margin:6px 0 0; color:#334155;">{{ $item->content }}</p>
                    @if($item->attachment_path)
                        <a href="{{ asset('storage/' . $item->attachment_path) }}" target="_blank" style="font-size:13px;">View note file</a>
                    @endif
                </div>
            @empty
                <p style="color:#64748b;">No notes shared yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
