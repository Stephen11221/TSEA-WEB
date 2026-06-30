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
     * Shared icon options used in admin forms.
     */
    private function programIconOptions(): array
    {
        return [
            'fa-laptop-code' => 'Technology',
            'fa-chart-line' => 'Digital Economy',
            'fa-handshake' => 'Commercial Excellence',
            'fa-user-tie' => 'Professional Excellence',
            'fa-chart-simple' => 'Data Analytics',
            'fa-shield-halved' => 'Cybersecurity',
            'fa-code' => 'Software Development',
            'fa-microchip' => 'AI & Prompt Engineering',
            'fa-bullhorn' => 'Digital Marketing',
            'fa-paintbrush' => 'Graphic Design',
            'fa-briefcase' => 'Workplace Application',
            'fa-graduation-cap' => 'General Program',
        ];
    }

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
        $categories = Program::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
        $levels = Program::whereNotNull('level')->distinct()->orderBy('level')->pluck('level');

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

        return view('pages.programs', compact('page', 'available', 'comingSoon', 'notAvailable', 'categories', 'levels'));
    }

    /**
 * Store new Program
 */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive,published,unpublished,archived,disabled',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['status'] = $data['status'] ?? 'active';
        $data['is_active'] = in_array($data['status'], ['active', 'published']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        Program::create($data);

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

        $allPrograms = Program::latest()->get();
        $iconOptions = $this->programIconOptions();
        
        $publishedPrograms = $allPrograms->filter(fn($p) => in_array($p->status, ['active', 'published']));
        $hiddenPrograms = $allPrograms->filter(fn($p) => !in_array($p->status, ['active', 'published']));

        return view('admin.content.program', compact('page', 'publishedPrograms', 'hiddenPrograms', 'iconOptions'));
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
        $iconOptions = $this->programIconOptions();

        return view('admin.content.edit', compact('program', 'iconOptions'));
    }

    public function updateSingle(Request $request, Program $program)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive,published,unpublished,archived,disabled',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'icon', 'category', 'level', 'status']);

        if (array_key_exists('status', $data)) {
            $data['is_active'] = in_array($data['status'], ['active', 'published']);
        }

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
                'category' => 'Career',
                'level' => 'Beginner',
                'status' => 'active',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Skills',
                'description' => 'Gain practical tools for modern work and AI-enabled productivity.',
                'icon' => 'fa-laptop-code',
                'category' => 'Digital',
                'level' => 'Beginner',
                'status' => 'active',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Future Skills',
                'description' => 'Develop problem solving, adaptability and communication.',
                'icon' => 'fa-lightbulb',
                'category' => 'Workforce',
                'level' => 'Intermediate',
                'status' => 'active',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Leadership',
                'description' => 'Prepare for team contribution and professional growth.',
                'icon' => 'fa-chess-king',
                'category' => 'Leadership',
                'level' => 'Intermediate',
                'status' => 'active',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Entrepreneurship',
                'description' => 'Validate ideas, business models and market pathways.',
                'icon' => 'fa-rocket',
                'category' => 'Business',
                'level' => 'Intermediate',
                'status' => 'active',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Executive Programs',
                'description' => 'Institution and employer workforce transformation tracks.',
                'icon' => 'fa-chart-pie',
                'category' => 'Executive',
                'level' => 'Advanced',
                'status' => 'active',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Default programs restored successfully.');
    }
}
