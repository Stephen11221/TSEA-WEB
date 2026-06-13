<?php

namespace App\Http\Controllers;

use App\Models\UserPassport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    public function index()
    {
        $passport = Auth::user()->passport;
        return view('user.passport.index', compact('passport'));
    }

    public function create()
    {
        if (Auth::user()->passport) return redirect()->route('passport.index');
        return view('user.passport.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'skills' => 'required|array',
            'experience' => 'required|array',
            'education' => 'nullable|array',
            'certifications' => 'nullable|array',
        ]);

        Auth::user()->passport()->create([
            'passport_number' => 'WP-' . strtoupper(uniqid()),
            'skills' => $request->skills,
            'experience' => $request->experience,
            'education' => $request->education ?? [],
            'certifications' => $request->certifications ?? [],
            'status' => 'draft'
        ]);

        return redirect()->route('passport.index')->with('success', 'Passport created as draft.');
    }

    public function submit()
    {
        $passport = Auth::user()->passport;
        if ($passport && $passport->status === 'draft') {
            $passport->update(['status' => 'submitted']);
            return back()->with('success', 'Passport submitted for approval.');
        }
        return back()->with('error', 'Cannot submit passport.');
    }
}