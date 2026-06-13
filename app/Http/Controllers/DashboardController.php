<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Fetch some recommended programs for the user
        $recommendedPrograms = Program::where('is_active', true)->limit(3)->get();

        return view('user.dashboard', compact('user', 'recommendedPrograms'));
    }
}