<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use App\Models\Subscription;
use App\Models\UserPassport;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'new_registrations' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'total_applications' => Application::count(),
            'approved_applications' => Application::where('status', 'approved')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'total_passports' => UserPassport::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}