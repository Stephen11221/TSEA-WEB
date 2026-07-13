<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\TrainerAssignment;
use App\Models\TrainerNote;
use App\Models\TrainerTimetable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerPortalController extends Controller
{
    public function index()
    {
        $trainerId = Auth::id();

        $programs = Program::whereIn('status', ['active', 'published'])
            ->orderBy('title')
            ->get();

        $timetables = TrainerTimetable::with('program')
            ->where('trainer_id', $trainerId)
            ->latest('scheduled_for')
            ->paginate(8, ['*'], 'timetables_page');

        $assignments = TrainerAssignment::with('program')
            ->where('trainer_id', $trainerId)
            ->latest()
            ->paginate(8, ['*'], 'assignments_page');

        $notes = TrainerNote::with('program')
            ->where('trainer_id', $trainerId)
            ->latest()
            ->paginate(8, ['*'], 'notes_page');

        return view('trainer.dashboard', compact('programs', 'timetables', 'assignments', 'notes'));
    }

    public function storeTimetable(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'scheduled_for' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        TrainerTimetable::create($validated + [
            'trainer_id' => Auth::id(),
        ]);

        return back()->with('success', 'Class timetable posted successfully.');
    }

    public function storeAssignment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'due_at' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
        ]);

        $payload = [
            'trainer_id' => Auth::id(),
            'program_id' => $validated['program_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_at' => $validated['due_at'] ?? null,
        ];

        if ($request->hasFile('attachment')) {
            $payload['attachment_path'] = $request->file('attachment')->store('trainer/assignments', 'public');
        }

        TrainerAssignment::create($payload);

        return back()->with('success', 'Assignment posted successfully.');
    }

    public function storeNote(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:5120',
        ]);

        $payload = [
            'trainer_id' => Auth::id(),
            'program_id' => $validated['program_id'] ?? null,
            'title' => $validated['title'],
            'content' => $validated['content'],
        ];

        if ($request->hasFile('attachment')) {
            $payload['attachment_path'] = $request->file('attachment')->store('trainer/notes', 'public');
        }

        TrainerNote::create($payload);

        return back()->with('success', 'Learning note posted successfully.');
    }
}
