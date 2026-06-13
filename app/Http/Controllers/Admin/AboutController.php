<?php

namespace App\Http\Controllers\Admin;
use App\Services\CardSplitter;   
use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected $splitter;

    public function __construct(CardSplitter $splitter)
    {
        $this->splitter = $splitter;
    }

    public function index()
{
    $about = AboutPage::firstOrCreate(['id' => 1]);

    $missionCards = $this->splitter->split($about->mission_title ?? 'Mission', $about->mission_description);
    $infraCards   = $this->splitter->split($about->infrastructure_title ?? 'Infrastructure', $about->infrastructure_description);
    $impactCards  = $this->splitter->split($about->impact_title ?? 'Impact', $about->impact_description);

    return view('pages.about', compact('about', 'missionCards', 'infraCards', 'impactCards'));
}
    public function edit()
    {
        $about = AboutPage::firstOrCreate(['id' => 1]);

        return view('admin.content.about', compact('about'));
    }

    /**
     * Split text into multiple card chunks
     */
    public function update(Request $request)
    {
        $about = AboutPage::firstOrCreate(['id' => 1]);

        $about->fill($request->only([
            'hero_label',
            'hero_title',
            'hero_description',
            'hero_tagline',
            'mission_title',
            'mission_description',
            'infrastructure_title',
            'infrastructure_description',
            'impact_title',
            'impact_description',
        ]));

        if ($request->hasFile('hero_image')) {
            $about->hero_image = $request->file('hero_image')
                ->store('about', 'public');
        }

        $about->save();

        return redirect()
            ->route('admin.content.about')
            ->with('success', 'About page updated successfully.');
    }

    public function restore()
    {
        $about = AboutPage::firstOrNew([]);

        $about->fill([
            'hero_label' => 'ABOUT TSEA',
            'hero_title' => 'One Passport, Endless Opportunities',
            'hero_description' => 'TSEA builds trusted employability infrastructure connecting skills, identity and opportunity for Africa’s workforce.',
            'hero_tagline' => 'Your Identity | Your Opportunity | Your Future',

            'mission_title' => 'Mission',
            'mission_description' => 'Help every learner prove readiness and access opportunity.',

            'infrastructure_title' => 'Infrastructure',
            'infrastructure_description' => 'Unify workforce identity, skills evidence and market intelligence.',

            'impact_title' => 'Impact',
            'impact_description' => 'Support employers, institutions and governments with trusted data.',
        ]);

        $about->save();

        return back()->with('success', 'About page restored successfully.');
    }
}