<?php

namespace App\Http\Controllers\Admin;
use App\Services\CardSplitter;   
use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutController extends Controller
{
 public function index()
{
    $about = AboutPage::first();

    $missionCards = $this->splitIntoCards($about->mission_title, $about->mission_description);
    $infraCards   = $this->splitIntoCards($about->infrastructure_title, $about->infrastructure_description);
    $impactCards  = $this->splitIntoCards($about->impact_title, $about->impact_description);

    return view('pages.about', compact('about', 'missionCards', 'infraCards', 'impactCards'));
}
    protected function splitIntoCards($title, $text, $limit = 200)
    {
        $words = explode(' ', $text ?? '');
        $chunks = array_chunk($words, $limit);

        $cards = [];

        foreach ($chunks as $chunk) {
            $cards[] = [
                'title' => $title,
                'text' => implode(' ', $chunk),
            ];
        }

        return $cards;
    }


    public function edit()
    {
        $about = AboutPage::first();

        return view('admin.content.about', compact('about'));
    }

    /**
     * Split text into multiple card chunks
     */
    public function update(Request $request)
    {
        $about = AboutPage::firstOrNew([]);

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