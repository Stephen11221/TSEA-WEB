<?php

namespace App\Http\Controllers\Admin;

use App\Models\Homepage;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePageController extends Controller
{
    public function showHomepage()
    {
        try {
            $homepage = Homepage::query()->first();
            $homepageContent = $homepage?->contentWithDefaults() ?? Homepage::defaults();
        } catch (QueryException) {
            $homepage = null;
            $homepageContent = Homepage::defaults();
        }

        return view('welcome', compact('homepage', 'homepageContent'));
    }

    public function editHomepage()
    {
        $homepage = Homepage::singleton();
        $homepageContent = $homepage->contentWithDefaults();

        return view('admin.content.homepage', compact('homepage', 'homepageContent'));
    }

    public function updateHomepage(Request $request)
    {
        $validated = $request->validate([
            'hero_eyebrow' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'primary_button_text' => ['nullable', 'string', 'max:255'],
            'primary_button_link' => ['nullable', 'string', 'max:255'],
            'secondary_button_text' => ['nullable', 'string', 'max:255'],
            'secondary_button_link' => ['nullable', 'string', 'max:255'],
            'content.dashboard.score_title' => ['nullable', 'string', 'max:255'],
            'content.dashboard.score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'content.dashboard.passport_title' => ['nullable', 'string', 'max:255'],
            'content.dashboard.profile_name' => ['nullable', 'string', 'max:255'],
            'content.dashboard.profile_caption' => ['nullable', 'string', 'max:255'],
            'content.dashboard.skills_count' => ['nullable', 'string', 'max:50'],
            'content.dashboard.skills_label' => ['nullable', 'string', 'max:100'],
            'content.dashboard.matches_count' => ['nullable', 'string', 'max:50'],
            'content.dashboard.matches_label' => ['nullable', 'string', 'max:100'],
            'content.dashboard.applications_count' => ['nullable', 'string', 'max:50'],
            'content.dashboard.applications_label' => ['nullable', 'string', 'max:100'],
            'content.dashboard.insights_title' => ['nullable', 'string', 'max:255'],
            'content.dashboard.top_skills_title' => ['nullable', 'string', 'max:255'],
            'content.problem.eyebrow' => ['nullable', 'string', 'max:255'],
            'content.problem.title' => ['nullable', 'string', 'max:255'],
            'content.solution.eyebrow' => ['nullable', 'string', 'max:255'],
            'content.solution.title' => ['nullable', 'string', 'max:255'],
            'content.stakeholders.eyebrow' => ['nullable', 'string', 'max:255'],
            'content.stakeholders.title' => ['nullable', 'string', 'max:255'],
            'content.impact.eyebrow' => ['nullable', 'string', 'max:255'],
            'content.impact.title' => ['nullable', 'string', 'max:255'],
            'content.*.items.*.title' => ['nullable', 'string', 'max:255'],
            'content.*.items.*.copy' => ['nullable', 'string'],
            'content.*.items.*.icon' => ['nullable', 'string', 'max:100'],
            'content.impact.metrics.*.value' => ['nullable', 'string', 'max:100'],
            'content.impact.metrics.*.label' => ['nullable', 'string', 'max:255'],
            'content.impact.partners.*.name' => ['nullable', 'string', 'max:255'],
            'content.impact.partners.*.logo' => ['nullable', 'string', 'max:255'],
            'content.documents.eyebrow' => ['nullable', 'string', 'max:255'],
            'content.documents.title' => ['nullable', 'string', 'max:255'],
            'content.documents.items.*.title' => ['nullable', 'string', 'max:255'],
            'content.documents.items.*.description' => ['nullable', 'string'],
            'content.documents.items.*.path' => ['nullable', 'string', 'max:255'],
            'content.documents.items.*.original_name' => ['nullable', 'string', 'max:255'],
            'content.documents.items.*.file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip', 'max:10240'],
        ]);

        $defaults = Homepage::defaults();
        $input = $validated['content'] ?? [];
        $content = array_replace_recursive($defaults, $input);

        foreach (['problem', 'solution', 'stakeholders'] as $section) {
            $content[$section]['items'] = $this->cleanList(
                $input[$section]['items'] ?? [],
                $defaults[$section]['items'],
                ['title', 'copy', 'icon']
            );
        }

        $content['impact']['metrics'] = $this->cleanList(
            $input['impact']['metrics'] ?? [],
            $defaults['impact']['metrics'],
            ['value', 'label']
        );
        $content['impact']['partners'] = $this->cleanList(
            $input['impact']['partners'] ?? [],
            $defaults['impact']['partners'],
            ['name', 'logo']
        );
        $content['documents']['items'] = $this->cleanDocuments(
            $request,
            $input['documents']['items'] ?? [],
            $defaults['documents']['items']
        );

        Homepage::singleton()->update([
            'hero_eyebrow' => $validated['hero_eyebrow'] ?? null,
            'hero_title' => $validated['hero_title'] ?? null,
            'hero_description' => $validated['hero_description'] ?? null,
            'primary_button_text' => $validated['primary_button_text'] ?? null,
            'primary_button_link' => $validated['primary_button_link'] ?? null,
            'secondary_button_text' => $validated['secondary_button_text'] ?? null,
            'secondary_button_link' => $validated['secondary_button_link'] ?? null,
            'content' => $content,
        ]);

        return redirect()
            ->route('admin.content.homepage')
            ->with('success', 'Homepage updated successfully.');
    }

    public function restoreHomepage()
    {
        Homepage::singleton()->update([
            'hero_eyebrow' => 'Taifa Skills & Employability Academy',
            'hero_title' => 'Africa’s Workforce Passport for Skills, Identity & Opportunity',
            'hero_description' => 'Building Africa’s most trusted workforce infrastructure for learners, employers, institutions and governments.',
            'primary_button_text' => 'Create Workforce Passport',
            'primary_button_link' => route('passport.create', [], false),
            'secondary_button_text' => 'Partner With TSEA',
            'secondary_button_link' => route('contact', [], false),
            'content' => Homepage::defaults(),
        ]);

        return redirect()
            ->route('admin.content.homepage')
            ->with('success', 'Homepage content restored successfully.');
    }

    public function newPartner()
    {
        $homepage = Homepage::singleton();
        $homepageContent = $homepage->contentWithDefaults();
        $partners = Homepage::normalizePartners($homepageContent['impact']['partners'] ?? []);

        return view('admin.content.new-partner', compact('partners'));
    }

    public function storePartner(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $path = $request->file('logo')->store('partners', 'public');

        $homepage = Homepage::singleton();
        $content = $homepage->contentWithDefaults();
        $partners = Homepage::normalizePartners($content['impact']['partners'] ?? []);

        $partners[] = [
            'name' => trim($data['name']),
            'logo' => $path,
        ];

        $content['impact']['partners'] = $partners;

        $homepage->update(['content' => $content]);

        return redirect()
            ->route('admin.content.homepage')
            ->with('success', 'Partner added successfully.');
    }

    private function cleanList(array $inputRows, array $defaultRows, array $fields): array
    {
        $rows = [];

        foreach ($defaultRows as $index => $defaultRow) {
            $source = $inputRows[$index] ?? [];
            $row = [];

            foreach ($fields as $field) {
                $row[$field] = trim((string) ($source[$field] ?? $defaultRow[$field] ?? ''));
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function cleanDocuments(Request $request, array $inputRows, array $defaultRows): array
    {
        $rows = [];

        foreach ($defaultRows as $index => $defaultRow) {
            $source = $inputRows[$index] ?? [];
            $path = trim((string) ($source['path'] ?? $defaultRow['path'] ?? ''));
            $originalName = trim((string) ($source['original_name'] ?? $defaultRow['original_name'] ?? ''));
            $uploadedFile = $request->file("content.documents.items.$index.file");

            if ($uploadedFile) {
                $path = $uploadedFile->store('homepage-documents', 'public');
                $originalName = $uploadedFile->getClientOriginalName();
            }

            $rows[] = [
                'title' => trim((string) ($source['title'] ?? $defaultRow['title'] ?? '')),
                'description' => trim((string) ($source['description'] ?? $defaultRow['description'] ?? '')),
                'path' => $path,
                'original_name' => $originalName,
            ];
        }

        return $rows;
    }
}
