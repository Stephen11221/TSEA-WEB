<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EriPage;
use Illuminate\Http\Request;

class EriController extends Controller
{

public function index()
    {
        $eri = EriPage::firstOrCreate(
            ['id' => 1],
            [
                'hero_eyebrow' => 'ERI',
                'hero_title' => 'Economic Resilience Index',
                'hero_description' => 'Measure readiness, resilience and opportunity signals across the workforce ecosystem.',
                'eri_score' => 78,
                'score_label' => 'Ready',
                'score_message' => 'Your current resilience profile shows strong opportunity readiness with room to strengthen market alignment.',
                'competencies' => [
                    ['label' => 'Digital Literacy', 'value' => 92],
                    ['label' => 'Communication', 'value' => 84],
                    ['label' => 'Problem Solving', 'value' => 78],
                ],
                'recommendations' => [
                    'Complete your verified skills profile.',
                    'Add recent credentials and work evidence.',
                    'Review opportunity matches weekly.',
                ],
            ]
        );

        return view('pages.eri', compact('eri'));
    }
    public function edit()
{
    $eri = EriPage::firstOrCreate(['id' => 1]);

    return view('admin.content.eri', compact('eri'));
}

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_eyebrow' => 'nullable|string|max:255',
            'hero_title' => 'required|string',
            'hero_description' => 'nullable|string',
            'eri_score' => 'required|integer|min:0|max:100',
            'score_label' => 'nullable|string|max:255',
            'score_message' => 'nullable|string',
            'competencies' => 'nullable|json',
            'recommendations' => 'nullable|json',
        ]);

        $eri = EriPage::firstOrCreate(['id' => 1]);

        $eri->update([
            'hero_eyebrow' => $validated['hero_eyebrow'] ?? null,
            'hero_title' => $validated['hero_title'],
            'hero_description' => $validated['hero_description'] ?? null,
            'eri_score' => $validated['eri_score'],
            'score_label' => $validated['score_label'] ?? null,
            'score_message' => $validated['score_message'] ?? null,
            'competencies' => json_decode($validated['competencies'] ?? '[]', true),
            'recommendations' => json_decode($validated['recommendations'] ?? '[]', true),
        ]);

        return back()->with('success', 'ERI page updated successfully.');
    }
}
