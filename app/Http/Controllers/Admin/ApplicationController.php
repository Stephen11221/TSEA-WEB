<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        // Fetch all applications with eager-loaded user, job, and the job's employer
        $applications = Application::with([
            'user', 
            'job.employer'
        ])->latest()->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    public function show(Application $application): View
    {
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application): RedirectResponse
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        
        $application->update([
            'status' => $request->status,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return back()->with('success', "Application status updated to {$request->status}.");
    }
}