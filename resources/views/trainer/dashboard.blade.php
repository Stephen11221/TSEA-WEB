@extends('layouts.app')

@section('title', 'Trainer Dashboard')

@section('content')
<div class="container py-5">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="font-size:30px; font-weight:800;">Trainer Dashboard</h1>
            <p style="color:#64748b;">Create class timetable, post assignments, and publish notes for students.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="padding:12px; border-radius:8px; background:rgba(0,179,89,.12); color:#08763f; border:1px solid rgba(0,179,89,.25); margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding:12px; border-radius:8px; background:rgba(220,53,69,.12); color:#b42318; border:1px solid rgba(220,53,69,.25); margin-bottom:16px;">
            Please review form fields and try again.
        </div>
    @endif

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:16px; margin-bottom:20px;">
        <div class="card">
            <h2 style="font-size:20px; margin-bottom:10px;">Post Class Timetable</h2>
            <form action="{{ route('trainer.timetable.store') }}" method="POST" style="display:grid; gap:8px;">
                @csrf
                <input type="text" name="title" placeholder="Class title" required style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <textarea name="description" rows="3" placeholder="Class details" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;"></textarea>
                <select name="program_id" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                    <option value="">General (All Students)</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                    @endforeach
                </select>
                <input type="datetime-local" name="scheduled_for" required style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <input type="text" name="location" placeholder="Location / Link" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <button class="btn btn-primary" type="submit">Post Timetable</button>
            </form>
        </div>

        <div class="card">
            <h2 style="font-size:20px; margin-bottom:10px;">Post Assignment</h2>
            <form action="{{ route('trainer.assignments.store') }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:8px;">
                @csrf
                <input type="text" name="title" placeholder="Assignment title" required style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <textarea name="description" rows="3" placeholder="Assignment instructions" required style="padding:10px; border:1px solid #d1d5db; border-radius:8px;"></textarea>
                <select name="program_id" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                    <option value="">General (All Students)</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                    @endforeach
                </select>
                <input type="datetime-local" name="due_at" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <input type="file" name="attachment" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <button class="btn btn-primary" type="submit">Post Assignment</button>
            </form>
        </div>

        <div class="card">
            <h2 style="font-size:20px; margin-bottom:10px;">Post Notes</h2>
            <form action="{{ route('trainer.notes.store') }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:8px;">
                @csrf
                <input type="text" name="title" placeholder="Note title" required style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <textarea name="content" rows="3" placeholder="Learning notes" required style="padding:10px; border:1px solid #d1d5db; border-radius:8px;"></textarea>
                <select name="program_id" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                    <option value="">General (All Students)</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                    @endforeach
                </select>
                <input type="file" name="attachment" style="padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                <button class="btn btn-primary" type="submit">Post Note</button>
            </form>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:16px;">
        <div class="card">
            <h3 style="font-size:18px; margin-bottom:10px;">Recent Timetables</h3>
            @forelse($timetables as $item)
                <div style="padding:10px 0; border-bottom:1px solid #e5e7eb;">
                    <strong>{{ $item->title }}</strong>
                    <div style="font-size:13px; color:#64748b;">{{ optional($item->scheduled_for)->format('M d, Y H:i') }} | {{ $item->program->title ?? 'All Students' }}</div>
                </div>
            @empty
                <p style="color:#64748b;">No timetables yet.</p>
            @endforelse
        </div>

        <div class="card">
            <h3 style="font-size:18px; margin-bottom:10px;">Recent Assignments</h3>
            @forelse($assignments as $item)
                <div style="padding:10px 0; border-bottom:1px solid #e5e7eb;">
                    <strong>{{ $item->title }}</strong>
                    <div style="font-size:13px; color:#64748b;">Due: {{ optional($item->due_at)->format('M d, Y H:i') ?: 'Not set' }} | {{ $item->program->title ?? 'All Students' }}</div>
                </div>
            @empty
                <p style="color:#64748b;">No assignments yet.</p>
            @endforelse
        </div>

        <div class="card">
            <h3 style="font-size:18px; margin-bottom:10px;">Recent Notes</h3>
            @forelse($notes as $item)
                <div style="padding:10px 0; border-bottom:1px solid #e5e7eb;">
                    <strong>{{ $item->title }}</strong>
                    <div style="font-size:13px; color:#64748b;">{{ $item->program->title ?? 'All Students' }}</div>
                </div>
            @empty
                <p style="color:#64748b;">No notes yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
