<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\JobPosting;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        // User Statistics
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalEmployers = User::where('role', 'employer')->count();
        $totalStudents = User::where('role', 'student')->count();
        $pendingEmployers = User::where('role', 'employer')->where('status', 'pending')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Jobs and Applications Statistics
        $totalJobs = JobPosting::count();
        $activeJobs = JobPosting::where('status', 'open')->count();
        $totalApplications = Application::count();
        $pendingApplications = Application::where('status', 'pending')->count();
        
        // Recent user activities from actual database
        $recentActivities = User::latest()->take(5)->get()->map(function($user) {
            $actionMap = [
                'admin' => 'Registered as Administrator',
                'employer' => 'Registered as Employer',
                'student' => 'Registered as Student',
                'instructor' => 'Registered as Instructor',
            ];
            
            return [
                'user' => $user->name,
                'action' => $actionMap[$user->role] ?? 'User Registration',
                'time' => $user->created_at->diffForHumans(),
            ];
        })->toArray();

        // Monthly user growth statistics from actual data
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = User::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $monthlyStats[$month->format('M')] = $count;
        }
        
        // Program visibility stats
        $allPrograms = Program::all();
        $programStats = [
            'published' => $allPrograms->filter(function($p) {
                $isFuture = $p->scheduled_activation_at && $p->scheduled_activation_at->isFuture();
                $isExpired = $p->scheduled_deactivation_at && $p->scheduled_deactivation_at->isPast();
                return in_array($p->status, ['active', 'published']) && !$isFuture && !$isExpired;
            })->count(),
            'coming_soon' => $allPrograms->filter(function($p) {
                $isFuture = $p->scheduled_activation_at && $p->scheduled_activation_at->isFuture();
                return $p->status === 'unpublished' || (in_array($p->status, ['active', 'published']) && $isFuture);
            })->count(),
            'unavailable' => $allPrograms->filter(function($p) {
                $isExpired = $p->scheduled_deactivation_at && $p->scheduled_deactivation_at->isPast();
                return in_array($p->status, ['inactive', 'archived', 'disabled']) || $isExpired;
            })->count(),
        ];

        // Get total programs
        $totalPrograms = Program::count();
        
        // Calculate engagement rate
        $engagementRate = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;

        return view('admin.dashboard.index', [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'totalAdmins' => $totalAdmins,
            'totalEmployers' => $totalEmployers,
            'totalStudents' => $totalStudents,
            'pendingEmployers' => $pendingEmployers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'totalJobs' => $totalJobs,
            'activeJobs' => $activeJobs,
            'totalApplications' => $totalApplications,
            'pendingApplications' => $pendingApplications,
            'totalPrograms' => $totalPrograms,
            'programStats' => $programStats,
            'recentActivities' => $recentActivities,
            'monthlyStats' => $monthlyStats,
            'engagementRate' => $engagementRate,
            'totalRevenue' => 0,
        ]);
    }

    /**
     * List all users
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Edit user
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,employer,student,instructor,user',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    /**
     * List all job postings
     */
    public function jobsIndex()
    {
        $jobs = JobPosting::with('employer')->latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Show create job form
     */
    public function createJob()
    {
        $employers = User::where('role', 'employer')->get();
        return view('admin.jobs.create', compact('employers'));
    }

    /**
     * Store job posting
     */
    public function storeJob(Request $request)
    {
        $validated = $request->validate([
            'employer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'job_type' => 'required|in:full-time,part-time,contract,internship',
            'deadline' => 'nullable|date',
        ]);

        JobPosting::create($validated + ['status' => 'open', 'posted_date' => now()]);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posted successfully');
    }

    /**
     * Edit job posting
     */
    public function editJob(JobPosting $job)
    {
        $employers = User::where('role', 'employer')->get();
        return view('admin.jobs.edit', compact('job', 'employers'));
    }

    /**
     * Update job posting
     */
    public function updateJob(Request $request, JobPosting $job)
    {
        $validated = $request->validate([
            'employer_id' => 'required|exists:users,id',
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

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully');
    }

    /**
     * Delete job posting
     */
    public function destroyJob(JobPosting $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully');
    }

    /**
     * View all created passports
     */
    public function passportsIndex()
    {
        $passports = \App\Models\UserPassport::with('user')->latest()->paginate(15);
        return view('admin.passports.index', compact('passports'));
    }

    /**
     * Verify/Approve a Workforce Passport
     */
    public function verifyPassport(Request $request, $id)
    {
        $passport = \App\Models\UserPassport::findOrFail($id);
        $passport->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        return back()->with('success', 'Workforce Passport verified successfully.');
    }

    /**
     * Assessments & Analytics Report
     */
    public function reports()
    {
        $applicationStats = Application::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')->get();
            
        return view('admin.reports.index', compact('applicationStats'));
    }

    /**
     * List all programs
     */
    public function programs()
    {
        $allPrograms = Program::all();
        $query = Program::query();

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('level', 'like', "%{$search}%");
            });
        }
        
        $stats = [
            'total' => $allPrograms->count(),
            'published' => $allPrograms->filter(function($p) {
                $isFuture = $p->scheduled_activation_at && $p->scheduled_activation_at->isFuture();
                $isExpired = $p->scheduled_deactivation_at && $p->scheduled_deactivation_at->isPast();
                return in_array($p->status, ['active', 'published']) && !$isFuture && !$isExpired;
            })->count(),
            'coming_soon' => $allPrograms->filter(function($p) {
                return $p->status === 'unpublished' || (in_array($p->status, ['active', 'published']) && $p->scheduled_activation_at && $p->scheduled_activation_at->isFuture());
            })->count(),
            'unavailable' => $allPrograms->filter(function($p) {
                return in_array($p->status, ['inactive', 'archived', 'disabled']) || ($p->scheduled_deactivation_at && $p->scheduled_deactivation_at->isPast());
            })->count(),
        ];

        $programs = $query->latest()->paginate(15)->withQueryString();
        return view('admin.programs.index', compact('programs', 'stats'));
    }

    /**
     * Store a new program
     */
    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,published,unpublished,archived,disabled',
            'scheduled_activation_at' => 'nullable|date',
            'scheduled_deactivation_at' => 'nullable|date|after_or_equal:scheduled_activation_at',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        $validated['is_active'] = in_array($validated['status'], ['active', 'published']);

        Program::create($validated);

        return back()->with('success', 'Program created successfully.');
    }

    /**
     * Update an existing program
     */
    public function updateProgram(Request $request, Program $program)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,published,unpublished,archived,disabled',
            'scheduled_activation_at' => 'nullable|date',
            'scheduled_deactivation_at' => 'nullable|date|after_or_equal:scheduled_activation_at',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        $validated['is_active'] = in_array($validated['status'], ['active', 'published']);

        $program->update($validated);

        return back()->with('success', 'Program updated successfully.');
    }

    /**
     * Delete a program
     */
    public function destroyProgram(Program $program)
    {
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();

        return back()->with('success', 'Program deleted successfully.');
    }

    /**
     * Update program status and scheduling
     */
    public function updateProgramStatus(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        $oldStatus = $program->status;

        $validated = $request->validate([
            'status' => 'required|in:active,inactive,published,unpublished,archived,disabled',
            'scheduled_activation_at' => 'nullable|date',
            'scheduled_deactivation_at' => 'nullable|date|after_or_equal:scheduled_activation_at',
        ]);

        $program->update($validated);

        // Maintain Audit Log
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'status_update',
            'model' => 'Program',
            'model_id' => $program->id,
            'old_values' => json_encode(['status' => $oldStatus]),
            'new_values' => json_encode($validated),
        ]);

        return back()->with('success', "Program '{$program->title}' status updated to {$request->status}.");
    }

    /**
     * Bulk status update for programs
     */
    public function bulkProgramStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:programs,id',
            'action' => 'required|in:activate,deactivate,archive,delete'
        ]);

        $statusMap = [
            'activate' => 'active',
            'deactivate' => 'disabled',
            'archive' => 'archived'
        ];

        if ($request->action === 'delete') {
            Program::whereIn('id', $request->ids)->delete();
            $message = "Selected programs deleted successfully.";
        } else {
            $newStatus = $statusMap[$request->action];
            Program::whereIn('id', $request->ids)->update(['status' => $newStatus]);
            $message = "Selected programs updated to {$newStatus}.";
        }

        // Log bulk action
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'bulk_status_update',
            'model' => 'Program',
            'model_id' => 0,
            'new_values' => json_encode(['action' => $request->action, 'affected_ids' => $request->ids]),
        ]);

        return back()->with('success', $message);
    }

    /**
     * Manage ERI content
     */
    public function eriContent()
    {
        // The 'admin.content.eri' view likely expects an $eri variable.
        $eri = null; // TODO: Fetch actual ERI content from the database

        return view('admin.content.eri', ['eri' => $eri]);
    }

    /**
     * Manage Workforce Passport content
     */
    public function passportContent()
    {
        // Just like eriContent, this view likely expects a variable to be defined.
        $passportContent = null; // TODO: Fetch actual content from database

        return view('admin.content.workforce-passport', ['content' => $passportContent]);
    }

    /**
     * Edit page content
     */
    public function editPage(string $page)
    {
        return view('admin.pages.edit', ['page' => $page]);
    }

    /**
     * Update page content
     */
    public function updatePage(Request $request, string $page)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        // TODO: Save page content to database or file
        
        return redirect()->route('admin.dashboard')->with('success', 'Page updated successfully');
    }

    /**
     * Show admin profile
     */
    public function profile()
    {
        return view('admin.profile.show', ['user' => auth()->user()]);
    }

    /**
     * Edit admin profile
     */
    public function editProfile()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update admin profile
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

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        return view('admin.change-password');
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
