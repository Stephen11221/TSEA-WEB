<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    /**
     * Show Programs Dashboard
     */
    public function index(Request $request)
    {
        $page = ProgramPage::firstOrCreate(
            ['id' => 1],
            [
                'hero_label' => 'Programs',
                'hero_title' => 'Workforce Programs',
                'hero_description' => 'Discover readiness, digital skills, leadership and entrepreneurship programs aligned to market demand.',
            ]
        );

        $query = Program::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $allPrograms = $query->latest()->get();

        // Categorize programs
        $available = $allPrograms->filter(function($p) {
            $isFuture = $p->scheduled_activation_at && $p->scheduled_activation_at->isFuture();
            $isExpired = $p->scheduled_deactivation_at && $p->scheduled_deactivation_at->isPast();
            return in_array($p->status, ['active', 'published']) && !$isFuture && !$isExpired;
        });

        $comingSoon = $allPrograms->filter(function($p) {
            $isFuture = $p->scheduled_activation_at && $p->scheduled_activation_at->isFuture();
            return $p->status === 'unpublished' || (in_array($p->status, ['active', 'published']) && $isFuture);
        });

        $notAvailable = $allPrograms->filter(function($p) {
            $isExpired = $p->scheduled_deactivation_at && $p->scheduled_deactivation_at->isPast();
            return in_array($p->status, ['inactive', 'archived', 'disabled']) || $isExpired;
        });

        $hasFilters = $request->filled('search') || $request->filled('category') || $request->filled('level');

        if ($allPrograms->isEmpty() && !$hasFilters) {
            $programs = collect([
                ['title' => 'Career Readiness', 'description' => 'Build interview confidence, CV quality and workplace behaviours.', 'icon' => 'fa-user-tie'],
                ['title' => 'Digital Skills', 'description' => 'Gain practical tools for modern work and AI-enabled productivity.', 'icon' => 'fa-laptop-code'],
                ['title' => 'Future Skills', 'description' => 'Develop problem solving, adaptability and communication.', 'icon' => 'fa-lightbulb'],
                ['title' => 'Leadership', 'description' => 'Prepare for team contribution and professional growth.', 'icon' => 'fa-chess-king'],
                ['title' => 'Entrepreneurship', 'description' => 'Validate ideas, business models and market pathways.', 'icon' => 'fa-rocket'],
                ['title' => 'Executive Programs', 'description' => 'Institution and employer workforce transformation tracks.', 'icon' => 'fa-chart-pie'],
            ])->map(fn ($program) => (object) array_merge($program, ['status' => 'active', 'id' => 0]));
            $available = $programs;
        }

        return view('pages.programs', compact('page', 'available', 'comingSoon', 'notAvailable'));
    }

    /**
 * Store new Program
 */
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'icon' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('programs', 'public');
    }

    Program::create([
        'title' => $request->title,
        'description' => $request->description,
        'icon' => $request->icon,
        'image' => $imagePath,
    ]);

    return redirect()
        ->back()
        ->with('success', 'Program created successfully.');
}

    public function edit()
    {
        $page = ProgramPage::firstOrCreate(
            ['id' => 1],
            [
                'hero_label' => 'Programs',
                'hero_title' => 'Workforce Programs',
                'hero_description' => 'Discover readiness, digital skills, leadership and entrepreneurship programs aligned to market demand.',
            ]
        );
        $programs = Program::latest()->get();

        return view('admin.content.program', compact('page', 'programs'));
    }


    /**
     * Update Hero Section
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_label' => 'nullable|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'nullable|string',
        ]);

        $page = ProgramPage::firstOrCreate(['id' => 1]);

        $page->update([
            'hero_label' => $request->hero_label,
            'hero_title' => $request->hero_title,
            'hero_description' => $request->hero_description,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Programs page updated successfully.');
    }

    public function editSingle(Program $program)
    {
        return view('admin.content.edit', compact('program'));
    }

    public function updateSingle(Request $request, Program $program)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'icon']);

        if ($request->hasFile('image')) {
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $program->update($data);

        return redirect()
            ->route('admin.content.program')
            ->with('success', 'Program updated successfully.');
    }

    public function delete(Program $program)
    {
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }
        
        $program->delete();

        return redirect()
            ->back()
            ->with('success', 'Program deleted successfully.');
    }

    /**
     * Restore Default Programs
     */
    public function restoreDefaults()
    {
        Program::truncate();

        Program::insert([
            [
                'title' => 'Career Readiness',
                'description' => 'Build interview confidence, CV quality and workplace behaviours.',
                'icon' => 'fa-user-tie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Skills',
                'description' => 'Gain practical tools for modern work and AI-enabled productivity.',
                'icon' => 'fa-laptop-code',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Future Skills',
                'description' => 'Develop problem solving, adaptability and communication.',
                'icon' => 'fa-lightbulb',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Leadership',
                'description' => 'Prepare for team contribution and professional growth.',
                'icon' => 'fa-chess-king',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Entrepreneurship',
                'description' => 'Validate ideas, business models and market pathways.',
                'icon' => 'fa-rocket',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Executive Programs',
                'description' => 'Institution and employer workforce transformation tracks.',
                'icon' => 'fa-chart-pie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Default programs restored successfully.');
    }
}
