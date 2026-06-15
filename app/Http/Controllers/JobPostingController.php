<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostingController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::where('employer_id', Auth::id())->latest()->paginate(10);
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
            'employer_id' => Auth::id(),
            'status' => 'open',
            'posted_date' => now()
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully');
    }

    public function edit(JobPosting $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }
        return view('employer.jobs.edit', compact('job'));
    }

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

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully');
    }

    public function destroy(JobPosting $job)
    {
        if ($job->employer_id !== Auth::id()) {
            abort(403);
        }
        $job->delete();
        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted successfully');
    }
}