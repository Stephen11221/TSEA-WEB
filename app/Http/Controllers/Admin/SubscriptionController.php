<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     */
    public function index(): View
    {
        $subscriptions = Subscription::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Approve a pending subscription.
     */
    public function approve(Subscription $subscription): RedirectResponse
    {
        $subscription->update([
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addYear(), // Defaulting to a 1-year term
        ]);

        return back()->with('success', "Subscription for {$subscription->user->name} has been approved.");
    }
}