<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * User dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        $passports = []; // TODO: Get user's passports from database
        
        return view('user.dashboard', [
            'user' => $user,
            'passports' => $passports,
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
        // TODO: Get opportunity from database
        return view('user.opportunities.show', ['opportunity' => null]);
    }

    /**
     * Apply to opportunity
     */
    public function applyOpportunity(Request $request, $id)
    {
        // TODO: Store application in database
        return back()->with('success', 'Application submitted successfully');
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
