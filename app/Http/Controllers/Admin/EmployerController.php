<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EmployerController extends Controller
{
    /**
     * Display a listing of the employers.
     */
    public function index(): View
    {
        $employers = User::where('role', 'employer')->latest()->paginate(20);
        return view('admin.employers.index', compact('employers'));
    }

    /**
     * Show the form for creating a new employer.
     */
    public function create(): View
    {
        return view('admin.employers.create');
    }

    /**
     * Store a newly created employer in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'employer',
            'status' => 'active',
            'is_verified' => true,
        ]);

        return redirect()->route('admin.employers.index')
            ->with('success', 'Employer account created successfully.');
    }

    /**
     * Show the form for editing the specified employer.
     */
    public function edit(User $employer): View
    {
        if ($employer->role !== 'employer') {
            abort(404, 'Employer not found.');
        }

        return view('admin.employers.edit', compact('employer'));
    }

    /**
     * Update the specified employer in storage.
     */
    public function update(Request $request, User $employer): RedirectResponse
    {
        if ($employer->role !== 'employer') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $employer->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive,suspended,pending'],
        ]);

        $employer->update($validated);

        return redirect()->route('admin.employers.index')
            ->with('success', 'Employer details updated successfully.');
    }

    /**
     * Approve a pending employer.
     */
    public function approve(User $employer): RedirectResponse
    {
        if ($employer->role !== 'employer') {
            abort(404);
        }

        $employer->update([
            'status' => 'active',
            'is_verified' => true
        ]);

        return back()->with('success', "Employer {$employer->name} has been approved.");
    }

    /**
     * Remove the specified employer from storage.
     */
    public function destroy(User $employer): RedirectResponse
    {
        if ($employer->role !== 'employer') {
            abort(404);
        }

        $employer->delete();

        return redirect()->route('admin.employers.index')
            ->with('success', 'Employer account deleted successfully.');
    }
}