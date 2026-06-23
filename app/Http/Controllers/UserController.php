<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program; // Import the Program model
use App\Models\JobPosting;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Student dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        $passports = $user->passport; // Assuming a user has one passport
        $applications = $user->applications()->with(['jobPosting', 'program'])->latest()->take(5)->get(); // Get recent applications
        $unreadNotificationsCount = $user->notifications()->unread()->count(); // Get unread notifications count
        $recommendedPrograms = Program::where('is_active', true)->inRandomOrder()->take(3)->get(); // Fetch some recommended programs
        
        return view('user.dashboard', [
            'user' => $user,
            'unreadNotificationsCount' => $unreadNotificationsCount, // Pass unread notifications count
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
        $opportunities = JobPosting::where('status', 'open')
            ->when($query, function ($q) use ($query) {
                return $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('location', 'LIKE', "%{$query}%");
            })
            ->with('employer')
            ->latest()
            ->get();
        
        return view('user.opportunities.search', compact('opportunities', 'query'));
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
     * Show application form
     */
    public function showApplyForm($id)
    {
        $opportunity = JobPosting::with('employer')->findOrFail($id);
        return view('user.opportunities.apply', compact('opportunity'));
    }

    /**
     * Apply to opportunity
     */
    public function applyOpportunity(Request $request, $id)
    {
        $validated = $request->validate([
            'cover_letter' => 'required|string|min:50|max:5000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048', // Max 2MB
        ]);

        $user = auth()->user();

        // Check if user already applied
        $existing = Application::where('user_id', $user->id)
            ->where('job_posting_id', $id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied for this opportunity.');
        }

        // Handle resume upload
        $cvPath = $request->file('cv')->store('resumes', 'public');

        // Create the application
        Application::create([
            'user_id' => $user->id,
            'job_posting_id' => $id,
            'cover_letter' => $validated['cover_letter'],
            'resume_path' => $cvPath,
            'status' => 'pending',
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
        return view('profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update profile
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
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully');
    }

    /**
     * Display a listing of the user's notifications.
     */
    public function notificationsIndex()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->paginate(10); // Paginate for large number of notifications
        return view('user.notifications.index', compact('notifications'));
    }

    /**
     * Display a listing of the user's applications.
     */
    public function applicationsIndex()
    {
        $applications = auth()->user()->applications()->with('job')->latest()->paginate(10);
        return view('user.applications.index', compact('applications'));
    }

    /**
     * Mark a notification as read.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markNotificationAsRead(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }
        $notification->update(['read_at' => now()]);
        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Display the multi-step student enrollment tracking page.
     */
    public function showEnrollment($id)
    {
        $program = \App\Models\Program::findOrFail($id);
        $existingEnrollment = Application::where('user_id', auth()->id())
            ->where('program_id', $program->id)
            ->first();

        return view('enrollment.track', compact('program', 'existingEnrollment'));
    }

    public function storeEnrollment(Request $request, $id)
    {
        $program = Program::whereKey($id)
            ->whereIn('status', ['active', 'published'])
            ->firstOrFail();

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        $existingEnrollment = Application::where('user_id', auth()->id())
            ->where('program_id', $program->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()
                ->route('user.dashboard')
                ->with('success', 'You are already enrolled in this program.');
        }

        Application::create([
            'user_id' => auth()->id(),
            'program_id' => $program->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('user.dashboard')
            ->with('success', "Enrollment submitted for {$program->title}.");
    }
}
