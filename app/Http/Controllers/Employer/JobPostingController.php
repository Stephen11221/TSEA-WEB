<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the employer's job postings.
     */
    public function index()
    {
        $jobs = JobPosting::where('employer_id', Auth::id())
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    /**
     * Show the employer dashboard with stats and recent applications.
     */
    public function dashboard()
    {
        $employerId = Auth::id();

        $stats = [
            'total_jobs' => JobPosting::where('employer_id', $employerId)->count(),
            'active_jobs' => JobPosting::where('employer_id', $employerId)->where('status', 'open')->count(),
            'total_applications' => Application::whereHas('job', function($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })->count(),
            'pending_applications' => Application::whereHas('job', function($query) use ($employerId) {
                $query->where('employer_id', $employerId);
            })->where('status', 'pending')->count(),
        ];

        $recentApplications = Application::whereHas('job', function($query) use ($employerId) {
            $query->where('employer_id', $employerId);
        })->with(['user', 'job'])->latest()->take(5)->get();

        return view('employer.dashboard', compact('stats', 'recentApplications'));
    }

    /**
     * List all applications for the employer's jobs.
     */
    public function applications()
    {
        $employerId = Auth::id();
        
        $applications = Application::whereHas('job', function($query) use ($employerId) {
            $query->where('employer_id', $employerId);
        })->with(['user', 'job'])->latest()->paginate(15);

        return view('employer.applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new job posting.
     */
    public function create()
    {
        return view('employer.jobs.create');
    }

    /**
     * Store a newly created job posting in storage.
     */
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
            'employer_id' => Auth::id(),
            'status' => 'open',
            'posted_date' => now()
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Job posting created successfully.');
    }

    /**
     * Display the specified application details.
     */
    public function showApplication(Application $application)
    {
        // Security check: Ensure this application belongs to a job posted by this employer
        if ($application->job->employer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load passport details for the profile view
        $application->load(['user.passport', 'job']);

        return view('employer.show', compact('application'));
    }

    /**
     * Display the specified job posting.
     */
    public function show(JobPosting $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }
        return view('employer.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job posting.
     */
    public function edit(JobPosting $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }
        return view('employer.jobs.edit', compact('job'));
    }

    /**
     * Update the specified job posting in storage.
     */
    public function update(Request $request, JobPosting $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'deadline' => 'nullable|date',
            'status' => 'required|in:open,closed,filled',
        ]);

        $job->update($validated);

        return redirect()->route('employer.jobs.index')->with('success', 'Job posting updated successfully.');
    }

    /**
     * Remove the specified job posting from storage.
     */
    public function destroy(JobPosting $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job posting deleted successfully.');
    }

    /**
     * Update the status of an application (Shortlist, Accept, Reject).
     */
    public function updateStatus(Request $request, Application $application)
    {
        if ($application->job->employer_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,shortlisted,accepted,rejected,closed',
        ]);

        $application->update([
            'status' => $validated['status']
        ]);

        // Optional: Trigger notification to user here

        return back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Show employer profile
     */
    public function profile()
    {
        return view('employer.profile.show', ['user' => auth()->user()]);
    }

    /**
     * Edit employer profile
     */
    public function editProfile()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update employer profile
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $user->update($validated);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return redirect()->route('employer.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Change password form
     */
    public function changePassword()
    {
        return view('employer.change-password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully');
    }
}