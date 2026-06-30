<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApplicationController extends Controller
{
    /**
     * Show student enrollments grouped by program context.
     */
    public function enrollments(Request $request): View
    {
        $programs = Program::query()->orderBy('title')->get(['id', 'title']);

        $selectedProgramId = $request->filled('program_id') ? (int) $request->input('program_id') : null;
        $status = $request->input('status');
        $search = trim((string) $request->input('search', ''));

        $enrollmentsQuery = Application::query()
            ->with([
                'user:id,name,email,phone',
                'program:id,title',
            ])
            ->whereNotNull('program_id');

        if ($selectedProgramId) {
            $enrollmentsQuery->where('program_id', $selectedProgramId);
        }

        if (!empty($status)) {
            $enrollmentsQuery->where('status', $status);
        }

        if ($search !== '') {
            $enrollmentsQuery->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $enrollments = $enrollmentsQuery
            ->orderByDesc('submitted_at')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $programCounts = Application::query()
            ->selectRaw('program_id, COUNT(*) as total')
            ->whereNotNull('program_id')
            ->groupBy('program_id')
            ->pluck('total', 'program_id');

        $stats = [
            'total_enrollments' => Application::whereNotNull('program_id')->count(),
            'unique_students' => Application::whereNotNull('program_id')->distinct('user_id')->count('user_id'),
            'programs_with_enrollments' => $programCounts->count(),
        ];

        return view('admin.enrollments.index', [
            'enrollments' => $enrollments,
            'programs' => $programs,
            'programCounts' => $programCounts,
            'selectedProgramId' => $selectedProgramId,
            'status' => $status,
            'search' => $search,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the list of all job applications.
     */
    public function index(): View
    {
        // Fetch all applications with eager-loaded user, job, and the job's employer
        $applications = Application::with([
            'user', 
            'job.employer'
        ])->latest()->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Show the application details.
     */
    public function show(Application $application): View
    {
        Gate::authorize('view', $application);
        
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update the application status.
     */
    public function updateStatus(Request $request, Application $application): RedirectResponse
    {
        Gate::authorize('update', $application);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        
        $application->update([
            'status' => $validated['status'],
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return back()->with('success', "Application status updated to {$validated['status']}.");
    }

    /**
     * Download the application's resume file.
     */
    public function downloadResume(Application $application): BinaryFileResponse
    {
        Gate::authorize('downloadResume', $application);

        // Validate resume path to prevent directory traversal
        if (!$application->resume_path || !$this->isValidResumePath($application->resume_path)) {
            abort(404, 'Resume file not found');
        }

        // Check file exists
        if (!Storage::disk('public')->exists($application->resume_path)) {
            abort(404, 'Resume file not found');
        }

        return response()->download(storage_path('app/public/' . $application->resume_path));
    }

    /**
     * Validate that the resume path is legitimate and doesn't contain traversal sequences.
     */
    private function isValidResumePath(string $path): bool
    {
        // Check for directory traversal attempts
        if (strpos($path, '..') !== false || strpos($path, '//') !== false) {
            return false;
        }

        // Check that path starts with expected directory
        if (!str_starts_with($path, 'applications/')) {
            return false;
        }

        // Validate file extension
        $allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        return in_array($extension, $allowedExtensions, true);
    }
}