<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        
        // Mock data for jobs and courses (will be real once those models are populated)
        $totalJobs = 0;
        $activeJobs = 0;
        $totalCourses = 0;
        $activeCourses = 0;
        $totalApplications = 0;
        $pendingApplications = 0;
        $totalRevenue = 0;
        
        // Recent activities
        $recentActivities = [
            ['user' => 'John Doe', 'action' => 'Created new user account', 'time' => '2 hours ago'],
            ['user' => 'Jane Smith', 'action' => 'Updated course content', 'time' => '4 hours ago'],
            ['user' => 'Mike Johnson', 'action' => 'Posted new job', 'time' => '1 day ago'],
        ];
        
        // Monthly statistics
        $monthlyStats = [
            'Jan' => 45, 'Feb' => 52, 'Mar' => 48, 'Apr' => 61,
            'May' => 55, 'Jun' => 67, 'Jul' => 72, 'Aug' => 68,
            'Sep' => 74, 'Oct' => 79, 'Nov' => 85, 'Dec' => 90
        ];
        
        return view('admin.dashboard.index', [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'totalAdmins' => $totalAdmins,
            'newUsersThisMonth' => $newUsersThisMonth,
            'totalJobs' => $totalJobs,
            'activeJobs' => $activeJobs,
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'totalApplications' => $totalApplications,
            'pendingApplications' => $pendingApplications,
            'totalRevenue' => $totalRevenue,
            'recentActivities' => $recentActivities,
            'monthlyStats' => $monthlyStats,
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
            'role' => 'required|in:admin,user',
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
     * View all created passports
     */
    public function passports()
    {
        // TODO: Implement when Passport model is created
        return view('admin.passports.index');
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
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully');
    }
}
