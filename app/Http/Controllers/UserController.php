<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program; // Import the Program model
use App\Models\JobPosting;
use App\Models\Application;

class UserController extends Controller
{
    /**
     * User dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        $passports = $user->passport; // Assuming a user has one passport
        $applications = $user->applications()->latest()->take(5)->get(); // Get recent applications
        $recommendedPrograms = Program::where('is_active', true)->inRandomOrder()->take(3)->get(); // Fetch some recommended programs
        
        return view('user.dashboard', [
            'user' => $user,
            'passports' => $passports, // Pass the user's passport
            'applications' => $applications, // Pass recent applications
            'recommendedPrograms' => $recommendedPrograms, // Pass recommended programs
        ]);
    }

    /**
     * Create passport
     */
    public function createPassport()
    {
        return view('user.passport.create');
    }

    /**
     * Store passport
     */
    public function storePassport(Request $request)
    {
        $validated = $request->validate([
            'skills' => 'required|array',
            'experience' => 'required|string',
            'education' => 'required|string',
        ]);

        // TODO: Save passport to database
        
        return redirect()->route('user.dashboard')->with('success', 'Passport created successfully');
    }

    /**
     * View user passports
     */
    public function passports()
    {
        $passports = []; // TODO: Get user's passports from database
        return view('user.passports.index', ['passports' => $passports]);
    }

    /**
     * Search opportunities
     */
    public function searchOpportunities(Request $request)
    {
        $query = $request->input('q');
        $opportunities = []; // TODO: Search opportunities in database
        
        return view('user.opportunities.search', ['opportunities' => $opportunities, 'query' => $query]);
    }

    /**
     * View opportunity details
     */
    public function viewOpportunity($id)
    {
        $opportunity = JobPosting::with('employer')->findOrFail($id);
        return view('user.opportunities.show', compact('opportunity'));
    }

    /**
     * Apply to opportunity
     */
    public function applyOpportunity(Request $request, $id)
    {
        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'resume_path' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
        ]);

        $user = auth()->user();

        // Handle resume upload
        $resumePath = $request->file('resume_path')->store('resumes', 'public');

        // Create the application
        Application::create([
            'user_id' => $user->id,
            'job_posting_id' => $id, // Assuming $id is the job_posting_id
            'cover_letter' => $validated['cover_letter'],
            'resume_path' => $resumePath,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()->route('user.opportunities.show', $id)->with('success', 'Application submitted successfully!');
    }

    /**
     * User profile
     */
    public function profile()
    {
        return view('user.profile.show', ['user' => auth()->user()]);
    }

    /**
     * Edit profile
     */
    public function editProfile()
    {
        return view('user.profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($validated);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        return view('user.change-password');
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
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully');
    }
}
