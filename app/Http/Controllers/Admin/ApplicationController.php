<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationController extends Controller
{
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
        $this->authorize('view', $application);
        
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update the application status.
     */
    public function updateStatus(Request $request, Application $application): RedirectResponse
    {
        $this->authorize('update', $application);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        
        $application->update([
            'status' => $validated['status'],
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return back()->with('success', "Application status updated to {$validated['status']}.");
    }

    /**
     * Download the application's resume file.
     */
    public function downloadResume(Application $application): StreamedResponse
    {
        $this->authorize('downloadResume', $application);

        // Validate resume path to prevent directory traversal
        if (!$application->resume_path || !$this->isValidResumePath($application->resume_path)) {
            abort(404, 'Resume file not found');
        }

        // Check file exists
        if (!Storage::disk('public')->exists($application->resume_path)) {
            abort(404, 'Resume file not found');
        }

        return Storage::disk('public')->download($application->resume_path);
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