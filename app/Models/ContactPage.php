<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    protected $fillable = [
        'hero_label',
        'hero_title',
        'hero_description',
        'form_title',
        'submit_button_text',
        'stakeholder_title',
        'stakeholders',
        'connect_title',
        'email',
        'phone',
        'address',
    ];

    protected $casts = [
        'stakeholders' => 'array',
    ];

    public static function defaults(): array
    {
        return [
            'hero_label' => 'Contact',
            'hero_title' => "Let's Build Africa's Workforce Future",
            'hero_description' => 'Connect with TSEA for partnerships, programs, talent discovery and workforce intelligence.',
            'form_title' => 'Send Us A Message',
            'submit_button_text' => 'Submit Message',
            'stakeholder_title' => 'I am a...',
            'stakeholders' => [
                'Employer',
                'Institution',
                'Government',
                'Development Partner',
                'Learner',
            ],
            'connect_title' => 'Other Ways To Connect',
            'email' => 'info@tsea.africa',
            'phone' => '+254 700 123 456',
            'address' => 'Nairobi, Kenya',
        ];
    }

    public static function singleton(): self
    {
        return self::firstOrCreate(['id' => 1], self::defaults());
    }
}
