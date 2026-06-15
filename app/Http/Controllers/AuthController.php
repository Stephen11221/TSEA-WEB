<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show employer registration form
     */
    public function showEmployerRegister()
    {
        return view('employer-register');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Check if user exists and is active before attempting login
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user && $user->status !== 'active') {
            return back()->withErrors([
                'email' => "Your account status is currently: {$user->status}. Please contact an administrator.",
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role
            $user = auth()->user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'employer') {
                return redirect()->route('employer.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'role' => 'required|in:user,employer,instructor',
            'password' => 'required|string|min:8|confirmed',
            'company_website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:255',
            'agree_terms' => 'required|accepted',
        ]);

        return DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => $validated['role'] === 'employer' ? 'pending' : 'active',
                'is_verified' => false,
            ]);

            if ($user->role === 'employer') {
                $user->employer()->create([
                    'company_name' => $validated['name'],
                    'website' => $validated['company_website'] ?? null,
                    'industry' => $validated['industry'] ?? null,
                    'company_size' => $validated['company_size'] ?? null,
                    'about' => $validated['bio'] ?? null,
                ]);
            }

            if ($user->role === 'employer') {
                return redirect()->route('login')->with('success', 'Registration submitted! Your account is pending admin approval.');
            }

            Auth::login($user);

            return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome to TSEA.');
        });
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
