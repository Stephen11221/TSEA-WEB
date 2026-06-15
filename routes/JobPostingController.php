<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\Application;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    public function dashboard()
    {
        $employerId = auth()->id();
        $stats = [
            'total_jobs' => JobPosting::where('employer_id', $employerId)->count(),
            'active_jobs' => JobPosting::where('employer_id', $employerId)->where('status', 'open')->count(),
            'total_applications' => Application::whereHas('job', function($q) use ($employerId) {
                $q->where('employer_id', $employerId);
            })->count(),
            'pending_applications' => Application::where('status', 'pending')->whereHas('job', function($q) use ($employerId) {
                $q->where('employer_id', $employerId);
            })->count(),
        ];

        $recentApplications = Application::whereHas('job', function($q) use ($employerId) {
            $q->where('employer_id', $employerId);
        })->with(['user', 'job'])->latest()->take(5)->get();

        return view('employer.dashboard', compact('stats', 'recentApplications'));
    }

    public function index()
    {
        $jobs = JobPosting::where('employer_id', auth()->id())->latest()->paginate(10);
        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'deadline' => 'nullable|date',
        ]);

        JobPosting::create($validated + [
            'employer_id' => auth()->id(),
            'status' => 'open',
            'posted_date' => now()
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully.');
    }

    public function edit(JobPosting $job)
    {
        if ($job->employer_id !== auth()->id()) abort(403);
        return view('employer.jobs.edit', compact('job'));
    }

    public function update(Request $request, JobPosting $job)
    {
        if ($job->employer_id !== auth()->id()) abort(403);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:open,closed,filled',
            // ... other validations
        ]);

        $job->update($validated);
        return redirect()->route('employer.jobs.index')->with('success', 'Job updated.');
    }

    public function applications()
    {
        $employerId = auth()->id();
        $applications = Application::whereHas('job', function($q) use ($employerId) {
            $q->where('employer_id', $employerId);
        })->with(['user', 'job'])->latest()->paginate(15);

        return view('employer.applications.index', compact('applications'));
    }

    public function showApplication(Application $application)
    {
        // Ensure application belongs to one of this employer's jobs
        if ($application->job->employer_id !== auth()->id()) abort(403);
        
        $application->load(['user.passport', 'job']);
        return view('employer.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        if ($application->job->employer_id !== auth()->id()) abort(403);

        $request->validate(['status' => 'required|string']);
        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated to ' . $request->status);
    }
}