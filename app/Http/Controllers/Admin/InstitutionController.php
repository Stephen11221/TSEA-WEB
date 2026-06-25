<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionPage;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index()
    {
        $institution = InstitutionPage::singleton();

        return view('pages.institutions', compact('institution'));
    }

    public function edit()
    {
        $institution = InstitutionPage::singleton();

        return view('admin.content.institutions', compact('institution'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_label' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'outcomes_title' => ['nullable', 'string', 'max:255'],
            'trend_title' => ['nullable', 'string', 'max:255'],
            'benefits_title' => ['nullable', 'string', 'max:255'],
            'metrics' => ['nullable', 'array'],
            'metrics.*.value' => ['nullable', 'string', 'max:50'],
            'metrics.*.label' => ['nullable', 'string', 'max:255'],
            'trend_items' => ['nullable', 'array'],
            'trend_items.*' => ['nullable', 'integer', 'min:0', 'max:100'],
            'benefits' => ['nullable', 'string'],
            'institutions' => ['nullable', 'array'],
            'institutions.*.name' => ['nullable', 'string', 'max:255'],
            'institutions.*.category' => ['nullable', 'string', 'max:255'],
            'institutions.*.description' => ['nullable', 'string'],
            'institutions.*.location' => ['nullable', 'string', 'max:255'],
            'institutions.*.students' => ['nullable', 'string', 'max:255'],
            'institutions.*.logo' => ['nullable', 'string', 'max:255'],
            'institutions.*.accent' => ['nullable', 'string', 'max:50'],
        ]);

        $defaults = InstitutionPage::defaults();
        $validated['metrics'] = $this->cleanMetrics($validated['metrics'] ?? [], $defaults['metrics']);
        $validated['trend_items'] = array_replace(
            $defaults['trend_items'],
            $validated['trend_items'] ?? []
        );
        $validated['benefits'] = collect(preg_split('/\r\n|\r|\n/', $validated['benefits'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all() ?: $defaults['benefits'];
        $validated['institutions'] = $this->cleanInstitutions(
            $validated['institutions'] ?? [],
            $defaults['institutions']
        );

        InstitutionPage::singleton()->update($validated);

        return redirect()
            ->route('admin.content.institutions')
            ->with('success', 'Institution page updated successfully.');
    }

    public function restore()
    {
        InstitutionPage::singleton()->update(InstitutionPage::defaults());

        return redirect()
            ->route('admin.content.institutions')
            ->with('success', 'Institution page restored successfully.');
    }

    private function cleanMetrics(array $input, array $defaults): array
    {
        $metrics = [];

        foreach ($defaults as $index => $default) {
            $row = $input[$index] ?? [];
            $metrics[] = [
                'value' => trim((string) ($row['value'] ?? $default['value'])),
                'label' => trim((string) ($row['label'] ?? $default['label'])),
            ];
        }

        return $metrics;
    }

    private function cleanInstitutions(array $input, array $defaults): array
    {
        $institutions = [];

        foreach ($defaults as $index => $default) {
            $row = $input[$index] ?? [];
            $name = trim((string) ($row['name'] ?? $default['name']));

            if ($name === '') {
                continue;
            }

            $institutions[] = [
                'name' => $name,
                'category' => trim((string) ($row['category'] ?? $default['category'])),
                'description' => trim((string) ($row['description'] ?? $default['description'])),
                'location' => trim((string) ($row['location'] ?? $default['location'])),
                'students' => trim((string) ($row['students'] ?? $default['students'])),
                'logo' => trim((string) ($row['logo'] ?? $default['logo'])),
                'accent' => trim((string) ($row['accent'] ?? $default['accent'])),
            ];
        }

        return $institutions ?: $defaults;
    }
}
