<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkforcePassport; 
class WorkforcePassportController extends Controller
{
    //
    public function workforcePassport()
{
    $passport = WorkforcePassport::firstOrCreate(
        ['id' => 1],
        [
            'hero_label' => 'Workforce Passport™',
            'hero_title' => 'Your Workforce Identity',
            'hero_description' => 'One verified profile for identity, skills, credentials, readiness and opportunity.',
            'cta_text' => 'Create Your Passport',
        ]
    );

    return view('pages.workforce-passport', compact('passport'));
}
    public function edit()
{
    $passport = WorkforcePassport::firstOrCreate(
        ['id' => 1],
        [
            'hero_label' => 'Workforce Passport™',
            'hero_title' => 'Your Workforce Identity',
            'hero_description' => 'One verified profile for identity, skills, credentials, readiness and opportunity.',
            'cta_text' => 'Create Your Passport',
        ]
    );

    return view('admin.content.workforce', compact('passport'));
}

public function update(Request $request)
{
    $validated = $request->validate([
        'hero_label' => 'nullable|string|max:255',
        'hero_title' => 'nullable|string|max:255',
        'hero_description' => 'nullable|string',
        'cta_text' => 'nullable|string|max:255',
        'profile_name' => 'nullable|string|max:255',
        'profile_location' => 'nullable|string|max:255',
        'passport_score' => 'nullable|integer|min:0|max:100',
        'skill_name_*' => 'nullable|string|max:255',
        'skill_score_*' => 'nullable|integer|min:0|max:100',
        'credential_*' => 'nullable|string',
        'readiness_*' => 'nullable|string|max:255',
        'benefit_*' => 'nullable|string|max:255',
    ]);

    WorkforcePassport::updateOrCreate(
        ['id' => 1],
        $validated
    );

    return back()->with('success', 'Workforce Passport page updated successfully.');
}
}
