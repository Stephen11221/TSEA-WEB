<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserPassport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class PassportApprovalController extends Controller
{
    public function index(): View
    {
        $passports = UserPassport::with('user')
            ->where('status', 'submitted')
            ->latest()
            ->paginate(15);

        return view('admin.passports.index', compact('passports'));
    }

    public function approve(UserPassport $passport): RedirectResponse
    {
        $passport->update(['status' => 'approved']);

        return back()->with('success', 'Workforce Passport has been approved.');
    }
}