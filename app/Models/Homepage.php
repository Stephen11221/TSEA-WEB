<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage extends Model
{
    protected $table = 'homepage_settings';

    protected $fillable = [
        'hero_eyebrow',
        'hero_title',
        'hero_description',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public static function defaults(): array
    {
        return [
            'dashboard' => [
                'score_title' => 'ERI™ Score',
                'score' => 82,
                'passport_title' => 'Your Passport',
                'profile_name' => 'Jane Mwangi',
                'profile_caption' => 'Verified workforce profile',
                'skills_count' => '12',
                'skills_label' => 'Skills',
                'matches_count' => '24',
                'matches_label' => 'Matches',
                'applications_count' => '6',
                'applications_label' => 'Applications',
                'insights_title' => 'Workforce Insights',
                'top_skills_title' => 'Top Skills',
            ],
            'problem' => [
                'eyebrow' => 'The Workforce Visibility Gap',
                'title' => 'Every stakeholder needs trusted workforce evidence',
                'items' => [
                    ['title' => 'Learners', 'copy' => 'Cannot prove readiness', 'icon' => 'fa-user-graduate'],
                    ['title' => 'Employers', 'copy' => 'Cannot verify talent', 'icon' => 'fa-building'],
                    ['title' => 'Institutions', 'copy' => 'Cannot track outcomes', 'icon' => 'fa-university'],
                    ['title' => 'Governments', 'copy' => 'Cannot see workforce trends', 'icon' => 'fa-landmark'],
                ],
            ],
            'solution' => [
                'eyebrow' => 'Integrated Solution',
                'title' => 'A complete infrastructure for skills, identity and opportunity',
                'items' => [
                    ['title' => 'ERI™', 'copy' => 'Measure, benchmark and improve workforce readiness.', 'icon' => 'fa-tachometer-alt'],
                    ['title' => 'Workforce Passport™', 'copy' => 'Digital workforce identity that verifies skills, credentials and experience.', 'icon' => 'fa-id-card'],
                    ['title' => 'Talent Marketplace™', 'copy' => 'Connect verified talent with employers and opportunities.', 'icon' => 'fa-users'],
                    ['title' => 'Workforce Intelligence™', 'copy' => 'Real-time labour market insights for better decisions.', 'icon' => 'fa-chart-line'],
                ],
            ],
            'stakeholders' => [
                'eyebrow' => 'Built For Every Stakeholder',
                'title' => 'One platform, role-specific value',
                'items' => [
                    ['title' => 'Learners', 'copy' => 'Build identity and unlock opportunities.', 'icon' => 'fa-user'],
                    ['title' => 'Employers', 'copy' => 'Find and hire ready talent faster.', 'icon' => 'fa-briefcase'],
                    ['title' => 'Institutions', 'copy' => 'Measure outcomes and improve employability.', 'icon' => 'fa-school'],
                    ['title' => 'Governments', 'copy' => 'Make data-driven workforce policy decisions.', 'icon' => 'fa-landmark'],
                    ['title' => 'Partners', 'copy' => 'Collaborate to build a skilled Africa.', 'icon' => 'fa-handshake'],
                ],
            ],
            'impact' => [
                'eyebrow' => 'Impact At A Glance',
                'title' => 'Trusted workforce infrastructure across Africa',
                'metrics' => [
                    ['value' => '1M+', 'label' => 'Workforce Passports™ Created'],
                    ['value' => '500K+', 'label' => 'ERI™ Assessments Completed'],
                    ['value' => '10K+', 'label' => 'Employers Onboarded'],
                    ['value' => '700+', 'label' => 'Partner Institutions Across Africa'],
                    ['value' => '54', 'label' => 'African Countries Impacted'],
                ],
                'partners' => [
                    ['name' => 'Partner Name', 'logo' => ''],
                    ['name' => 'Partner Name', 'logo' => ''],
                    ['name' => 'Partner Name', 'logo' => ''],
                    ['name' => 'Partner Name', 'logo' => ''],
                    ['name' => 'Partner Name', 'logo' => ''],
                    ['name' => 'Partner Name', 'logo' => ''],
                    ['name' => 'Partner Name', 'logo' => ''],
                ],
            ],
            'documents' => [
                'eyebrow' => 'Resources',
                'title' => 'Download TSEA documents',
                'items' => [
                    ['title' => '', 'description' => '', 'path' => '', 'original_name' => ''],
                    ['title' => '', 'description' => '', 'path' => '', 'original_name' => ''],
                    ['title' => '', 'description' => '', 'path' => '', 'original_name' => ''],
                ],
            ],
        ];
    }

    public static function singleton(): self
    {
        return static::query()->first() ?? static::query()->create([
            'hero_eyebrow' => 'Taifa Skills & Employability Academy',
            'hero_title' => 'Africa’s Workforce Passport for Skills, Identity & Opportunity',
            'hero_description' => 'Building Africa’s most trusted workforce infrastructure for learners, employers, institutions and governments.',
            'primary_button_text' => 'Create Workforce Passport',
            'primary_button_link' => route('passport.create', [], false),
            'secondary_button_text' => 'Partner With TSEA',
            'secondary_button_link' => route('contact', [], false),
            'content' => static::defaults(),
        ]);
    }

    public function contentWithDefaults(): array
    {
        $content = array_replace_recursive(static::defaults(), $this->content ?? []);
        $content['impact']['partners'] = static::normalizePartners($content['impact']['partners'] ?? []);
        $content['documents']['items'] = static::normalizeDocuments($content['documents']['items'] ?? []);

        return $content;
    }

    public static function normalizePartners(array $partners): array
    {
        return array_values(array_map(function ($partner) {
            if (is_array($partner)) {
                return [
                    'name' => trim((string) ($partner['name'] ?? '')),
                    'logo' => trim((string) ($partner['logo'] ?? '')),
                ];
            }

            return [
                'name' => trim((string) $partner),
                'logo' => '',
            ];
        }, $partners));
    }

    public static function normalizeDocuments(array $documents): array
    {
        return array_values(array_map(function ($document) {
            return [
                'title' => trim((string) ($document['title'] ?? '')),
                'description' => trim((string) ($document['description'] ?? '')),
                'path' => trim((string) ($document['path'] ?? '')),
                'original_name' => trim((string) ($document['original_name'] ?? '')),
            ];
        }, $documents));
    }
}
