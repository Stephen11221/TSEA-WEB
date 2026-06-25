<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionPage extends Model
{
    protected $fillable = [
        'hero_label',
        'hero_title',
        'hero_description',
        'outcomes_title',
        'trend_title',
        'benefits_title',
        'metrics',
        'trend_items',
        'benefits',
        'institutions',
    ];

    protected $casts = [
        'metrics' => 'array',
        'trend_items' => 'array',
        'benefits' => 'array',
        'institutions' => 'array',
    ];

    public static function defaults(): array
    {
        return [
            'hero_label' => 'Institutions',
            'hero_title' => 'Measure Graduate Employability',
            'hero_description' => 'Track outcomes, benchmark readiness and align programs with labour market demand.',
            'outcomes_title' => 'Outcomes Overview',
            'trend_title' => 'ERI(TM) Trend',
            'benefits_title' => 'Benefits',
            'metrics' => [
                ['value' => '76%', 'label' => 'Placement Rate'],
                ['value' => '74', 'label' => 'ERI(TM) Average'],
                ['value' => '68%', 'label' => 'Graduate Employment'],
                ['value' => '82%', 'label' => 'Industry Alignment'],
            ],
            'trend_items' => [
                'Jan' => 52,
                'Feb' => 60,
                'Mar' => 67,
                'Apr' => 74,
                'May' => 78,
            ],
            'benefits' => [
                'Track Outcomes',
                'Benchmark Performance',
                'Employer Connections',
            ],
            'institutions' => [
                [
                    'name' => 'Strathmore University',
                    'category' => 'University',
                    'description' => 'Leading private university committed to academic excellence and innovation.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '12,500+ students',
                    'logo' => '',
                    'accent' => 'blue',
                ],
                [
                    'name' => 'Kenya Institute of Management',
                    'category' => 'Business School',
                    'description' => 'Developing management professionals for global competitiveness.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '8,200+ students',
                    'logo' => '',
                    'accent' => 'green',
                ],
                [
                    'name' => 'University of Nairobi',
                    'category' => 'University',
                    'description' => 'Premier public university offering world-class education and research.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '56,000+ students',
                    'logo' => '',
                    'accent' => 'purple',
                ],
                [
                    'name' => 'Zetech University',
                    'category' => 'University',
                    'description' => 'Technology-focused university preparing students for the digital future.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '9,300+ students',
                    'logo' => '',
                    'accent' => 'blue',
                ],
                [
                    'name' => 'Mount Kenya University',
                    'category' => 'University',
                    'description' => 'Transforming lives through quality education and innovation.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '35,000+ students',
                    'logo' => '',
                    'accent' => 'gold',
                ],
                [
                    'name' => 'Technical University of Kenya',
                    'category' => 'Technical University',
                    'description' => 'Advancing technical education and innovation for national development.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '15,000+ students',
                    'logo' => '',
                    'accent' => 'green',
                ],
                [
                    'name' => 'Riara University',
                    'category' => 'University',
                    'description' => 'Nurturing innovators and leaders for a better world.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '6,500+ students',
                    'logo' => '',
                    'accent' => 'blue',
                ],
                [
                    'name' => 'Africa Nazarene University',
                    'category' => 'University',
                    'description' => 'Holistic education rooted in Christian values and service.',
                    'location' => 'Nairobi, Kenya',
                    'students' => '4,800+ students',
                    'logo' => '',
                    'accent' => 'red',
                ],
            ],
        ];
    }

    public static function singleton(): self
    {
        $page = self::firstOrCreate(['id' => 1], self::defaults());
        $defaults = self::defaults();
        $changed = false;

        foreach (['metrics', 'trend_items', 'benefits', 'institutions'] as $field) {
            if (empty($page->{$field})) {
                $page->{$field} = $defaults[$field];
                $changed = true;
            }
        }

        if ($changed) {
            $page->save();
        }

        return $page;
    }
}
